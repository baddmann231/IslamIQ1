<div class="container py-5">
    <div class="row">
        <!-- Kolom Kiri: Daftar Teman & Pencarian -->
        <div class="col-md-4">
            <!-- Card Pencarian & Tambah Teman -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Cari & Tambah Teman</h5>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Search Users -->
                    <div class="mb-3">
                        <label class="form-label">Cari Pengguna</label>
                        <div class="input-group">
                            <input type="text" class="form-control" 
                                   wire:model.live="search"
                                   wire:keydown.debounce.500ms="searchUsers"
                                   placeholder="Ketik nama pengguna...">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Search Results -->
                    @if($users->count() > 0)
                    <div class="mb-3">
                        <h6>Hasil Pencarian</h6>
                        @foreach($users as $user)
                        <div class="card mb-2">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <br>
                                        <small class="text-muted">Level {{ $user->level }}</small>
                                    </div>
                                    <button class="btn btn-primary btn-sm" 
                                            wire:click="addFriend({{ $user->id }})">
                                        <i class="fas fa-user-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Card Daftar Teman -->
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Daftar Teman</h5>
                </div>
                <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    @foreach($friends as $friend)
                    <div class="p-3 border-bottom cursor-pointer 
                                {{ $selectedFriend && $selectedFriend->id == $friend->id ? 'bg-light' : '' }}"
                         wire:click="selectFriend({{ $friend->id }})">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ $friend->avatar_url }}" class="rounded-circle me-2" 
                                     width="40" height="40" alt="{{ $friend->name }}">
                                <div>
                                    <strong>{{ $friend->name }}</strong>
                                    <br>
                                    <small class="text-muted">Level {{ $friend->level }}</small>
                                </div>
                            </div>
                            @if($unreadCounts[$friend->id] > 0)
                            <span class="badge bg-danger">{{ $unreadCounts[$friend->id] }}</span>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    @if($friends->count() == 0)
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <p>Belum ada teman</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Card Permintaan Pertemanan -->
            @if($friendRequests->count() > 0 || $pendingRequests->count() > 0)
            <div class="card shadow mt-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Permintaan Pertemanan</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Friend Requests (Masuk) -->
                    @if($friendRequests->count() > 0)
                    <div class="p-3 border-bottom">
                        <h6>Permintaan Masuk</h6>
                        @foreach($friendRequests as $request)
                        <div class="card mb-2">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $request->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">Level {{ $request->user->level }}</small>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-success btn-sm" 
                                                wire:click="acceptFriend({{ $request->id }})">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" 
                                                wire:click="rejectFriend({{ $request->id }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Pending Requests (Dikirim) -->
                    @if($pendingRequests->count() > 0)
                    <div class="p-3">
                        <h6>Menunggu Konfirmasi</h6>
                        @foreach($pendingRequests as $request)
                        <div class="card mb-2">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $request->friend->name }}</strong>
                                        <br>
                                        <small class="text-muted">Menunggu konfirmasi</small>
                                    </div>
                                    <button class="btn btn-warning btn-sm" 
                                            wire:click="cancelRequest({{ $request->id }})">
                                        <i class="fas fa-times"></i> Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Kolom Kanan: Chat -->
        <div class="col-md-8">
            <div class="card shadow h-100">
                <div class="card-header bg-info text-white">
                    @if($selectedFriend)
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <img src="{{ $selectedFriend->avatar_url }}" class="rounded-circle me-2" 
                                 width="35" height="35" alt="{{ $selectedFriend->name }}">
                            Chat dengan {{ $selectedFriend->name }}
                        </h5>
                        <small>Level {{ $selectedFriend->level }} • {{ $selectedFriend->points }} points</small>
                    </div>
                    @else
                    <h5 class="mb-0">Pilih teman untuk memulai chat</h5>
                    @endif
                </div>
                
                @if($selectedFriend)
                <div class="card-body d-flex flex-column" style="height: 600px;">
                    <!-- Messages -->
                    <div class="flex-grow-1 overflow-auto mb-3">
                        @foreach($messages as $message)
                        <div class="d-flex mb-2 {{ $message->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="card {{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }}"
                                 style="max-width: 70%;">
                                <div class="card-body py-2">
                                    <p class="mb-1">{{ $message->message }}</p>
                                    <small class="{{ $message->sender_id == auth()->id() ? 'text-white-50' : 'text-muted' }}">
                                        {{ $message->created_at->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Message Input -->
                    <div class="mt-auto">
                        <form wire:submit.prevent="sendMessage">
                            <div class="input-group">
                                <input type="text" class="form-control" 
                                       wire:model="message"
                                       placeholder="Ketik pesan..."
                                       wire:keydown.enter.prevent="sendMessage">
                                <button class="btn btn-primary" type="submit" 
                                        {{ !$message ? 'disabled' : '' }}>
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="card-body text-center text-muted d-flex flex-column justify-content-center" style="height: 600px;">
                    <i class="fas fa-comments fa-4x mb-3"></i>
                    <h5>Belum ada chat</h5>
                    <p>Pilih teman dari daftar untuk memulai percakapan</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>