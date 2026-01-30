<?php

namespace App\Livewire\Dashboard\Komentar;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class Semua extends Component
{
    use WithPagination;
    public $selectedComment = null;
    public $showDetailModal = false;

    public function showDetail($commentId)
    {
        $this->selectedComment = Comment::with('buku')->find($commentId);
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedComment = null;
    }

    public function approveComment($commentId)
    {
        $comment = Comment::find($commentId);
        $comment->is_approved = true;
        $comment->save();
        $this->dispatch('close-modal', 'show-detail-komentar');
        $this->dispatch('notify', message: 'Komentar berhasil diapprove', type: 'success');
    }

    public function rejectComment($commentId)
    {
        $comment = Comment::find($commentId);
        $comment->delete();
        $this->dispatch('close-modal', 'show-detail-komentar');
        $this->dispatch('notify', message: 'Komentar berhasil dihapus', type: 'success');
    }

    public function render()
    {
        $comments = Comment::with('buku')
            ->where('is_approved', false)
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('livewire.dashboard.komentar.semua', [
            'comments' => $comments,
        ]);
    }
}
