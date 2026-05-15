<x-app-layout>
    <x-slot name="title">
        Sikap dan Keaktifan - {{ $kelas->nama_kelas }}
    </x-slot>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('nilai.kelas', $kelas->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Instrumen Afektif</span>
                <h2 class="font-bold text-xl text-white tracking-tight leading-none">
                    Sikap & Keaktifan: {{ $kelas->nama_kelas }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-2">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">

            <a href="{{ route('nilai.sikap.keaktifan', $kelas->id) }}"
               class="bg-[#111827] border border-slate-800/80 p-6 rounded-2xl hover:border-emerald-500/30 hover:bg-slate-800/20 transition duration-200 group relative overflow-hidden shadow-md flex flex-col justify-between min-h-[140px]">
                <div class="absolute -right-6 -top-6 w-20 h-20 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition"></div>
                
                <div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-4 shadow-inner group-hover:scale-105 transition duration-200">
                        <i class="fas fa-chart-line text-sm"></i>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-tight group-hover:text-emerald-400 transition">
                        Input Nilai Keaktifan
                    </h3>
                    <p class="text-xs text-slate-400 font-medium mt-1.5 leading-relaxed">
                        Evaluasi tingkat partisipasi, inisiatif, dan performa komunikasi siswa selama kegiatan diskusi.
                    </p>
                </div>
                
                <div class="mt-4 flex items-center justify-end text-[11px] font-bold text-slate-500 group-hover:text-emerald-400 transition gap-1">
                    Buka Lembar Nilai <i class="fas fa-chevron-right text-[9px] translate-x-0 group-hover:translate-x-0.5 transition"></i>
                </div>
            </a>

            <a href="{{ route('nilai.sikap.perilaku', $kelas->id) }}"
               class="bg-[#111827] border border-slate-800/80 p-6 rounded-2xl hover:border-sky-500/30 hover:bg-slate-800/20 transition duration-200 group relative overflow-hidden shadow-md flex flex-col justify-between min-h-[140px]">
                <div class="absolute -right-6 -top-6 w-20 h-20 bg-sky-500/5 rounded-full blur-xl group-hover:bg-sky-500/10 transition"></div>
                
                <div>
                    <div class="w-10 h-10 rounded-xl bg-sky-500/10 border border-sky-500/20 text-sky-400 flex items-center justify-center mb-4 shadow-inner group-hover:scale-105 transition duration-200">
                        <i class="fas fa-universal-access text-sm"></i>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-tight group-hover:text-sky-400 transition">
                        Input Nilai Sikap & Perilaku
                    </h3>
                    <p class="text-xs text-slate-400 font-medium mt-1.5 leading-relaxed">
                        Rekam data perkembangan karakter moral, tingkat kedisiplinan, serta rasa tanggung jawab siswa.
                    </p>
                </div>
                
                <div class="mt-4 flex items-center justify-end text-[11px] font-bold text-slate-500 group-hover:text-sky-400 transition gap-1">
                    Buka Lembar Nilai <i class="fas fa-chevron-right text-[9px] translate-x-0 group-hover:translate-x-0.5 transition"></i>
                </div>
            </a>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <div class="bg-[#111827] rounded-2xl p-5 border border-slate-800/80 shadow-sm">
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-800/60">
                    <div class="w-1.5 h-4 bg-emerald-500 rounded-full"></div>
                    <h4 class="text-xs font-extrabold text-slate-300 uppercase tracking-wider">
                        Indikator Penilaian Keaktifan
                    </h4>
                </div>

                <ul class="space-y-3 text-slate-400 text-xs font-medium">
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-check-circle text-emerald-500/60 mt-0.5 text-xs"></i>
                        <span><strong class="text-slate-300">Keterlibatan Diskusi:</strong> Aktif memberikan tanggapan ilmiah saat forum grup.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-check-circle text-emerald-500/60 mt-0.5 text-xs"></i>
                        <span><strong class="text-slate-300">Inisiatif Belajar:</strong> Memiliki dorongan mencari referensi materi tanpa instruksi.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-check-circle text-emerald-500/60 mt-0.5 text-xs"></i>
                        <span><strong class="text-slate-300">Kolaborasi & Kerjasama:</strong> Berkontribusi merata dalam pembagian tugas tim.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-check-circle text-emerald-500/60 mt-0.5 text-xs"></i>
                        <span><strong class="text-slate-300">Kemampuan Komunikasi:</strong> Menyampaikan gagasan dengan runut dan sopan.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-check-circle text-emerald-500/60 mt-0.5 text-xs"></i>
                        <span><strong class="text-slate-300">Ketepatan Solusi:</strong> Fokus merampungkan lembar kerja sesuai batas waktu.</span>
                    </li>
                </ul>
            </div>

            <div class="bg-[#111827] rounded-2xl p-5 border border-slate-800/80 shadow-sm">
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-800/60">
                    <div class="w-1.5 h-4 bg-sky-500 rounded-full"></div>
                    <h4 class="text-xs font-extrabold text-slate-300 uppercase tracking-wider">
                        Indikator Penilaian Sikap
                    </h4>
                </div>

                <ul class="space-y-3 text-slate-400 text-xs font-medium">
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-heart text-sky-500/60 mt-0.5 text-xs"></i>
                        <span><strong class="text-slate-300">Tingkat Kedisiplinan:</strong> Hadir tepat waktu dan mengenakan atribut lengkap.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-heart text-sky-500/60 mt-0.5 text-xs"></i>
                        <span><strong class="text-slate-300">Aspek Kejujuran:</strong> Integritas dalam mengerjakan ujian (tidak menyontek).</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-heart text-sky-500/60 mt-0.5 text-xs"></i>
                        <span><strong class="text-slate-300">Tanggung Jawab:</strong> Menerima konsekuensi atas tugas yang diamanahkan.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-heart text-sky-500/60 mt-0.5 text-xs"></i>
                        <span><strong class="text-slate-300">Kemandirian Kerja:</strong> Mampu memecahkan kendala mandiri sebelum bertanya.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-heart text-sky-500/60 mt-0.5 text-xs"></i>
                        <span><strong class="text-slate-300">Kepedulian Sosial:</strong> Berempati dan menolong rekan sejawat yang kesulitan.</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="bg-[#111827] rounded-2xl p-5 border border-slate-800/80 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <i class="fas fa-sliders text-indigo-400 text-sm"></i>
                <h4 class="text-xs font-extrabold text-slate-300 uppercase tracking-wider">
                    Konversi Skala Nilai Acuan (Standar Rapor)
                </h4>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 text-center">
                <div class="bg-rose-500/5 border border-rose-500/20 p-3.5 rounded-xl shadow-sm">
                    <span class="block text-sm font-black text-rose-400 font-mono">1 / D</span>
                    <span class="text-[11px] font-semibold text-slate-400 mt-1 block">Kurang / Tidak Aktif</span>
                </div>

                <div class="bg-amber-500/5 border border-amber-500/20 p-3.5 rounded-xl shadow-sm">
                    <span class="block text-sm font-black text-amber-400 font-mono">2 / C</span>
                    <span class="text-[11px] font-semibold text-slate-400 mt-1 block">Cukup Aktif</span>
                </div>

                <div class="bg-sky-500/5 border border-sky-500/20 p-3.5 rounded-xl shadow-sm">
                    <span class="block text-sm font-black text-sky-400 font-mono">3 / B</span>
                    <span class="text-[11px] font-semibold text-slate-400 mt-1 block">Aktif / Baik</span>
                </div>

                <div class="bg-emerald-500/5 border border-emerald-500/20 p-3.5 rounded-xl shadow-sm">
                    <span class="block text-sm font-black text-emerald-400 font-mono">4 / A</span>
                    <span class="text-[11px] font-semibold text-slate-400 mt-1 block">Sangat Aktif / Baik</span>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>