<div>
<div class="pagetitle">
    <h1>🎯 Dashboard Saya</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        
        <!-- Stats Cards -->
        <div class="col-lg-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Kuis Dikerjakan</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-play-circle"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $userStats['total_attempts'] }}</h6>
                            <span class="text-success small pt-1 fw-bold">{{ $userStats['completed_quizzes'] }}</span>
                            <span class="text-muted small pt-2 ps-1">selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Rata-rata Nilai</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $userStats['average_score'] }}%</h6>
                            <span class="text-success small pt-1 fw-bold">{{ $userStats['highest_score'] }}%</span>
                            <span class="text-muted small pt-2 ps-1">tertinggi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Akurasi</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $userStats['accuracy_rate'] }}%</h6>
                            <span class="text-success small pt-1 fw-bold">{{ $userStats['total_correct_answers'] }}</span>
                            <span class="text-muted small pt-2 ps-1">jawaban benar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Progress</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $userStats['completed_quizzes'] }}/{{ $userStats['total_attempts'] }}</h6>
                            <span class="text-success small pt-1 fw-bold">Active</span>
                            <span class="text-muted small pt-2 ps-1">Learner</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Quick Actions -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">📈 Progress Belajar</h5>
                    <div id="progressChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">⚡ Aksi Cepat</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.daftar-kuis') }}" 
                           class="btn btn-primary btn-lg d-flex align-items-center justify-content-start">
                            <i class="bi bi-play-circle me-2"></i>
                            <div class="text-start">
                                <div class="fw-bold">Mulai Kuis Baru</div>
                                <small class="opacity-75">Jelajahi kuis tersedia</small>
                            </div>
                        </a>
                        
                        <a href="{{ route('user.materi') }}" 
                           class="btn btn-success btn-lg d-flex align-items-center justify-content-start">
                            <i class="bi bi-book me-2"></i>
                            <div class="text-start">
                                <div class="fw-bold">Pelajari Materi</div>
                                <small class="opacity-75">Tingkatkan pengetahuan</small>
                            </div>
                        </a>
                        
                        <a href="{{ route('user.profile') }}" 
                           class="btn btn-info btn-lg d-flex align-items-center justify-content-start">
                            <i class="bi bi-person me-2"></i>
                            <div class="text-start">
                                <div class="fw-bold">Edit Profil</div>
                                <small class="opacity-75">Perbarui informasi</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">📋 Aktivitas Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Kuis</th>
                                    <th scope="col">Skor</th>
                                    <th scope="col">Detail</th>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userQuizAttempts as $attempt)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $attempt->quiz->title }}</div>
                                        <small class="text-muted">{{ $attempt->quiz->description }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 80px; height: 8px;">
                                                <div class="progress-bar 
                                                    {{ $attempt->score >= 80 ? 'bg-success' : 
                                                       ($attempt->score >= 60 ? 'bg-warning' : 'bg-danger') }}" 
                                                    style="width: {{ $attempt->score }}%">
                                                </div>
                                            </div>
                                            <span class="fw-bold 
                                                {{ $attempt->score >= 80 ? 'text-success' : 
                                                   ($attempt->score >= 60 ? 'text-warning' : 'text-danger') }}">
                                                {{ $attempt->score }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">{{ $attempt->correct_answers }}</span> benar<br>
                                        <span class="text-danger">{{ $attempt->total_questions - $attempt->correct_answers }}</span> salah
                                    </td>
                                    <td>{{ floor($attempt->time_spent / 60) }}:{{ sprintf('%02d', $attempt->time_spent % 60) }}</td>
                                    <td>{{ $attempt->completed_at->format('d/m/Y') }}</td>
                                    <td>
                                        <button wire:click="viewQuizDetails({{ $attempt->id }})" 
                                                class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                            Belum ada riwayat kuis
                                            <div class="mt-2">
                                                <a href="{{ route('user.daftar-kuis') }}" class="btn btn-primary btn-sm">
                                                    Mulai kuis pertama Anda
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($userQuizAttempts->hasPages())
                    <div class="mt-3">
                        {{ $userQuizAttempts->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Modal Detail Kuis -->
@if($showQuizDetail && $selectedQuiz)
<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5)" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kuis: {{ $selectedQuiz->quiz->title }}</h5>
                <button type="button" class="btn-close" wire:click="closeQuizDetail"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6>Jawaban Benar</h6>
                                <h2 class="text-success">{{ $selectedQuiz->correct_answers }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6>Jawaban Salah</h6>
                                <h2 class="text-danger">{{ $selectedQuiz->total_questions - $selectedQuiz->correct_answers }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6>Nilai Akhir</h6>
                                <h2 class="{{ $selectedQuiz->score >= 80 ? 'text-success' : ($selectedQuiz->score >= 60 ? 'text-warning' : 'text-danger') }}">
                                    {{ $selectedQuiz->score }}%
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6>Waktu Pengerjaan</h6>
                                <h2 class="text-info">
                                    {{ floor($selectedQuiz->time_spent / 60) }}:{{ sprintf('%02d', $selectedQuiz->time_spent % 60) }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeQuizDetail">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Vendor JS Files -->
<script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Progress Chart - Line Chart
    var progressOptions = {
        series: [{
            name: 'Nilai Kuis',
            data: {!! json_encode($chartData['scores']) !!}
        }],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ['#4154f1'],
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'],
                opacity: 0.5
            },
        },
        xaxis: {
            categories: {!! json_encode($chartData['labels']) !!}
        },
        yaxis: {
            min: 0,
            max: 100,
            labels: {
                formatter: function(value) {
                    return value + '%';
                }
            }
        },
        markers: {
            size: 5,
            colors: ['#4154f1'],
            strokeColors: '#fff',
            strokeWidth: 2
        }
    };

    var progressChart = new ApexCharts(document.querySelector("#progressChart"), progressOptions);
    progressChart.render();
});
</script>