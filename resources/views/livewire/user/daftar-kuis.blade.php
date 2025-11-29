<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold">Daftar Kuis IslamIQ</h2>

        <!-- ✅ SEARCH BAR DAN FILTER KATEGORI -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           placeholder="Cari kuis berdasarkan judul..."
                           wire:model.live="search">
                    @if($search)
                        <button class="btn btn-outline-secondary" type="button" wire:click="$set('search', '')">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-filter"></i>
                    </span>
                    <select class="form-select" wire:model.live="category">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @if($category)
                        <button class="btn btn-outline-secondary" type="button" wire:click="$set('category', '')">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- ✅ TOMBOL RESET FILTER -->
        @if($search || $category)
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        @if($search && $category)
                            Menampilkan hasil untuk "{{ $search }}" dalam kategori {{ $categories[$category] }}
                        @elseif($search)
                            Menampilkan hasil untuk "{{ $search }}"
                        @elseif($category)
                            Menampilkan kuis kategori {{ $categories[$category] }}
                        @endif
                        ({{ $quizzes->count() }} hasil)
                    </small>
                    <button class="btn btn-sm btn-outline-secondary" wire:click="resetFilters">
                        <i class="fas fa-refresh"></i> Reset Filter
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- ✅ DAFTAR KUIS -->
        <div class="row g-4 justify-content-center">
            @if($quizzes->count() > 0)
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
                            
                            <!-- ✅ BADGE KATEGORI -->
                            <div class="mb-2">
                                <span class="badge bg-primary">
                                    {{ $categories[$quiz->category] ?? 'Umum' }}
                                </span>
                            </div>
                            
                            <p class="card-text">{{ Str::limit($quiz->description, 100) }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-question-circle"></i> {{ $quiz->question_count }} soal • 
                                    <i class="fas fa-clock"></i> {{ $quiz->duration }} menit
                                </small>
                            </p>
                            <div class="mt-auto">
                                <!-- Tombol Mulai Kuis -->
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
                    <i class="fas fa-info-circle"></i> 
                    @if($search || $category)
                        Tidak ada kuis yang sesuai dengan pencarian Anda.
                    @else
                        Belum ada kuis yang tersedia.
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>