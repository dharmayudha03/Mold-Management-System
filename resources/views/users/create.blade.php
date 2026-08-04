<x-app-layout>
    <x-slot name="header">
        Tambah User Baru
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-light border font-weight-bold px-3.5 py-2 text-gray-700 shadow-xs" style="border-radius: 0.75rem;">
                <i class="fas fa-arrow-left mr-1.5"></i> Kembali ke Kelola User & Password
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-user-plus text-primary mr-2"></i>Form Tambah User Baru</h6>
                <span class="badge bg-light text-gray-700 border px-3 py-1 font-weight-bold" style="border-radius: 50rem;">Akun Sistem</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Super Administrator" 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: admin@irc.co.id" 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" required placeholder="Minimal 8 karakter" 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem;">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-xs font-weight-extrabold text-gray-900 uppercase mb-2">Role / Hak Akses Sistem <span class="text-danger">*</span></label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}">
                                    <label class="form-check-label text-xs font-weight-bold text-gray-800" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-4 py-2" style="border-radius: 0.75rem;">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-4 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                            <i class="fas fa-save mr-1.5"></i> Simpan User Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
