<x-app-layout>
    <x-slot name="header">
        Update Hasil Mold Shop (Form MJO)
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('form-mjos.index') }}" class="text-sm text-slate-400 hover:text-white flex items-center gap-2">
                &larr; Kembali ke List Form MJO
            </a>
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                <i class="fas fa-tools mr-1"></i> Update Mold Shop
            </span>
        </div>

        <form action="{{ route('form-mjos.update-moldshop', $formMjo->id) }}" method="POST" enctype="multipart/form-data" class="bg-slate-950 border border-emerald-900/60 rounded-2xl p-6 shadow-xl space-y-6">
            @csrf
            @method('PUT')

            <!-- Header Summary Doc Info (Readonly for Mold Shop context) -->
            <div class="bg-slate-900/80 p-4 rounded-xl border border-slate-800 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                    <span class="text-xs font-bold text-slate-400 uppercase">Informasi Laporan PE</span>
                    <span class="text-xs font-bold text-indigo-400 bg-indigo-950/60 px-2.5 py-1 rounded-md border border-indigo-800/40">
                        No Doc: {{ $formMjo->nodoc }}
                    </span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                    <div>
                        <span class="text-slate-500 block">Code Item & Mold:</span>
                        <strong class="text-slate-200 text-sm block mt-0.5">{{ $formMjo->listCodeItem->name ?? '-' }}</strong>
                        <span class="text-slate-400 font-medium">Set: {{ $formMjo->setCodeItem->moldset ?? '-' }} | Cav: {{ $formMjo->cavCodeItem->moldcav ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">PIC PE:</span>
                        <strong class="text-slate-200 block mt-0.5">{{ $formMjo->detailUser->name ?? '-' }}</strong>
                        <span class="text-slate-400 font-medium">Tgl MJO: {{ \Carbon\Carbon::parse($formMjo->tanggal)->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Status Repair Saat Ini:</span>
                        <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $formMjo->status == 'Selesai' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30' }}">
                            {{ $formMjo->status ?? 'Dalam Proses' }}
                        </span>
                    </div>
                </div>
                <div class="pt-1">
                    <span class="text-slate-500 block text-xs">Masalah dari PE:</span>
                    <p class="text-slate-300 text-xs bg-slate-950 p-2.5 rounded-lg border border-slate-800/80 mt-1 italic">
                        "{{ $formMjo->masalah }}"
                    </p>
                </div>
            </div>

            <!-- Form Perbaikan Mold Shop -->
            <div class="space-y-4">
                <div class="border-b border-emerald-800/40 pb-2">
                    <h3 class="text-sm font-extrabold text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-check-circle text-emerald-400"></i> Form Hasil Perbaikan (Mold Shop)
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Status Perbaikan Mold Shop *</label>
                        <select name="status" required class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 text-sm text-white h-[42px] focus:border-emerald-500">
                            <option value="Proses" {{ old('status', $formMjo->status) == 'Proses' || empty($formMjo->status) ? 'selected' : '' }}>Dalam Proses (Process)</option>
                            <option value="Selesai" {{ old('status', $formMjo->status) == 'Selesai' ? 'selected' : '' }}>Selesai (Completed)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Tanggal Selesai Perbaikan</label>
                        <input type="date" name="tglselesai" value="{{ old('tglselesai', $formMjo->tglselesai ? \Carbon\Carbon::parse($formMjo->tglselesai)->format('Y-m-d') : date('Y-m-d')) }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 text-sm text-white h-[42px] focus:border-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase mb-2">Tindakan / Detail Perbaikan oleh Mold Shop *</label>
                    <textarea name="tindakan_moldshop" rows="4" required placeholder="Tuliskan tindakan perbaikan yang telah dilakukan oleh tim Mold Shop..." class="w-full bg-slate-900 border border-slate-800 rounded-xl p-3 text-sm text-white focus:border-emerald-500">{{ old('tindakan_moldshop', $formMjo->tindakan_moldshop) }}</textarea>
                </div>

                <!-- Foto Bukti Hasil Perbaikan Selesai -->
                <div class="space-y-3 pt-2">
                    <h4 class="text-xs font-bold text-emerald-400 uppercase tracking-wider border-b border-emerald-900/40 pb-1">
                        Foto Bukti Perbaikan Selesai (Mold Shop)
                    </h4>
                    @php
                        $imgsSelesai = json_decode($formMjo->gambar_selesai, true);
                        if (!is_array($imgsSelesai)) {
                            $imgsSelesai = $formMjo->gambar_selesai ? [$formMjo->gambar_selesai] : [];
                        }
                    @endphp
                    @if(count($imgsSelesai) > 0)
                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Foto Bukti Hasil Repair Terupload Saat Ini:</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($imgsSelesai as $imgPathS)
                                    @php $cleanUrlS = asset(ltrim(str_replace('\\', '/', $imgPathS), '/')); @endphp
                                    <a href="{{ $cleanUrlS }}" target="_blank" class="border border-emerald-700/50 rounded-lg p-1 bg-emerald-950/40 hover:border-emerald-400 transition-all" title="Klik untuk lihat foto bukti repair">
                                        <img src="{{ $cleanUrlS }}" class="w-16 h-16 object-cover rounded-md">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">Tambah Foto Bukti Repair Selesai (Maks 10 MB per file)</label>
                        <input type="file" name="gambar_selesai[]" id="gambar_selesai_input" multiple accept="image/*" class="w-full bg-slate-900 border border-slate-800 rounded-xl p-2 text-xs text-slate-300">
                        <p class="text-xs text-slate-500 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal ukuran per foto: <strong>10 MB</strong>.</p>
                        <div id="image_selesai_preview_container" class="flex flex-wrap gap-2 mt-3"></div>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-800">
                <a href="{{ route('form-mjos.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-700 text-sm font-medium text-slate-300 hover:bg-slate-800 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-sm font-semibold text-white shadow-lg shadow-emerald-600/30 transition-all">
                    <i class="fas fa-check mr-1"></i> Simpan Hasil Mold Shop
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Image Selesai 10MB Validation & Preview Handler
            const gambarSelesaiInput = document.getElementById('gambar_selesai_input');
            const previewSelesaiContainer = document.getElementById('image_selesai_preview_container');

            if (gambarSelesaiInput && previewSelesaiContainer) {
                gambarSelesaiInput.addEventListener('change', function () {
                    previewSelesaiContainer.innerHTML = '';
                    const files = Array.from(this.files);
                    let sizeExceeded = false;

                    files.forEach(file => {
                        if (file.size > 10 * 1024 * 1024) { // 10MB
                            sizeExceeded = true;
                        } else {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const div = document.createElement('div');
                                div.className = 'border border-emerald-700/50 rounded-lg p-1 bg-emerald-950/40';
                                div.style.width = '64px';
                                div.style.height = '64px';
                                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-md" title="${file.name}">`;
                                previewSelesaiContainer.appendChild(div);
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    if (sizeExceeded) {
                        alert('Perhatian: Salah satu atau beberapa foto bukti perbaikan yang Anda pilih melebihi ukuran 10 MB! Silakan pilih foto dengan ukuran maksimal 10 MB.');
                        this.value = '';
                        previewSelesaiContainer.innerHTML = '';
                    }
                });
            }
        });
    </script>
</x-app-layout>
