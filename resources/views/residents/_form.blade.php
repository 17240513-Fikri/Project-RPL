@csrf
@if($resident->exists)
    @method('PUT')
@endif

@php
    $genderOptions = ['Laki-laki', 'Perempuan'];
    $religionOptions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    $educationOptions = ['Tidak Sekolah', 'SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'];
    $maritalOptions = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];
    $familyOptions = ['Kepala Keluarga', 'Istri', 'Anak', 'Orang Tua', 'Famili Lain'];
    $statusOptions = ['aktif', 'sementara', 'pindah', 'meninggal'];
@endphp

<div class="form-grid">
    <div class="field">
        <label for="nik">NIK</label>
        <input id="nik" name="nik" value="{{ old('nik', $resident->nik) }}" required>
    </div>
    <div class="field">
        <label for="name">Nama Lengkap</label>
        <input id="name" name="name" value="{{ old('name', $resident->name) }}" required>
    </div>
    <div class="field">
        <label for="household_id">Nomor KK</label>
        <select id="household_id" name="household_id">
            <option value="">Belum terhubung</option>
            @foreach($households as $household)
                <option value="{{ $household->id }}" @selected(old('household_id', $resident->household_id) == $household->id)>
                    {{ $household->family_card_number }} - {{ $household->address }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="gender">Jenis Kelamin</label>
        <select id="gender" name="gender" required>
            @foreach($genderOptions as $option)
                <option value="{{ $option }}" @selected(old('gender', $resident->gender) === $option)>{{ $option }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="birth_place">Tempat Lahir</label>
        <input id="birth_place" name="birth_place" value="{{ old('birth_place', $resident->birth_place) }}">
    </div>
    <div class="field">
        <label for="birth_date">Tanggal Lahir</label>
        <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date', optional($resident->birth_date)->format('Y-m-d')) }}">
    </div>
    <div class="field">
        <label for="religion">Agama</label>
        <select id="religion" name="religion">
            <option value="">Pilih agama</option>
            @foreach($religionOptions as $option)
                <option value="{{ $option }}" @selected(old('religion', $resident->religion) === $option)>{{ $option }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="education">Pendidikan</label>
        <select id="education" name="education">
            <option value="">Pilih pendidikan</option>
            @foreach($educationOptions as $option)
                <option value="{{ $option }}" @selected(old('education', $resident->education) === $option)>{{ $option }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="occupation">Pekerjaan</label>
        <input id="occupation" name="occupation" value="{{ old('occupation', $resident->occupation) }}">
    </div>
    <div class="field">
        <label for="marital_status">Status Perkawinan</label>
        <select id="marital_status" name="marital_status">
            <option value="">Pilih status</option>
            @foreach($maritalOptions as $option)
                <option value="{{ $option }}" @selected(old('marital_status', $resident->marital_status) === $option)>{{ $option }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="family_status">Status Dalam Keluarga</label>
        <select id="family_status" name="family_status">
            <option value="">Pilih status</option>
            @foreach($familyOptions as $option)
                <option value="{{ $option }}" @selected(old('family_status', $resident->family_status) === $option)>{{ $option }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="citizenship">Kewarganegaraan</label>
        <input id="citizenship" name="citizenship" value="{{ old('citizenship', $resident->citizenship ?: 'WNI') }}">
    </div>
    <div class="field">
        <label for="blood_type">Golongan Darah</label>
        <input id="blood_type" name="blood_type" value="{{ old('blood_type', $resident->blood_type) }}">
    </div>
    <div class="field">
        <label for="phone">Telepon</label>
        <input id="phone" name="phone" value="{{ old('phone', $resident->phone) }}">
    </div>
    <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $resident->email) }}">
    </div>
    <div class="field">
        <label for="resident_status">Status Warga</label>
        <select id="resident_status" name="resident_status" required>
            @foreach($statusOptions as $option)
                <option value="{{ $option }}" @selected(old('resident_status', $resident->resident_status ?: 'aktif') === $option)>{{ ucwords($option) }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label for="arrival_date">Tanggal Masuk</label>
        <input id="arrival_date" name="arrival_date" type="date" value="{{ old('arrival_date', optional($resident->arrival_date)->format('Y-m-d')) }}">
    </div>
    <div class="field">
        <label for="departure_date">Tanggal Keluar</label>
        <input id="departure_date" name="departure_date" type="date" value="{{ old('departure_date', optional($resident->departure_date)->format('Y-m-d')) }}">
    </div>
    <div class="field full">
        <label for="address_on_id">Alamat Sesuai KTP</label>
        <textarea id="address_on_id" name="address_on_id">{{ old('address_on_id', $resident->address_on_id) }}</textarea>
    </div>
    <div class="field full">
        <label for="notes">Catatan</label>
        <textarea id="notes" name="notes">{{ old('notes', $resident->notes) }}</textarea>
    </div>
</div>

<div class="form-actions" style="margin-top: 18px;">
    <a class="btn secondary" href="{{ route('residents.index') }}">Batal</a>
    <button class="btn" type="submit">Simpan Data</button>
</div>
