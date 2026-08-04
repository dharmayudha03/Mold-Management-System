<x-app-layout>
    <x-slot name="header">
        Tambah List Code Item
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('list-code-items.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke List Code Item
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-plus-circle text-primary mr-2"></i>Form Tambah Master Code Item</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Master Data</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('list-code-items.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">Nama / Kode Item <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: B301-SET" 
                            class="form-control text-xs py-2 uppercase" style="border-radius: 0.75rem;">
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('list-code-items.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
