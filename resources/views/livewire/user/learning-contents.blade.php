<div>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-dark">Konten Pembelajaran</h1>
            <p class="lead text-muted">Tingkatkan pengetahuan Anda dengan materi pembelajaran berkualitas</p>
        </div>

        <!-- Search -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" wire:model.live="search" 
                           class="form-control border-start-0" 
                           placeholder="Cari konten pembelajaran...">
                </div>
            </div>
        </div>

        <!-- Content Cards -->
        @if($contents->count() > 0)
            <div class="row g-4">
                @foreach($contents as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <!-- Image -->
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $item->title }}"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="bi bi-file-text display-4 text-muted"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark">{{ $item->title }}</h5>
                                <p class="card-text text-muted flex-grow-1">
                                    {{ Str::limit(strip_tags($item->content), 120) }}
                                </p>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $item->created_at->format('d M Y') }}
                                        </small>
                                        <a href="{{ route('user.learning-contents.detail', $item->id) }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="bi bi-book me-1"></i>Baca
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $contents->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="bi bi-file-text display-1 text-muted"></i>
                <h3 class="mt-3 text-dark">Belum ada konten</h3>
                <p class="text-muted">Konten pembelajaran akan segera tersedia.</p>
                @if($search)
                    <p class="text-muted">Coba dengan kata kunci lain</p>
                @endif
            </div>
        @endif
    </div>
</div>