<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold">Daftar Kuis IslamIQ</h2>

        <div class="row g-4 justify-content-center">
            <!-- ✅ Pastikan variable $quizzes ada -->
            @if(isset($quizzes) && $quizzes->count() > 0)
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
                                <!-- ✅ Tombol Mulai Kuis -->
                                <a href="{{ route('user.quiz-attempt', $quiz->id) }}" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-play"></i> Mulai Kuis
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Belum ada kuis yang tersedia.
                </div>
            </div>
            @endif
        </div>
    </div>
</div>