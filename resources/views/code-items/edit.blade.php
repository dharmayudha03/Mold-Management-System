<x-app-layout>
    <x-slot name="header">
        Edit Code Item
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('code-items.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke List Code Item
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-edit text-primary mr-2"></i>Form Edit Code Item</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Update Master Data</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('code-items.update', $codeItem->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Section 1 -->
                    <div class="border-bottom pb-3 mb-4">
                        <h6 class="font-weight-extrabold text-gray-900 mb-1"><i class="fas fa-link text-indigo-600 mr-2"></i>Relasi Master Data</h6>
                        <p class="text-xs text-gray-500 mb-0">Pilih / ketik relasi master data code item, mold set, dan cavity.</p>
                    </div>

                    <div class="form-grid-3">
                        <div class="form-group-item">
                            <label class="form-label">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" id="list_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item --</option>
                                @foreach($listCodeItems as $item)
                                    <option value="{{ $item->id }}" {{ old('list_code_item_id', $codeItem->list_code_item_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select">
                                <option value="">-- Pilih Mold Set --</option>
                                @foreach($setCodeItems as $set)
                                    <option value="{{ $set->id }}" {{ old('set_code_item_id', $codeItem->set_code_item_id) == $set->id ? 'selected' : '' }}>{{ $set->moldset }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" id="cav_code_item_id" required class="form-select">
                                <option value="">-- Pilih Mold Cavity --</option>
                                @foreach($cavCodeItems as $cav)
                                    <option value="{{ $cav->id }}" {{ old('cav_code_item_id', $codeItem->cav_code_item_id) == $cav->id ? 'selected' : '' }}>{{ $cav->moldcav }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Section 2 -->
                    <div class="border-bottom pb-3 mb-4 pt-2">
                        <h6 class="font-weight-extrabold text-gray-900 mb-1"><i class="fas fa-info-circle text-primary mr-2"></i>Detail Part & Status Mold</h6>
                        <p class="text-xs text-gray-500 mb-0">Masukkan detail part name, part number, customer, dan posisi lokasi mold.</p>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group-item">
                            <label class="form-label">Part Name <span class="text-danger">*</span></label>
                            <input type="text" name="partname" value="{{ old('partname', $codeItem->partname) }}" required class="form-control uppercase">
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Part Number <span class="text-danger">*</span></label>
                            <input type="text" name="partnumber" value="{{ old('partnumber', $codeItem->partnumber) }}" required class="form-control uppercase">
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Customer <span class="text-danger">*</span></label>
                            <input type="text" name="customer" value="{{ old('customer', $codeItem->customer) }}" required class="form-control uppercase">
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Posisi Mold <span class="text-danger">*</span></label>
                            <select name="moldposisi" required class="form-select">
                                <option value="Plant 1" {{ old('moldposisi', $codeItem->moldposisi) == 'Plant 1' ? 'selected' : '' }}>Plant 1</option>
                                <option value="Plant 2" {{ old('moldposisi', $codeItem->moldposisi) == 'Plant 2' ? 'selected' : '' }}>Plant 2</option>
                                <option value="Plant 4" {{ old('moldposisi', $codeItem->moldposisi) == 'Plant 4' ? 'selected' : '' }}>Plant 4</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-1">
                        <div class="form-group-item">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" required class="form-select">
                                <option value="Aktif" {{ old('status', $codeItem->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status', $codeItem->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('code-items.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Update Code Item
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
            const cavEl = document.getElementById('cav_code_item_id');
            const baseUrl = "{{ url('/') }}";

            let tsCodeItem = null, tsSet = null, tsCav = null;

            if (window.TomSelect) {
                if (codeItemEl && !codeItemEl.tomselect) {
                    tsCodeItem = new TomSelect(codeItemEl, { 
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
                if (setEl && !setEl.tomselect) {
                    tsSet = new TomSelect(setEl, { plugins: ['dropdown_input'], create: false, maxItems: 1, closeAfterSelect: true, placeholder: '-- Pilih / Ketik Mold Set --' });
                }
                if (cavEl && !cavEl.tomselect) {
                    tsCav = new TomSelect(cavEl, { plugins: ['dropdown_input'], create: false, maxItems: 1, closeAfterSelect: true, placeholder: '-- Pilih / Ketik Mold Cavity --' });
                }
            }

            function updateSets(listId) {
                if (!setEl) return;
                fetch(`${baseUrl}/api/code-item/sets?list_code_item_id=${listId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (tsSet) {
                            tsSet.clearOptions();
                            tsSet.clear();
                            data.forEach(item => tsSet.addOption({ value: item.id, text: item.moldset }));
                            tsSet.refreshOptions(false);
                        } else {
                            setEl.innerHTML = '<option value="">-- Pilih Mold Set --</option>';
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.id;
                                opt.textContent = item.moldset;
                                setEl.appendChild(opt);
                            });
                        }
                    });
            }

            function updateCavs(listId, setId) {
                if (!cavEl) return;
                fetch(`${baseUrl}/api/code-item/cavs?list_code_item_id=${listId}&set_code_item_id=${setId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (tsCav) {
                            tsCav.clearOptions();
                            tsCav.clear();
                            data.forEach(item => tsCav.addOption({ value: item.id, text: item.moldcav }));
                            tsCav.refreshOptions(false);
                        } else {
                            cavEl.innerHTML = '<option value="">-- Pilih Mold Cavity --</option>';
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.id;
                                opt.textContent = item.moldcav;
                                cavEl.appendChild(opt);
                            });
                        }
                    });
            }

            if (codeItemEl) {
                codeItemEl.addEventListener('change', function () {
                    const listId = this.value;
                    updateSets(listId);
                    updateCavs(listId, setEl ? setEl.value : '');
                });
            }

            if (setEl) {
                setEl.addEventListener('change', function () {
                    const listId = codeItemEl ? codeItemEl.value : '';
                    const setId = this.value;
                    updateCavs(listId, setId);
                });
            }
        });
    </script>
</x-app-layout>
