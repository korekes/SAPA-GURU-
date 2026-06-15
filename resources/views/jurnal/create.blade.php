<x-app-layout>
    <x-slot name="title">
        Tambah Jurnal - {{ $kelas->nama_kelas }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('jurnal.index', $kelas->id) }}" 
               class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-0.5">Input Harian</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Tambah Jurnal: {{ $kelas->nama_kelas }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-4">
        
        <div class="bg-[#111827] border border-slate-800/80 rounded-3xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-800/50 bg-slate-900/30">
                <p class="text-sm text-slate-400">
                    Lengkapi detail kegiatan belajar mengajar untuk mendokumentasikan kemajuan kurikulum.
                </p>
            </div>

            <form action="{{ route('jurnal.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Tanggal Pelaksanaan</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fas fa-calendar-alt text-xs"></i>
                            </span>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 transition-all shadow-sm">
                        </div>
                    </div>

                    @php
                        $mapel = auth()->user()->guru->mapel ?? '';
                    @endphp
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Mata Pelajaran</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500 group-focus-within:text-emerald-500 transition-colors">
                                <i class="fas fa-book text-xs"></i>
                            </span>
                            <input type="text" name="mapel" value="{{ $mapel }}" required
                                   placeholder="Contoh: Matematika Wajib"
                                   class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Topik / Materi Pembelajaran</label>
                        <textarea name="materi" rows="2" required
                                  placeholder="Tuliskan pokok bahasan utama..."
                                  class="w-full px-4 py-3 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 transition-all shadow-sm resize-none"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Tujuan Pembelajaran (CP/TP)</label>
                        <textarea name="tujuan_pembelajaran" rows="2"
                                  placeholder="Target yang ingin dicapai siswa..."
                                  class="w-full px-4 py-3 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 transition-all shadow-sm resize-none"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Langkah Kegiatan Pembelajaran</label>
                        <textarea name="kegiatan" rows="4" required
                                  placeholder="Deskripsikan metode atau urutan kegiatan..."
                                  class="w-full px-4 py-3 bg-slate-900 border border-slate-800 text-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 transition-all shadow-sm"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-slate-800/50">
                    <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold px-8 py-3 rounded-xl transition duration-150 shadow-lg shadow-emerald-900/20 flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Jurnal
                    </button>
                </div>
            </form>
        </div>
        
        <p class="text-center text-[10px] text-slate-600 mt-6 uppercase tracking-[0.2em]">
            Dokumen ini akan tersinkronisasi otomatis dengan laporan wali kelas.
        </p>
    </div>
</x-app-layout>