<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 mb-6">
                <div class="flex flex-col md:flex-row">
                    <!-- Image Column -->
                    <div class="w-full md:w-1/3 flex items-center justify-center p-6 bg-gray-50">
                        <img src="{{ asset('dashboard.png') }}" alt="Counseling Illustration"
                             class="max-w-full h-auto rounded">
                    </div>

                    <!-- Content Column -->
                    <div class="w-full md:w-2/3 p-6">
                        @if(auth()->user()->isKonselor())
                            <h3 class="text-xl font-semibold text-[#63003a] mb-2">Selamat
                                bertugas, {{ auth()->user()->name }}!</h3>
                            <p class="text-gray-600 mb-4">
                                Lihat pengajuan jadwal terbaru dari mahasiswa, atur ulang sesi jika diperlukan, dan
                                mulai sesi konseling Anda hari ini.
                                Berikan dampak positif bagi mahasiswa melalui bimbingan yang Anda berikan.
                            </p>
                            <p class="text-gray-600">
                                Jadilah bagian dari solusi mereka dengan mendengarkan, memahami, dan mendampingi setiap
                                langkah perjalanan mereka.
                            </p>
                        @endif

                        @if(auth()->user()->isMahasiswa())
                            <h3 class="text-xl font-semibold text-[#63003a] mb-2">Selamat
                                datang, {{ auth()->user()->name }}!</h3>
                            <p class="text-gray-600 mb-4">
                                Layanan konseling siap mendukung perjalanan akademik dan personal Anda. Jadwalkan sesi
                                konseling
                                dengan konselor pilihan Anda dan diskusikan hal-hal yang menjadi perhatian Anda.
                            </p>
                            <p class="text-gray-600">
                                Kami di sini untuk membantu Anda menghadapi tantangan, menemukan solusi, dan
                                mengembangkan
                                potensi diri Anda secara maksimal.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            @if(auth()->user()->isKonselor())
                <!-- Statistics Chart -->
                <div x-data="{ open: true }"
                     class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
                    <button @click="open = !open"
                            class="w-full p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-medium text-gray-700">Statistik Konseling</h3>
                        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-700">Filter Periode</h2>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <x-primary-button>
                                        <span id="chartPeriodText">Harian</span>
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </x-primary-button>
                                </x-slot>

                                <x-slot name="content">
                                    <button
                                        onclick="showChart('daily'); document.getElementById('chartPeriodText').innerText = 'Harian';"
                                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        Harian
                                    </button>
                                    <button
                                        onclick="showChart('weekly'); document.getElementById('chartPeriodText').innerText = 'Mingguan';"
                                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        Mingguan
                                    </button>
                                    <button
                                        onclick="showChart('monthly'); document.getElementById('chartPeriodText').innerText = 'Bulanan';"
                                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        Bulanan
                                    </button>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <div class="h-80">
                            <canvas id="statisticsChart"></canvas>
                        </div>
                    </div>
                </div>

                @push('scripts')
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const statistics = @json($statistics);
                        let currentChart = null;

                        function showChart(period) {
                            const ctx = document.getElementById('statisticsChart').getContext('2d');

                            if (currentChart) {
                                currentChart.destroy();
                            }

                            let labels, data;

                            switch (period) {
                                case 'daily':
                                    labels = statistics.daily.map(item => {
                                        return new Date(item.date).toLocaleDateString('id-ID', {
                                            weekday: 'short',
                                            day: 'numeric',
                                            month: 'short'
                                        });
                                    });
                                    data = statistics.daily.map(item => item.count);
                                    break;
                                case 'weekly':
                                    labels = statistics.weekly.map((item, index) => `Minggu ${index + 1}`);
                                    data = statistics.weekly.map(item => item.count);
                                    break;
                                case 'monthly':
                                    labels = statistics.monthly.map(item => {
                                        const [year, month] = item.month.split('-');
                                        return new Date(year, month - 1).toLocaleDateString('id-ID', {
                                            month: 'long',
                                            year: 'numeric'
                                        });
                                    });
                                    data = statistics.monthly.map(item => item.count);
                                    break;
                            }

                            currentChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Jumlah Konseling',
                                        data: data,
                                        backgroundColor: 'rgba(102, 0, 58, 0.5)',
                                        borderColor: 'rgb(102, 0, 58)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 1
                                            }
                                        }
                                    }
                                }
                            });
                        }

                        // Show daily chart by default
                        showChart('daily');
                    </script>
                @endpush

                <!-- Add after Today's Approved Sessions section -->
                <!-- Upcoming Sessions -->
                <div x-data="{ open: true }"
                     class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
                    <button @click="open = !open"
                            class="w-full p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-medium text-gray-700">Jadwal Konseling Mendatang</h3>
                        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="p-6">
                        @if($upcomingSessions->count() > 0)
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($upcomingSessions as $session)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Mahasiswa</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->mahasiswa->name }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($session->tanggal)->format('d F Y') }}
                                                    ({{ \Carbon\Carbon::parse($session->tanggal)->diffForHumans() }})
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Sesi</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->sesi->name }}
                                                    ({{ $session->sesi->start_time }} - {{ $session->sesi->end_time }})
                                                </dd>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">Topik Konseling</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->topik }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada jadwal konseling mendatang</p>
                        @endif
                    </div>
                </div>

                <!-- Today's Approved Sessions -->
                <div x-data="{ open: true }"
                     class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
                    <button @click="open = !open"
                            class="w-full p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-medium text-gray-700">Jadwal Konseling Hari Ini</h3>
                        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="p-6">
                        @if($todaySessions->count() > 0)
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($todaySessions as $session)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Mahasiswa</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->mahasiswa->name }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Sesi</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->sesi->name }}
                                                    ({{ $session->sesi->start_time }} - {{ $session->sesi->end_time }})
                                                </dd>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">Topik Konseling</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->topik }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada jadwal konseling hari ini</p>
                        @endif
                    </div>
                </div>

                <!-- Pending Sessions -->
                <div x-data="{ open: true }"
                     class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
                    <button @click="open = !open"
                            class="w-full p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-medium text-gray-700">Pengajuan Konseling Pending</h3>
                        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="p-6">
                        @if($pendingSessions->count() > 0)
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($pendingSessions as $session)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Mahasiswa</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->mahasiswa->name }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($session->tanggal)->format('d F Y') }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Sesi</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->sesi->name }}</dd>
                                                ({{ $session->sesi->start_time }} - {{ $session->sesi->end_time }})

                                            </div>
                                            <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">Topik Konseling</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->topik }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada pengajuan konseling yang pending</p>
                        @endif
                    </div>
                </div>

                <!-- Rescheduled Sessions -->
                <div x-data="{ open: true }"
                     class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
                    <button @click="open = !open"
                            class="w-full p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-medium text-gray-700">Konseling Di-reschedule</h3>
                        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="p-6">
                        @if($rescheduledSessions->count() > 0)
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($rescheduledSessions as $session)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Mahasiswa</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->mahasiswa->name }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($session->tanggal)->format('d F Y') }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Sesi</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->sesi->name }}</dd>
                                                ({{ $session->sesi->start_time }} - {{ $session->sesi->end_time }})
                                            </div>
                                            <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">Topik Konseling</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->topik }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada konseling yang di-reschedule</p>
                        @endif
                    </div>
                </div>

                <!-- Feedback List -->
                <div x-data="{ open: true }"
                     class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = !open"
                            class="w-full p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-medium text-gray-700">Feedback Mahasiswa</h3>
                        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="p-6">
                        @if($feedbacks->count() > 0)
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($feedbacks as $feedback)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Mahasiswa</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $feedback->mahasiswa->name }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($feedback->session->tanggal)->format('d F Y') }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Rating</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $feedback->rating }}/5</dd>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">Komentar</dt>
                                                <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-md border border-gray-200">{{ $feedback->komentar }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada feedback dari mahasiswa</p>
                        @endif
                    </div>
                </div>
            @endif

            @if(auth()->user()->isMahasiswa())
                <!-- Upcoming Sessions -->
                <div x-data="{ open: true }"
                     class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
                    <button @click="open = !open"
                            class="w-full p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-medium text-gray-700">Jadwal Konseling Mendatang</h3>
                        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="p-6">
                        @if($upcomingSessions->count() > 0)
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($upcomingSessions as $session)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Konselor</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->konselor->name }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($session->tanggal)->format('d F Y') }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Sesi</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->sesi->name }}
                                                    ({{ $session->sesi->start_time }} - {{ $session->sesi->end_time }})
                                                </dd>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">Topik Konseling</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->topik }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada jadwal konseling mendatang</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Updates -->
                <div x-data="{ open: true }"
                     class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
                    <button @click="open = !open"
                            class="w-full p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-medium text-gray-700">Update Terbaru Konseling</h3>
                        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="p-6">
                        @if($recentUpdates->count() > 0)
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($recentUpdates as $session)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Konselor</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->konselor->name }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($session->tanggal)->format('d F Y') }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                                <dd class="mt-1 text-sm">
                                                    <span class="px-2 py-1 rounded text-sm
                                                    @if($session->status === 'approved') bg-green-100 text-green-800
                                                    @elseif($session->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($session->status === 'reschedule') bg-blue-100 text-blue-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($session->status) }}
                                                    </span>
                                                </dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Diperbarui</dt>
                                                <dd class="mt-1 text-sm text-gray-500">{{ $session->updated_at->diffForHumans() }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Tidak ada update terbaru</p>
                        @endif
                    </div>
                </div>

                <!-- Konselor Notes -->
                <div x-data="{ open: true }"
                     class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <button @click="open = !open"
                            class="w-full p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-medium text-gray-700">Catatan Konselor</h3>
                        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="open" class="p-6">
                        @if($sessionNotes->count() > 0)
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($sessionNotes as $session)
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-2 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Konselor</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $session->konselor->name }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($session->tanggal)->format('d F Y') }}</dd>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <dt class="text-sm font-medium text-gray-500">Catatan Konselor</dt>
                                                <dd class="mt-1 text-sm text-gray-900 bg-yellow-50 p-3 rounded-md border border-yellow-100">
                                                    {{ $session->catatan_konselor }}
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada catatan dari konselor</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
