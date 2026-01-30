<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorSettingsController extends Controller
{
    public function index()
    {
        $author = Auth::user()?->author;
        if (! $author) {
            abort(403, 'Author profile not found.');
        }

        return view('author.settings.index', [
            'title' => 'Pengaturan',
            'author' => $author,
        ]);
    }

    public function update(Request $request)
    {
        $author = Auth::user()?->author;
        if (! $author) {
            abort(403, 'Author profile not found.');
        }

        $validated = $request->validate([
            'bank_name' => 'required|string|max:100',
            'bank_account_name' => 'required|string|max:150',
            'bank_account_number' => 'required|string|max:50',
        ]);

        $author->update($validated);

        return back()->with('success', 'Info rekening berhasil diperbarui.');
    }
}
