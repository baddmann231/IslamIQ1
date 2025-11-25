<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="bi bi-person-gear me-2"></i>Admin Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Avatar Section -->
                        <div class="col-md-4 text-center">
                            <div class="avatar-section mb-4">
                                <div class="avatar-preview mb-3">
                                    <img src="{{ auth()->user()->avatar_url }}" 
                                         alt="Admin Avatar" 
                                         class="rounded-circle shadow"
                                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #198754;">
                                </div>
                                
                                <div class="upload-section">
                                    <form wire:submit.prevent="uploadAvatar">
                                        <label class="btn btn-outline-success btn-sm mb-2">
                                            <i class="bi bi-upload me-1"></i> Upload Avatar
                                            <input type="file" wire:model="newAvatar" class="d-none" accept="image/*">
                                        </label>
                                        @error('newAvatar') 
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        
                                        @if ($newAvatar)
                                            <div class="mt-2 p-2 border rounded">
                                                <p class="small mb-1">Preview:</p>
                                                <img src="{{ $newAvatar->temporaryUrl() }}" 
                                                     class="img-thumbnail mb-2" 
                                                     style="max-height: 80px;">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="bi bi-check-lg"></i> Save
                                                    </button>
                                                    <button type="button" wire:click="$set('newAvatar', null)" class="btn btn-secondary btn-sm">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </form>
                                    
                                    @if(auth()->user()->avatar)
                                        <div class="mt-2">
                                            <button wire:click="deleteAvatar" 
                                                    wire:confirm="Are you sure you want to delete your avatar?"
                                                    class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash me-1"></i> Delete Avatar
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Profile Form -->
                        <div class="col-md-8">
                            <form wire:submit.prevent="updateProfile">
                                <h5 class="mb-3">Admin Information</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               wire:model="name">
                                        @error('name') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                                        <small class="text-muted">Email cannot be changed</small>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               wire:model="phone">
                                        @error('phone') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Birth Date</label>
                                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                               wire:model="birth_date">
                                        @error('birth_date') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Admin Stats -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card bg-light">
                                            <div class="card-body py-2">
                                                <div class="row text-center">
                                                    <div class="col-3">
                                                        <small class="text-muted">Role</small>
                                                        <div class="fw-bold text-success text-capitalize">{{ auth()->user()->role }}</div>
                                                    </div>
                                                    <div class="col-3">
                                                        <small class="text-muted">Admin Since</small>
                                                        <div class="fw-bold">{{ auth()->user()->created_at->format('M Y') }}</div>
                                                    </div>
                                                    <div class="col-3">
                                                        <small class="text-muted">Age</small>
                                                        <div class="fw-bold">{{ auth()->user()->age ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="col-3">
                                                        <small class="text-muted">Status</small>
                                                        <div class="fw-bold text-success">Active</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <i class="bi bi-check-circle me-2"></i>
                                        <span wire:loading.remove>Update Profile</span>
                                        <span wire:loading>Updating...</span>
                                    </button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary ms-2">
                                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>