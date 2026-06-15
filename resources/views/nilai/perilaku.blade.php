<x-app-layout>
    <x-slot name="title">
        Nilai Perilaku - {{ $kelas->nama_kelas }}
    </x-slot>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('nilai.kelas', $kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <span class="block text-xs font-semibold text-sky-400 uppercase tracking-wider mb-0.5">Lembar Evaluasi Karakter</span>
                    <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                        Input Nilai Sikap & Perilaku: {{ $kelas->nama_kelas }}
                    </h2>
                </div>
            </div>

            <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-500/5 border border-emerald-500/10 text-[11px] font-bold text-emerald-400 max-w-max">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Cloud Auto-Save Aktif
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-2">
        <input type="hidden" id="kelas_id" value="{{ $kelas->id }}">

        <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-300 whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-400 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800/80">
                            <th class="py-4 px-5 text-center w-16">No</th>
                            <th class="py-4 px-5">Nama Siswa</th>
                            <th class="py-4 px-3 text-center w-28">Disiplin</th>
                            <th class="py-4 px-3 text-center w-28">Kejujuran</th>
                            <th class="py-4 px-3 text-center w-28">Tanggung Jawab</th>
                            <th class="py-4 px-3 text-center w-28">Kemandirian</th>
                            <th class="py-4 px-3 text-center w-28">Kepedulian</th>
                            <th class="py-4 px-5 text-center w-28 text-indigo-400">Skor Akhir</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800/60">
                        @foreach($kelas->siswa as $i => $s)
                            <tr class="hover:bg-slate-800/10 transition duration-100">
                                <td class="py-2.5 px-5 text-center font-mono text-slate-500 font-medium">
                                    {{ sprintf('%02d', $i + 1) }}
                                </td>

                                <td class="py-2.5 px-5 font-bold text-slate-200">
                                    {{ $s->nama }}
                                </td>

                                @php
                                    $detail = $nilai[$s->id] ?? null;
                                    
                                    // Pemetaan field database dengan nilai default 1
                                    $rubrikData = [
                                        'Disiplin' => $detail->Disiplin ?? 1,
                                        'Kejujuran' => $detail->Kejujuran ?? 1,
                                        'Tanggung_Jawab' => $detail->Tanggung_Jawab ?? 1,
                                        'Kemandirian' => $detail->Kemandirian ?? 1,
                                        'Kepedulian' => $detail->Kepedulian ?? 1,
                                    ];
                                @endphp

                                @foreach($rubrikData as $fieldName => $fieldValue)
                                    <td class="py-2.5 px-3 text-center">
                                        <div class="relative inline-block w-16">
                                            <select data-siswa="{{ $s->id }}" data-field="{{ $fieldName }}"
                                                    class="score w-full bg-slate-900 border border-slate-800 text-slate-200 rounded-lg py-1.5 px-2.5 text-center font-mono font-bold text-xs appearance-none cursor-pointer focus:border-sky-500 focus:ring-1 focus:ring-sky-500/20 transition">
                                                @for($v = 1; $v <= 4; $v++)
                                                    <option value="{{ $v }}" {{ $fieldValue == $v ? 'selected' : '' }}>
                                                        {{ $v }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </td>
                                @endforeach

                                <td class="py-2.5 px-5 text-center">
                                    <span class="total inline-flex px-3 py-1 rounded-lg text-xs font-black font-mono tracking-wide bg-indigo-500/5 text-indigo-400 border border-indigo-500/10 min-w-[56px] justify-center transition-all duration-300">
                                        0
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tempat menyimpan antrean waktu per individu siswa_id
            const saveTimeouts = {};

            document.querySelectorAll('tbody tr').forEach(row => {
                const selects = row.querySelectorAll('.score');
                const totalCell = row.querySelector('.total');

                function hitungDanSimpan(event) {
                    let dataKirim = {};
                    let totalSkor = 0;
                    let siswa_id = null;

                    selects.forEach(s => {
                        let val = parseInt(s.value || 1);
                        let field = s.dataset.field; // Mengambil string nama kolom (Disiplin, Kejujuran, dll)

                        totalSkor += val;
                        dataKirim[field] = val;
                        siswa_id = s.dataset.siswa;
                    });

                    // Konversi Nilai: Akumulasi Poin (Max 20) x 5 = Skala 100
                    let skorAkhir = totalSkor * 5;
                    totalCell.innerText = skorAkhir;

                    // Mutasi kelas warna lencana sesuai ambang batas kelulusan
                    totalCell.className = "total inline-flex px-3 py-1 rounded-lg text-xs font-black font-mono tracking-wide min-w-[56px] justify-center border transition-all duration-300 " +
                        (skorAkhir >= 80 ? "bg-emerald-500/10 text-emerald-400 border-emerald-500/20" : 
                         skorAkhir >= 60 ? "bg-amber-500/10 text-amber-400 border-amber-500/20" : 
                                           "bg-rose-500/10 text-rose-400 border-rose-500/20");

                    // Cegah pengiriman AJAX saat rendering pertama kali dimuat
                    if (!event) return;

                    // Bersihkan antrean request siswa ini jika guru mengubah kriteria lain dengan cepat
                    if (saveTimeouts[siswa_id]) {
                        clearTimeout(saveTimeouts[siswa_id]);
                    }

                    // Tampilkan transisi visual memproses
                    totalCell.classList.add('animate-pulse', 'opacity-50');

                    // Setel ulang waktu tunggu pengetikan (Debounce 500ms)
                    saveTimeouts[siswa_id] = setTimeout(() => {
                        fetch("{{ route('nilai.perilaku.ajax') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                kelas_id: document.getElementById('kelas_id').value,
                                siswa_id: siswa_id,
                                ...dataKirim
                            })
                        })
                        .then(res => {
                            if (!res.ok) throw new Error('Simpan data gagal');
                            return res.json();
                        })
                        .then(() => {
                            // Hapus status berkedip dan beri feedback kilatan sukses
                            totalCell.classList.remove('animate-pulse', 'opacity-50');
                            
                            const currentClasses = totalCell.className;
                            totalCell.className += " ring-2 ring-sky-400 scale-105";
                            setTimeout(() => {
                                totalCell.className = currentClasses;
                            }, 400);
                        })
                        .catch(err => {
                            console.error('Error:', err);
                            totalCell.classList.remove('animate-pulse', 'opacity-50');
                            // fallback indikator error gagal simpan
                            totalCell.className = "total inline-flex px-3 py-1 rounded-lg text-xs font-black font-mono tracking-wide min-w-[56px] justify-center bg-rose-600 text-white border border-rose-500";
                        });
                    }, 500);
                }

                selects.forEach(s => {
                    s.addEventListener('change', hitungDanSimpan);
                });

                // Jalankan inisialisasi hitung awal baris saat halaman terbuka
                hitungDanSimpan(null);
            });
        });
    </script>
</x-app-layout>