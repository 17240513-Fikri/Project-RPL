@csrf
@if($household->exists)
    @method('PUT')
@endif

@php
    $homeStatuses = ['milik_sendiri' => 'Milik Sendiri', 'kontrak' => 'Kontrak', 'sewa' => 'Sewa', 'dinas' => 'Rumah Dinas', 'lainnya' => 'Lainnya'];
    $economicStatuses = ['pra_sejahtera' => 'Pra Sejahtera', 'menengah' => 'Menengah', 'sejahtera' => 'Sejahtera'];
@endphp

<div class="form-grid">
    <div class="field">
        <label for="family_card_number">Nomor KK</label>
        <input id="family_card_number" name="family_card_number" value="{{ old('family_card_number', $household->family_card_number) }}" required>
    </div>
    <div class="field">
        <label for="head_resident_id">Kepala Keluarga</label>
        <select id="head_resident_id" name="head_resident_id">
            <option value="">Belum dipilih</option>
            @foreach($residents as $resident)
                <option value="{{ $resident->id }}" @selected(old('head_resident_id', $household->head_resident_id) == $resident->id)>{{ $resident->name }} - {{ $resident->nik }}</option>
            @endforeach
        </select>
    </div>
    <div class="field full">
        <label for="address">Alamat</label>
        <textarea id="address" name="address" required>{{ old('address', $household->address) }}</textarea>
    </div>
    <div class="field">
        <label for="rt">RT</label>
        <input id="rt" name="rt" value="{{ old('rt', $household->rt ?: '001') }}" required>
    </div>
    <div class="field">
        <label for="rw">RW</label>
        <input id="rw" name="rw" value="{{ old('rw', $household->rw ?: '001') }}" required>
    </div>
    <div class="field">
        <label for="block">Blok/Gang</label>
        <input id="block" name="block" value="{{ old('block', $household->block) }}">
    </div>
    <div class="field">
        <label for="postal_code">Kode Pos</label>
        <input id="postal_code" name="postal_code" value="{{ old('postal_code', $household->postal_code) }}">
    </div>
    <div class="field">
        <label for="kelurahan">Kelurahan</label>
        <input id="kelurahan" name="kelurahan" value="{{ old('kelurahan', $household->kelurahan) }}">
    </div>
    <div class="field">
        <label for="kecamatan">Kecamatan</label>
        <input id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $household->kecamatan) }}">
    </div>
    <div class="field">
        <label for="city">Kota/Kabupaten</label>
        <input id="city" name="city" value="{{ old('city', $household->city) }}">
    </div>
    <div class="field">
        <label for="province">Provinsi</label>
        <input id="province" name="province" value="{{ old('province', $household->province) }}">
    </div>
    <div class="field">
        <label for="home_status">Status Rumah</label>
        <select id="home_status" name="home_status" required>
            @foreach($homeStatuses as $value => $label)
                <option value="{{ $value }}" @selected(old('home_status', $household->home_status ?: 'milik_sendiri') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="economic_status">Status Ekonomi</label>
        <select id="economic_status" name="economic_status" required>
            @foreach($economicStatuses as $value => $label)
                <option value="{{ $value }}" @selected(old('economic_status', $household->economic_status ?: 'menengah') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="field full">
        <label for="notes">Catatan</label>
        <textarea id="notes" name="notes">{{ old('notes', $household->notes) }}</textarea>
    </div>
</div>

<div class="form-actions" style="margin-top: 18px;">
    <a class="btn secondary" href="{{ route('households.index') }}">Batal</a>
    <button class="btn" type="submit">Simpan Data</button>
</div>
