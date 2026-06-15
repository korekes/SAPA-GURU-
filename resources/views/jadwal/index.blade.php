<x-app-layout>
    <x-slot name="title">
        Jadwal Pelajaran
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider">
                    Akademik
                </span>
                <h2 class="font-bold text-xl text-white">
                    Jadwal Pelajaran
                </h2>
            </div>
            <a href="{{ route('jadwal.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold px-5 py-3 rounded-xl">

                <i class="fas fa-plus"></i>
                Tambah Jadwal
            </a>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6">
        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
            @forelse($jadwal as $j)
            <div class="bg-[#111827] border border-slate-800 rounded-2xl p-5">
                <div class="flex justify-between items-center">
                    <span class="text-indigo-400 text-xs font-bold uppercase">
                        {{ $j->hari }}
                    </span>
                    <span class="text-slate-400 text-xs">
                        {{ substr($j->jam_mulai,0,5) }}
                        -
                        {{ substr($j->jam_selesai,0,5) }}
                    </span>
                </div>
                <h3 class="text-white font-bold text-lg mt-4">
                    {{ $j->mengajar->mapel->nama_mapel }}
                </h3>
                <p class="text-slate-400 text-sm mt-1">
                    {{ $j->kelas->nama_kelas }}
                </p>
                <div class="mt-4 pt-4 border-t border-slate-800">
                    <p class="text-orange-400 text-sm">
                        {{ $j->mengajar->guru->user->name }}
                    </p>
                </div>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('jadwal.edit',$j->id) }}"
                       class="flex-1 text-center bg-amber-600 hover:bg-amber-500 text-white py-2 rounded-xl text-sm">
                        Edit
                    </a>
                    <form action="{{ route('jadwal.destroy',$j->id) }}"
                          method="POST"
                          class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button
                            onclick="return confirm('Hapus jadwal ini?')"
                            class="w-full bg-red-600 hover:bg-red-500 text-white py-2 rounded-xl text-sm">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty

            <div class="col-span-full text-center py-20">
                <i class="fas fa-calendar-xmark text-5xl text-slate-700"></i>
                <h3 class="text-white font-bold mt-4">
                    Belum Ada Jadwal
                </h3>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>