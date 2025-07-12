<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Daftar Pertanyaan') }}
                        </h2>
                        <a href="{{ route('form-questions.create') }}">
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('Tambah') }}
                            </x-primary-button>
                        </a>
                    </div>

                    @if(session('success'))
                        <div
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Mobile View -->
                    <div class="mb-4 md:hidden">
                        @foreach($questions as $question)
                            <div class="bg-white rounded-lg shadow mb-4 overflow-hidden">
                                <div class="p-4 border-b">
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="flex items-center">
                                            <!-- Rearranged buttons -->
                                            <div class="flex items-center space-x-2">
                                                <button type="button" onclick="moveQuestion({{ $question->id }}, 'up')"
                                                        class="w-6 h-6 rounded-full inline-flex items-center justify-center bg-[#66003a] hover:bg-[#4d002b] focus:bg-[#4d002b] active:bg-[#330025] focus:ring-[#66003a] focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 {{ $question->urutan == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ $question->urutan == 1 ? 'disabled' : '' }}>
                                                    <svg class="w-4 h-4" fill="none" stroke="white"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    </svg>
                                                </button>
                                                <span class="font-medium">{{ $question->urutan }}</span>
                                                <button type="button"
                                                        onclick="moveQuestion({{ $question->id }}, 'down')"
                                                        class="w-6 h-6 rounded-full inline-flex items-center justify-center bg-[#66003a] hover:bg-[#4d002b] focus:bg-[#4d002b] active:bg-[#330025] focus:ring-[#66003a] focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 {{ $question->urutan == count($questions) ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ $question->urutan == count($questions) ? 'disabled' : '' }}>
                                                    <svg class="w-4 h-4" fill="none" stroke="white"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <span class="ml-3 font-medium">{{ $question->pertanyaan }}</span>
                                        </div>
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $question->tipe }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <p class="line-clamp-2">{{ $question->pertanyaan }}</p>
                                    </div>
                                </div>
                                <div class="bg-gray-50 p-3 flex flex-wrap gap-2">
                                    <a href="{{ route('form-questions.edit', $question) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('form-questions.destroy', $question) }}" method="POST"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-md transition duration-150 ease-in-out"
                                                onclick="return confirm('Yakin ingin menghapus?')">
                                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            {{ __('Hapus') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop View -->
                    <div class="overflow-x-auto rounded-lg shadow hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <!-- Table headers... -->
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($questions as $question)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- Rearranged buttons in horizontal layout with smaller size -->
                                            <button type="button" onclick="moveQuestion({{ $question->id }}, 'up')"
                                                    class="w-6 h-6 rounded-full inline-flex items-center justify-center bg-[#66003a] hover:bg-[#4d002b] focus:bg-[#4d002b] active:bg-[#330025] focus:ring-[#66003a] focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 {{ $question->urutan == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $question->urutan == 1 ? 'disabled' : '' }}>
                                                <svg class="w-4 h-4" fill="none" stroke="white"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                </svg>
                                            </button>
                                            <span class="font-medium">{{ $question->urutan }}</span>
                                            <button type="button" onclick="moveQuestion({{ $question->id }}, 'down')"
                                                    class="w-6 h-6 rounded-full inline-flex items-center justify-center bg-[#66003a] hover:bg-[#4d002b] focus:bg-[#4d002b] active:bg-[#330025] focus:ring-[#66003a] focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 {{ $question->urutan == count($questions) ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $question->urutan == count($questions) ? 'disabled' : '' }}>
                                                <svg class="w-4 h-4" fill="none" stroke="white"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900 max-w-xs">
                                        <div class="line-clamp-2" title="{{ $question->pertanyaan }}">
                                            {{ $question->pertanyaan }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $question->tipe }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm max-w-xs">
                                        @if($question->opsi)
                                            <div class="flex flex-wrap gap-1 overflow-hidden">
                                                @foreach(explode(',', $question->opsi) as $index => $opsi)
                                                    @php
                                                        $colors = [
                                                            'bg-red-100 text-red-800',
                                                            'bg-green-100 text-green-800',
                                                            'bg-blue-100 text-blue-800',
                                                            'bg-yellow-100 text-yellow-800',
                                                            'bg-indigo-100 text-indigo-800',
                                                            'bg-orange-100 text-orange-800',
                                                            'bg-purple-100 text-purple-800'
                                                        ];
                                                        $colorClass = $colors[$index % count($colors)];
                                                    @endphp
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }} whitespace-nowrap overflow-hidden text-ellipsis max-w-[150px]"
                                                        title="{{ trim($opsi) }}">
                                                        {{ trim($opsi) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <x-dropdown-action>
                                            <a href="{{ route('form-questions.edit', $question) }}"
                                               class="inline-flex w-full items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>

                                            <form action="{{ route('form-questions.destroy', $question) }}"
                                                  method="POST" class="block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex w-full items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-md transition duration-150 ease-in-out"
                                                        onclick="return confirm('Yakin ingin menghapus?')">
                                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                         fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    {{ __('Hapus') }}
                                                </button>
                                            </form>
                                        </x-dropdown-action>
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

    <!-- Toast notifications -->
    <div id="loading-toast"
         class="fixed bottom-4 right-4 bg-[#66003a] text-white px-4 py-2 rounded shadow-lg hidden z-50">
        Menyimpan perubahan urutan...
    </div>
    <div id="success-toast"
         class="fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow-lg hidden z-50">
        Urutan berhasil diperbarui!
    </div>

    <script>
        function moveQuestion(id, direction) {
            const loadingToast = document.getElementById('loading-toast');
            if (loadingToast) loadingToast.classList.remove('hidden');

            // Ambil semua ID pertanyaan dalam urutan saat ini
            const questions = @json($questions->pluck('id'));
            const currentIndex = questions.indexOf(id);

            if (direction === 'up' && currentIndex > 0) {
                // Tukar dengan pertanyaan di atasnya
                [questions[currentIndex], questions[currentIndex - 1]] = [questions[currentIndex - 1], questions[currentIndex]];
            } else if (direction === 'down' && currentIndex < questions.length - 1) {
                // Tukar dengan pertanyaan di bawahnya
                [questions[currentIndex], questions[currentIndex + 1]] = [questions[currentIndex + 1], questions[currentIndex]];
            }

            // Kirim urutan baru ke server
            fetch('{{ route('form-questions.update-order') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    questions: questions
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const successToast = document.getElementById('success-toast');
                        if (successToast) {
                            successToast.classList.remove('hidden');
                            setTimeout(() => {
                                successToast.classList.add('hidden');
                            }, 2000);
                        }

                        // Refresh halaman untuk menampilkan urutan baru
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui urutan.');
                })
                .finally(() => {
                    if (loadingToast) loadingToast.classList.add('hidden');
                });
        }
    </script>
</x-app-layout>
