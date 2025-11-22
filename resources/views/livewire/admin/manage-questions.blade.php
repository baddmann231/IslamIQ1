<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Kelola Soal - {{ $quiz->title }}</h4>
                        <a href="{{ route('admin.daftar-kuis') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form wire:submit.prevent="saveQuestions">
                        <!-- Daftar Soal -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Daftar Soal ({{ count($questions) }} soal)</h5>
                                <button type="button" class="btn btn-success btn-sm" wire:click="addQuestion">
                                    <i class="fas fa-plus"></i> Tambah Soal
                                </button>
                            </div>

                            @foreach($questions as $questionIndex => $question)
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Soal {{ $questionIndex + 1 }}</h6>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            wire:click="removeQuestion({{ $questionIndex }})">
                                        <i class="fas fa-trash"></i> Hapus Soal
                                    </button>
                                </div>
                                <div class="card-body">
                                    <!-- Input Soal -->
                                    <div class="mb-3">
                                        <label class="form-label">Pertanyaan *</label>
                                        <textarea class="form-control" 
                                                  wire:model="questions.{{ $questionIndex }}.text" 
                                                  rows="3" 
                                                  placeholder="Masukkan pertanyaan..."></textarea>
                                        @error('questions.'.$questionIndex.'.text') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <!-- Pilihan Jawaban -->
                                    <div class="mb-3">
                                        <label class="form-label">Pilihan Jawaban *</label>
                                        @foreach($question['options'] as $optionIndex => $option)
                                        <div class="input-group mb-2">
                                            <span class="input-group-text" style="width: 50px;">
                                                <input class="form-check-input mt-0" 
                                                       type="radio" 
                                                       name="correct_answer_{{ $questionIndex }}" 
                                                       wire:click="setCorrectAnswer({{ $questionIndex }}, {{ $optionIndex }})"
                                                       {{ $option['is_correct'] ? 'checked' : '' }}>
                                                {{ $option['letter'] }}
                                            </span>
                                            <input type="text" class="form-control" 
                                                   wire:model="questions.{{ $questionIndex }}.options.{{ $optionIndex }}.text"
                                                   placeholder="Jawaban {{ $option['letter'] }}">
                                        </div>
                                        @error('questions.'.$questionIndex.'.options.'.$optionIndex.'.text') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.daftar-kuis') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Semua Soal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>