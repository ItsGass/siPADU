<?php

namespace Database\Seeders;

use App\Enums\ComplaintCategory;
use App\Enums\ComplaintPriority;
use App\Enums\ComplaintStatus;
use App\Enums\SuggestionType;
use App\Models\Complaint;
use App\Models\ContactMessage;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = $this->createUser([
            'name' => 'Admin SIPADU',
            'email' => 'admin@unpam.ac.id',
            'role' => User::ROLE_ADMIN,
        ]);

        $rizky = $this->createUser([
            'name' => 'Rizky Pratama',
            'nim' => '2210112345',
            'program_studi' => 'Teknik Informatika',
            'no_hp' => '081234567890',
            'email' => 'mahasiswa@unpam.ac.id',
        ]);

        $ahmad = $this->createUser([
            'name' => 'Ahmad Fauzi',
            'nim' => '2210112001',
            'program_studi' => 'Sistem Informasi',
            'no_hp' => '081298765432',
            'email' => 'ahmad@unpam.ac.id',
        ]);

        $siti = $this->createUser([
            'name' => 'Siti Nurhaliza',
            'nim' => '2310112002',
            'program_studi' => 'Manajemen',
            'no_hp' => '081377788899',
            'email' => 'siti@unpam.ac.id',
        ]);

        $budi = $this->createUser([
            'name' => 'Budi Santoso',
            'nim' => '2310112003',
            'program_studi' => 'Akuntansi',
            'no_hp' => '081355566677',
            'email' => 'budi@unpam.ac.id',
        ]);

        $this->seedComplaints($admin, $rizky, $ahmad, $siti, $budi);
        $this->seedSuggestions($rizky, $ahmad, $siti, $budi);

        ContactMessage::query()->create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@unpam.ac.id',
            'subject' => 'Pertanyaan ketersediaan jadwal konsultasi',
            'message' => 'Selamat siang, apakah SIPADU juga dapat digunakan untuk konsultasi akademik selain pengaduan? Terima kasih.',
        ]);

        ContactMessage::query()->create([
            'name' => 'Fajar Ramadhan',
            'email' => 'fajar@unpam.ac.id',
            'subject' => 'Kendala unggah bukti pengaduan',
            'message' => 'Saya mencoba mengunggah foto bukti berukuran 4 MB namun gagal. Mohon informasi batas ukuran file yang disarankan.',
        ]);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createUser(array $attributes): User
    {
        $user = User::query()->create([
            ...$attributes,
            'password' => 'password',
            'role' => $attributes['role'] ?? User::ROLE_MAHASISWA,
        ]);

        $user->forceFill(['email_verified_at' => now()])->save();

        return $user;
    }

    private function seedComplaints(User $admin, User ...$students): void
    {
        $samples = [
            [
                'student' => 0,
                'category' => ComplaintCategory::Fasilitas,
                'title' => 'AC ruang laboratorium komputer tidak berfungsi',
                'description' => "Selama dua minggu terakhir, AC di ruang laboratorium komputer Gedung C lantai 2 tidak berfungsi dengan baik. Ruangan menjadi sangat panas sehingga mahasiswa sulit berkonsentrasi saat praktikum.\n\nKami berharap unit fasilitas dapat segera melakukan pengecekan dan perbaikan.",
                'location' => 'Gedung C, Lantai 2 - Lab Komputer 2',
                'status' => ComplaintStatus::Diproses,
                'priority' => ComplaintPriority::Tinggi,
                'days_ago' => 4,
                'is_anonymous' => false,
            ],
            [
                'student' => 1,
                'category' => ComplaintCategory::Akademik,
                'title' => 'Nilai mata kuliah belum keluar di portal akademik',
                'description' => "Nilai mata kuliah Basis Data semester lalu belum muncul di portal akademik, padahal perkuliahan semester baru sudah berjalan. Hal ini menghambat pengisian KRS dan perhitungan IPK saya.\n\nMohon bantuan untuk mengecek status input nilai tersebut.",
                'location' => 'Portal Akademik',
                'status' => ComplaintStatus::Selesai,
                'priority' => ComplaintPriority::Sedang,
                'days_ago' => 12,
                'is_anonymous' => false,
                'updates' => [
                    [ComplaintStatus::Diverifikasi, 'Pengaduan telah diverifikasi dan diteruskan ke bagian akademik.', 10],
                    [ComplaintStatus::Diproses, 'Bagian akademik sedang berkoordinasi dengan dosen pengampu.', 8],
                    [ComplaintStatus::Selesai, 'Nilai telah diinput dan kini sudah tampil di portal akademik. Silakan dicek kembali.', 5],
                ],
            ],
            [
                'student' => 2,
                'category' => ComplaintCategory::Pelayanan,
                'title' => 'Antrean layanan administrasi terlalu panjang',
                'description' => 'Proses pengambilan surat keterangan aktif kuliah membutuhkan waktu hampir tiga jam karena hanya satu loket yang melayani. Mohon dipertimbangkan penambahan loket atau sistem antrean online.',
                'location' => 'Gedung A, Lantai 1',
                'status' => ComplaintStatus::Diverifikasi,
                'priority' => ComplaintPriority::Sedang,
                'days_ago' => 3,
                'is_anonymous' => true,
                'updates' => [
                    [ComplaintStatus::Diverifikasi, 'Terima kasih atas masukannya. Laporan telah diverifikasi dan akan dibahas bersama unit layanan administrasi.', 2],
                ],
            ],
            [
                'student' => 0,
                'category' => ComplaintCategory::Keuangan,
                'title' => 'Bukti pembayaran UKT belum tercatat di sistem',
                'description' => "Saya sudah melakukan pembayaran UKT melalui bank pada tanggal 10 bulan lalu, namun status pembayaran di portal masih belum berubah. Bukti transfer sudah saya lampirkan pada pengaduan ini.\n\nMohon bantuan untuk verifikasi pembayaran saya.",
                'location' => 'Portal Keuangan',
                'status' => ComplaintStatus::Baru,
                'priority' => ComplaintPriority::Tinggi,
                'days_ago' => 1,
                'is_anonymous' => false,
            ],
            [
                'student' => 3,
                'category' => ComplaintCategory::Dosen,
                'title' => 'Jadwal penggantian kelas belum diinformasikan',
                'description' => 'Dosen mata kuliah Hukum Bisnis tidak hadir pada dua pertemuan terakhir, namun belum ada informasi mengenai jadwal penggantian kelas. Mahasiswa kesulitan mempersiapkan diri untuk ujian akhir semester.',
                'location' => 'Gedung B, Lantai 3',
                'status' => ComplaintStatus::Diproses,
                'priority' => ComplaintPriority::Sedang,
                'days_ago' => 6,
                'is_anonymous' => false,
                'updates' => [
                    [ComplaintStatus::Diverifikasi, 'Laporan telah diverifikasi. Kami sedang menghubungi dosen yang bersangkutan.', 5],
                    [ComplaintStatus::Diproses, 'Program studi sedang mengatur jadwal penggantian kelas. Informasi akan disampaikan melalui ketua kelas.', 3],
                ],
            ],
            [
                'student' => 1,
                'category' => ComplaintCategory::Fasilitas,
                'title' => 'WiFi kampus sering terputus di area perpustakaan',
                'description' => 'Koneksi WiFi di area perpustakaan sering terputus, terutama pada jam 10.00 sampai 14.00. Hal ini mengganggu mahasiswa yang sedang mengerjakan tugas dan mengakses jurnal online.',
                'location' => 'Perpustakaan Lantai 1',
                'status' => ComplaintStatus::Diverifikasi,
                'priority' => ComplaintPriority::Sedang,
                'days_ago' => 2,
                'is_anonymous' => true,
                'updates' => [
                    [ComplaintStatus::Diverifikasi, 'Terima kasih atas laporannya. Tim IT akan melakukan pengecekan jaringan di area perpustakaan.', 1],
                ],
            ],
            [
                'student' => 2,
                'category' => ComplaintCategory::Akademik,
                'title' => 'Perubahan jadwal kuliah mendadak tanpa pemberitahuan',
                'description' => 'Jadwal kuliah Manajemen Keuangan berubah dari hari Senin ke hari Kamis tanpa pemberitahuan resmi. Banyak mahasiswa yang sudah memiliki jadwal lain pada hari tersebut dan tidak dapat hadir.',
                'location' => 'Gedung A, Ruang 204',
                'status' => ComplaintStatus::Ditolak,
                'priority' => ComplaintPriority::Rendah,
                'days_ago' => 9,
                'is_anonymous' => false,
                'updates' => [
                    [ComplaintStatus::Diverifikasi, 'Laporan telah diverifikasi.', 8],
                    [ComplaintStatus::Ditolak, 'Berdasarkan pengecekan, perubahan jadwal telah diinformasikan melalui grup akademik masing-masing kelas. Pengaduan ditutup.', 6],
                ],
            ],
            [
                'student' => 0,
                'category' => ComplaintCategory::Lainnya,
                'title' => 'Area parkir kampus belum tertata dengan baik',
                'description' => 'Area parkir motor di dekat gerbang utama belum tertata rapi. Banyak kendaraan yang saling menghalangi sehingga sulit keluar, terutama saat jam pulang kuliah. Mohon penataan ulang dan penambahan petunjuk parkir.',
                'location' => 'Area Parkir Gerbang Utama',
                'status' => ComplaintStatus::Selesai,
                'priority' => ComplaintPriority::Rendah,
                'days_ago' => 16,
                'is_anonymous' => true,
                'updates' => [
                    [ComplaintStatus::Diverifikasi, 'Laporan diterima dan diteruskan ke unit sarana dan prasarana.', 15],
                    [ComplaintStatus::Diproses, 'Tim sarana sedang melakukan penataan ulang area parkir.', 11],
                    [ComplaintStatus::Selesai, 'Penataan area parkir telah selesai dilakukan. Mohon tetap mengikuti petunjuk petugas.', 7],
                ],
            ],
            [
                'student' => 3,
                'category' => ComplaintCategory::Pelayanan,
                'title' => 'Informasi beasiswa belum dipublikasikan secara luas',
                'description' => 'Informasi mengenai beasiswa prestasi hanya disampaikan melalui grup angkatan, sehingga banyak mahasiswa yang tidak mengetahuinya. Mohon informasi beasiswa juga dipublikasikan melalui website kampus dan media sosial resmi.',
                'location' => 'Bagian Kemahasiswaan',
                'status' => ComplaintStatus::Baru,
                'priority' => ComplaintPriority::Rendah,
                'days_ago' => 1,
                'is_anonymous' => false,
            ],
        ];

        foreach ($samples as $sample) {
            $createdAt = Carbon::now()->subDays($sample['days_ago'])->setTime(9, 15)->subHours(random_int(0, 5));

            $complaint = Complaint::query()->create([
                'user_id' => $students[$sample['student']]->id,
                'category' => $sample['category'],
                'title' => $sample['title'],
                'description' => $sample['description'],
                'location' => $sample['location'],
                'incident_date' => $createdAt->copy()->subDays(random_int(1, 3)),
                'is_anonymous' => $sample['is_anonymous'],
                'status' => $sample['status'],
                'priority' => $sample['priority'],
            ]);

            $complaint->forceFill(['created_at' => $createdAt, 'updated_at' => $createdAt])->save();

            $lastUpdateDaysAgo = null;

            foreach ($sample['updates'] ?? [] as [$status, $message, $daysAgo]) {
                $update = $complaint->updates()->create([
                    'user_id' => $admin->id,
                    'status' => $status,
                    'message' => $message,
                ]);

                $update->forceFill([
                    'created_at' => Carbon::now()->subDays($daysAgo),
                    'updated_at' => Carbon::now()->subDays($daysAgo),
                ])->save();

                $lastUpdateDaysAgo = $daysAgo;
            }

            $complaint->forceFill([
                'updated_at' => $lastUpdateDaysAgo === null ? $createdAt : now()->subDays($lastUpdateDaysAgo),
            ])->save();
        }
    }

    private function seedSuggestions(User ...$students): void
    {
        $samples = [
            ['student' => 0, 'type' => SuggestionType::Saran, 'subject' => 'Tambahkan fitur notifikasi WhatsApp', 'message' => 'Akan lebih membantu jika status pengaduan juga dikirim melalui notifikasi WhatsApp agar mahasiswa tidak perlu terus membuka dashboard.', 'is_anonymous' => false, 'is_reviewed' => false],
            ['student' => 1, 'type' => SuggestionType::Kritik, 'subject' => 'Proses verifikasi pengaduan masih lambat', 'message' => 'Beberapa pengaduan teman saya membutuhkan waktu lebih dari tiga hari hanya untuk status verifikasi. Mohon standar waktu verifikasi diperjelas dan dipercepat.', 'is_anonymous' => true, 'is_reviewed' => true],
            ['student' => 2, 'type' => SuggestionType::Saran, 'subject' => 'Adakan sesi sosialisasi SIPADU', 'message' => 'Sosialisasi penggunaan SIPADU untuk mahasiswa baru akan sangat membantu, terutama saat orientasi mahasiswa.', 'is_anonymous' => false, 'is_reviewed' => false],
            ['student' => 3, 'type' => SuggestionType::Saran, 'subject' => 'Tampilkan estimasi waktu penanganan', 'message' => 'Setiap kategori pengaduan sebaiknya memiliki estimasi waktu penanganan agar mahasiswa dapat menyesuaikan ekspektasi.', 'is_anonymous' => false, 'is_reviewed' => true],
            ['student' => 0, 'type' => SuggestionType::Kritik, 'subject' => 'Tampilan jadwal layanan kontak kurang jelas', 'message' => 'Informasi jam layanan pada halaman kontak sebaiknya dipertegas, termasuk hari libur dan layanan daring.', 'is_anonymous' => true, 'is_reviewed' => false],
            ['student' => 1, 'type' => SuggestionType::Saran, 'subject' => 'Tambahkan kategori beasiswa', 'message' => 'Kategori pengaduan sebaiknya mencakup beasiswa secara khusus agar laporan terkait beasiswa lebih mudah dikelompokkan.', 'is_anonymous' => false, 'is_reviewed' => false],
        ];

        foreach ($samples as $sample) {
            $suggestion = Suggestion::query()->create([
                'user_id' => $students[$sample['student']]->id,
                'type' => $sample['type'],
                'subject' => $sample['subject'],
                'message' => $sample['message'],
                'is_anonymous' => $sample['is_anonymous'],
                'is_reviewed' => $sample['is_reviewed'],
            ]);

            $suggestion->forceFill(['created_at' => now()->subDays(random_int(0, 10))])->save();
        }
    }
}
