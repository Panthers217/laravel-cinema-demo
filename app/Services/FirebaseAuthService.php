<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class FirebaseAuthService
{
    private const FIREBASE_LOGIN_URL = 'https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword';

    private const FIREBASE_CERTS_URL = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';

    public function authenticateWithEmailAndPassword(string $email, string $password): array
    {
        $apiKey = (string) config('firebase.web_api_key');

        if ($apiKey === '') {
            throw new RuntimeException('Firebase API key is not configured.');
        }

        $response = Http::timeout(15)->asJson()->post(self::FIREBASE_LOGIN_URL.'?key='.$apiKey, [
            'email' => $email,
            'password' => $password,
            'returnSecureToken' => true,
        ]);

        if ($response->failed()) {
            $code = (string) Arr::get($response->json(), 'error.message', 'AUTH_FAILED');
            throw new RuntimeException($this->humanizeFirebaseError($code));
        }

        $idToken = (string) $response->json('idToken');

        if ($idToken === '') {
            throw new RuntimeException('Firebase did not return an ID token.');
        }

        return $this->verifyIdToken($idToken);
    }

    public function verifyIdToken(string $idToken): array
    {
        $projectId = (string) config('firebase.project_id');

        if ($projectId === '') {
            throw new RuntimeException('Firebase project ID is not configured.');
        }

        $parts = explode('.', $idToken);
        if (count($parts) !== 3) {
            throw new RuntimeException('Invalid Firebase ID token format.');
        }

        [$encodedHeader, $encodedPayload, $encodedSignature] = $parts;

        $header = $this->decodeJwtPart($encodedHeader);
        $payload = $this->decodeJwtPart($encodedPayload);
        $signature = $this->base64UrlDecode($encodedSignature);

        if (($header['alg'] ?? null) !== 'RS256') {
            throw new RuntimeException('Unsupported Firebase token algorithm.');
        }

        $kid = (string) ($header['kid'] ?? '');
        if ($kid === '') {
            throw new RuntimeException('Firebase token is missing key ID.');
        }

        $certs = $this->firebaseCerts();
        $publicKey = $certs[$kid] ?? null;

        if (! is_string($publicKey) || $publicKey === '') {
            throw new RuntimeException('Firebase signing certificate not found for token key ID.');
        }

        $verified = openssl_verify(
            $encodedHeader.'.'.$encodedPayload,
            $signature,
            $publicKey,
            OPENSSL_ALGO_SHA256
        );

        if ($verified !== 1) {
            throw new RuntimeException('Firebase ID token signature verification failed.');
        }

        $now = time();
        $issuer = 'https://securetoken.google.com/'.$projectId;

        if (($payload['aud'] ?? null) !== $projectId) {
            throw new RuntimeException('Firebase token audience mismatch.');
        }

        if (($payload['iss'] ?? null) !== $issuer) {
            throw new RuntimeException('Firebase token issuer mismatch.');
        }

        if (! isset($payload['exp']) || (int) $payload['exp'] <= $now) {
            throw new RuntimeException('Firebase token is expired.');
        }

        if (! isset($payload['iat']) || (int) $payload['iat'] > $now) {
            throw new RuntimeException('Firebase token issued-at time is invalid.');
        }

        return $payload;
    }

    private function firebaseCerts(): array
    {
        return Cache::remember('firebase_signing_certs', now()->addMinutes(55), function (): array {
            $response = Http::timeout(15)->get(self::FIREBASE_CERTS_URL);

            if ($response->failed()) {
                throw new RuntimeException('Unable to fetch Firebase signing certificates.');
            }

            $certs = $response->json();

            if (! is_array($certs) || $certs === []) {
                throw new RuntimeException('Firebase signing certificates are empty or invalid.');
            }

            return $certs;
        });
    }

    private function decodeJwtPart(string $encoded): array
    {
        $decoded = $this->base64UrlDecode($encoded);
        $data = json_decode($decoded, true);

        if (! is_array($data)) {
            throw new RuntimeException('Invalid Firebase token payload.');
        }

        return $data;
    }

    private function base64UrlDecode(string $input): string
    {
        $remainder = strlen($input) % 4;
        if ($remainder !== 0) {
            $input .= str_repeat('=', 4 - $remainder);
        }

        $decoded = base64_decode(strtr($input, '-_', '+/'), true);

        if ($decoded === false) {
            throw new RuntimeException('Invalid base64url token segment.');
        }

        return $decoded;
    }

    private function humanizeFirebaseError(string $code): string
    {
        return match ($code) {
            'EMAIL_NOT_FOUND', 'INVALID_PASSWORD', 'INVALID_LOGIN_CREDENTIALS' => 'Invalid email or password.',
            'USER_DISABLED' => 'This Firebase user account is disabled.',
            'TOO_MANY_ATTEMPTS_TRY_LATER' => 'Too many failed attempts. Try again later.',
            'OPERATION_NOT_ALLOWED' => 'Email/password auth is disabled in Firebase project settings.',
            'CONFIGURATION_NOT_FOUND' => 'Firebase configuration not found. Verify FIREBASE_WEB_API_KEY points to a Firebase project with Email/Password auth enabled.',
            default => 'Firebase sign-in failed: '.$code,
        };
    }
}
