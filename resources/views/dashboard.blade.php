@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-people-fill stat-icon"></i>
                <div>
                    <div class="fs-4 fw-bold">{{ $totalUsers }}</div>
                    <div class="small" style="color:var(--text-muted)">Total Users</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-collection-play-fill stat-icon"></i>
                <div>
                    <div class="fs-4 fw-bold">{{ $totalAnime }}</div>
                    <div class="small" style="color:var(--text-muted)">Total Anime Records</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-bookmark-heart-fill stat-icon"></i>
                <div>
                    <div class="fs-4 fw-bold">{{ $myAnime }}</div>
                    <div class="small" style="color:var(--text-muted)">My Anime</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header py-2 px-3"><small class="fw-semibold">My Anime by Status</small></div>
            <div class="card-body d-flex align-items-center justify-content-center" style="min-height:220px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header py-2 px-3"><small class="fw-semibold">Top Genres</small></div>
            <div class="card-body d-flex align-items-center justify-content-center" style="min-height:220px;">
                <canvas id="genreChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Anime -->
<div class="card">
    <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center">
        <small class="fw-semibold">Recently Added</small>
        <a href="{{ route('anime.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Title</th><th>Genre</th><th>Status</th><th>Rating</th></tr></thead>
            <tbody>
                @forelse($recentAnime as $a)
                <tr>
                    <td class="fw-semibold">{{ $a->title }}</td>
                    <td><span class="badge bg-secondary">{{ $a->genre }}</span></td>
                    <td>
                        @php $colors = ['Watching'=>'primary','Completed'=>'success','Dropped'=>'danger','On Hold'=>'warning','Plan to Watch'=>'secondary']; @endphp
                        <span class="badge bg-{{ $colors[$a->status] ?? 'secondary' }}">{{ $a->status }}</span>
                    </td>
                    <td>{{ $a->rating ? $a->rating . '/10' : '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-3">No anime added yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.color = '#7a8aaa';
Chart.defaults.borderColor = '#dde3f0';

const statusData = @json($statusCounts);
const genreData  = @json($genreCounts);

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData),
        datasets: [{ data: Object.values(statusData), backgroundColor: ['#4f6ef7','#28a745','#ffc107','#e94560','#aab4cc'], borderWidth: 2, borderColor: '#fff' }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

new Chart(document.getElementById('genreChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(genreData),
        datasets: [{ label: 'Count', data: Object.values(genreData), backgroundColor: '#4f6ef7', borderRadius: 6 }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});
</script>
@endpush
