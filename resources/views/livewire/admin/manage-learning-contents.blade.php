<div>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Konten Pembelajaran</h1>
            <a href="{{ route('admin.learning-contents.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Konten
            </a>
        </div>

        <!-- Search -->
        <div class="card mb-4">
            <div class="card-body">
                <input type="text" wire:model.live="search" class="form-control" placeholder="Cari konten...">
            </div>
        </div>

        <!-- Flash Message -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Content Cards -->
        @if($contents->count() > 0)
            <div class="row">
                @foreach($contents as $content)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            @if($content->image)
                                <img src="{{ asset('storage/' . $content->image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $content->title }}"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="bi bi-file-text display-4 text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $content->title }}</h5>
                                <p class="card-text flex-grow-1">
                                    {{ Str::limit(strip_tags($content->content), 100) }}
                                </p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            {{ $content->created_at->format('d M Y') }}
                                        </small>
                                        <div>
                                            <a href="{{ route('admin.learning-contents.edit', $content->id) }}" 
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button wire:click="deleteContent({{ $content->id }})" 
                                                    wire:confirm="Yakin hapus konten ini?"
                                                    class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $contents->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-file-text display-1 text-muted"></i>
                <h3 class="mt-3">Belum ada konten</h3>
                <p class="text-muted">Mulai dengan membuat konten pembelajaran pertama Anda.</p>
                <a href="{{ route('admin.learning-contents.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Konten Pertama
                </a>
            </div>
        @endif
    </div>
</div>