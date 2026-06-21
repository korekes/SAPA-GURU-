<x-app-layout>
    <x-slot name="title">
        Jadwal Pelajaran
    </x-slot>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-widest mb-1">
                    Akademik & Kurikulum
                </span>
                <h2 class="font-extrabold text-2xl sm:text-3xl text-white tracking-tight">
                    Jadwal Pelajaran
                </h2>
            </div>
            <a href="{{ route('jadwal.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 active:scale-95 text-white text-sm font-semibold px-5 py-3 rounded-xl shadow-lg shadow-indigo-600/20 transition-all duration-200">
                <i class="fas fa-plus text-xs"></i>
                Tambah Jadwal
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Alert Notification --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center gap-3 shadow-sm animate-fade-in">
                <i class="fas fa-circle-check text-lg"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Toggle Blok A / Blok B --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="inline-flex bg-slate-800 border border-slate-700 rounded-xl p-1">
                <a href="{{ route('jadwal.index', ['minggu' => 'produktif']) }}"
                   class="px-5 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2
                          {{ ($minggu ?? 'produktif') === 'produktif' ? 'bg-amber-600 text-white shadow-lg shadow-amber-900/30' : 'text-slate-400 hover:text-white' }}">
                    <i class="fas fa-bolt"></i> Blok A
                    <span class="text-[10px] font-normal opacity-80">Minggu Produktif</span>
                </a>
                <a href="{{ route('jadwal.index', ['minggu' => 'normada']) }}"
                   class="px-5 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2
                          {{ ($minggu ?? 'produktif') === 'normada' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/30' : 'text-slate-400 hover:text-white' }}">
                    <i class="fas fa-layer-group"></i> Blok B
                    <span class="text-[10px] font-normal opacity-80">Minggu Normada</span>
                </a>
            </div>
        </div>

        {{-- Konten dikelompokkan per hari --}}
        @php
            // Urutan hari yang ingin ditampilkan, terlepas dari urutan key di collection
            $urutanHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        @endphp

        @forelse ($urutanHari as $hari)
            @if ($jadwal->has($hari) && $jadwal->get($hari)->isNotEmpty())
                <div class="mb-10">
                    {{-- Heading nama hari --}}
                    <div class="flex items-center gap-3 mb-4">
                        <h3 class="text-lg font-bold text-white tracking-tight">
                            {{ $hari }}
                        </h3>
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-400 text-xs font-semibold">
                            {{ $jadwal->get($hari)->count() }} sesi
                        </span>
                        <div class="flex-1 h-px bg-slate-800"></div>
                    </div>

                    {{-- Grid card untuk hari ini --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($jadwal->get($hari) as $j)
                            <div class="group relative bg-[#111827] border border-slate-800/80 rounded-2xl p-6 hover:border-indigo-500/40 hover:shadow-xl hover:shadow-indigo-500/[0.02] transition-all duration-300 flex flex-col justify-between">

                                <div>
                                    {{-- Header Card --}}
                                    <div class="flex justify-between items-start gap-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 uppercase tracking-wider">
                                            {{ $j->hari }}
                                        </span>
                                        <div class="flex items-center gap-1.5 text-slate-400 bg-slate-800/40 px-2.5 py-1 rounded-md border border-slate-700/30 text-xs font-medium">
                                            <i class="far fa-clock text-indigo-400"></i>
                                            <span>{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</span>
                                        </div>
                                    </div>

                                    {{-- Subject Name --}}
                                    <h3 class="text-white font-bold text-lg mt-4 group-hover:text-indigo-400 transition-colors duration-200 line-clamp-2">
                                        {{ $j->mengajar->mapel->nama_mapel ?? '-' }}
                                    </h3>

                                    {{-- Class Info --}}
                                    <div class="flex items-center gap-2 text-slate-400 text-sm mt-2">
                                        <i class="fas fa-layer-group text-slate-500 text-xs w-4"></i>
                                        <span>Kelas {{ $j->kelas->nama_kelas ?? ($j->mengajar->kelas->nama_kelas ?? '-') }}</span>
                                    </div>
                                </div>

                                {{-- Footer Card --}}
                                <div class="mt-6 pt-4 border-t border-slate-800/80 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-amber-500/20 to-orange-500/20 border border-orange-500/20 flex items-center justify-center shrink-0">
                                            <i class="fas fa-user-tie text-orange-400 text-xs"></i>
                                        </div>
                                        <p class="text-slate-300 text-xs font-medium truncate">
                                            {{ $j->mengajar->guru->user->name ?? '-' }}
                                        </p>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="flex items-center gap-1 shrink-0">
                                        <a href="{{ route('jadwal.edit', $j->id) }}"
                                           title="Edit Jadwal"
                                           class="p-2 text-slate-400 hover:text-amber-400 hover:bg-amber-500/10 rounded-lg transition-all duration-200">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>
                                        <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')"
                                                    title="Hapus Jadwal"
                                                    class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all duration-200">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @empty
        @endforelse

        {{-- Empty State — tampil kalau seluruh $jadwal kosong di semua hari --}}
        @if ($jadwal->isEmpty())
            <div class="col-span-full flex flex-col items-center justify-center text-center py-20 bg-[#111827]/50 border border-dashed border-slate-800 rounded-2xl px-4">
                <div class="h-16 w-16 bg-slate-800/50 border border-slate-700/50 rounded-2xl flex items-center justify-center text-slate-500 mb-4 shadow-inner">
                    <i class="fas fa-calendar-xmark text-2xl"></i>
                </div>
                <h3 class="text-white font-bold text-lg">Belum Ada Jadwal Pelajaran</h3>
                <p class="text-slate-500 text-sm mt-1 max-w-xs">Silakan tambahkan jadwal baru menggunakan tombol "Tambah Jadwal" di atas.</p>
            </div>
        @endif
    </div>
</x-app-layout>