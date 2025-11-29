<?php
// app/Livewire/User/Chat.php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Message;
use App\Models\Friendship;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Chat extends Component
{
    public $friends = [];
    public $selectedFriend = null;
    public $message = '';
    public $messages = [];
    public $unreadCounts = [];

    public function mount()
    {
        $this->loadFriends();
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
            
            // Dispatch event untuk real-time (jika menggunakan Pusher/Laravel Echo)
            $this->dispatch('messageSent');
        }
    }

    public function render()
    {
        return view('livewire.user.chat');
    }
}