<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kelas' => 'X TSM', 'wali_kelas' => "Darul Ma'arif, S.Pd.I"],
            ['nama_kelas' => 'X TKR 1', 'wali_kelas' => 'Supriyanto, S.Pd.,M.Pd'],
            ['nama_kelas' => 'X TKR 2', 'wali_kelas' => 'Dwi Artinawati, S.Pd'],
            ['nama_kelas' => 'X TKR 3', 'wali_kelas' => 'Khannatul Fitriyani, S.Pd'],
            ['nama_kelas' => 'X TJKT 1', 'wali_kelas' => 'Nur Azimah, S.Ag'],
            ['nama_kelas' => 'X TJKT 2', 'wali_kelas' => 'Yuda Abidin Muchtar, S.Pd'],
            ['nama_kelas' => 'X TJKT 3', 'wali_kelas' => 'Arifin Setya Budi, S.Pd'],
            ['nama_kelas' => 'X TJKT 4', 'wali_kelas' => 'Munirul Hakim, S.Pd'],
            ['nama_kelas' => 'X TEI', 'wali_kelas' => 'Naning Khikmawati, S.Pd'],
            ['nama_kelas' => 'X TAV 1', 'wali_kelas' => 'Slamet Riyanto, S.Pd'],
            ['nama_kelas' => 'X TAV 2', 'wali_kelas' => 'Lutfia Kusuma Dewi, S.Pd.,M.Pd'],
            ['nama_kelas' => 'X TAV 3', 'wali_kelas' => 'Sukma Indri Hapsari, S.Pd'],

            ['nama_kelas' => 'XI TO 1', 'wali_kelas' => 'Sofiyanti, S.Pd'],
            ['nama_kelas' => 'XI TO 2', 'wali_kelas' => 'Adeng Fatah Bintoro, S.Pd.,M.Pd'],
            ['nama_kelas' => 'XI TO 3', 'wali_kelas' => 'Abdul Rosyid, S.Pd'],
            ['nama_kelas' => 'XI TO 4', 'wali_kelas' => 'Istiqomah, S.Pd'],

            ['nama_kelas' => 'XI TJKT 1', 'wali_kelas' => 'Nur Indah Ariyani, S.Kom'],
            ['nama_kelas' => 'XI TJKT 2', 'wali_kelas' => 'Fahrudin Kartika Aji, S.Pd'],
            ['nama_kelas' => 'XI TJKT 3', 'wali_kelas' => 'Ahmad Oktri W.S, S.Kom'],
            ['nama_kelas' => 'XI TJKT 4', 'wali_kelas' => 'Kumayah, S.Kom'],

            ['nama_kelas' => 'XI TE 1', 'wali_kelas' => 'Amin Mustaqim, S.Pd'],
            ['nama_kelas' => 'XI TE 2', 'wali_kelas' => 'Mohammad Hasan, S.Pd'],
            ['nama_kelas' => 'XI TE 3', 'wali_kelas' => 'Paryadi, S.Pd'],
            ['nama_kelas' => 'XI TE 4', 'wali_kelas' => 'Tino Nafis Junalia, S.Pd'],

            ['nama_kelas' => 'XII TO 1', 'wali_kelas' => 'Iwan Kurniawan, S.Pd.,M.Pd'],
            ['nama_kelas' => 'XII TO 2', 'wali_kelas' => 'Andi Bahroin, S.Pd'],
            ['nama_kelas' => 'XII TO 3', 'wali_kelas' => 'Fitria Thyastiani Hadi, S.Pd'],
            ['nama_kelas' => 'XII TO 4', 'wali_kelas' => 'Widayaningsih, S.Pd.,M.Pd'],

            ['nama_kelas' => 'XII TJKT 1', 'wali_kelas' => 'Septiani, S.Pd'],
            ['nama_kelas' => 'XII TJKT 2', 'wali_kelas' => 'Eka Yuni Rahmawati, S.Pd'],
            ['nama_kelas' => 'XII TJKT 3', 'wali_kelas' => 'Ponsari, S.Pd.,M.Pd'],
            ['nama_kelas' => 'XII TJKT 4', 'wali_kelas' => 'Ibrahim Ghufron, S.Kom'],

            ['nama_kelas' => 'XII TE 1', 'wali_kelas' => 'Kasnawi, S.Pd.,M.Pd'],
            ['nama_kelas' => 'XII TE 2', 'wali_kelas' => 'Muh Dalhar, S.T,.M.Pd'],
            ['nama_kelas' => 'XII TE 3', 'wali_kelas' => 'Wike Dirga Indaryanti, S.Pd'],
            ['nama_kelas' => 'XII TE 4', 'wali_kelas' => 'Ani Faridha, S.Pd'],
        ];

        foreach ($data as $kelas) {
            Kelas::create($kelas);
        }
    }
}