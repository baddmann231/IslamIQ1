<div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-{{ $this->getScoreColor() }} text-white text-center">
                        <h3 class="mb-0">Hasil Kuis</h3>
                        <h2 class="mb-0">{{ $this->getScoreMessage() }}</h2>
                    </div>
                    
                    <div class="card-body text-center">
                        <!-- Score Circle -->
                        <div class="mb-4">
                            <div class="position-relative d-inline-block">
                                <div class="progress-circle progress-{{ $this->getScoreColor() }}" 
                                     style="--percentage: {{ $quizAttempt->percentage }}%;">
                                    <span class="progress-circle-value">{{ $quizAttempt->percentage }}%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Score Details -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Skor</h5>
                                        <h3 class="text-primary">{{ $quizAttempt->correct_answers }}/{{ $quizAttempt->total_questions }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Waktu</h5>
                                        <h3 class="text-info">{{ round($quizAttempt->time_spent / 60) }} menit</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Persentase</h5>
                                        <h3 class="text-{{ $this->getScoreColor() }}">{{ $quizAttempt->percentage }}%</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Answers -->
                        <div class="mb-4">
                            <h4 class="mb-3">Review Jawaban</h4>
                            
                            @if($userAnswers && $userAnswers->count() > 0)
                                @foreach($userAnswers as $index => $userAnswer)
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Soal {{ $index + 1 }}</h6>
                                    </div>
                                    <div class="card-body text-start">
                                        <p class="card-text">{{ $userAnswer->question->question_text }}</p>
                                        
                                        @if($userAnswer->option)
                                        <div class="mb-2">
                                            <strong>Jawaban Anda:</strong>
                                            <span class="{{ $userAnswer->is_correct ? 'text-success' : 'text-danger' }}">
                                                {{ $userAnswer->option->option_letter }}. {{ $userAnswer->option->option_text }}
                                                @if($userAnswer->is_correct)
                                                    <i class="fas fa-check"></i> Benar
                                                @else
                                                    <i class="fas fa-times"></i> Salah
                                                @endif
                                            </span>
                                        </div>
                                        @else
                                        <div class="mb-2">
                                            <strong>Jawaban Anda:</strong>
                                            <span class="text-warning">
                                                <i class="fas fa-minus-circle"></i> Tidak menjawab
                                            </span>
                                        </div>
                                        @endif

                                        @if(!$userAnswer->is_correct)
                                        <div class="mb-2">
                                            <strong>Jawaban Benar:</strong>
                                            @php
                                                $correctOption = $this->getCorrectOption($userAnswer->question);
                                            @endphp
                                            @if($correctOption)
                                            <span class="text-success">
                                                {{ $correctOption->option_letter }}. {{ $correctOption->option_text }}
                                                <i class="fas fa-check"></i>
                                            </span>
                                            @else
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i> Jawaban benar tidak ditemukan
                                            </span>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Tidak ada data jawaban untuk ditampilkan.
                            </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('user.daftar-kuis') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> Kuis Lainnya
                            </a>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .progress-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: conic-gradient(
            var(--circle-color) calc(var(--percentage) * 3.6deg),
            #e0e0e0 0deg
        );
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .progress-circle::before {
        content: '';
        position: absolute;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: white;
    }

    .progress-circle-value {
        position: relative;
        font-size: 1.5rem;
        font-weight: bold;
        z-index: 1;
    }

    .progress-success {
        --circle-color: #28a745;
    }

    .progress-warning {
        --circle-color: #ffc107;
    }

    .progress-danger {
        --circle-color: #dc3545;
    }
    </style>
</div>