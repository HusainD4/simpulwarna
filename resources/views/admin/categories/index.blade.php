<x-layouts.app :title="'Daftar Kategori'">
    @section('title', 'Daftar Kategori')

    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kategori Produk</h1>
            <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-black text-sm rounded">
                + Tambah Kategori
            </a>
        </div>

        @if(session('successMessage'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('successMessage') }}
            </div>
        @endif

        @if(session('errorMessage'))
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                {{ session('errorMessage') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">#</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Deskripsi</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Status Sinkron</th>
                        <th class="px-4 py-2 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($categories as $index => $category)
                        <tr>
                            <td class="px-4 py-2 text-gray-700">{{ $categories->firstItem() + $index }}</td>
                            <td class="px-4 py-2 text-gray-800 font-medium">{{ $category->name }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $category->description ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if ($category->hub_category_id)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Tersinkron</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Belum Sinkron</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center space-x-1 whitespace-nowrap">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-black text-xs rounded">
                                    Edit
                                </a>

                                {{-- Tombol Sinkron / Hapus Sinkron --}}
                                <form action="{{ route('admin.categories.sync', $category->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('{{ $category->hub_category_id ? 'Hapus sinkronisasi kategori ini?' : 'Sinkronisasi kategori ini?' }}')">
                                    @csrf
                                    <button type="submit"
                                            class="px-3 py-1 {{ $category->hub_category_id ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white text-xs rounded">
                                        {{ $category->hub_category_id ? 'Hapus Sinkronisasi' : 'Sinkronkan' }}
                                    </button>
                                </form>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-black text-xs rounded">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">Tidak ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-layouts.app>
