<x-app-layout>
    @section('header', 'Absensi')

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Waktu Realtime -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 rounded-md p-3 bg-indigo-500">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Waktu Sekarang
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div id="current-time" class="text-2xl font-semibold text-gray-900">
                                            {{ now()->format('H:i:s') }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Absensi -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 rounded-md p-3 
                {{ $isOnLeave ? 'bg-yellow-500' : ($todayAbsensi && $todayAbsensi->check_in ? 'bg-green-500' : 'bg-gray-500') }}">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Status Hari Ini
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            @if ($isOnLeave)
                                                Izin/Cuti
                                            @elseif(!$todayAbsensi)
                                                Belum Absen
                                            @elseif($todayAbsensi && !$todayAbsensi->check_out)
                                                Sudah Check In
                                            @else
                                                Selesai
                                            @endif
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Absensi -->
            <div class="mt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <form action="{{ route('absensi.checkin') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                    {{ $isOnLeave || ($todayAbsensi && $todayAbsensi->check_in) ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $isOnLeave || ($todayAbsensi && $todayAbsensi->check_in) ? 'disabled' : '' }}>
                            Check In
                        </button>
                    </form>

                    <form action="{{ route('absensi.checkout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 
                    {{ $isOnLeave || !$todayAbsensi || !$todayAbsensi->check_in || $todayAbsensi->check_out ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $isOnLeave || !$todayAbsensi || !$todayAbsensi->check_in || $todayAbsensi->check_out ? 'disabled' : '' }}>
                            Check Out
                        </button>
                    </form>
                </div>
            </div>

            @if ($isOnLeave)
                <div class="mt-4">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Anda sedang dalam masa izin/cuti. Tidak dapat melakukan absensi.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Riwayat Absensi -->
            <div class="mt-8">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Riwayat Absensi</h3>
                <div class="mt-4 flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Check In
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Check Out
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($riwayatAbsensi ?? [] as $absen)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $absen->created_at->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $absen->check_in ? $absen->check_in->format('H:i:s') : '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $absen->check_out ? $absen->check_out->format('H:i:s') : '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $absen->check_out ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ $absen->check_out ? 'Selesai' : 'Belum Checkout' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function updateTime() {
                const timeDisplay = document.getElementById('current-time');

                function addLeadingZero(number) {
                    return number < 10 ? '0' + number : number;
                }

                function updateClock() {
                    const now = new Date();
                    const hours = addLeadingZero(now.getHours());
                    const minutes = addLeadingZero(now.getMinutes());
                    const seconds = addLeadingZero(now.getSeconds());

                    timeDisplay.textContent = `${hours}:${minutes}:${seconds}`;
                }

                // Update setiap detik
                updateClock();
                setInterval(updateClock, 1000);
            }

            // Jalankan saat halaman dimuat
            document.addEventListener('DOMContentLoaded', updateTime);
        </script>
    @endpush
</x-app-layout>
