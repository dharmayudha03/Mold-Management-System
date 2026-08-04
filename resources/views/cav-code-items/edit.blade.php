<x-app-layout>
    <x-slot name="header">
        Edit Mold Cavity
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('cav-code-items.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Mold Cavity
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900">
                    <i class="fas fa-edit text-primary mr-2"></i>Form Edit Mold Cavity
                </h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Update Master Data</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('cav-code-items.update', $cavCodeItem->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Section: Relasi --}}
                    <div class="border-bottom pb-3 mb-4">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0">
                            <i class="fas fa-link text-indigo-600 mr-2"></i>Relasi Code Item & Mold Set
                        </h6>
                    </div>

                    <div class="form-grid-1 mb-3">
                        <div class="form-group-item">
                            <label class="form-label">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" id="list_code_item_id" required class="form-select">
                                <option value="">-- Pilih / Ketik Code Item --</option>
                                @foreach($listCodeItems as $ci)
                                    <option value="{{ $ci->id }}" {{ old('list_code_item_id', $cavCodeItem->list_code_item_id) == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-1 mb-1">
                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select"
                                data-selected="{{ old('set_code_item_id', $cavCodeItem->set_code_item_id) }}">
                                <option value="">-- Pilih Mold Set --</option>
                                @foreach($setCodeItems as $s)
                                    <option value="{{ $s->id }}" {{ old('set_code_item_id', $cavCodeItem->set_code_item_id) == $s->id ? 'selected' : '' }}>{{ $s->moldset }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Section: Nama Cavity --}}
                    <div class="border-bottom pb-3 mb-4 pt-4">
                        <h6 class="font-weight-extrabold text-gray-900 mb-0">
                            <i class="fas fa-tag text-emerald-600 mr-2"></i>Nama Mold Cavity
                        </h6>
                    </div>

                    <div class="form-grid-1">
                        <div class="form-group-item">
                            <label class="form-label">Nama Mold Cavity <span class="text-danger">*</span></label>
                            <input type="text" name="moldcav" value="{{ old('moldcav', $cavCodeItem->moldcav) }}" required
                                class="form-control uppercase">
                        </div>
                    </div>

                    <div class="pt-4 border-top d-flex align-items-center justify-content-end gap-2 mt-4">
                        <a href="{{ route('cav-code-items.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Update Mold Cavity
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const codeItemEl = document.getElementById('list_code_item_id');
            const setEl = document.getElementById('set_code_item_id');
            const baseUrl = "{{ url('/') }}";
            const selectedSetId = setEl ? setEl.dataset.selected : null;

            // TomSelect for Code Item (searchable)
            if (window.TomSelect && codeItemEl && !codeItemEl.tomselect) {
                new TomSelect(codeItemEl, {
                    plugins: {
                        'dropdown_input': {},
                        'clear_button': { title: 'Hapus pilihan' }
                    },
                    allowEmptyOption: true,
                    create: false,
                    maxItems: 1,
                    closeAfterSelect: true,
                    placeholder: '-- Pilih Code Item --',
                    sortField: [],
                    render: {
                        no_results: function(data, escape) {
                            return '<div class="no-results p-2 text-xs text-gray-500 font-weight-bold">Code item yang dicari tidak ada</div>';
                        }
                    }
                });
            }

            if (codeItemEl && setEl) {
                codeItemEl.addEventListener('change', function () {
                    const listId = this.value;
                    setEl.innerHTML = '<option value="">-- Memuat Mold Set... --</option>';

                    if (!listId) {
                        setEl.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>';
                        return;
                    }

                    fetch(`${baseUrl}/api/code-item/sets?list_code_item_id=${listId}`)
                        .then(res => res.json())
                        .then(data => {
                            setEl.innerHTML = '<option value="">-- Pilih Mold Set --</option>';
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.id;
                                opt.textContent = item.moldset;
                                if (String(item.id) === String(selectedSetId)) opt.selected = true;
                                setEl.appendChild(opt);
                            });
                        })
                        .catch(() => {
                            setEl.innerHTML = '<option value="">-- Gagal memuat data --</option>';
                        });
                });
            }
        });
    </script>
</x-app-layout>
