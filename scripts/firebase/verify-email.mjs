#!/usr/bin/env node

import process from 'node:process';
import { cert, getApps, initializeApp } from 'firebase-admin/app';
import { getAuth } from 'firebase-admin/auth';

function parseArgs(argv) {
  const args = { email: '', serviceAccountPath: '' };

  for (let i = 2; i < argv.length; i += 1) {
    const current = argv[i];
    const next = argv[i + 1];

    if (current === '--email' && next) {
      args.email = next;
      i += 1;
      continue;
    }

    if (current === '--service-account' && next) {
      args.serviceAccountPath = next;
      i += 1;
      continue;
    }

    if (current === '--help' || current === '-h') {
      printHelpAndExit(0);
    }
  }

  return args;
}

function printHelpAndExit(code = 1) {
  console.log('Usage:');
  console.log('  node scripts/firebase/verify-email.mjs --email <email> [--service-account <path>]');
  console.log('');
  console.log('Options:');
  console.log('  --email            Email address of the Firebase Auth user to verify');
  console.log('  --service-account  Path to Firebase service account JSON key');
  console.log('                     Defaults to GOOGLE_APPLICATION_CREDENTIALS');
  process.exit(code);
}

async function main() {
  const args = parseArgs(process.argv);

  if (!args.email) {
    printHelpAndExit(1);
  }

  const serviceAccountPath = args.serviceAccountPath || process.env.GOOGLE_APPLICATION_CREDENTIALS;

  if (!serviceAccountPath) {
    throw new Error('Service account path not provided. Use --service-account or set GOOGLE_APPLICATION_CREDENTIALS.');
  }

  if (getApps().length === 0) {
    initializeApp({
      credential: cert(serviceAccountPath),
    });
  }

  const auth = getAuth();
  const user = await auth.getUserByEmail(args.email);

  if (user.emailVerified) {
    console.log(`User is already verified: ${args.email} (uid: ${user.uid})`);
    return;
  }

  await auth.updateUser(user.uid, { emailVerified: true });
  console.log(`Verified Firebase user: ${args.email} (uid: ${user.uid})`);
}

main().catch((error) => {
  console.error(error.message || error);
  process.exit(1);
});
