<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\LetterTemplate;
use App\Models\LetterType;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        return view('dashboard-surat.template.index', [
            'title' => 'Template Surat',
            'templates' => LetterTemplate::latest()->paginate(15),
        ]);
    }

    public function create()
    {
        return view('dashboard-surat.template.create', [
            'title' => 'Tambah Template',
            'types' => LetterType::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type_code' => ['nullable', 'string', 'max:50'],
            'content' => ['required', 'string'],
            'variables' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $template = LetterTemplate::create([
            'name' => $validated['name'],
            'type_code' => $validated['type_code'] ?? null,
            'content' => $validated['content'],
            'variables' => $this->parseVariables($validated['variables'] ?? ''),
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        $this->logAction($request->user()->id, 'template.create', $template->id, [
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('dashboard-surat.template.index')
            ->with('success', 'Template berhasil ditambahkan.');
    }

    public function edit(LetterTemplate $template)
    {
        return view('dashboard-surat.template.edit', [
            'title' => 'Edit Template',
            'template' => $template,
            'types' => LetterType::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, LetterTemplate $template)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type_code' => ['nullable', 'string', 'max:50'],
            'content' => ['required', 'string'],
            'variables' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $template->update([
            'name' => $validated['name'],
            'type_code' => $validated['type_code'] ?? null,
            'content' => $validated['content'],
            'variables' => $this->parseVariables($validated['variables'] ?? ''),
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        $this->logAction($request->user()->id, 'template.update', $template->id, []);

        return redirect()
            ->route('dashboard-surat.template.index')
            ->with('success', 'Template berhasil diperbarui.');
    }

    public function destroy(LetterTemplate $template)
    {
        $template->delete();

        $this->logAction(request()->user()->id, 'template.delete', $template->id, []);

        return back()->with('success', 'Template berhasil dihapus.');
    }

    private function parseVariables(string $raw): array
    {
        $items = array_filter(array_map('trim', explode(',', $raw)));

        return array_values($items);
    }

    private function logAction(int $userId, string $action, ?int $entityId, array $meta): void
    {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => LetterTemplate::class,
            'entity_id' => $entityId,
            'meta' => $meta,
        ]);
    }
}
