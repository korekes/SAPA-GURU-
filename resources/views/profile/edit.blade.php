<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="javascript:history.back()" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-400 hover:text-white border border-slate-700/60 transition shadow-sm">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <span class="block text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-0.5">Pengaturan Akun</span>
                    <h2 class="font-bold text-xl text-white tracking-tight leading-none">Manajemen Profil</h2>
                </div>
            </div>
            <div class="flex gap-2">
                <button @click="$dispatch('open-modal', 'edit-profile')" class="hidden md:flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl transition shadow-lg shadow-indigo-600/20">
                    <i class="fas fa-edit"></i> Edit Profil
                </button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto px-6 py-12 relative z-20 pb-20" x-data="{ photoHover: false, showPhotoModal: false }">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-[#111827] rounded-[2.5rem] border border-slate-800/80 p-8 shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-indigo-600/20 to-transparent"></div>
                    
                    <div class="relative flex flex-col items-center">
                        <div class="relative group cursor-pointer" @click="showPhotoModal = true">
                            <div class="absolute inset-0 bg-indigo-500 blur-2xl opacity-20 group-hover:opacity-40 transition-opacity rounded-full"></div>
                            <div class="relative w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-[#0f172a] shadow-2xl overflow-hidden bg-slate-800 ring-1 ring-white/10 transition-transform duration-500 group-hover:scale-105">
                                @if($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-600 to-cyan-600 flex items-center justify-center text-5xl font-black text-white">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-white">
                                    <i class="fas fa-search-plus text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <h3 class="text-2xl font-black text-white tracking-tight">{{ $user->name }}</h3>
                            <span class="inline-block px-3 py-1 mt-2 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                {{ $user->role }}
                            </span>
                        </div>

                        <div class="w-full mt-8 space-y-3">
                            <button @click="$dispatch('open-modal', 'edit-profile')" class="w-full py-3 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold rounded-2xl transition border border-slate-700/50">
                                <i class="fas fa-user-edit mr-2 text-indigo-400"></i> Edit Informasi
                            </button>
                            <button @click="$dispatch('open-modal', 'update-password')" class="w-full py-3 bg-slate-800/50 hover:bg-slate-700 text-white text-xs font-bold rounded-2xl transition border border-slate-700/50">
                                <i class="fas fa-key mr-2 text-amber-400"></i> Ganti Password
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-[#111827] rounded-3xl border border-slate-800/80 p-6 shadow-xl">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Informasi Kontak</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center text-indigo-400 border border-slate-800"><i class="far fa-envelope text-xs"></i></div>
                            <div class="truncate"><p class="text-[10px] text-slate-500 font-bold uppercase">Email</p><p class="text-sm text-slate-200 truncate">{{ $user->email }}</p></div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center text-rose-400 border border-slate-800"><i class="fas fa-map-marker-alt text-xs"></i></div>
                            <div><p class="text-[10px] text-slate-500 font-bold uppercase">Penempatan</p><p class="text-sm text-slate-200">SMK NEGERI 2 DEMAK</p></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-indigo-600 p-8 rounded-[2rem] shadow-xl shadow-indigo-600/20 relative overflow-hidden group">
                        <i class="fas fa-id-card absolute -bottom-4 -right-4 text-8xl text-white/10 rotate-12 transition-transform group-hover:scale-110"></i>
                        <p class="text-indigo-200 text-[10px] font-black uppercase tracking-widest mb-1">NIP Resmi Pegawai</p>
                        <h4 class="text-2xl font-black text-white tracking-tighter">{{ $user->nip ?? 'Belum Diatur' }}</h4>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="px-2 py-1 bg-white/20 rounded text-[9px] text-white font-bold">TERVERIFIKASI</span>
                        </div>
                    </div>
                    <div class="bg-slate-800/50 p-8 rounded-[2rem] border border-slate-700/50 shadow-xl relative overflow-hidden group">
                        <i class="fas fa-clock-rotate-left absolute -bottom-4 -right-4 text-8xl text-slate-700/20 rotate-12 transition-transform group-hover:scale-110"></i>
                        <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1">Sesi Aktif Terakhir</p>
                        <h4 class="text-2xl font-black text-white tracking-tighter">{{ now()->translatedFormat('d M Y') }}</h4>
                        <p class="text-xs text-slate-400 mt-2">Pukul {{ now()->format('H:i') }} WIB</p>
                    </div>
                </div>

                <div class="bg-[#111827] rounded-[2.5rem] border border-slate-800/80 p-8 shadow-2xl relative">
                    <div class="flex items-center justify-between mb-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 shadow-inner">
                                <i class="fas fa-stream"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-white tracking-tight">Riwayat Kegiatan</h3>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Real-time Activity Tracker</p>
                            </div>
                        </div>
                    </div>
                    <div id="activity-timeline" class="relative space-y-6 before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-slate-800 before:via-slate-800 before:to-transparent">
                        </div>
                </div>
            </div>
        </div>

        <template x-if="showPhotoModal">
            <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm" @click.self="showPhotoModal = false" x-transition>
                <div class="relative max-w-2xl w-full">
                    <button @click="showPhotoModal = false" class="absolute -top-12 right-0 text-white text-2xl hover:text-indigo-400 transition">
                        <i class="fas fa-times"></i>
                    </button>
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" class="w-full h-auto rounded-3xl shadow-2xl border border-white/10">
                    @else
                        <div class="w-64 h-64 mx-auto bg-gradient-to-br from-indigo-600 to-cyan-600 rounded-full flex items-center justify-center text-8xl font-black text-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
        </template>
    </div>

    <x-modal name="edit-profile" focusable>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-8 bg-[#111827]" x-data="{ photoPreview: null }">
            @csrf
            @method('patch')
            <h2 class="text-xl font-black text-white tracking-tight mb-1">Edit Profil</h2>
            <p class="text-xs text-slate-500 mb-6 uppercase tracking-widest font-bold">Perbarui Informasi Dasar Anda</p>

            <div class="space-y-5">
                <div class="flex flex-col items-center mb-4">
                    <div class="relative mb-3">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-900 border-2 border-slate-800 ring-2 ring-indigo-500/20">
                            <template x-if="!photoPreview">
                                @if($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl font-black text-indigo-500 bg-indigo-500/5">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </template>
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                        </div>
                        <label for="modalPhotoInput" class="absolute -bottom-2 -right-2 w-8 h-8 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg flex items-center justify-center cursor-pointer shadow-lg transition shadow-indigo-600/40">
                            <i class="fas fa-camera text-xs"></i>
                            <input type="file" id="modalPhotoInput" name="foto" class="hidden" accept="image/*"
                                @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }">
                        </label>
                    </div>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Ganti Foto Profil</span>
                </div>

                <hr class="border-slate-800/50">

                <div>
                    <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-slate-900 border-slate-800 rounded-xl text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" name="nip" value="{{ $user->nip }}" class="w-full bg-slate-900 border-slate-800 rounded-xl text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-slate-900 border-slate-800 rounded-xl text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-2 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-700 transition">Batal</button>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-500 transition shadow-lg shadow-indigo-600/20">Simpan Perubahan</button>
            </div>
        </form>
    </x-modal>

    <x-modal name="update-password" focusable>
    <form method="POST" action="{{ route('password.update') }}" class="p-8 bg-[#111827]">
        @csrf
        @method('put')

        <h2 class="text-xl font-black text-white tracking-tight mb-1">Ganti Password</h2>
        <p class="text-xs text-slate-500 mb-6 uppercase tracking-widest font-bold">
            Pastikan password baru aman dan mudah diingat
        </p>

        <div class="space-y-4">
            <!-- Password Lama -->
            <div>
                <label class="block text-[10px] font-black text-amber-400 uppercase mb-1">
                    Password Saat Ini
                </label>
                <input type="password" name="current_password"
                    class="w-full bg-slate-900 border-slate-800 rounded-xl text-white text-sm focus:ring-amber-500 focus:border-amber-500">
            </div>

            <!-- Password Baru -->
            <div>
                <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1">
                    Password Baru
                </label>
                <input type="password" name="password"
                    class="w-full bg-slate-900 border-slate-800 rounded-xl text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Konfirmasi -->
            <div>
                <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1">
                    Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation"
                    class="w-full bg-slate-900 border-slate-800 rounded-xl text-white text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <button type="button" x-on:click="$dispatch('close')"
                class="px-6 py-2 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-700 transition">
                Batal
            </button>

            <button type="submit"
                class="px-6 py-2 bg-amber-600 text-white text-xs font-bold rounded-xl hover:bg-amber-500 transition shadow-lg shadow-amber-600/20">
                Update Password
            </button>
        </div>
    </form>
</x-modal>

    <script>
           function loadProfileActivity() {
        fetch("/Activity/latest")
            .then(res => res.json())
            .then(data => {
                let html = '';
                if (data.length === 0) {
                    html = `
                        <div class="text-center py-10">
                            <p class="text-slate-500 text-xs uppercase tracking-widest font-bold">Belum ada aktivitas tercatat</p>
                        </div>`;
                } else {
                    data.forEach((item) => {
                        // Logika warna berdasarkan icon/tipe dari DB (default indigo)
                        let colorClass = item.icon_color || 'indigo'; 
                        let iconClass = item.icon_name || 'fas fa-circle';

                        html += `
                        <div class="relative flex items-center justify-between group">
                            <div class="flex items-center gap-6">
                                <div class="absolute left-0 w-10 h-10 rounded-full bg-slate-900 border-4 border-[#111827] flex items-center justify-center z-10 group-hover:border-${colorClass}-500/50 transition-colors shadow-xl">
                                    <i class="${iconClass} text-${colorClass}-500 text-xs"></i>
                                </div>
                                <div class="ml-14">
                                    <p class="text-sm font-bold text-slate-200 group-hover:text-white transition-colors">${item.judul}</p>
                                    <p class="text-[10px] text-slate-500 font-medium">${item.deskripsi ?? ''}</p>
                                    <p class="text-[9px] text-slate-600 mt-1 uppercase font-black tracking-tighter italic">
                                        <i class="far fa-clock mr-1"></i> ${timeAgoProfile(item.created_at)}
                                    </p>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                }
                document.getElementById('activity-timeline').innerHTML = html;
            })
            .catch(err => {
                console.error('Error fetching activity:', err);
                document.getElementById('activity-timeline').innerHTML = '<p class="text-rose-400 text-xs p-4">Gagal memuat aktivitas.</p>';
            });
    }

    function timeAgoProfile(time) {
        let now = new Date();
        let past = new Date(time);
        let diff = Math.floor((now - past) / 1000);

        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return Math.floor(diff/60) + ' menit lalu';
        if (diff < 86400) return Math.floor(diff/3600) + ' jam lalu';
        return Math.floor(diff/86400) + ' hari lalu';
    }

    // Inisialisasi awal
    loadProfileActivity();

    // Auto Refresh setiap 10 detik agar tidak terlalu membebani server
    setInterval(loadProfileActivity, 10000);
    </script>
</x-app-layout>