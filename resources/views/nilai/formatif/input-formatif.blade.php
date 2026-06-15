<x-app-layout>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="max-w-7xl mx-auto py-6 px-4">

    <!-- HEADER -->
    <div class="bg-slate-800 p-6 rounded-2xl shadow mb-6">
        <h2 class="text-xl font-bold text-white">
            Input Nilai Per Bab - {{ $kelas->nama_kelas }}
        </h2>
    </div>

    <!-- HIDDEN -->
    <input type="hidden" id="kelas_id" value="{{ $kelas->id }}">
    <input type="hidden" id="bab" value="{{ $bab }}">

    <!-- NAMA BAB -->
    <div class="bg-slate-800 p-4 rounded-xl mb-4">
        <input type="text" value="{{ $bab }}"
               class="w-full p-2 rounded bg-gray-700 text-white"
               disabled>
    </div>

    <!-- TABLE -->
    <div class="bg-slate-800 rounded-2xl shadow overflow-x-auto">
        <table class="w-full text-sm text-gray-300">

            <thead class="bg-slate-900 text-gray-400">
                <tr>
                    <th class="p-3">No</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3">Nilai Bab</th>
                </tr>
            </thead>

            <tbody>
            @foreach($kelas->siswa as $i => $s)
            <tr class="border-b border-gray-700">

                <td class="p-3 text-center">{{ $i+1 }}</td>
                <td class="p-3">{{ $s->nama }}</td>

                <td class="text-center">
                    <input type="number"
                        class="nilai-input w-20 p-1 rounded bg-gray-700 text-white text-center"
                        min="0" max="100"
                        oninput="if(this.value > 100) this.value = 100;"
                        data-siswa="{{ $s->id }}"
                        value="{{ $nilai[$s->id] ?? '' }}">
                </td>

            </tr>
            @endforeach
            </tbody>

        </table>
    </div>

    <!-- BUTTON BACK -->
    <div class="mt-6">
        <a href="{{ route('nilai.akademik', $kelas->id) }}"
           class="bg-gray-600 px-4 py-2 rounded text-white">
            ← Kembali
        </a>
    </div>

</div>
let timeout = null;

document.querySelectorAll('.nilai-input').forEach(input => {

    input.addEventListener('input', function () {

        let el = this;

        clearTimeout(timeout);

        timeout = setTimeout(() => {

            let siswa_id = el.dataset.siswa;
            let nilai = el.value;

            fetch("{{ route('nilai.formatif.ajax') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    kelas_id: document.getElementById('kelas_id').value,
                    bab: document.getElementById('bab').value,
                    nilai: {
                        [siswa_id]: nilai
                    }
                })
            })
            .then(res => res.json())
            .then(() => {
                el.style.border = "2px solid green";
                setTimeout(() => el.style.border = "", 500);
            });

        }, 400);

    });

});
</x-app-layout>