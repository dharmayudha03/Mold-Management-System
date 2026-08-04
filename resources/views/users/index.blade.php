<x-app-layout>
    <x-slot name="header">
        Kelola User & Password / Detail User PIC
    </x-slot>

    <!-- Filter & Top Action Bar -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-body p-3.5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <form method="GET" action="{{ route('users.index') }}" class="d-flex align-items-center gap-2">
                    <div class="position-relative" style="width: 280px;">
                        <i class="fas fa-search position-absolute text-gray-400" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama / Email User / PIC..." 
                            class="form-control text-xs py-2" style="border-radius: 0.75rem; padding-left: 32px !important;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2" style="border-radius: 0.75rem; background-color: #2563eb; border: none;">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if($search)
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-2" style="border-radius: 0.75rem;">Reset</a>
                    @endif
                </form>

                <div class="d-flex items-center gap-2 shrink-0">
                    <a href="{{ route('detail-users.create') }}" class="btn btn-sm font-weight-bold px-3.5 py-2 text-white" style="background-color: #4f46e5; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-id-card mr-1.5"></i> Tambah PIC Detail User
                    </a>
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary font-weight-bold px-3.5 py-2 text-white" style="background-color: #2563eb; border: none; border-radius: 0.75rem;">
                        <i class="fas fa-user-plus mr-1.5"></i> Tambah User Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 1: Table Pengguna Sistem & Password -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-users-cog text-gray-700 mr-2"></i>Daftar Pengguna Sistem & Password</h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: {{ $users->total() }} User</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-xs">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Lengkap</th>
                            <th>Email Address</th>
                            <th>Role / Hak Akses</th>
                            <th>Password</th>
                            <th class="text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $item)
                            <tr>
                                <td class="font-weight-bold text-gray-500">{{ $users->firstItem() + $index }}</td>
                                <td class="font-weight-extrabold text-gray-900 text-sm">
                                    {{ $item->name }}
                                    @if(Auth::id() == $item->id)
                                        <span class="badge bg-secondary text-white font-weight-bold ml-1.5 px-2 py-0.5" style="border-radius: 50rem;">(Anda)</span>
                                    @endif
                                </td>
                                <td class="font-weight-semibold text-gray-700">{{ $item->email }}</td>
                                <td>
                                    @forelse($item->roles as $r)
                                        <span class="badge bg-light text-gray-800 border px-2.5 py-1 font-weight-bold" style="border-radius: 0.5rem;">
                                            {{ $r->name }}
                                        </span>
                                    @empty
                                        <span class="badge bg-light text-gray-600 border px-2.5 py-1 font-weight-bold">Viewer</span>
                                    @endforelse
                                </td>
                                <td>
                                    <div class="d-inline-flex align-items-center gap-1.5 bg-light border px-2.5 py-1" style="border-radius: 0.5rem;">
                                        <span class="font-mono font-weight-bold text-gray-800 text-xs" id="pwd-text-{{ $item->id }}">••••••••</span>
                                        <button type="button" class="btn btn-xs text-gray-500 hover:text-gray-900 p-0 ml-1 border-0 bg-transparent" 
                                            onclick="
                                                const el = document.getElementById('pwd-text-{{ $item->id }}');
                                                const icon = this.querySelector('i');
                                                if (el.textContent === '••••••••') {
                                                    el.textContent = '{{ explode('@', $item->email)[0] }}123';
                                                    icon.className = 'fas fa-eye-slash text-xs text-primary';
                                                } else {
                                                    el.textContent = '••••••••';
                                                    icon.className = 'fas fa-eye text-xs text-gray-400';
                                                }
                                            ">
                                            <i class="fas fa-eye text-xs text-gray-400"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-right pr-4">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-xs btn-light text-gray-600 border shadow-xs p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 28px; height: 28px; border-radius: 0.5rem;">
                                            <i class="fas fa-ellipsis-v text-xs"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="border-radius: 0.75rem; font-size: 0.8rem;">
                                            <li>
                                                <a href="{{ route('users.edit', $item->id) }}" class="dropdown-item py-1.5 px-3 text-gray-700 font-weight-bold">
                                                    <i class="fas fa-edit text-primary mr-2"></i> Edit
                                                </a>
                                            </li>
                                            @if(Auth::id() != $item->id)
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li>
                                                    <form action="{{ route('users.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item py-1.5 px-3 text-danger font-weight-bold">
                                                            <i class="fas fa-trash-alt text-danger mr-2"></i> Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-gray-500 py-4 font-weight-bold">Tidak ada data user.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top bg-white">{{ $users->links() }}</div>
        </div>
    </div>

    <!-- Section 2: Table Detail User (PIC Petugas Form Operasional) -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-extrabold text-gray-900"><i class="fas fa-id-card text-gray-700 mr-2"></i>Daftar Detail User (PIC Petugas Form Operasional)</h6>
            <span class="badge bg-light text-gray-700 border px-3 py-1.5 font-weight-bold" style="border-radius: 50rem;">Total: {{ $detailUsers->total() }} PIC</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-xs">
                    <thead class="bg-light text-gray-900 font-weight-extrabold border-bottom">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama PIC Petugas</th>
                            <th>Role Tugas / Jabatan</th>
                            <th>Form Terkait</th>
                            <th class="text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($detailUsers as $index => $item)
                            <tr>
                                <td class="font-weight-bold text-gray-500">{{ $detailUsers->firstItem() + $index }}</td>
                                <td class="font-weight-extrabold text-gray-900 text-sm">{{ $item->name }}</td>
                                <td>
                                    <span class="badge bg-light text-gray-800 border px-2.5 py-1 font-weight-bold" style="border-radius: 0.5rem;">
                                        {{ $item->role->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="font-weight-bold text-gray-700">
                                    Form Setup, Repair, Sandblasting, MJO
                                </td>
                                <td class="text-right pr-4">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-xs btn-light text-gray-600 border shadow-xs p-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 28px; height: 28px; border-radius: 0.5rem;">
                                            <i class="fas fa-ellipsis-v text-xs"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-1" style="border-radius: 0.75rem; font-size: 0.8rem;">
                                            <li>
                                                <a href="{{ route('detail-users.edit', $item->id) }}" class="dropdown-item py-1.5 px-3 text-gray-700 font-weight-bold">
                                                    <i class="fas fa-edit text-primary mr-2"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider my-1"></li>
                                            <li>
                                                <form action="{{ route('detail-users.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus detail user PIC ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-1.5 px-3 text-danger font-weight-bold">
                                                        <i class="fas fa-trash-alt text-danger mr-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-gray-500 py-4 font-weight-bold">Tidak ada data detail user.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top bg-white">{{ $detailUsers->links() }}</div>
        </div>
    </div>
</x-app-layout>
