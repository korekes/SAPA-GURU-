<x-app-layout>

    <x-slot name="title">
        Tambah Mata Pelajaran
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            
            <a href="{{ route('mapel.index') }}" class="w-9 h-9 rounded-xl bg-orange-500/10 border border-orange-500/20 text-orange-400 flex items-center justify-center shadow-inner">
                <i class="fas fa-book text-sm"></i>
            </a>

            <div>
                <span class="block text-xs font-semibold text-orange-400 uppercase tracking-wider">
                    Akademik
                </span>

                <h2 class="font-bold text-xl text-white">
                    Tambah Mata Pelajaran
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">

        @if ($errors->any())
            <div class="mb-5 bg-red-500/10 border border-red-500/20 text-red-400 rounded-xl p-4">
                <ul class="text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-[#111827] border border-slate-800 rounded-3xl overflow-hidden">

            <div class="p-6 border-b border-slate-800">
                <h3 class="font-bold text-white">
                    Informasi Mata Pelajaran
                </h3>
            </div>

            <form action="{{ route('mapel.store') }}"
                  method="POST"
                  class="p-6 space-y-5">

                @csrf

                {{-- Nama Mapel --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">
                        Nama Mata Pelajaran
                    </label>

                    <input type="text"
                           name="nama_mapel"
                           value="{{ old('nama_mapel') }}"
                           required
                           class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-orange-500 focus:ring-orange-500"
                           placeholder="Contoh: Pemrograman Web">
                </div>

                {{-- Guru --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">
                        Guru Pengampu
                    </label>

                    <select name="guru_id"
                            required
                            class="guru-select w-full rounded-xl bg-slate-900 border border-slate-700 text-white">

                        <option value="">
                            Pilih Guru
                        </option>

                        @foreach($guru as $g)
                            <option value="{{ $g->id }}">
                                {{ $g->user->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">
                        Kelas Yang Diampu
                    </label>

                    <select name="kelas_id"
                            required
                            class="w-full rounded-xl bg-slate-900 border border-slate-700 text-white">

                        <option value="">
                            Pilih Kelas
                        </option>

                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="pt-4 border-t border-slate-800 flex justify-between">

                    <a href="{{ route('mapel.index') }}"
                       class="px-5 py-3 rounded-xl bg-slate-800 text-slate-300 hover:bg-slate-700">
                        Kembali
                    </a>

                    <button type="submit"
                            class="px-6 py-3 rounded-xl bg-orange-600 hover:bg-orange-500 text-white font-bold">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data
                    </button>

                </div>

            </form>

        </div>

        <div class="mt-8 bg-[#111827] border border-slate-800 rounded-3xl overflow-hidden">

            <div class="p-6 border-b border-slate-800">
                <h3 class="font-bold text-white flex items-center gap-2">
                    <i class="fas fa-file-excel text-emerald-500"></i>
                    Import Mata Pelajaran dari Excel
                </h3>
            </div>

            <form action="{{ route('mapel.import') }}"
                method="POST"
                enctype="multipart/form-data"
                class="p-6">

                @csrf

                <div class="flex flex-col sm:flex-row items-center gap-4">
                            <div class="relative flex-1 w-full">
                                <div x-data="{ fileName: '' }">
                                    <input type="file"
                                        name="file"
                                        id="file-upload"
                                        accept=".xlsx,.xls"
                                        class="hidden"
                                        @change="fileName = $event.target.files[0]?.name">

                                    <label for="file-upload"
                                        class="flex items-center justify-center w-full px-4 py-2.5 bg-slate-900 border border-dashed border-slate-700 text-slate-400 rounded-xl text-xs cursor-pointer hover:border-emerald-500/50 transition">
                                        <i class="fas fa-file-excel mr-2"></i>
                                        <span class="text-slate-300 text-xs font-semibold"
                                            x-text="fileName ? fileName : 'Pilih File Excel (.xlsx)'">
                                        </span>
                                        
                                    </label>
                                </div>
                                
                            </div>

                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl transition shadow-lg shadow-emerald-900/20">
                                <i class="fas fa-upload"></i>
                                Import Mapel
                            </button>
                        </div>

                <div class="mt-5 p-4 bg-slate-900 rounded-xl border border-slate-800">
                    <p class="text-xs font-bold text-amber-400 mb-2">
                        Format Excel yang digunakan:
                    </p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-slate-300">
                            <thead>
                                <tr class="border-b border-slate-700">
                                    <th class="text-left py-2">nama_mapel</th>
                                    <th class="text-left py-2">guru</th>
                                    <th class="text-left py-2">kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Matematika</td>
                                    <td>Budi Santoso</td>
                                    <td>XI TKR 1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </form>

        </div>
    </div>

</x-app-layout>