<x-layouts.app :title="'Edit Kategori'">
    @section('title', 'Edit Kategori')

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Kategori</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')

            {{-- Nama Kategori --}}
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                       class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200"
                       required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description"
                          class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200"
                          rows="4">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.categories.index') }}"
                   class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-sm rounded">Batal</a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
