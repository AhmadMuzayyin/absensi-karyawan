<x-app-layout>
    @section('header', 'Tambah Shift Baru')

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <form action="{{ route('shifts.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Shift</label>
                                <input type="text" name="nama" id="nama" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Contoh: Shift Pagi">
                            </div>

                            <div>
                                <label for="jam_masuk" class="block text-sm font-medium text-gray-700">Jam Masuk</label>
                                <input type="time" name="jam_masuk" id="jam_masuk" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="jam_keluar" class="block text-sm font-medium text-gray-700">Jam
                                    Keluar</label>
                                <input type="time" name="jam_keluar" id="jam_keluar" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('shifts.index') }}"
                                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-300">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
