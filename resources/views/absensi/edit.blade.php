<x-app-layout>
    <x-slot name="title">
        Edit Absensi - {{ $kelas->nama_kelas }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('absensi.kelas', $absensi->kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Sistem Presensi</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Edit Lembar Absensi
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-2">
        
        <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 bg-[#111827] p-4 rounded-xl border border-slate-800/80 shadow-sm">
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-1">Tanggal Sesi</label>
                    <input type="date" name="tanggal" value="{{ $absensi->tanggal }}"
                           class="w-full px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition duration-150" required>
                </div>
                
                <div>
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 pl-1">Mata Pelajaran</label>
                    <input type="text" name="mapel" value="{{ $absensi->mapel }}"
                           class="w-full px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition duration-150"
                           placeholder="Mata Pelajaran">
                </div>
            </div>

            <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden">
                <div class="p-4 bg-slate-900/50 border-b border-slate-800/80">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">
                        Kelas: <span class="text-white font-extrabold">{{ $kelas->nama_kelas }}</span>
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300 whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-900/30 text-slate-400 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800/80">
                                <th class="py-3 px-6 text-center w-16">No</th>
                                <th class="py-3 px-6">Nama Lengkap</th>
                                <th class="py-3 px-4 text-center w-24 text-emerald-400">Hadir</th>
                                <th class="py-3 px-4 text-center w-24 text-amber-400">Izin</th>
                                <th class="py-3 px-4 text-center w-24 text-sky-400">Sakit</th>
                                <th class="py-3 px-4 text-center w-24 text-rose-400">Alfa</th>
                                <th class="py-3 px-6 text-center w-64">Catatan / Keterangan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-800/60">
                            @foreach($kelas->siswa->sortBy('no_absen') as $s)
                                @php
                                    $detail = $absensi->details->where('siswa_id', $s->id)->first();
                                    $status = $detail->status ?? 'hadir';
                                    $ket = $detail->keterangan ?? '';
                                @endphp
                                <tr class="hover:bg-slate-800/20 transition duration-100">
                                    <td class="py-3.5 px-6 text-center font-semibold text-slate-500">
                                        {{ sprintf('%02d', $s->no_absen) }}
                                    </td>

                                    <td class="py-3.5 px-6 font-bold text-slate-200">
                                        {{ $s->nama }}
                                    </td>

                                    <td class="py-3.5 px-4 text-center">
                                        <label class="inline-flex items-center justify-center p-2 rounded-lg cursor-pointer hover:bg-slate-800/60 transition">
                                            <input type="radio" name="status[{{ $s->id }}]" value="hadir"
                                                   {{ $status == 'hadir' ? 'checked' : '' }}
                                                   class="w-4 h-4 text-emerald-500 bg-slate-900 border-slate-700 focus:ring-offset-slate-900 focus:ring-emerald-500/40">
                                        </label>
                                    </td>

                                    <td class="py-3.5 px-4 text-center">
                                        <label class="inline-flex items-center justify-center p-2 rounded-lg cursor-pointer hover:bg-slate-800/60 transition">
                                            <input type="radio" name="status[{{ $s->id }}]" value="izin"
                                                   {{ $status == 'izin' ? 'checked' : '' }}
                                                   class="w-4 h-4 text-amber-500 bg-slate-900 border-slate-700 focus:ring-offset-slate-900 focus:ring-amber-500/40">
                                        </label>
                                    </td>

                                    <td class="py-3.5 px-4 text-center">
                                        <label class="inline-flex items-center justify-center p-2 rounded-lg cursor-pointer hover:bg-slate-800/60 transition">
                                            <input type="radio" name="status[{{ $s->id }}]" value="sakit"
                                                   {{ $status == 'sakit' ? 'checked' : '' }}
                                                   class="w-4 h-4 text-sky-500 bg-slate-900 border-slate-700 focus:ring-offset-slate-900 focus:ring-sky-500/40">
                                        </label>
                                    </td>

                                    <td class="py-3.5 px-4 text-center">
                                        <label class="inline-flex items-center justify-center p-2 rounded-lg cursor-pointer hover:bg-slate-800/60 transition">
                                            <input type="radio" name="status[{{ $s->id }}]" value="alfa"
                                                   {{ $status == 'alfa' ? 'checked' : '' }}
                                                   class="w-4 h-4 text-rose-500 bg-slate-900 border-slate-700 focus:ring-offset-slate-900 focus:ring-rose-500/40">
                                        </label>
                                    </td>

                                    <td class="py-2 px-6 text-center">
                                        <input type="text" name="keterangan[{{ $s->id }}]" value="{{ $ket }}"
                                               class="w-full px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800/80 text-slate-300 text-xs placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 transition"
                                               placeholder="opsional">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('absensi.kelas', $absensi->kelas->id) }}" 
                   class="py-2.5 px-4 bg-slate-900 hover:bg-slate-800 border border-slate-800 text-xs font-bold text-slate-400 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 py-2.5 px-5 bg-amber-600 hover:bg-amber-500 text-xs font-bold text-white rounded-xl shadow-lg shadow-amber-600/10 transition duration-150">
                    <i class="fas fa-rotate"></i> Perbarui Data Absensi
                </button>
            </div>
        </form>
    </div>
</x-app-layout>