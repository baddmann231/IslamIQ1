<div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <!-- Header -->
                    <div class="card-header bg-info text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-eye"></i> Preview: {{ $quiz->title }}
                            </h4>
                            <div class="d-flex gap-2">
                                <button class="btn btn-light btn-sm" wire:click="toggleAnswers">
                                    <i class="fas fa-{{ $showAnswers ? 'eye-slash' : 'eye' }}"></i>
                                    {{ $showAnswers ? 'Sembunyikan' : 'Tampilkan' }} Jawaban
                                </button>
                                <a href="{{ route('admin.daftar-kuis') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="card-body border-bottom">
                        <div class="progress mb-2" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" 
                                 style="width: {{ $this->progressPercentage }}%"
                                 aria-valuenow="{{ $this->progressPercentage }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                        <small class="text-muted">
                            Soal {{ $currentQuestionIndex + 1 }} dari {{ count($questions) }}
                            ({{ $this->progressPercentage }}%)
                        </small>
                    </div>

                    <!-- Soal dan Jawaban -->
                    <div class="card-body">
                        @if($this->currentQuestion)
                            <!-- Teks Soal -->
                            <div class="mb-4">
                                <h5 class="mb-3">Soal {{ $currentQuestionIndex + 1 }}</h5>
                                <p class="lead">{{ $this->currentQuestion->question_text }}</p>
                                
                                @if($this->currentQuestion->question_image)
                                    <img src="{{ asset('storage/' . $this->currentQuestion->question_image) }}" 
                                         class="img-fluid rounded mb-3" 
                                         style="max-height: 300px; object-fit: cover;">
                                @endif
                            </div>

                            <!-- Pilihan Jawaban -->
                            <div class="mb-4">
                                @foreach($this->currentQuestion->options as $option)
                                <div class="form-check mb-3 p-3 border rounded {{ $showAnswers && $option->is_correct ? 'bg-success text-white' : '' }}">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="question_{{ $this->currentQuestion->id }}" 
                                           id="option_{{ $option->id }}"
                                           wire:click="selectAnswer({{ $this->currentQuestion->id }}, {{ $option->id }})"
                                           {{ isset($userAnswers[$this->currentQuestion->id]) && $userAnswers[$this->currentQuestion->id] == $option->id ? 'checked' : '' }}
                                           {{ $showAnswers ? 'disabled' : '' }}>
                                    <label class="form-check-label w-100" for="option_{{ $option->id }}">
                                        <strong>{{ $option->option_letter }}.</strong> 
                                        {{ $option->option_text }}
                                        
                                        @if($showAnswers && $option->is_correct)
                                            <span class="badge bg-light text-dark ms-2">
                                                <i class="fas fa-check"></i> Jawaban Benar
                                            </span>
                                        @endif
                                        
                                        @if($option->option_image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $option->option_image) }}" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 150px; object-fit: cover;">
                                            </div>
                                        @endif
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle"></i>
                                Tidak ada soal yang tersedia untuk kuis ini.
                            </div>
                        @endif

                        <!-- Navigation Buttons -->
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-secondary" 
                                    wire:click="previousQuestion"
                                    {{ $currentQuestionIndex == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-arrow-left"></i> Soal Sebelumnya
                            </button>

                            @if($currentQuestionIndex < count($questions) - 1)
                                <button class="btn btn-primary" 
                                        wire:click="nextQuestion">
                                    Soal Berikutnya <i class="fas fa-arrow-right"></i>
                                </button>
                            @else
                                <div class="text-muted">
                                    <i class="fas fa-flag-checkered"></i> Soal Terakhir
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Panel untuk Admin -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6><i class="fas fa-info-circle text-info"></i> Informasi Preview</h6>
                        <ul class="mb-0">
                            <li>Mode preview hanya untuk melihat kuis</li>
                            <li>Tidak ada penilaian atau penyimpanan hasil</li>
                            <li>Gunakan tombol "Tampilkan Jawaban" untuk melihat kunci jawaban</li>
                            <li>Untuk mengedit soal, gunakan tombol "Edit Soal" di halaman daftar kuis</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>