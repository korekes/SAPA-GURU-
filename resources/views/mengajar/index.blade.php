<x-app-layout>

    <x-slot name="title">
        Pengaturan Mengajar
    </x-slot>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="font-bold text-xl text-white">
                Pengaturan Mengajar
            </h2>

            <a href="{{ route('mengajar.create') }}"
               class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-xl text-sm font-bold">

                <i class="fas fa-plus"></i>
                Tambah Pengajaran

            </a>

        </div>

    </x-slot>

    <div class="max-w-7xl mx-auto py-6">

        <div class="bg-[#111827] border border-slate-800 rounded-2xl overflow-hidden">

            <table class="w-full text-sm">

                <thead>

                    <tr class="bg-slate-900">

                        <th class="p-4 text-left">Guru</th>
                        <th class="p-4 text-left">Kelas</th>
                        <th class="p-4 text-left">Mapel</th>
                        <th class="p-4 text-right">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($mengajar as $m)

                    <tr class="border-t border-slate-800">

                        <td class="p-4 text-white">
                            {{ $m->guru->user->name }}
                        </td>

                        <td class="p-4 text-white">
                            {{ $m->kelas->nama_kelas }}
                        </td>

                        <td class="p-4 text-white">
                            {{ $m->mapel->nama_mapel }}
                        </td>

                        <td class="p-4 text-right">

                            <form action="{{ route('mengajar.destroy',$m->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Hapus data?')"
                                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-lg">

                                    Hapus

                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>