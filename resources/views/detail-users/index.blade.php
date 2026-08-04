<x-app-layout>
    <x-slot name="header">
        Detail Users (Karyawan PIC)
    </x-slot>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <form method="GET" action="{{ route('detail-users.index') }}" class="flex items-center gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama Karyawan..." class="bg-slate-950 border border-slate-800 text-slate-200 text-sm rounded-xl px-4 py-2.5 w-64 md:w-80">
            <button type="submit" class="bg-slate-800 text-slate-200 text-sm px-4 py-2.5 rounded-xl font-medium">Cari</button>
        </form>

        <a href="{{ route('detail-users.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-lg">
            + Tambah Detail User
        </a>
    </div>

    <div class="bg-slate-950 border border-slate-800 rounded-2xl shadow-xl overflow-hidden max-w-3xl">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900 text-slate-400 font-semibold uppercase text-xs">
                <tr>
                    <th class="p-4">Group / Role</th>
                    <th class="p-4">Nama Karyawan</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse($detailUsers as $item)
                    <tr class="hover:bg-slate-900/40">
                        <td class="p-4 font-semibold text-indigo-400">{{ $item->role->name ?? '-' }}</td>
                        <td class="p-4 font-medium text-white">{{ $item->name }}</td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('detail-users.edit', $item->id) }}" class="px-3 py-1.5 bg-slate-800 text-xs text-indigo-400 rounded-lg">Edit</a>
                            <form action="{{ route('detail-users.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus karyawan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-rose-950/40 text-xs text-rose-400 rounded-lg border border-rose-800/40">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-8 text-center text-slate-500">Tidak ada data karyawan PIC.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-800">{{ $detailUsers->links() }}</div>
    </div>
</x-app-layout>
