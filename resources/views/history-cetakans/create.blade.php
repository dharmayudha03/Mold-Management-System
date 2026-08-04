<x-app-layout>
    <x-slot name="header">
        Tambah History Cetakan
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('history-cetakans.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke History Cetakan
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-plus-circle text-primary mr-2"></i>Form Tambah History Cetakan</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Input History Data</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('history-cetakans.store') }}" method="POST">
                    @csrf

                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Tanggal History <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="form-control">
                        </div>
                    </div>

                    <div class="form-grid-3 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" id="list_code_item_id" required class="form-select">
                                <option value="">-- Pilih Code Item --</option>
                                @foreach($listCodeItems as $ci)
                                    <option value="{{ $ci->id }}" {{ old('list_code_item_id') == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" id="set_code_item_id" required class="form-select">
                                <option value="">-- Pilih Mold Set --</option>
                                @foreach($setCodeItems as $sc)
                                    <option value="{{ $sc->id }}" {{ old('set_code_item_id') == $sc->id ? 'selected' : '' }}>{{ $sc->moldset }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-item">
                            <label class="form-label">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" id="cav_code_item_id" required class="form-select">
                                <option value="">-- Pilih Mold Cavity --</option>
                                @foreach($cavCodeItems as $cc)
                                    <option value="{{ $cc->id }}" {{ old('cav_code_item_id') == $cc->id ? 'selected' : '' }}>{{ $cc->moldcav }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-1 mb-4">
                        <div class="form-group-item">
                            <label class="form-label">Deskripsi History <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" required rows="3" placeholder="Masukkan rincian riwayat perbaikan / aktivitas cetakan..." class="form-control">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('history-cetakans.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
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
                        placeholder: '-- Pilih / Ketik Code Item --',
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
