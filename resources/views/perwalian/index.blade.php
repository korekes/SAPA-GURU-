<x-app-layout>
    <x-slot name="title">
        Daftar Siswa Perwalian - {{ config('app.name') }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center shadow-inner">
                <i class="fas fa-users-cog text-sm"></i>
            </div>
            <div>
                <span class="block text-xs font-semibold text-orange-400 uppercase tracking-wider mb-0.5">Administrasi Kelas</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Daftar Siswa Perwalian
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-2">
        
        @if($kelas)
            <div class="mb-6 pl-1 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <p class="text-sm text-slate-400">
                    Menampilkan data profil dasar pertanggungjawaban peserta didik aktif pada <span class="text-white font-semibold">{{ $kelas->nama_kelas }}</span>.
                </p>
                <span class="text-[10px] font-bold uppercase tracking-wider text-orange-400 bg-orange-500/10 px-2.5 py-1 rounded-lg border border-orange-500/20 max-w-max">
                    Wali Kelas Resmi
                </span>
            </div>

            <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300 whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-900/50 text-slate-400 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800/80">
                                <th class="py-4 px-5 text-center w-20">No. Absen</th>
                                <th class="py-4 px-5">Nama Lengkap Siswa</th>
                                <th class="py-4 px-5 w-44">Nomor Induk Siswa (NIS)</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-800/60">
                            @foreach($kelas->siswa as $s)
                                <tr class="hover:bg-slate-800/10 transition duration-100">
                                    <td class="py-3 px-5 text-center font-mono text-slate-500 font-medium">
                                        {{ sprintf('%02d', $s->no_absen) }}
                                    </td>

                                    <td class="py-3 px-5 font-bold text-slate-200">
                                        {{ $s->nama }}
                                    </td>

                                    <td class="py-3 px-5 font-mono text-xs text-slate-400 tracking-wider">
                                        {{ $s->nis }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @else
            <div class="bg-[#111827] rounded-2xl p-10 border border-slate-800/80 text-center text-slate-500 font-medium">
                <div class="flex flex-col items-center justify-center gap-3 py-6">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-600 text-xl shadow-inner">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="max-w-sm">
                        <h3 class="text-slate-300 font-bold text-sm mb-1">Akses Terbatasi</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Akun Anda saat ini tidak terdaftar sebagai wali kelas aktif pada semester ini. Hubungi bagian kurikulum jika terjadi kesalahan penugasan.
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>