<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <x-breadcrumb :items="[
                                                    ['name' => 'Daftar Konseling', 'url' => route('konseling-mahasiswa.index')],
                                                    ['name' => 'Detail Konseling']
                                                ]"/>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold leading-tight mb-6">
                        {{ __('Detail Konseling') }}
                    </h2>

                    @if(session('success'))
                        <div
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Status Badge -->
                    <div class="mb-6 flex items-center">
                        <span class="text-sm font-medium text-gray-500 mr-2">Status:</span>
                        <span class="px-3 py-1 text-sm leading-5 font-semibold rounded-full
                                                               {{ $konseling->status === 'finished' ? 'bg-green-100 text-green-800' :
                                                                  ($konseling->status === 'approved' ? 'bg-blue-100 text-blue-800' :
                                                                  ($konseling->status === 'canceled' ? 'bg-red-100 text-red-800' :
                                                                  'bg-yellow-100 text-yellow-800')) }}">
                                                               {{ ucfirst($konseling->status) }}
                                                           </span>
                    </div>

                    <!-- Detail Info -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
                        <div class="p-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="font-medium text-gray-700">Informasi Sesi</h3>
                        </div>
                        <div class="p-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Konseling</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->tanggal }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Waktu</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $konseling->sesi->name ?? '-' }} ({{ $konseling->sesi->start_time ?? '' }}
                                        - {{ $konseling->sesi->end_time ?? '' }})
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Konselor</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->konselor->name ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Topik Konseling</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->topik }}</dd>
                                </div>

                                @if($konseling->catatan_konselor)
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Catatan Konselor</dt>
                                        <dd class="mt-1 text-sm text-gray-900 bg-yellow-50 p-3 rounded-md border border-yellow-100">
                                            {{ $konseling->catatan_konselor }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                    
                    <!-- Reschedule History Section -->
                    @if(isset($rescheduleHistory) && $rescheduleHistory->isNotEmpty())
                        <div class="mt-6">
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-4 border-b border-gray-200 bg-gray-50">
                                    <h3 class="font-medium text-gray-700">Riwayat Perubahan Jadwal</h3>
                                </div>
                                <div class="p-4">
                                    <div class="flow-root">
                                        <ul class="-mb-8">
                                            @foreach($rescheduleHistory as $index => $reschedule)
                                                <li>
                                                    <div class="relative pb-8">
                                                        @if(!$loop->last)
                                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                                        @endif
                                                        <div class="relative flex space-x-3">
                                                            <div>
                                                                <span class="h-8 w-8 rounded-full flex items-center justify-center {{ $reschedule->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                    @if($reschedule->status === 'approved')
                                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                        </svg>
                                                                    @else
                                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                                <div>
                                                                    <p class="text-sm text-gray-500">
                                                                        Perubahan jadwal dari <span class="font-medium text-gray-900">{{ $reschedule->old_tanggal }}</span> 
                                                                        ({{ App\Models\Session::find($reschedule->old_sesi_id)->name ?? 'Unknown' }} -
                                                                        {{ App\Models\Session::find($reschedule->old_sesi_id)->start_time ?? '' }} sampai
                                                                        {{ App\Models\Session::find($reschedule->old_sesi_id)->end_time ?? '' }})
                                                                        menjadi <span class="font-medium text-gray-900">{{ $reschedule->new_tanggal }}</span>
                                                                        ({{ App\Models\Session::find($reschedule->new_sesi_id)->name ?? 'Unknown' }} -
                                                                        {{ App\Models\Session::find($reschedule->new_sesi_id)->start_time ?? '' }} sampai
                                                                        {{ App\Models\Session::find($reschedule->new_sesi_id)->end_time ?? '' }})
                                                                    </p>
                                                                    @if($reschedule->alasan)
                                                                        <p class="mt-1 text-sm text-gray-500">
                                                                            Alasan: {{ $reschedule->alasan }}
                                                                        </p>
                                                                    @endif
                                                                </div>
                                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                                    <time datetime="{{ $reschedule->created_at }}">{{ $reschedule->created_at->format('d M Y, H:i') }}</time>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Detail Mahasiswa -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6 mt-6">
                        <div class="p-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="font-medium text-gray-700">Informasi Mahasiswa</h3>
                        </div>
                        <div class="p-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama Mahasiswa</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->name ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">NIM</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->nim ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->email ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">WhatsApp</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->whatsapp_number ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->prodi ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Semester</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->semester ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tipe Mahasiswa</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->student_type ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <!-- Form Answers Section -->
                <div class="mt-8">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                            <div class="flex items-center">
                                <h3 class="font-medium text-gray-700">Form Pertanyaan</h3>
                            </div>
                
                            <div class="flex items-center">
                                <button type="button" id="toggleAnswers"
                                        class="flex items-center focus:outline-none">
                                    <svg id="chevronIcon" class="w-5 h-5 text-gray-500" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                
                        <div id="answersContent" class="p-4">
                            @if($answers->isEmpty())
                                <div class="text-center py-4 text-gray-500 italic">
                                    Tidak ada data form pertanyaan untuk sesi ini.
                                </div>
                            @else
                                <div class="text-xs text-[#66003a] bg-[#66003a]/10 rounded-md p-2 mb-4 flex items-center">
                                    <svg class="h-4 w-4 mr-1 text-[#66003a]" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    Form pertanyaan yang telah diisi saat pengajuan konseling
                                </div>
                
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($answers as $index => $answer)
                                        <div class="border-b border-gray-100 pb-4 md:border-b-0 md:pb-0">
                                            <dt class="flex items-center text-sm font-medium text-gray-700">
                                                <span class="inline-flex justify-center items-center min-w-6 h-6 px-2 bg-[#66003a]/10 text-[#66003a] rounded-full font-medium text-sm mr-2">
                                                    {{ $index + 1 }}
                                                </span>
                                                {{ $answer->question->pertanyaan }}
                                            </dt>
                                            <dd class="mt-2 text-sm text-gray-900 bg-gray-50 p-3 rounded border border-gray-200">
                                                {{ $answer->jawaban }}
                                            </dd>
                                        </div>
                                    @endforeach
                                </dl>
                            @endif
                        </div>
                    </div>
                </div>
                
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const toggleButton = document.getElementById('toggleAnswers');
                        const content = document.getElementById('answersContent');
                        const chevronIcon = document.getElementById('chevronIcon');
                
                        toggleButton.addEventListener('click', function () {
                            content.classList.toggle('hidden');
                
                            // Toggle chevron direction
                            if (content.classList.contains('hidden')) {
                                chevronIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
                            } else {
                                chevronIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>';
                            }
                        });
                    });
                </script>
                    <!-- Button section -->
                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('konseling-mahasiswa.index') }}">
                            <x-secondary-button>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('Kembali') }}
                            </x-secondary-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
