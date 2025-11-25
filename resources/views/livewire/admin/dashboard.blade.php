<div>
    <div class="pagetitle">
        <h1>📊 Dashboard Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    
                    <!-- Stats Cards -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Pengguna</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $stats['total_users'] }}</h6>
                                        <span class="text-success small pt-1 fw-bold">{{ $stats['active_users'] }}</span>
                                        <span class="text-muted small pt-2 ps-1">aktif</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Kuis</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $stats['total_quizzes'] }}</h6>
                                        <span class="text-success small pt-1 fw-bold">{{ $stats['active_quizzes'] }}</span>
                                        <span class="text-muted small pt-2 ps-1">aktif</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Kuis Diselesaikan</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $stats['completed_attempts'] }}</h6>
                                        <span class="text-success small pt-1 fw-bold">{{ $stats['average_score'] }}%</span>
                                        <span class="text-muted small pt-2 ps-1">rata-rata</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Kuis Terpopuler</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-fire"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="truncate-text">{{ $stats['popular_quiz_name'] }}</h6>
                                        <span class="text-success small pt-1 fw-bold">{{ $stats['popular_quiz_attempts'] }}</span>
                                        <span class="text-muted small pt-2 ps-1">x dikerjakan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">📈 Performa Kuis</h5>
                                <div id="performanceChart" style="min-height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">👥 Aktivitas Pengguna</h5>
                                <div id="activityChart" style="min-height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>

    <!-- Vendor JS Files -->
    <script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Performance Chart - Line Chart
        var performanceOptions = {
            series: [{
                name: 'Rata-rata Skor',
                data: {!! json_encode($chartData['performance']['scores']) !!}
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
                categories: {!! json_encode($chartData['performance']['labels']) !!}
            },
            yaxis: {
                min: 0,
                max: 100,
                labels: {
                    formatter: function(value) {
                        return value + '%';
                    }
                }
            }
        };

        var performanceChart = new ApexCharts(document.querySelector("#performanceChart"), performanceOptions);
        performanceChart.render();

        // Activity Chart - Bar Chart
        var activityOptions = {
            series: [{
                name: 'Attempt Kuis',
                data: {!! json_encode($chartData['activity']['data']) !!}
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#2eca6a'],
            xaxis: {
                categories: {!! json_encode($chartData['activity']['labels']) !!}
            }
        };

        var activityChart = new ApexCharts(document.querySelector("#activityChart"), activityOptions);
        activityChart.render();
    });

    // CSS untuk truncate text
    const style = document.createElement('style');
    style.textContent = `
        .truncate-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }
    `;
    document.head.appendChild(style);
    </script>
</div>