@extends('layouts.app')
@section('title', 'My Anime List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold">My Anime List</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAnimeModal">
        <i class="bi bi-plus-lg me-1"></i> Add Anime
    </button>
</div>

<!-- Filter badges -->
<div class="mb-3 d-flex flex-wrap gap-2">
    @foreach(['All','Watching','Completed','On Hold','Dropped','Plan to Watch'] as $f)
        <a href="{{ $f === 'All' ? route('anime.index') : route('anime.index', ['status' => $f]) }}"
           class="badge text-decoration-none {{ request('status') === $f || ($f === 'All' && !request('status')) ? 'bg-danger' : 'bg-secondary' }}">
            {{ $f }}
        </a>
    @endforeach
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>#</th><th>Title</th><th>Genre</th><th>Progress</th><th>Status</th><th>Rating</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($animeList as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $a->title }}</td>
                    <td><span class="badge bg-secondary">{{ $a->genre }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="height:6px;background:#2d2d4e;min-width:60px;">
                                @php $pct = $a->episodes > 0 ? min(100, round($a->episodes_watched / $a->episodes * 100)) : 0; @endphp
                                <div class="progress-bar bg-danger" style="width:{{ $pct }}%"></div>
                            </div>
                            <small class="text-muted">{{ $a->episodes_watched }}/{{ $a->episodes }}</small>
                        </div>
                    </td>
                    <td>
                        @php $colors = ['Watching'=>'info','Completed'=>'success','Dropped'=>'danger','On Hold'=>'warning','Plan to Watch'=>'secondary']; @endphp
                        <span class="badge bg-{{ $colors[$a->status] ?? 'secondary' }}">{{ $a->status }}</span>
                    </td>
                    <td>
                        @if($a->rating)
                            <span class="text-warning"><i class="bi bi-star-fill"></i> {{ $a->rating }}/10</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-warning me-1"
                            data-bs-toggle="modal" data-bs-target="#editAnimeModal{{ $a->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form method="POST" action="{{ route('anime.destroy', $a) }}" class="d-inline"
                            onsubmit="return confirm('Remove this anime?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editAnimeModal{{ $a->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="background:#1a1a2e;border:1px solid #2d2d4e;">
                            <div class="modal-header" style="border-color:#2d2d4e;">
                                <h6 class="modal-title">Edit Anime</h6>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('anime.update', $a) }}">
                                @csrf @method('PUT')
                                <div class="modal-body">
                                    @include('anime._form', ['anime' => $a])
                                </div>
                                <div class="modal-footer" style="border-color:#2d2d4e;">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No anime in your list yet. Add one!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Anime Modal -->
<div class="modal fade" id="addAnimeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background:#1a1a2e;border:1px solid #2d2d4e;">
            <div class="modal-header" style="border-color:#2d2d4e;">
                <h6 class="modal-title">Add Anime</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('anime.store') }}">
                @csrf
                <div class="modal-body">
                    @include('anime._form', ['anime' => null])
                </div>
                <div class="modal-footer" style="border-color:#2d2d4e;">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Add Anime</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
