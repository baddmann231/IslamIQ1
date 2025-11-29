<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold">Materi Quiz IslamIQ</h2>

        <!-- Search & Filter -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           placeholder="Cari materi berdasarkan judul..."
                           wire:model.live="search">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-filter"></i>
                    </span>
                    <select class="form-select" wire:model.live="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Materi Cards -->
        <div class="row g-4 justify-content-center">
            @if($materi->count() > 0)
                @foreach($materi as $item)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="{{ $item->gambar_url }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $kategoriList[$item->kategori] ?? $item->kategori }}</span>
                            </div>
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <p class="card-text">{{ $item->deskripsi ?: $item->excerpt }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> {{ $item->durasi_baca_formatted }}
                                </small>
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('user.detail-materi', $item->slug) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-book-open"></i> Mulai Belajar
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
                    @if($search || $kategori)
                        Tidak ada materi yang sesuai dengan pencarian Anda.
                    @else
                        Belum ada materi yang tersedia.
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>