<!-- resources/views/livewire/admin/daftar-kuis.blade.php -->
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

        <!-- ✅ TOMBOL RESET FILTER DAN INFO HASIL -->
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
                        ({{ $quizzes->count() }} kuis)
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
                                <span class="badge bg-primary">{{ $quiz->category_label }}</span>
                                @if(!$quiz->is_active)
                                    <span class="badge bg-warning">Non-Aktif</span>
                                @endif
                            </div>
                            
                            <p class="card-text">{{ $quiz->description }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-question-circle"></i> {{ $quiz->question_count }} soal • 
                                    <i class="fas fa-clock"></i> {{ $quiz->duration }} menit
                                </small>
                            </p>
                            <div class="mt-auto">
                                <!-- Tombol Preview untuk Admin -->
                                <a href="{{ route('admin.quiz-preview', $quiz->id) }}" class="btn btn-info w-100 mb-2">
                                    <i class="fas fa-eye"></i> Preview Kuis
                                </a>
                                
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.manage-questions', $quiz->id) }}" class="btn btn-warning flex-fill">
                                        <i class="fas fa-edit"></i> Edit Soal
                                    </a>
                                    <button wire:click="deleteQuiz({{ $quiz->id }})" class="btn btn-danger flex-fill" 
                                            onclick="return confirm('Hapus kuis {{ $quiz->title }}? Tindakan ini tidak dapat dibatalkan.')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
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
                        Belum ada kuis. Silakan buat kuis baru.
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- ✅ STATISTIK JUMLAH KUIS -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Statistik Kuis</h6>
                        <div class="row text-center">
                            <div class="col-md-3">
                                <span class="h5 text-primary">{{ $quizzes->count() }}</span>
                                <br>
                                <small class="text-muted">Total Kuis</small>
                            </div>
                            <div class="col-md-3">
                                <span class="h5 text-success">{{ $quizzes->where('is_active', true)->count() }}</span>
                                <br>
                                <small class="text-muted">Kuis Aktif</small>
                            </div>
                            <div class="col-md-3">
                                <span class="h5 text-warning">{{ $quizzes->where('is_active', false)->count() }}</span>
                                <br>
                                <small class="text-muted">Kuis Non-Aktif</small>
                            </div>
                            <div class="col-md-3">
                                <span class="h5 text-info">{{ $quizzes->sum('question_count') }}</span>
                                <br>
                                <small class="text-muted">Total Soal</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>