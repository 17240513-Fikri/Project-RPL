@csrf
@if($announcement->exists)
    @method('PUT')
@endif

<div class="form-grid">
    <div class="field">
        <label for="title">Judul</label>
        <input id="title" name="title" value="{{ old('title', $announcement->title) }}" required>
    </div>
    <div class="field">
        <label for="category">Kategori</label>
        <input id="category" name="category" value="{{ old('category', $announcement->category ?: 'Umum') }}" required>
    </div>
    <div class="field full">
        <label for="content">Isi Pengumuman</label>
        <textarea id="content" name="content" required>{{ old('content', $announcement->content) }}</textarea>
    </div>
    <label style="display: flex; gap: 8px; align-items: center;">
        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $announcement->is_published))> Publikasikan
    </label>
</div>

<div class="form-actions" style="margin-top: 18px;">
    <a class="btn secondary" href="{{ route('announcements.index') }}">Batal</a>
    <button class="btn" type="submit">Simpan Pengumuman</button>
</div>
