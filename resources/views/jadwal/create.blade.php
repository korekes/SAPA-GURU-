<x-app-layout>
    <x-slot name="title">Tambah Jadwal</x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('jadwal.index') }}"
               class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700
                      text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <h2 class="font-bold text-xl text-white">Tambah Jadwal Pelajaran</h2>
        </div>
    </x-slot>

    {{-- ============================= ALERT ============================= --}}
    @if (session('success'))
        <div class="max-w-6xl mx-auto px-4 pt-4">
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-900/40 border border-emerald-700/50 text-emerald-300 text-sm">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-6xl mx-auto px-4 pt-4">
            <div class="px-4 py-3 rounded-xl bg-red-900/40 border border-red-700/50 text-red-300 text-sm space-y-1">
                @foreach ($errors->all() as $e)
                    <p><i class="fas fa-exclamation-circle mr-1"></i>{{ $e }}</p>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ============================= TABS ============================== --}}
    <div class="max-w-6xl mx-auto py-6 px-4" x-data="{ tab: 'dnd' }">

        <div class="flex gap-2 mb-6">
            <button @click="tab='dnd'"
                    :class="tab==='dnd'
                        ? 'bg-indigo-600 text-white border-indigo-500'
                        : 'bg-slate-800 text-slate-400 border-slate-700 hover:text-white'"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl border text-sm font-semibold transition">
                <i class="fas fa-th"></i> Susun Jadwal
            </button>
            <button @click="tab='excel'"
                    :class="tab==='excel'
                        ? 'bg-emerald-600 text-white border-emerald-500'
                        : 'bg-slate-800 text-slate-400 border-slate-700 hover:text-white'"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl border text-sm font-semibold transition">
                <i class="fas fa-file-excel"></i> Import Excel
            </button>
            <button @click="tab='manual'"
                    :class="tab==='manual'
                        ? 'bg-slate-600 text-white border-slate-500'
                        : 'bg-slate-800 text-slate-400 border-slate-700 hover:text-white'"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl border text-sm font-semibold transition">
                <i class="fas fa-edit"></i> Input Manual
            </button>
        </div>

        {{-- ==================== DRAG & DROP PANEL ===================== --}}
        <div x-show="tab==='dnd'" x-cloak>

            {{-- Baris atas: pilih kelas --}}
            <div class="flex items-center gap-3 mb-4">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Kelas:</label>
                <select id="select-kelas" onchange="setKelas(this.value)"
                        class="px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm
                            focus:outline-none focus:border-indigo-500 min-w-[180px]">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <span class="text-xs text-slate-500 ml-auto">Seret kartu mapel ke slot di timetable</span>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-[240px_1fr] gap-4 items-start">

                {{-- Sidebar mapel saja --}}
                <div class="bg-[#111827] border border-slate-800 rounded-2xl overflow-hidden sticky top-4">
                    <div class="p-4 border-b border-slate-800">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Mata Pelajaran</p>

                        {{-- Search mapel --}}
                        <div class="relative mb-3">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs pointer-events-none"></i>
                            <input type="text" id="search-mapel" placeholder="Cari mapel atau guru..."
                                oninput="filterMapel(this.value)"
                                class="w-full pl-8 pr-3 py-2 rounded-lg bg-slate-900 border border-slate-700
                                        text-white text-xs placeholder-slate-600 focus:outline-none focus:border-indigo-500">
                        </div>

                        <div id="mapel-list" class="space-y-2 max-h-[380px] overflow-y-auto pr-1">
                            <p class="text-xs text-slate-600 italic">Pilih kelas terlebih dahulu</p>
                        </div>
                    </div>

                    {{-- Tombol simpan --}}
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs text-slate-400">Tersusun:</span>
                            <span id="jadwal-count"
                                class="px-2 py-0.5 rounded-full bg-indigo-900/60 text-indigo-300 text-xs font-bold">
                                0 sesi
                            </span>
                        </div>
                        <button onclick="simpanDragDrop()"
                                class="w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500
                                    text-white text-sm font-bold transition flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Simpan Jadwal
                        </button>
                        <button onclick="resetGrid()"
                                class="mt-2 w-full py-2 rounded-xl border border-slate-700 text-slate-400
                                    hover:text-white text-xs transition">
                            <i class="fas fa-trash-alt mr-1"></i> Bersihkan Semua
                        </button>
                    </div>
                </div>

                {{-- Timetable --}}
                <div class="bg-[#111827] border border-slate-800 rounded-2xl overflow-x-auto">
                    <div class="p-4 border-b border-slate-800 flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-white text-sm">
                                Timetable — <span id="label-kelas" class="text-indigo-400">Pilih kelas</span>
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">Seret kartu mapel ke slot yang sesuai</p>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <span class="w-3 h-3 rounded bg-indigo-900/80 inline-block"></span> Sudah terisi
                        </div>
                    </div>

                    <div class="min-w-[640px]">
                        {{-- Header hari --}}
                        <div class="grid grid-cols-[80px_repeat(5,1fr)] border-b border-slate-800 bg-slate-900/30">
                            <div class="px-3 py-2 text-xs text-slate-500">Jam</div>
                            @foreach (['Senin','Selasa','Rabu','Kamis','Jumat'] as $day)
                                <div class="px-2 py-2 text-center text-xs font-bold text-slate-300 border-l border-slate-800">
                                    {{ $day }}
                                </div>
                            @endforeach
                        </div>

                        {{-- Baris slot waktu --}}
                        @php
                            $slots = [
                                ['07:00','08:30'],['08:30','10:00'],['10:15','11:45'],
                                ['11:45','13:00'],['13:30','15:00'],['15:00','16:30'],
                            ];
                        @endphp

                        <div id="tt-body">
                            @foreach ($slots as $si => $sl)
                                <div class="grid grid-cols-[80px_repeat(5,1fr)] border-b border-slate-800 last:border-0 min-h-[60px]">
                                    <div class="px-3 py-2 flex flex-col justify-center border-r border-slate-800">
                                        <span class="text-[10px] text-slate-400 leading-tight">{{ $sl[0] }}</span>
                                        <span class="text-[10px] text-slate-600 leading-tight">{{ $sl[1] }}</span>
                                    </div>
                                    @foreach (['Senin','Selasa','Rabu','Kamis','Jumat'] as $day)
                                        <div class="tt-cell border-l border-slate-800 p-1.5 relative min-h-[60px] transition"
                                             data-day="{{ $day }}"
                                             data-si="{{ $si }}"
                                             data-mulai="{{ $sl[0] }}"
                                             data-selesai="{{ $sl[1] }}"
                                             ondragover="event.preventDefault();this.classList.add('drag-over')"
                                             ondragleave="this.classList.remove('drag-over')"
                                             ondrop="dropToCell(event,this)">
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== EXCEL PANEL ===================== --}}
        <div x-show="tab==='excel'" x-cloak>
            <div class="max-w-2xl">
                <div class="bg-[#111827] border border-slate-800 rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-800">
                        <h3 class="font-bold text-white flex items-center gap-2 text-sm">
                            <i class="fas fa-file-excel text-emerald-400"></i> Import Jadwal dari Excel
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Upload file .xlsx untuk menambah jadwal secara massal</p>
                    </div>

                    <form method="POST" action="{{ route('jadwal.import') }}" enctype="multipart/form-data" class="p-5 space-y-4">
                        @csrf

                        {{-- Upload zone --}}
                        <div x-data="{ name: '' }">
                            <input type="file" id="file-inp" name="file" accept=".xlsx,.xls"
                                   class="hidden" @change="name=$event.target.files[0]?.name">
                            <label for="file-inp"
                                   class="flex flex-col items-center justify-center gap-3 w-full px-6 py-10
                                          border-2 border-dashed rounded-xl cursor-pointer transition"
                                   :class="name
                                       ? 'border-emerald-600 bg-emerald-900/20'
                                       : 'border-slate-700 bg-slate-900/40 hover:border-emerald-600/50'"
                                   ondragover="event.preventDefault()"
                                   ondrop="handleExcelDrop(event)">
                                <i class="fas text-3xl"
                                   :class="name ? 'fa-file-excel text-emerald-400' : 'fa-cloud-upload-alt text-slate-500'"></i>
                                <div class="text-center">
                                    <p class="text-sm font-semibold" :class="name ? 'text-emerald-300' : 'text-slate-300'">
                                        <span x-text="name || 'Klik atau seret file Excel'"></span>
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1" x-show="!name">.xlsx atau .xls — maks. 10MB</p>
                                </div>
                            </label>
                        </div>

                        {{-- Format tabel --}}
                        <div class="p-4 bg-slate-900 rounded-xl border border-slate-800">
                            <p class="text-xs font-bold text-amber-400 mb-3">
                                <i class="fas fa-info-circle mr-1"></i>Format kolom Excel:
                            </p>
                            <div class="overflow-x-auto">
                                <table class="w-full text-xs">
                                    <thead>
                                        <tr class="border-b border-slate-700">
                                            @foreach (['hari','jam_mulai','jam_selesai','kelas','mapel','guru'] as $col)
                                                <th class="text-left py-2 px-2 text-slate-400 font-mono font-normal">{{ $col }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-slate-300">
                                            <td class="py-2 px-2">Senin</td>
                                            <td class="py-2 px-2">07:00</td>
                                            <td class="py-2 px-2">08:30</td>
                                            <td class="py-2 px-2">X RPL 1</td>
                                            <td class="py-2 px-2">Pemrograman Web</td>
                                            <td class="py-2 px-2">Budi Santoso</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white
                                       font-bold text-sm transition flex items-center justify-center gap-2">
                            <i class="fas fa-upload"></i> Import Jadwal
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ==================== MANUAL PANEL ===================== --}}
        <div x-show="tab==='manual'" x-cloak>
            <div class="max-w-2xl">
                <div class="bg-[#111827] border border-slate-800 rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-800">
                        <h3 class="font-bold text-white text-sm">
                            <i class="fas fa-edit text-slate-400 mr-2"></i>Input Manual
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Tambahkan satu jadwal secara manual</p>
                    </div>

                    <form action="{{ route('jadwal.store') }}" method="POST" class="p-5 space-y-4">
                        @csrf

                        {{-- Hari --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Hari</label>
                            <select name="hari" required
                                    class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-indigo-500">
                                <option value="">Pilih Hari</option>
                                @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                                    <option value="{{ $h }}" {{ old('hari')===$h ? 'selected' : '' }}>{{ $h }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jam --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jam Mulai</label>
                                <input type="time" name="jam_mulai" required value="{{ old('jam_mulai') }}"
                                       class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jam Selesai</label>
                                <input type="time" name="jam_selesai" required value="{{ old('jam_selesai') }}"
                                       class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-indigo-500">
                            </div>
                        </div>

                        {{-- Guru Mengajar --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Guru, Mapel & Kelas</label>
                            <select name="guru_mengajar_id" required
                                    class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:outline-none focus:border-indigo-500">
                                <option value="">Pilih Pengampu</option>
                                @foreach ($mengajar as $m)
                                    <option value="{{ $m->id }}" {{ old('guru_mengajar_id')==$m->id ? 'selected' : '' }}>
                                        {{ $m->kelas->nama_kelas }} | {{ $m->mapel->nama_mapel }} | {{ $m->guru->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-2 border-t border-slate-800">
                            <button type="submit"
                                    class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm transition flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Simpan Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================= STYLES ============================= --}}
    <style>
        .kelas-tab.active {
            background: #312e81;
            color: #a5b4fc;
            font-weight: 600;
        }
        .tt-cell.drag-over {
            background: rgba(99, 102, 241, 0.15);
            outline: 2px dashed #6366f1;
            outline-offset: -2px;
            border-radius: 6px;
        }
        .sched-block {
            border-radius: 6px;
            padding: 5px 7px;
            font-size: 10px;
            font-weight: 600;
            line-height: 1.3;
            cursor: grab;
            position: relative;
            min-height: 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .sched-block:active { cursor: grabbing; opacity: 0.7; }
        .sched-block .blk-del {
            position: absolute;
            top: 3px; right: 3px;
            width: 14px; height: 14px;
            border-radius: 50%;
            background: rgba(0,0,0,.35);
            color: #fff;
            border: none;
            font-size: 8px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            opacity: 0;
            transition: opacity .1s;
            padding: 0;
        }
        .sched-block:hover .blk-del { opacity: 1; }
        [x-cloak] { display: none !important; }
    </style>

    {{-- ============================= SCRIPTS ============================= --}}
    <script>
    // ── Data dari Laravel ──────────────────────────────────────────────────
    const mengajarPerKelas = @json($mengajarPerKelas);

    // Palet warna per urutan mapel
    const COLORS = [
        { bg:'#1e1b4b', text:'#a5b4fc', border:'#3730a3' },
        { bg:'#064e3b', text:'#6ee7b7', border:'#047857' },
        { bg:'#451a03', text:'#fcd34d', border:'#92400e' },
        { bg:'#4a044e', text:'#f0abfc', border:'#7e22ce' },
        { bg:'#0c4a6e', text:'#7dd3fc', border:'#0369a1' },
        { bg:'#052e16', text:'#86efac', border:'#15803d' },
        { bg:'#450a0a', text:'#fca5a5', border:'#b91c1c' },
        { bg:'#1c1917', text:'#d6d3d1', border:'#57534e' },
    ];

    let activeKelas   = null;
    let dragPayload   = null;
    let jadwalData    = {};   // key: "Senin|0" -> { ...mengajar, jam_mulai, jam_selesai, hari }

    // ── Pilih kelas ────────────────────────────────────────────────────────
    function setKelas(nama) {
        activeKelas = nama;
        document.getElementById('label-kelas').textContent = nama;

        document.querySelectorAll('.kelas-tab').forEach(b => {
            b.classList.toggle('active', b.textContent.trim() === nama);
        });

        buildMapelList();
        refreshGrid();
    }

    // ── Kartu mapel di sidebar ─────────────────────────────────────────────
    function buildMapelList() {
        const wrap = document.getElementById('mapel-list');
        wrap.innerHTML = '';

        const list = mengajarPerKelas[activeKelas] || [];
        if (!list.length) {
            wrap.innerHTML = '<p class="text-xs text-slate-600 italic">Tidak ada pengampu</p>';
            return;
        }

        list.forEach((m, idx) => {
            const c = COLORS[idx % COLORS.length];
            const div = document.createElement('div');
            div.draggable = true;
            div.className = 'rounded-lg px-3 py-2 text-xs font-semibold cursor-grab select-none transition hover:opacity-80';
            div.style.cssText = `background:${c.bg};color:${c.text};border:1px solid ${c.border}`;
            div.innerHTML = `
                <div>${m.mapel}</div>
                <div style="font-weight:400;opacity:.7;font-size:10px;margin-top:1px">${m.guru}</div>`;
            div.ondragstart = e => {
                dragPayload = { ...m, color: c };
                e.dataTransfer.effectAllowed = 'copy';
            };
            wrap.appendChild(div);
        });
    }

    // ── Drop ke cell ────────────────────────────────────────────────────────
    function dropToCell(e, cell) {
        e.preventDefault();
        cell.classList.remove('drag-over');
        if (!dragPayload || !activeKelas) return;

        const day    = cell.dataset.day;
        const si     = cell.dataset.si;
        const mulai  = cell.dataset.mulai;
        const selesai= cell.dataset.selesai;
        const key    = `${activeKelas}|${day}|${si}`;

        jadwalData[key] = {
            ...dragPayload,
            hari       : day,
            jam_mulai  : mulai,
            jam_selesai: selesai,
            kelas      : activeKelas,
        };

        renderCell(cell, jadwalData[key], key);
        updateCount();
    }

    function renderCell(cell, m, key) {
        cell.innerHTML = '';
        const c = m.color;
        const blk = document.createElement('div');
        blk.className = 'sched-block';
        blk.style.cssText = `background:${c.bg};color:${c.text};border:1px solid ${c.border}`;
        blk.draggable = true;
        blk.ondragstart = e => {
            dragPayload = { ...m };
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(() => cell.innerHTML = '', 0);
            delete jadwalData[key];
            updateCount();
        };
        blk.innerHTML = `
            <button class="blk-del" onclick="delBlock('${key}')" title="Hapus">
                <i class="fas fa-times" style="font-size:7px"></i>
            </button>
            <div>${m.mapel}</div>
            <div style="font-weight:400;opacity:.75;font-size:9px;margin-top:1px">${m.guru}</div>`;
        cell.appendChild(blk);
    }

    function delBlock(key) {
        delete jadwalData[key];
        refreshGrid();
        updateCount();
    }

    function refreshGrid() {
        document.querySelectorAll('.tt-cell').forEach(cell => {
            const day  = cell.dataset.day;
            const si   = cell.dataset.si;
            const key  = `${activeKelas}|${day}|${si}`;
            cell.innerHTML = '';
            if (jadwalData[key]) renderCell(cell, jadwalData[key], key);
        });
    }

    function resetGrid() {
        if (!confirm('Hapus semua jadwal yang sudah disusun?')) return;
        // Hanya hapus jadwal kelas aktif
        Object.keys(jadwalData).forEach(k => {
            if (k.startsWith(activeKelas + '|')) delete jadwalData[k];
        });
        refreshGrid();
        updateCount();
    }

    function updateCount() {
        const n = Object.keys(jadwalData).length;
        document.getElementById('jadwal-count').textContent = n + ' sesi';
    }

    // ── Simpan via AJAX ─────────────────────────────────────────────────────
    async function simpanDragDrop() {
        const items = Object.values(jadwalData).map(m => ({
            guru_mengajar_id : m.id,
            hari             : m.hari,
            jam_mulai        : m.jam_mulai,
            jam_selesai      : m.jam_selesai,
        }));

        if (!items.length) {
            alert('Belum ada jadwal yang disusun.');
            return;
        }

        const btn = event.currentTarget;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';

        try {
            const res = await fetch('{{ route('jadwal.drop') }}', {
                method : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept'      : 'application/json',
                },
                body: JSON.stringify({ items }),
            });

            const data = await res.json();

            if (data.success) {
                let msg = `${data.saved} jadwal berhasil disimpan.`;
                if (data.errors?.length) {
                    msg += '\n\nDilewati (bentrok):\n' + data.errors.join('\n');
                }
                alert(msg);
                if (data.saved > 0) window.location.href = '{{ route('jadwal.index') }}';
            } else {
                alert('Gagal menyimpan jadwal.');
            }
        } catch (err) {
            alert('Terjadi kesalahan: ' + err.message);
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan Jadwal';
        }
    }

    // ── Drop file Excel ke label ─────────────────────────────────────────────
    function handleExcelDrop(e) {
        e.preventDefault();
        const file = e.dataTransfer.files[0];
        if (!file) return;
        const inp = document.getElementById('file-inp');
        const dt  = new DataTransfer();
        dt.items.add(file);
        inp.files = dt.files;
        inp.dispatchEvent(new Event('change'));
    }

    // ── Init: pilih kelas pertama otomatis ──────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        const first = document.querySelector('.kelas-tab');
        if (first) first.click();
    });
    </script>
</x-app-layout>