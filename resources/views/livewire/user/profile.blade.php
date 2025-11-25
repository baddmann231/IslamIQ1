<div>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Flash Message -->
            @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i>My Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Avatar Section -->
                        <div class="col-md-4 text-center">
                            <div class="avatar-section mb-4">
                                <!-- Current Avatar Display -->
                                <div class="avatar-preview mb-3">
                                    <img src="{{ auth()->user()->avatar_url }}" 
                                         alt="Profile Avatar" 
                                         class="rounded-circle shadow"
                                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #dee2e6;">
                                </div>
                                
                                <!-- Upload Avatar Form -->
                                <div class="upload-section">
                                    <form wire:submit.prevent="uploadAvatar">
                                        <label class="btn btn-outline-primary btn-sm mb-2">
                                            <i class="bi bi-upload me-1"></i> Upload Avatar
                                            <input type="file" wire:model="newAvatar" class="d-none" accept="image/*">
                                        </label>
                                        @error('newAvatar') 
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        
                                        <!-- Avatar Preview -->
                                        @if ($newAvatar)
                                            <div class="mt-2 p-2 border rounded">
                                                <p class="small mb-1">Preview:</p>
                                                <img src="{{ $newAvatar->temporaryUrl() }}" 
                                                     class="img-thumbnail mb-2" 
                                                     style="max-height: 80px;">
                                                <div class="d-flex gap-2 justify-content-center">
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
                                    
                                    <!-- Delete Avatar Button -->
                                    @if(auth()->user()->avatar)
                                        <div class="mt-2">
                                            <button wire:click="deleteAvatar" 
                                                    onclick="return confirm('Are you sure you want to delete your avatar?')"
                                                    class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash me-1"></i> Delete Avatar
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Profile Information Form -->
                        <div class="col-md-8">
                            <form wire:submit.prevent="updateProfile">
                                <h5 class="mb-3">Profile Information</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               wire:model="name" placeholder="Enter your full name">
                                        @error('name') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                                        <small class="text-muted">Email cannot be changed</small>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               wire:model="phone" placeholder="+62 812-3456-7890">
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

                                <!-- User Stats -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card bg-light">
                                            <div class="card-body py-2">
                                                <div class="row text-center">
                                                    <div class="col-4">
                                                        <small class="text-muted">Member Since</small>
                                                        <div class="fw-bold">{{ auth()->user()->created_at->format('M Y') }}</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <small class="text-muted">Role</small>
                                                        <div class="fw-bold text-capitalize">{{ auth()->user()->role }}</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <small class="text-muted">Status</small>
                                                        <div class="fw-bold text-success">Active</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <i class="bi bi-check-circle me-2"></i>
                                        <span wire:loading.remove>Update Profile</span>
                                        <span wire:loading>Updating...</span>
                                    </button>
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary ms-2">
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

<style>
.avatar-section {
    border-right: 1px solid #dee2e6;
    padding-right: 2rem;
}

.avatar-preview img {
    transition: transform 0.3s ease;
}

.avatar-preview img:hover {
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .avatar-section {
        border-right: none;
        border-bottom: 1px solid #dee2e6;
        padding-right: 0;
        padding-bottom: 2rem;
        margin-bottom: 2rem;
    }
}
</style>