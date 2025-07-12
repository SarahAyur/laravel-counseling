<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('konseling-konselor.index') }}"
                           class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd"
                                      d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Daftar Konseling
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail Konseling</span>
                        </div>
                    </li>
                </ol>
            </nav>

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
                                    <dt class="text-sm font-medium text-gray-500">Mahasiswa</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->mahasiswa->name ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Topik Konseling</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $konseling->topik }}</dd>
                                </div>

                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Catatan Konselor</dt>
                                    <dd class="mt-1 text-sm text-gray-900 bg-yellow-50 p-3 rounded-md border border-yellow-100">
                                        {{ $konseling->catatan_konselor ?? '-' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                                        <!-- filepath: /D:/projectBackend/laravel-counseling/resources/views/konseling-mahasiswa/show.blade.php -->
                    <!-- Tempatkan setelah Detail Info dan sebelum Form Answers -->
                    
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

                    <!-- Form Answers Section -->
                    @if($answers->count() > 0)
                        <div class="mt-8">
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                <button type="button" id="toggleAnswers"
                                        class="w-full p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                                    <h3 class="font-medium text-gray-700">Jawaban Form Mahasiswa</h3>
                                    <svg id="chevronIcon" class="w-5 h-5 text-gray-500" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <div id="answersContent" class="p-4">
                                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @foreach($answers as $index => $answer)
                                            <div
                                                class="border-b border-gray-100 pb-4 md:border-b-0 md:pb-0">
                                                <dt class="flex items-center text-sm font-medium text-gray-700">
                                                <span
                                                    class="inline-flex justify-center items-center min-w-6 h-6 px-2 bg-[#66003a]/10 text-[#66003a] rounded-full font-medium text-sm mr-2">
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
                    @else
                        @if($konseling->status === 'approved' || $konseling->status === 'finished')
                            <div class="mt-8">
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                                        <h3 class="font-medium text-gray-700">Jawaban Form Mahasiswa</h3>
                                    </div>
                                    <div class="p-4">
                                        <div class="text-center py-4 text-gray-500 italic">
                                            Mahasiswa belum mengisi form pertanyaan untuk sesi ini.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Button section -->
                    <div class="mt-8">
                        <div class="grid grid-cols-1 sm:flex sm:justify-end sm:items-center gap-2 sm:gap-3">
                            @if($konseling->status === 'pending')
                                <form action="{{ route('konseling-konselor.status', $konseling) }}" method="POST"
                                      class="w-full sm:w-auto">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit"
                                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-100 border border-blue-200 rounded-md font-semibold text-xs text-blue-700 uppercase tracking-widest shadow-sm hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-[#66003a] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('konseling-konselor.status', $konseling) }}" method="POST"
                                      class="w-full sm:w-auto">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="canceled">
                                    <button type="submit"
                                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-red-100 border border-red-200 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest shadow-sm hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-[#66003a] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancel
                                    </button>
                                </form>
                            @endif

                            @if($konseling->status === 'approved')
                                <form action="{{ route('konseling-konselor.status', $konseling) }}" method="POST"
                                      class="w-full sm:w-auto">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="finished">
                                    <button type="submit"
                                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-green-100 border border-green-200 rounded-md font-semibold text-xs text-green-700 uppercase tracking-widest shadow-sm hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-[#66003a] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        Finish
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('konseling-konselor.toggle-chat', $konseling) }}" method="POST"
                                  class="w-full sm:w-auto">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                        class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-100 border border-blue-200 rounded-md font-semibold text-xs text-blue-700 uppercase tracking-widest shadow-sm hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-[#66003a] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    {{ $konseling->chat_enabled ? 'Disable Chat' : 'Enable Chat' }}
                                </button>
                            </form>

                            @if($konseling->status === 'approved' && $konseling->chat_enabled)
                                <a href="/chat/{{ $konseling->mahasiswa_id }}"
                                   class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-indigo-100 border border-indigo-200 rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest shadow-sm hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-[#66003a] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Chat dengan Mahasiswa
                                </a>
                            @endif

                            <a href="{{ route('konseling-konselor.index') }}" class="w-full sm:w-auto">
                                <x-secondary-button class="w-full justify-center sm:w-auto">
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
    </div>
</x-app-layout>
