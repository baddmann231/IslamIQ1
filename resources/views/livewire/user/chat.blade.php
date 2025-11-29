<!-- resources/views/livewire/user/chat.blade.php -->
<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Daftar Teman</h5>
                </div>
                <div class="card-body p-0">
                    @foreach($friends as $friend)
                    <div class="p-3 border-bottom cursor-pointer 
                                {{ $selectedFriend && $selectedFriend->id == $friend->id ? 'bg-light' : '' }}"
                         wire:click="selectFriend({{ $friend->id }})">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $friend->name }}</strong>
                                <br>
                                <small class="text-muted">Level {{ $friend->level }}</small>
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
                        <p>Belum ada teman. Tambah teman dulu yuk!</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow h-100">
                <div class="card-header bg-success text-white">
                    @if($selectedFriend)
                    <h5 class="mb-0">Chat dengan {{ $selectedFriend->name }}</h5>
                    @else
                    <h5 class="mb-0">Pilih teman untuk memulai chat</h5>
                    @endif
                </div>
                
                @if($selectedFriend)
                <div class="card-body d-flex flex-column" style="height: 400px;">
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
                                       placeholder="Ketik pesan...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="card-body text-center text-muted">
                    <i class="fas fa-comments fa-3x mb-3"></i>
                    <p>Pilih teman dari daftar untuk memulai percakapan</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>