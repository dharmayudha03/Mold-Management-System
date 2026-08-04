<x-app-layout>
    <x-slot name="header">
        Tambah Master Rak
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('list-raks.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Master List Rak
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-plus-circle text-primary mr-2"></i>Form Tambah Master Rak</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Master Data</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('list-raks.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">Pilih / Ketik Nama Rak <span class="text-danger">*</span></label>
                        <select name="rak" id="rak_select" required class="form-select text-xs">
                            <option value="">-- Pilih / Ketik Rak Baru --</option>
                            @foreach($existingRaks as $er)
                                <option value="{{ $er }}" {{ old('rak') == $er ? 'selected' : '' }}>{{ $er }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">No. Rak <span class="text-danger">*</span></label>
                        <input type="text" name="norak" value="{{ old('norak') }}" required placeholder="Contoh: 01 (atau 01-30 untuk buat rentang 1 s/d 30)" class="form-control text-xs py-2 uppercase" style="border-radius: 0.75rem;">
                        <small class="text-gray-500 mt-1 d-block" style="font-size: 0.75rem;">
                            <i class="fas fa-info-circle mr-1"></i>Anda dapat mengetik single nomor (misal: <code>01</code>) atau rentang (misal: <code>01-30</code>).
                        </small>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('list-raks.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Simpan Data Rak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.TomSelect) {
                new TomSelect('#rak_select', {
                    plugins: ['dropdown_input'],
                    create: true,
                    maxItems: 1,
                    closeAfterSelect: true,
                    placeholder: '-- Pilih / Ketik Rak Baru --'
                });
            }
        });
    </script>
</x-app-layout>
