<div>
    <div class="container-fluid py-4">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('user.learning-contents') }}" 
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Konten
            </a>
        </div>

        <!-- Main Content Card -->
        <div class="card shadow border-0">
            <!-- Header Image -->
            @if($content->image)
                <img src="{{ asset('storage/' . $content->image) }}" 
                     class="card-img-top" 
                     alt="{{ $content->title }}"
                     style="max-height: 400px; object-fit: cover;">
            @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                     style="height: 200px;">
                    <i class="bi bi-file-text display-1 text-muted"></i>
                </div>
            @endif

            <div class="card-body p-4">
                <!-- Title -->
                <h1 class="card-title display-6 fw-bold text-dark mb-3">{{ $content->title }}</h1>
                
                <!-- Meta Info -->
                <div class="d-flex flex-wrap gap-3 text-muted mb-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar3 me-2"></i>
                        <span>Diposting {{ $content->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person me-2"></i>
                        <span>Oleh: {{ $content->admin->name }}</span>
                    </div>
                </div>

                <hr>

                <!-- Content -->
                <div class="content-body">
                    {!! nl2br(e($content->content)) !!}
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                    <a href="{{ route('user.learning-contents') }}" 
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    
                    <div class="d-flex gap-2">
                        <button onclick="window.print()" class="btn btn-outline-primary">
                            <i class="bi bi-printer me-2"></i>Cetak
                        </button>
                        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                                class="btn btn-outline-success">
                            <i class="bi bi-arrow-up me-2"></i>Ke Atas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>