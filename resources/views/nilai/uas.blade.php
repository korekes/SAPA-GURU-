<x-app-layout>
    <x-slot name="title">
        Nilai UAS - {{ $kelas->nama_kelas }}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('nilai.akademik', $kelas->id) }}" 
                   class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Evaluasi Tengah Semester</span>
                    <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                        Input Nilai UAS: {{ $kelas->nama_kelas }}
                    </h2>
                </div>
            </div>

            <div id="sync-status" class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-800/80 border border-slate-700/60 text-[11px] font-bold text-slate-400 max-w-max transition-all duration-300">
                <span class="relative flex h-2 w-2 status-dot">
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-slate-500"></span>
                </span>
                <span class="status-text">Menunggu Perubahan Data</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-2">
        <form id="formNilai" onsubmit="return false;">
            <input type="hidden" id="kelas_id" value="{{ $kelas->id }}">

            <div class="bg-[#111827] rounded-2xl border border-slate-800/80 shadow-md overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300 whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-900/50 text-slate-400 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800/80">
                                <th class="py-4 px-5 text-center w-16">No</th>
                                <th class="py-4 px-5">Nama Siswa</th>
                                <th class="py-4 px-5 text-center w-44">Nilai UTS (Skala 0-100)</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-800/60">
                            @foreach($siswa as $i => $s)
                                <tr class="hover:bg-slate-800/10 transition duration-100">
                                    <td class="py-2.5 px-5 text-center font-mono text-slate-500 font-medium">
                                        {{ sprintf('%02d', $i + 1) }}
                                    </td>

                                    <td class="py-2.5 px-5 font-bold text-slate-200">
                                        {{ $s->nama }}
                                    </td>

                                    <td class="py-2.5 px-5 text-center">
                                        <div class="relative inline-flex items-center">
                                            <input type="number" 
                                                   class="nilai-input w-24 bg-slate-900 border border-slate-800 text-slate-200 rounded-lg py-1.5 px-3 text-center font-mono font-bold text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 transition"
                                                   data-siswa="{{ $s->id }}"
                                                   value="{{ $nilai[$s->id]->nilai ?? '' }}"
                                                   min="0" max="100" placeholder="0"
                                                   oninput="if(parseInt(this.value) > 100) this.value = 100; if(parseInt(this.value) < 0) this.value = 0;">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" id="btnSimpan"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition duration-150 shadow-md shadow-indigo-900/20">
                    <i class="fas fa-cloud-upload-alt text-xs"></i> Simpan Semua Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const saveTimeouts = {};
            const syncStatus = document.getElementById('sync-status');

            function updateStatusIndicator(state) {
                const dot = syncStatus.querySelector('.status-dot');
                const text = syncStatus.querySelector('.status-text');

                if (state === 'typing') {
                    syncStatus.className = "flex items-center gap-2 px-3 py-1.5 rounded-xl bg-amber-500/5 border border-amber-500/10 text-[11px] font-bold text-amber-400 max-w-max transition-all duration-300";
                    dot.innerHTML = '<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>';
                    text.innerText = "Sedang mengetik...";
                } else if (state === 'saving') {
                    syncStatus.className = "flex items-center gap-2 px-3 py-1.5 rounded-xl bg-blue-500/5 border border-blue-500/10 text-[11px] font-bold text-blue-400 max-w-max transition-all duration-300";
                    dot.innerHTML = '<span class="animate-spin inline-block h-2 w-2 border-2 border-blue-400 border-t-transparent rounded-full"></span>';
                    text.innerText = "Menyimpan ke cloud...";
                } else if (state === 'success') {
                    syncStatus.className = "flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-500/5 border border-emerald-500/10 text-[11px] font-bold text-emerald-400 max-w-max transition-all duration-300";
                    dot.innerHTML = '<span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>';
                    text.innerText = "Auto-save berhasil";
                } else if (state === 'error') {
                    syncStatus.className = "flex items-center gap-2 px-3 py-1.5 rounded-xl bg-rose-500/5 border border-rose-500/10 text-[11px] font-bold text-rose-400 max-w-max transition-all duration-300";
                    dot.innerHTML = '<span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>';
                    text.innerText = "Gagal menyimpan data";
                }
            }

            // --- 1. OTOMATISASI PER BARIS (AUTO SAVE) ---
            document.querySelectorAll('.nilai-input').forEach(input => {
                input.addEventListener('input', function () {
                    const el = this;
                    const siswa_id = el.dataset.siswa;

                    updateStatusIndicator('typing');

                    // Hapus antrean sebelumnya khusus untuk siswa_id ini
                    if (saveTimeouts[siswa_id]) clearTimeout(saveTimeouts[siswa_id]);

                    saveTimeouts[siswa_id] = setTimeout(() => {
                        updateStatusIndicator('saving');
                        el.classList.add('opacity-40', 'animate-pulse');

                        fetch("{{ route('nilai.uas.ajax') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                kelas_id: document.getElementById('kelas_id').value,
                                nilai: { [siswa_id]: el.value }
                            })
                        })
                        .then(res => {
                            if (!res.ok) throw new Error();
                            return res.json();
                        })
                        .then(() => {
                            updateStatusIndicator('success');
                            el.classList.remove('opacity-40', 'animate-pulse');
                            
                            // Efek visual kilatan hijau pada border input yang sukses terpantul ke database
                            el.classList.add('border-emerald-500', 'text-emerald-400');
                            setTimeout(() => el.classList.remove('border-emerald-500', 'text-emerald-400'), 600);
                        })
                        .catch(() => {
                            updateStatusIndicator('error');
                            el.classList.remove('opacity-40', 'animate-pulse');
                            el.classList.add('border-rose-500', 'text-rose-400');
                        });
                    }, 500); // Penundaan pengiriman AJAX selama 500ms setelah aktivitas ketik berhenti
                });
            });

            // --- 2. EVALUASI GLOBAL (TOMBOL SIMPAN SEMUA) ---
            document.getElementById('btnSimpan').addEventListener('click', function () {
                const btn = this;
                const originalHtml = btn.innerHTML;

                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner animate-spin"></i> Memproses...';

                const payloadData = {};
                document.querySelectorAll('.nilai-input').forEach(input => {
                    payloadData[input.dataset.siswa] = input.value;
                });

                fetch("{{ route('nilai.uas.ajax') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        kelas_id: document.getElementById('kelas_id').value,
                        nilai: payloadData
                    })
                })
                .then(res => {
                    if (!res.ok) throw new Error();
                    return res.json();
                })
                .then(() => {
                    updateStatusIndicator('success');
                    btn.className = btn.className.replace('bg-indigo-600', 'bg-emerald-600');
                    btn.innerHTML = '<i class="fas fa-check-circle"></i> Berhasil Disimpan!';
                    
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                        btn.className = btn.className.replace('bg-emerald-600', 'bg-indigo-600');
                    }, 2000);
                })
                .catch(() => {
                    updateStatusIndicator('error');
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                });
            });
        });
    </script>
</x-app-layout>