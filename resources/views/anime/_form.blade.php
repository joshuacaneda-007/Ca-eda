<div class="row g-3">
    <div class="col-12 col-md-6">
        <label class="form-label small">Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Attack on Titan"
            value="{{ old('title', $anime?->title) }}" required>
    </div>
    <div class="col-12 col-md-6">
        <label class="form-label small">Genre</label>
        <input type="text" name="genre" class="form-control" placeholder="e.g. Action, Romance"
            value="{{ old('genre', $anime?->genre) }}" required>
    </div>
    <div class="col-6 col-md-3">
        <label class="form-label small">Total Episodes</label>
        <input type="number" name="episodes" class="form-control" min="0"
            value="{{ old('episodes', $anime?->episodes ?? 0) }}" required>
    </div>
    <div class="col-6 col-md-3">
        <label class="form-label small">Watched</label>
        <input type="number" name="episodes_watched" class="form-control" min="0"
            value="{{ old('episodes_watched', $anime?->episodes_watched ?? 0) }}" required>
    </div>
    <div class="col-12 col-md-3">
        <label class="form-label small">Status</label>
        <select name="status" class="form-select">
            @foreach(['Watching','Completed','On Hold','Dropped','Plan to Watch'] as $s)
                <option value="{{ $s }}" {{ old('status', $anime?->status) === $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-md-3">
        <label class="form-label small">Rating (1-10)</label>
        <input type="number" name="rating" class="form-control" min="1" max="10" placeholder="Optional"
            value="{{ old('rating', $anime?->rating) }}">
    </div>
    <div class="col-12">
        <label class="form-label small">Notes</label>
        <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes...">{{ old('notes', $anime?->notes) }}</textarea>
    </div>
</div>
