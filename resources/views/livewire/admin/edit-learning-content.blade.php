<div>
    <div class="container-fluid py-4">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h3 fw-bold text-dark mb-1">Edit Konten Pembelajaran</h2>
                        <p class="text-muted mb-0">Perbarui konten yang sudah ada</p>
                    </div>
                    <a href="{{ route('admin.learning-contents') }}" 
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
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

                <form wire:submit="update">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">
                            Judul Konten <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="title" wire:model="title" 
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Masukkan judul yang menarik">
                        @error('title') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold">
                            Gambar Konten (Opsional)
                        </label>
                        
                        <!-- Current Image -->
                        @if ($oldImage)
                            <div class="mb-3">
                                <p class="text-muted mb-2">Gambar Saat Ini:</p>
                                <img src="{{ asset('storage/' . $oldImage) }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 300px;">
                            </div>
                        @endif
                        
                        <input type="file" id="image" wire:model="image" 
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/*">
                        @error('image') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Preview New Image -->
                        @if ($image)
                            <div class="mt-3">
                                <p class="text-muted mb-2">Preview Gambar Baru:</p>
                                <img src="{{ $image->temporaryUrl() }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 300px;">
                            </div>
                        @endif
                        
                        <div class="form-text">
                            Format: JPG, JPEG, PNG (Maksimal 2MB)
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <label for="content" class="form-label fw-semibold">
                            Isi Konten <span class="text-danger">*</span>
                        </label>
                        <textarea id="content" wire:model="content" rows="15"
                                  class="form-control @error('content') is-invalid @enderror"
                                  placeholder="Tulis konten pembelajaran disini..."></textarea>
                        @error('content') 
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end pt-3 border-top">
                        <button type="submit" 
                                class="btn btn-primary"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <i class="bi bi-check-circle me-2"></i>Update Konten
                            </span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>