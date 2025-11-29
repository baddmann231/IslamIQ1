<div>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Buat Konten Pembelajaran Baru</h1>
            <a href="{{ route('admin.learning-contents') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form wire:submit="save">
                    <!-- Judul -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Konten <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" wire:model="title" placeholder="Masukkan judul konten">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gambar -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Konten (Opsional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" wire:model="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if ($image)
                            <div class="mt-2">
                                <p class="text-muted mb-1">Preview:</p>
                                <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        @endif
                        
                        <div class="form-text">
                            Format: JPG, JPEG, PNG (Maksimal 2MB)
                        </div>
                    </div>

                    <!-- Konten -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Isi Konten <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" wire:model="content" rows="12" 
                                  placeholder="Tulis konten pembelajaran disini..."></textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Simpan Konten</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm" role="status"></span>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>