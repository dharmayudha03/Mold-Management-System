<x-app-layout>
    <x-slot name="header">
        Edit History Cetakan
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('history-cetakans.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke History Cetakan
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-edit text-primary mr-2"></i>Form Edit History Cetakan</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Update History Data</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('history-cetakans.update', $historyCetakan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">Tanggal History <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $historyCetakan->tanggal) }}" required 
                                class="form-control text-xs py-2" style="border-radius: 0.75rem;">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">Code Item <span class="text-danger">*</span></label>
                            <select name="list_code_item_id" required class="form-select text-xs py-2" style="border-radius: 0.75rem;">
                                @foreach($listCodeItems as $ci)
                                    <option value="{{ $ci->id }}" {{ old('list_code_item_id', $historyCetakan->list_code_item_id) == $ci->id ? 'selected' : '' }}>{{ $ci->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">Mold Set <span class="text-danger">*</span></label>
                            <select name="set_code_item_id" required class="form-select text-xs py-2" style="border-radius: 0.75rem;">
                                @foreach($setCodeItems as $sc)
                                    <option value="{{ $sc->id }}" {{ old('set_code_item_id', $historyCetakan->set_code_item_id) == $sc->id ? 'selected' : '' }}>{{ $sc->moldset }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">Mold Cavity <span class="text-danger">*</span></label>
                            <select name="cav_code_item_id" required class="form-select text-xs py-2" style="border-radius: 0.75rem;">
                                @foreach($cavCodeItems as $cc)
                                    <option value="{{ $cc->id }}" {{ old('cav_code_item_id', $historyCetakan->cav_code_item_id) == $cc->id ? 'selected' : '' }}>{{ $cc->moldcav }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">Deskripsi History <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" required rows="3" class="form-control text-xs py-2" style="border-radius: 0.75rem;">{{ old('deskripsi', $historyCetakan->deskripsi) }}</textarea>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('history-cetakans.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
