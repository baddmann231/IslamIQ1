<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-center mb-0 fw-bold">Daftar Kuis IslamIQ</h2>
            <a href="{{ route('admin.create-quiz') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Buat Kuis Baru
            </a>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 justify-content-center">
            @foreach($quizzes as $quiz)
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    @if($quiz->image)
                        <img src="{{ asset('storage/' . $quiz->image) }}" class="card-img-top" alt="{{ $quiz->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/600x300?text={{ urlencode($quiz->title) }}" class="card-img-top" alt="{{ $quiz->title }}">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $quiz->title }}</h5>
                        <p class="card-text">{{ $quiz->description }}</p>
                        <p class="card-text"><small class="text-muted">{{ $quiz->question_count }} soal • Durasi {{ $quiz->duration }} menit</small></p>
                        <div class="mt-auto">
                            <!-- ✅ Tombol Preview untuk Admin -->
                            <a href="{{ route('admin.quiz-preview', $quiz->id) }}" class="btn btn-info w-100 mb-2">
                                <i class="fas fa-eye"></i> Preview Kuis
                            </a>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.manage-questions', $quiz->id) }}" class="btn btn-warning flex-fill">
                                    <i class="fas fa-edit"></i> Edit Soal
                                </a>
                                <button wire:click="deleteQuiz({{ $quiz->id }})" class="btn btn-danger flex-fill" 
                                        onclick="return confirm('Hapus kuis ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @if($quizzes->count() == 0)
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Belum ada kuis. Silakan buat kuis baru.
                </div>
            </div>
            @endif
        </div>
    </div>
</div>