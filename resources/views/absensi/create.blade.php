<x-app-layout>
    <x-slot name="title">
        Input Absensi Baru - {{ $kelas->nama_kelas }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('absensi.kelas', $kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Sistem Presensi</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Input Absensi Baru
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-2">
        
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 bg-[#111827] p-4 rounded-xl border border-slate-800/80 shadow-sm">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-1">Tanggal Sesi</label>
                    <div class="relative">
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition duration-150" required>
                    </div>
                </div>
                
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-1">Mata Pelajaran</label>
                    @php
                        $mapel = auth()->user()->guru->mapel ?? 'Umum / Tematik';
                    @endphp
                    <input type="text" name="mapel" value="{{ $mapel }}"
                           class="w-full px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition duration-150"
                           placeholder="Masukkan nama mata pelajaran">
                </div>
            </div>

            <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden">
                <div class="p-4 bg-slate-900/50 border-b border-slate-800/80 flex justify-between items-center">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">
                        Kelas: <span class="text-white font-extrabold">{{ $kelas->nama_kelas }}</span>
                    </span>
                    <span class="text-xs text-slate-400">Total: <span class="font-bold text-indigo-400 font-mono">{{ $kelas->siswa->count() }}</span> Siswa</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300 whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-900/30 text-slate-400 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800/80">
                                <th class="py-3 px-6 text-center w-16">No</th>
                                <th class="py-3 px-6">Nama Lengkap</th>
                                <th class="py-3 px-4 text-center w-24">Hadir</th>
                                <th class="py-3 px-4 text-center w-24">Izin</th>
                                <th class="py-3 px-4 text-center w-24">Sakit</th>
                                <th class="py-3 px-4 text-center w-24">Alfa</th>
                                <th class="py-3 px-6 text-center w-64">Catatan / Keterangan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-800/60">
                            @foreach($kelas->siswa->sortBy('no_absen') as $s)
                            <tr class="hover:bg-slate-800/20 transition duration-100">
                                <td class="py-3.5 px-6 text-center font-semibold text-slate-500">
                                    {{ sprintf('%02d', $s->no_absen) }}
                                </td>

                                <td class="py-3.5 px-6 font-bold text-slate-200">
                                    {{ $s->nama }}
                                </td>

                                <td class="py-3.5 px-4 text-center">
                                    <label class="inline-flex items-center justify-center p-2 rounded-lg cursor-pointer hover:bg-slate-800/60 transition group-radio">
                                        <input type="radio" name="status[{{ $s->id }}]" value="hadir" checked
                                               class="w-4 h-4 text-emerald-500 bg-slate-900 border-slate-700 focus:ring-offset-slate-900 focus:ring-emerald-500/40">
                                    </label>
                                </td>

                                <td class="py-3.5 px-4 text-center">
                                    <label class="inline-flex items-center justify-center p-2 rounded-lg cursor-pointer hover:bg-slate-800/60 transition group-radio">
                                        <input type="radio" name="status[{{ $s->id }}]" value="izin"
                                               class="w-4 h-4 text-amber-500 bg-slate-900 border-slate-700 focus:ring-offset-slate-900 focus:ring-amber-500/40">
                                    </label>
                                </td>

                                <td class="py-3.5 px-4 text-center">
                                    <label class="inline-flex items-center justify-center p-2 rounded-lg cursor-pointer hover:bg-slate-800/60 transition group-radio">
                                        <input type="radio" name="status[{{ $s->id }}]" value="sakit"
                                               class="w-4 h-4 text-sky-500 bg-slate-900 border-slate-700 focus:ring-offset-slate-900 focus:ring-sky-500/40">
                                    </label>
                                </td>

                                <td class="py-3.5 px-4 text-center">
                                    <label class="inline-flex items-center justify-center p-2 rounded-lg cursor-pointer hover:bg-slate-800/60 transition group-radio">
                                        <input type="radio" name="status[{{ $s->id }}]" value="alfa"
                                               class="w-4 h-4 text-rose-500 bg-slate-900 border-slate-700 focus:ring-offset-slate-900 focus:ring-rose-500/40">
                                    </label>
                                </td>

                                <td class="py-2 px-6 text-center">
                                    <input type="text" name="keterangan[{{ $s->id }}]"
                                           class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800/80 text-slate-300 text-xs placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 transition"
                                           placeholder="Tulis alasan jika absen...">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('absensi.kelas', $kelas->id) }}" 
                   class="py-2.5 px-4 bg-slate-900 hover:bg-slate-800 border border-slate-800 text-xs font-bold text-slate-400 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 py-2.5 px-5 bg-indigo-600 hover:bg-indigo-500 text-xs font-bold text-white rounded-xl shadow-lg shadow-indigo-600/10 transition duration-150">
                    <i class="fas fa-circle-check"></i> Simpan Hasil Presensi
                </button>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div id="successPopup" 
         class="fixed bottom-5 right-5 bg-slate-900 border border-emerald-500/30 text-white px-5 py-4 rounded-2xl shadow-2xl flex items-center gap-4 z-50 transform translate-y-10 opacity-0 transition-all duration-300 ease-out">
        <div class="w-8 h-8 bg-emerald-500/10 text-emerald-400 rounded-xl flex items-center justify-center text-sm border border-emerald-500/20 shadow-inner">
            <i class="fas fa-check"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi Berhasil</p>
            <p class="text-sm font-semibold text-slate-200 mt-0.5">{{ session('success') }}</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('successPopup');
            if (popup) {
                // Efek Masuk (Fade-in)
                setTimeout(() => {
                    popup.classList.remove('translate-y-10', 'opacity-0');
                    popup.classList.add('translate-y-0', 'opacity-100');
                }, 100);

                // Efek Keluar Otomatis Setelah 4 Detik (Fade-out)
                setTimeout(() => {
                    popup.classList.remove('translate-y-0', 'opacity-100');
                    popup.classList.add('translate-y-10', 'opacity-0');
                }, 4000);
            }
        });
    </script>
    @endif
</x-app-layout>