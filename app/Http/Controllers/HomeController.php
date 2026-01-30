<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Authors;
use App\Models\Buku;
use App\Models\Certificate;
use App\Models\PaketPenerbit;
use App\Models\Pengaturan;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $latestArticles = Artikel::with(['kategori', 'user'])
            ->where('status', 'publish')
            ->latest()
            ->take(3)
            ->get();
        return view('home.index', [
            'title' => 'Home',
            'latestArticles' => $latestArticles,
            'settings' => Pengaturan::pluck('value', 'key'),
            'certificates' => Certificate::orderBy('position')->orderByDesc('id')->get(),
        ]);
    }

    public function tentangKami()
    {
        return view('home.tentangKami', [
            'title' => 'Tentang Kami',
        ]);
    }

    public function team()
    {
        return view('home.team', [
            'title' => 'Team',
            'teamMembers' => Tim::orderBy('position')->get()
        ]);
    }

    public function daftarPenulis()
    {
        return view('home.daftarPenulis', [
            'title' => 'Daftar Penulis',
            'settings' => Pengaturan::pluck('value', 'key')
        ]);
    }

    public function kirimNaskah()
    {
        $settings = Pengaturan::pluck('value', 'key');
        return view('home.kirimNaskah', [
            'title' => 'Kirim Naskah',
            'settings' => $settings
        ]);
    }

    public function penjelasanLayanan()
    {
        $packages = PaketPenerbit::where('active', true)
            ->orderBy('position')
            ->get();

        return view('home.penjelasanLayanan', [
            'title' => 'Penjelasan Layanan',
            'packages' => $packages,
        ]);
    }

    public function harga()
    {
        $packages = PaketPenerbit::where('active', true)
            ->orderBy('position')
            ->get();
        return view('home.harga', [
            'title' => 'Harga',
            'packages' => $packages,
        ]);
    }

    public function tokoBuku()
    {
        return view('home.tokoBuku', [
            'title' => 'Toko Buku',
        ]);
    }

    public function detailBuku($slug)
    {
        $book = Buku::with(['kategori', 'authors', 'comments.replies'])->where('slug', $slug)->where('status', true)->firstOrFail();
        $relatedBooks = Buku::where('status', true)
            ->where('id', '!=', $book->id)
            ->where(function ($query) use ($book) {
                $query->whereHas('authors', function ($q) use ($book) {
                    $q->whereIn('authors.id', $book->authors->pluck('id'));
                })
                    ->orWhere('kategori_id', $book->kategori_id);
            })
            ->limit(5)
            ->get();
        $comments = $book->comments;
        return view('home.detailBuku', [
            'title' => $book->judul,
            'book' => $book,
            'relatedBooks' => $relatedBooks,
            'comments' => $comments,
        ]);
    }

    public function detailAuthor($slug)
    {
        $author = Authors::where('slug', $slug)->firstOrFail();
        $books = $author->bukus;
        return view('home.detailAuthor', [
            'title' => $author->name,
            'author' => $author,
            'books' => $books
        ]);
    }

    public function kontak()
    {
        return view('home.kontak', [
            'title' => 'Kontak',
        ]);
    }

    public function artikel()
    {
        return view('home.artikel', [
            'title' => 'Artikel',
        ]);
    }

    public function detailArtikel($slug)
    {
        $article = Artikel::with(['kategori', 'user'])
            ->where('slug', $slug)
            ->where('status', 'publish')
            ->first();

        if (!$article) {
            return redirect()->route('home');
        }

        $article->increment('views');

        return view('home.detailArtikel', [
            'title' => $article->judul,
            'article' => $article,
        ]);
    }

    public function progressISBN()
    {
        return view('home.progressISBN', [
            'title' => 'Lihat Progress ISBN',
        ]);
    }

    public function submitComment(Request $request, $bukuId)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'content' => 'required|string|max:1000',
        ]);
        \App\Models\Comment::create([
            'buku_id' => $bukuId,
            'parent_id' => null,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'is_approved' => false,
        ]);
        return back()->with('success', 'Komentar berhasil dikirim dan akan tampil setelah disetujui admin.');
    }

    public function submitReply(Request $request, $bukuId, $parentId)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'content' => 'required|string|max:1000',
        ]);
        \App\Models\Comment::create([
            'buku_id' => $bukuId,
            'parent_id' => $parentId,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'is_approved' => false,
        ]);
        return back()->with('success', 'Balasan komentar berhasil dikirim dan akan tampil setelah disetujui admin.');
    }
}
