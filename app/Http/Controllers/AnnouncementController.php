<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with('author')
            ->when(! $request->user()->isAdmin(), fn ($q) => $q->where('terbit', true))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->string('search');
                $q->where(function ($sub) use ($search) {
                    $sub->where('judul', 'like', "%{$search}%")
                        ->orWhere('kategori', 'like', "%{$search}%")
                        ->orWhere('isi', 'like', "%{$search}%");
                });
            });

        return view('announcements.index', [
            'announcements' => $query->latest('terbit_pada')->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('announcements.create', [
            'announcement' => new Announcement(['is_published' => true]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;
        $data['created_by'] = $request->user()->id;

        Announcement::create($data);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dipublikasikan.');
    }

    public function show(Request $request, Announcement $announcement)
    {
        if (! $announcement->is_published && ! $request->user()->isAdmin()) {
            abort(404);
        }

        $announcement->load('author');

        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $this->validatedData($request, $announcement);
        $data['slug'] = $announcement->title === $data['title']
            ? $announcement->slug
            : $this->uniqueSlug($data['title'], $announcement);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($announcement->published_at ?: now()) : null;

        $announcement->update($data);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Announcement $announcement = null): array
    {
        return $request->validate([
            'title' => ['required', 'max:255'],
            'category' => ['required', 'max:100'],
            'content' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
            'slug' => ['nullable', Rule::unique('pengumuman', 'slug')->ignore($announcement)],
        ]);
    }

    private function uniqueSlug(string $title, ?Announcement $announcement = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $number = 2;

        while (Announcement::where('slug', $slug)
            ->when($announcement, fn ($q) => $q->where('id', '!=', $announcement->id))
            ->exists()) {
            $slug = "{$base}-{$number}";
            $number++;
        }

        return $slug;
    }
}
