{{-- Shared form fields for create & edit --}}
<div class="row g-3">
    <div class="col-12">
        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" id="title" name="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $movie?->title) }}" required placeholder="e.g. The Dark Knight">
        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
        <textarea id="description" name="description" rows="4"
                  class="form-control @error('description') is-invalid @enderror"
                  required placeholder="A brief synopsis of the movie...">{{ old('description', $movie?->description) }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="genre" class="form-label">Genre <span class="text-danger">*</span></label>
        <select id="genre" name="genre" class="form-select @error('genre') is-invalid @enderror" required>
            <option value="">— Select genre —</option>
            @foreach (['Action', 'Adventure', 'Animation', 'Comedy', 'Crime', 'Drama', 'Fantasy', 'Horror', 'Mystery', 'Romance', 'Sci-Fi', 'Thriller'] as $genre)
                <option value="{{ $genre }}" {{ old('genre', $movie?->genre) === $genre ? 'selected' : '' }}>
                    {{ $genre }}
                </option>
            @endforeach
        </select>
        @error('genre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="duration_minutes" class="form-label">Duration (minutes) <span class="text-danger">*</span></label>
        <input type="number" id="duration_minutes" name="duration_minutes" min="1" max="600"
               class="form-control @error('duration_minutes') is-invalid @enderror"
               value="{{ old('duration_minutes', $movie?->duration_minutes) }}" required placeholder="120">
        @error('duration_minutes') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="release_date" class="form-label">Release Date <span class="text-danger">*</span></label>
        <input type="date" id="release_date" name="release_date"
               class="form-control @error('release_date') is-invalid @enderror"
               value="{{ old('release_date', $movie?->release_date?->format('Y-m-d')) }}" required>
        @error('release_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="ticket_price" class="form-label">Ticket Price ($) <span class="text-danger">*</span></label>
        <input type="number" id="ticket_price" name="ticket_price" min="0.01" max="999.99" step="0.01"
               class="form-control @error('ticket_price') is-invalid @enderror"
               value="{{ old('ticket_price', $movie?->ticket_price) }}" required placeholder="12.99">
        @error('ticket_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="total_seats" class="form-label">Total Seats <span class="text-danger">*</span></label>
        <input type="number" id="total_seats" name="total_seats" min="1" max="1000"
               class="form-control @error('total_seats') is-invalid @enderror"
               value="{{ old('total_seats', $movie?->total_seats ?? 100) }}" required>
        @error('total_seats') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label for="poster_url" class="form-label">Poster Image URL <span class="text-muted">(optional)</span></label>
        <input type="url" id="poster_url" name="poster_url"
               class="form-control @error('poster_url') is-invalid @enderror"
               value="{{ old('poster_url', $movie?->poster_url) }}"
               placeholder="https://example.com/poster.jpg">
        @error('poster_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <div class="form-check">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" id="is_active" name="is_active" value="1"
                   class="form-check-input"
                   {{ old('is_active', $movie?->is_active ?? true) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Active (visible on site)</label>
        </div>
    </div>
</div>
