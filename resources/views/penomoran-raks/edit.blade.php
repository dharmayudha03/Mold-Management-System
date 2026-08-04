<x-app-layout>
    <x-slot name="header">
        Edit Penomoran Rak
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('penomoran-raks.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Penomoran Rak
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-edit text-primary mr-2"></i>Form Edit Penomoran Rak</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Update Tracking</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('penomoran-raks.update', $penomoranRak->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-grid-3 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" id="list_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item --</option>
                                @foreach($listCodeItems as $ci)
                                    <option value="{{ $ci->id }}" {{ old('list_code_item_id', $penomoranRak->list_code_item_id) == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item Terlebih Dahulu --</option>
                                @foreach($setCodeItems as $sc)
                                    <option value="{{ $sc->id }}" {{ old('set_code_item_id', $penomoranRak->set_code_item_id) == $sc->id ? 'selected' : '' }}>{{ $sc->moldset }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" id="cav_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item Terlebih Dahulu --</option>
                                @foreach($cavCodeItems as $cc)
                                    <option value="{{ $cc->id }}" {{ old('cav_code_item_id', $penomoranRak->cav_code_item_id) == $cc->id ? 'selected' : '' }}>{{ $cc->moldcav }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Rak <span class="text-danger">*</span></label>
                            <select name="list_rak_id" id="list_rak_id" required class="form-select">
                                <option value="">-- Pilih Rak --</option>
                                @foreach($listRaks as $lr)
                                    <option value="{{ $lr->id }}" {{ old('list_rak_id', $penomoranRak->list_rak_id) == $lr->id ? 'selected' : '' }}>{{ $lr->rak }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">No Rak <span class="text-danger">*</span></label>
                            <select name="list_no_rak_id" id="list_no_rak_id" required class="form-select">
                                <option value="">-- Pilih No Rak --</option>
                                @foreach($listNoRaks as $lnr)
                                    <option value="{{ $lnr->id }}" {{ old('list_no_rak_id', $penomoranRak->list_no_rak_id) == $lnr->id ? 'selected' : '' }}>{{ $lnr->norak }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('penomoran-raks.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Update Penomoran Rak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const codeItemEl = document.getElementById('list_code_item_id');
            const setEl     = document.getElementById('set_code_item_id');
            const cavEl     = document.getElementById('cav_code_item_id');
            const rakEl     = document.getElementById('list_rak_id');
            const noRakEl   = document.getElementById('list_no_rak_id');
            const baseUrl   = "{{ url('/') }}";

            // Saved values for pre-selection after cascade load
            const savedSetId = "{{ old('set_code_item_id', $penomoranRak->set_code_item_id) }}";
            const savedCavId = "{{ old('cav_code_item_id', $penomoranRak->cav_code_item_id) }}";

            let tsCodeItem = null, tsSet = null, tsCav = null, tsRak = null, tsNoRak = null;

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
                    tsSet = new TomSelect(setEl, { create: false, maxItems: 1, closeAfterSelect: true, placeholder: '-- Pilih Code Item Terlebih Dahulu --' });
                }
                if (cavEl && !cavEl.tomselect) {
                    tsCav = new TomSelect(cavEl, { create: false, maxItems: 1, closeAfterSelect: true, placeholder: '-- Pilih Code Item Terlebih Dahulu --' });
                }
                if (rakEl && !rakEl.tomselect) {
                    tsRak = new TomSelect(rakEl, { 
                        plugins: {
                            'dropdown_input': {},
                            'clear_button': { title: 'Hapus pilihan' }
                        },
                        allowEmptyOption: true,
                        create: false, 
                        maxItems: 1, 
                        closeAfterSelect: true, 
                        placeholder: '-- Pilih / Ketik Rak --',
                        render: {
                            no_results: function(data, escape) {
                                return '<div class="no-results p-2 text-xs text-gray-500 font-weight-bold">Rak yang anda cari tidak ada</div>';
                            }
                        }
                    });
                }
                if (noRakEl && !noRakEl.tomselect) {
                    tsNoRak = new TomSelect(noRakEl, { 
                        plugins: {
                            'dropdown_input': {},
                            'clear_button': { title: 'Hapus pilihan' }
                        },
                        allowEmptyOption: true,
                        create: false, 
                        maxItems: 1, 
                        closeAfterSelect: true, 
                        placeholder: '-- Pilih / Ketik No Rak --',
                        render: {
                            no_results: function(data, escape) {
                                return '<div class="no-results p-2 text-xs text-gray-500 font-weight-bold">No Rak yang anda cari tidak ada</div>';
                            }
                        }
                    });
                }
            }

            function updateSets(listId, preselectSetId) {
                if (!setEl) return;
                if (!listId) {
                    if (tsSet) { tsSet.clearOptions(); tsSet.clear(); }
                    else { setEl.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>'; }
                    return;
                }
                fetch(`${baseUrl}/api/code-item/sets?list_code_item_id=${listId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (tsSet) {
                            tsSet.clearOptions();
                            tsSet.clear();
                            data.forEach(item => tsSet.addOption({ value: item.id, text: item.moldset }));
                            tsSet.refreshOptions(false);
                            if (preselectSetId) {
                                tsSet.setValue(preselectSetId, true);
                            }
                        } else {
                            setEl.innerHTML = '<option value="">-- Pilih Mold Set --</option>';
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.id;
                                opt.textContent = item.moldset;
                                if (preselectSetId && item.id == preselectSetId) opt.selected = true;
                                setEl.appendChild(opt);
                            });
                        }
                    });
            }

            function updateCavs(listId, setId, preselectCavId) {
                if (!cavEl) return;
                if (!listId) {
                    if (tsCav) { tsCav.clearOptions(); tsCav.clear(); }
                    else { cavEl.innerHTML = '<option value="">-- Pilih Code Item Terlebih Dahulu --</option>'; }
                    return;
                }
                fetch(`${baseUrl}/api/code-item/cavs?list_code_item_id=${listId}&set_code_item_id=${setId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (tsCav) {
                            tsCav.clearOptions();
                            tsCav.clear();
                            data.forEach(item => tsCav.addOption({ value: item.id, text: item.moldcav }));
                            tsCav.refreshOptions(false);
                            if (preselectCavId) {
                                tsCav.setValue(preselectCavId, true);
                            }
                        } else {
                            cavEl.innerHTML = '<option value="">-- Pilih Mold Cavity --</option>';
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.id;
                                opt.textContent = item.moldcav;
                                if (preselectCavId && item.id == preselectCavId) opt.selected = true;
                                cavEl.appendChild(opt);
                            });
                        }
                    });
            }

            // On Code Item change (manual user action)
            if (codeItemEl) {
                codeItemEl.addEventListener('change', function () {
                    const listId = this.value;
                    updateSets(listId, '');
                    updateCavs(listId, '', '');
                });
            }

            // On Mold Set change (manual user action)
            if (setEl) {
                setEl.addEventListener('change', function () {
                    const listId = codeItemEl ? codeItemEl.value : '';
                    const setId  = this.value;
                    updateCavs(listId, setId, '');
                });
            }

            // On page load: cascade & pre-select existing values
            const initialCodeId = codeItemEl ? codeItemEl.value : '';
            if (initialCodeId) {
                // Load sets and pre-select saved, then load cavs and pre-select saved
                fetch(`${baseUrl}/api/code-item/sets?list_code_item_id=${initialCodeId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (tsSet) {
                            tsSet.clearOptions();
                            data.forEach(item => tsSet.addOption({ value: item.id, text: item.moldset }));
                            tsSet.refreshOptions(false);
                            if (savedSetId) tsSet.setValue(savedSetId, true);
                        } else {
                            setEl.innerHTML = '<option value="">-- Pilih Mold Set --</option>';
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.id;
                                opt.textContent = item.moldset;
                                if (savedSetId && item.id == savedSetId) opt.selected = true;
                                setEl.appendChild(opt);
                            });
                        }
                        // After sets loaded, load cavs
                        const currentSetId = savedSetId || (setEl ? setEl.value : '');
                        fetch(`${baseUrl}/api/code-item/cavs?list_code_item_id=${initialCodeId}&set_code_item_id=${currentSetId}`)
                            .then(res => res.json())
                            .then(cavData => {
                                if (tsCav) {
                                    tsCav.clearOptions();
                                    cavData.forEach(item => tsCav.addOption({ value: item.id, text: item.moldcav }));
                                    tsCav.refreshOptions(false);
                                    if (savedCavId) tsCav.setValue(savedCavId, true);
                                } else {
                                    cavEl.innerHTML = '<option value="">-- Pilih Mold Cavity --</option>';
                                    cavData.forEach(item => {
                                        const opt = document.createElement('option');
                                        opt.value = item.id;
                                        opt.textContent = item.moldcav;
                                        if (savedCavId && item.id == savedCavId) opt.selected = true;
                                        cavEl.appendChild(opt);
                                    });
                                }
                            });
                    });
            }
        });
    </script>
</x-app-layout>
