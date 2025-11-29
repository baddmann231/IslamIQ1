<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Friendship;
use App\Models\Message;
use Livewire\Attributes\Layout;
use Illuminate\Support\Collection;

#[Layout('components.layouts.app')]
class AddFriend extends Component
{
    public $search = '';
    public $users;
    public $pendingRequests;
    public $friendRequests;
    public $friends;
    
    // ✅ PROPERTIES UNTUK CHAT
    public $selectedFriend = null;
    public $message = '';
    public $messages = [];
    public $unreadCounts = [];

    public function mount()
    {
        $this->users = new Collection();
        $this->loadFriends();
        $this->loadPendingRequests();
        $this->loadFriendRequests();
    }

    public function loadFriends()
    {
        $this->friends = auth()->user()->friends()->get();
        
        // Hitung pesan belum dibaca untuk setiap teman
        foreach ($this->friends as $friend) {
            $this->unreadCounts[$friend->id] = Message::where('sender_id', $friend->id)
                ->where('receiver_id', auth()->id())
                ->where('is_read', false)
                ->count();
        }
    }

    public function loadPendingRequests()
    {
        $this->pendingRequests = auth()->user()->sentFriendships()
            ->where('status', 'pending')
            ->with('friend')
            ->get();
    }

    public function loadFriendRequests()
    {
        $this->friendRequests = auth()->user()->receivedFriendships()
            ->where('status', 'pending')
            ->with('user')
            ->get();
    }

    public function searchUsers()
    {
        if (strlen($this->search) >= 2) {
            $this->users = User::where('name', 'like', '%' . $this->search . '%')
                ->where('id', '!=', auth()->id())
                ->limit(10)
                ->get();
        } else {
            $this->users = new Collection();
        }
    }

    public function addFriend($friendId)
    {
        $existingFriendship = Friendship::where(function($query) use ($friendId) {
            $query->where('user_id', auth()->id())
                  ->where('friend_id', $friendId);
        })->orWhere(function($query) use ($friendId) {
            $query->where('user_id', $friendId)
                  ->where('friend_id', auth()->id());
        })->first();

        if (!$existingFriendship) {
            Friendship::create([
                'user_id' => auth()->id(),
                'friend_id' => $friendId,
                'status' => 'pending'
            ]);

            session()->flash('message', 'Permintaan pertemanan dikirim!');
            $this->loadPendingRequests();
        } else {
            session()->flash('error', 'Permintaan pertemanan sudah ada.');
        }
    }

    public function acceptFriend($friendshipId)
    {
        $friendship = Friendship::find($friendshipId);
        if ($friendship && $friendship->friend_id == auth()->id()) {
            $friendship->update(['status' => 'accepted']);
            session()->flash('message', 'Permintaan pertemanan diterima!');
            $this->loadFriendRequests();
            $this->loadFriends(); // Reload friends list
        }
    }

    public function rejectFriend($friendshipId)
    {
        $friendship = Friendship::find($friendshipId);
        if ($friendship && $friendship->friend_id == auth()->id()) {
            $friendship->update(['status' => 'rejected']);
            session()->flash('message', 'Permintaan pertemanan ditolak.');
            $this->loadFriendRequests();
        }
    }

    public function cancelRequest($friendshipId)
    {
        $friendship = Friendship::find($friendshipId);
        if ($friendship && $friendship->user_id == auth()->id()) {
            $friendship->delete();
            session()->flash('message', 'Permintaan pertemanan dibatalkan.');
            $this->loadPendingRequests();
        }
    }

    // ✅ METHOD UNTUK CHAT
    public function selectFriend($friendId)
    {
        $this->selectedFriend = User::find($friendId);
        $this->loadMessages();
        
        // Tandai pesan sebagai sudah dibaca
        Message::where('sender_id', $this->selectedFriend->id)
            ->where('receiver_id', auth()->id())
            ->update(['is_read' => true]);
            
        $this->loadFriends(); // Refresh unread counts
    }

    public function loadMessages()
    {
        if ($this->selectedFriend) {
            $this->messages = Message::where(function($query) {
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $this->selectedFriend->id);
            })->orWhere(function($query) {
                $query->where('sender_id', $this->selectedFriend->id)
                      ->where('receiver_id', auth()->id());
            })->orderBy('created_at', 'asc')
              ->get();
        }
    }

    public function sendMessage()
    {
        if ($this->message && $this->selectedFriend) {
            Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $this->selectedFriend->id,
                'message' => $this->message
            ]);

            $this->message = '';
            $this->loadMessages();
        }
    }

    public function render()
    {
        return view('livewire.user.add-friend');
    }
}