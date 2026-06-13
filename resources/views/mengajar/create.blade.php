<x-app-layout>

    <x-slot name="title">
        Tambah Pengaturan Mengajar
    </x-slot>

    <div class="max-w-2xl mx-auto py-8">

        <div class="bg-[#111827] border border-slate-800 rounded-2xl">

            <form action="{{ route('mengajar.store') }}"
                  method="POST"
                  class="p-6 space-y-5">

                @csrf

                <div>
                    <label class="block text-slate-300 mb-2">
                        Guru
                    </label>

                    <select name="guru_id"
                            class="guru-select w-full rounded-xl bg-slate-900 border border-slate-700 text-white">

                        @foreach($guru as $g)
                            <option value="{{ $g->id }}">
                                {{ $g->user->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-slate-300 mb-2">
                        Kelas
                    </label>

                    <select name="kelas_id"
                            class="w-full rounded-xl bg-slate-900 border border-slate-700 text-white">

                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="block text-slate-300 mb-2">
                        Mata Pelajaran
                    </label>

                    <select name="mapel_id"
                            class="w-full rounded-xl bg-slate-900 border border-slate-700 text-white">

                        @foreach($mapel as $m)
                            <option value="{{ $m->id }}">
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <button
                    class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-3 rounded-xl">

                    Simpan Pengajaran

                </button>

            </form>

        </div>

    </div>

</x-app-layout>