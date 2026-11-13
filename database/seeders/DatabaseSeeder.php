<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\CashTransaction;
use App\Models\CommunityProfile;
use App\Models\Household;
use App\Models\LetterRequest;
use App\Models\LetterType;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@rtrw.local'],
            [
                'nama' => 'Admin RT/RW',
                'kata_sandi' => Hash::make('password'),
                'peran' => 'admin',
            ]
        );

        CommunityProfile::updateOrCreate(
            ['id' => 1],
            [
                'nama' => 'RT 001 / RW 001 Kelurahan Harmoni',
                'rt' => '001',
                'rw' => '001',
                'alamat' => 'Jl. Melati Raya No. 1, Kelurahan Harmoni',
                'kelurahan' => 'Harmoni',
                'kecamatan' => 'Sejahtera',
                'kota' => 'Kota Mandiri',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40111',
                'telepon' => '0812-0000-0001',
                'email' => 'rt001rw001@example.test',
                'nama_ketua' => 'Budi Santoso',
                'nama_wakil_ketua' => 'Ahmad Fauzi',
                'nama_sekretaris' => 'Siti Aminah',
                'nama_bendahara' => 'Dewi Lestari',
                'visi' => 'Mewujudkan lingkungan yang tertib, aman, transparan, dan saling peduli.',
                'misi' => [
                    'Digitalisasi administrasi warga',
                    'Transparansi pengelolaan kas',
                    'Penyebaran informasi yang cepat dan rapi',
                ],
            ]
        );

        $household = Household::updateOrCreate(
            ['nomor_kk' => '3273010101010001'],
            [
                'alamat' => 'Jl. Melati Raya No. 25',
                'rt' => '001',
                'rw' => '001',
                'kelurahan' => 'Harmoni',
                'kecamatan' => 'Sejahtera',
                'kota' => 'Kota Mandiri',
                'provinsi' => 'Jawa Barat',
                'kode_pos' => '40111',
                'status_rumah' => 'milik_sendiri',
                'status_ekonomi' => 'menengah',
            ]
        );

        $resident = Resident::updateOrCreate(
            ['nik' => '3273010101900001'],
            [
                'kartu_keluarga_id' => $household->id,
                'nama' => 'Andi Pratama',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1990-01-01',
                'agama' => 'Islam',
                'pendidikan' => 'S1',
                'pekerjaan' => 'Karyawan Swasta',
                'status_perkawinan' => 'Kawin',
                'status_keluarga' => 'Kepala Keluarga',
                'kewarganegaraan' => 'WNI',
                'golongan_darah' => 'O',
                'telepon' => '0812-1111-2222',
                'email' => 'warga@rtrw.local',
                'alamat_ktp' => 'Jl. Melati Raya No. 25, RT 001/RW 001',
                'status_warga' => 'aktif',
                'tanggal_masuk' => '2020-01-10',
            ]
        );

        Resident::updateOrCreate(
            ['nik' => '3273014102920002'],
            [
                'kartu_keluarga_id' => $household->id,
                'nama' => 'Rina Wulandari',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1992-02-01',
                'agama' => 'Islam',
                'pendidikan' => 'S1',
                'pekerjaan' => 'Guru',
                'status_perkawinan' => 'Kawin',
                'status_keluarga' => 'Istri',
                'kewarganegaraan' => 'WNI',
                'golongan_darah' => 'A',
                'telepon' => '0812-3333-4444',
                'alamat_ktp' => 'Jl. Melati Raya No. 25, RT 001/RW 001',
                'status_warga' => 'aktif',
                'tanggal_masuk' => '2020-01-10',
            ]
        );

        Resident::updateOrCreate(
            ['nik' => '3273011505850003'],
            [
                'kartu_keluarga_id' => $household->id,
                'nama' => 'Maya Sari',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1985-05-15',
                'agama' => 'Islam',
                'pendidikan' => 'SMA/SMK',
                'pekerjaan' => 'Wiraswasta',
                'status_perkawinan' => 'Belum Kawin',
                'status_keluarga' => 'Famili Lain',
                'kewarganegaraan' => 'WNI',
                'golongan_darah' => 'B',
                'telepon' => '0812-5555-6666',
                'alamat_ktp' => 'Jl. Melati Raya No. 25, RT 001/RW 001',
                'status_warga' => 'aktif',
                'tanggal_masuk' => '2021-03-20',
                'catatan' => 'Data contoh untuk mencoba registrasi warga.',
            ]
        );

        $household->update(['kepala_warga_id' => $resident->id]);

        User::updateOrCreate(
            ['email' => 'warga@rtrw.local'],
            [
                'warga_id' => $resident->id,
                'nama' => 'Andi Pratama',
                'kata_sandi' => Hash::make('password'),
                'peran' => 'warga',
            ]
        );

        $letterTypes = [
            ['code' => 'SKD', 'name' => 'Surat Keterangan Domisili', 'description' => 'Surat keterangan tempat tinggal warga.'],
            ['code' => 'SKTM', 'name' => 'Surat Keterangan Tidak Mampu', 'description' => 'Surat keterangan kondisi ekonomi warga.'],
            ['code' => 'PKTP', 'name' => 'Surat Pengantar KTP', 'description' => 'Surat pengantar pengurusan KTP.'],
            ['code' => 'PSKCK', 'name' => 'Surat Pengantar SKCK', 'description' => 'Surat pengantar pembuatan SKCK.'],
            ['code' => 'SKU', 'name' => 'Surat Keterangan Usaha', 'description' => 'Surat keterangan usaha warga.'],
        ];

        foreach ($letterTypes as $type) {
            LetterType::updateOrCreate(
                ['kode' => $type['code']],
                [
                    'nama' => $type['name'],
                    'deskripsi' => $type['description'],
                    'template_isi' => 'Yang bertanda tangan di bawah ini menerangkan bahwa warga tersebut benar berdomisili di wilayah RT/RW setempat.',
                    'dokumen_wajib' => ['Fotokopi KTP', 'Fotokopi KK'],
                    'aktif' => true,
                ]
            );
        }

        CashTransaction::updateOrCreate(
            ['kode_transaksi' => 'KAS-IN-20260620-0001'],
            [
                'jenis' => 'pemasukan',
                'kategori' => 'Iuran Bulanan',
                'jumlah' => 1500000,
                'tanggal_transaksi' => now()->subDays(7)->toDateString(),
                'keterangan' => 'Iuran warga bulan berjalan',
                'metode_bayar' => 'Transfer',
                'referensi' => 'TRX-001',
                'dicatat_oleh' => $admin->id,
            ]
        );

        CashTransaction::updateOrCreate(
            ['kode_transaksi' => 'KAS-OUT-20260620-0001'],
            [
                'jenis' => 'pengeluaran',
                'kategori' => 'Kebersihan',
                'jumlah' => 350000,
                'tanggal_transaksi' => now()->subDays(3)->toDateString(),
                'keterangan' => 'Pembelian alat kebersihan lingkungan',
                'metode_bayar' => 'Tunai',
                'referensi' => 'Bukti-001',
                'dicatat_oleh' => $admin->id,
            ]
        );

        Announcement::updateOrCreate(
            ['slug' => 'jadwal-kerja-bakti-minggu-ini'],
            [
                'judul' => 'Jadwal Kerja Bakti Minggu Ini',
                'kategori' => 'Kegiatan',
                'isi' => "Kerja bakti akan dilaksanakan pada hari Minggu pukul 07.00. Warga dimohon berkumpul di pos RT.",
                'terbit' => true,
                'terbit_pada' => now(),
                'dibuat_oleh' => $admin->id,
            ]
        );

        LetterRequest::updateOrCreate(
            ['nomor_surat' => 'SKD/06/2026/0001'],
            [
                'jenis_surat_id' => LetterType::where('kode', 'SKD')->value('id'),
                'warga_id' => $resident->id,
                'diajukan_oleh' => User::where('email', 'warga@rtrw.local')->value('id'),
                'diproses_oleh' => $admin->id,
                'keperluan' => 'Keperluan administrasi sekolah anak.',
                'status' => 'disetujui',
                'disetujui_pada' => now(),
            ]
        );
    }
}
