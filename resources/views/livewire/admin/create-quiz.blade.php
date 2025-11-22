<!-- resources/views/livewire/admin/create-quiz.blade.php -->

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Buat Kuis Baru</h4>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form wire:submit.prevent="saveQuiz">
                        <!-- Informasi Kuis -->
                        <div class="mb-4">
                            <h5>Informasi Kuis</h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="quizTitle" class="form-label">Judul Kuis *</label>
                                        <input type="text" class="form-control" id="quizTitle" wire:model="quizTitle">
                                        @error('quizTitle') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="quizDescription" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="quizDescription" wire:model="quizDescription" rows="3"></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="quizDuration" class="form-label">Durasi (menit) *</label>
                                        <input type="number" class="form-control" id="quizDuration" wire:model="quizDuration" min="1">
                                        @error('quizDuration') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="quizImage" class="form-label">Gambar Kuis (opsional)</label>
                                        <input type="file" class="form-control" id="quizImage" wire:model="quizImage" accept="image/*">
                                        @error('quizImage') <span class="text-danger">{{ $message }}</span> @enderror
                                        
                                        @if ($quizImage)
                                            <div class="mt-2">
                                                <img src="{{ $quizImage->temporaryUrl() }}" class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Soal -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Daftar Soal</h5>
                                <button type="button" class="btn btn-success btn-sm" wire:click="addQuestion">
                                    <i class="fas fa-plus"></i> Tambah Soal
                                </button>
                            </div>

                            @foreach($questions as $questionIndex => $question)
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Soal {{ $questionIndex + 1 }}</h6>
                                    @if(count($questions) > 1)
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                wire:click="removeQuestion({{ $questionIndex }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <!-- Input Soal -->
                                    <div class="mb-3">
                                        <label class="form-label">Pertanyaan *</label>
                                        <textarea class="form-control" wire:model="questions.{{ $questionIndex }}.text" 
                                                  rows="3" placeholder="Masukkan pertanyaan..."></textarea>
                                        @error('questions.'.$questionIndex.'.text') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <!-- Gambar Soal -->
                                    <div class="mb-3">
                                        <label class="form-label">Gambar Soal (opsional)</label>
                                        <input type="file" class="form-control" 
                                               wire:model="questions.{{ $questionIndex }}.image" 
                                               accept="image/*">
                                        @error('questions.'.$questionIndex.'.image') 
                                            <span class="text-danger">{{ $message }}</span> 
                                        @enderror
                                        
                                        @if ($question['image'])
                                            <div class="mt-2">
                                                <img src="{{ $question['image']->temporaryUrl() }}" 
                                                     class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                        @endif
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
                                            <input type="file" class="form-control" 
                                                   wire:model="questions.{{ $questionIndex }}.options.{{ $optionIndex }}.image"
                                                   accept="image/*" style="max-width: 150px;">
                                            
                                            @if ($option['image'])
                                                <span class="input-group-text">
                                                    <img src="{{ $option['image']->temporaryUrl() }}" 
                                                         style="max-height: 30px;">
                                                </span>
                                            @endif
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
                                <i class="fas fa-save"></i> Simpan Kuis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>