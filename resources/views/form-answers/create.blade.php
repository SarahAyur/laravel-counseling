<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <x-breadcrumb :items="[
                                                ['name' => 'Daftar Konseling', 'url' => route('konseling-mahasiswa.index')],
                                                ['name' => 'Form Pertanyaan', 'url' => '#']
                                            ]"/>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold leading-tight mb-6">
                        {{ __('Form Pertanyaan') }}
                    </h2>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('form-answers.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="sesi_id" value="{{ $session->id }}">

                        @foreach ($questions as $index => $question)
                            <div class="mb-6">
                                <div class="flex items-center mb-1">
                                                                    <span
                                                                        class="inline-flex justify-center items-center min-w-6 h-6 px-2 bg-[#66003a]/10 text-[#66003a] rounded-full font-medium text-sm mr-2">
                                                                        {{ $index + 1 }}
                                                                    </span>
                                    <x-input-label for="question-{{ $question->id }}" :value="$question->pertanyaan"/>
                                </div>

                                @if ($question->tipe === 'text')
                                    <x-text-input
                                        id="question-{{ $question->id }}"
                                        name="answers[{{ $question->id }}][jawaban]"
                                        type="text"
                                        class="mt-1 block w-full"
                                        placeholder="Masukkan jawaban Anda"
                                        required
                                    />

                                @elseif ($question->tipe === 'textarea')
                                    <x-textarea
                                        id="question-{{ $question->id }}"
                                        name="answers[{{ $question->id }}][jawaban]"
                                        rows="4"
                                        placeholder="Masukkan jawaban Anda"
                                        required
                                    ></x-textarea>

                                @elseif (in_array($question->tipe, ['select', 'radio', 'checkbox']))
                                    @if ($question->opsi)
                                        @php
                                            $options = explode(',', $question->opsi);
                                            $formattedOptions = [];
                                            foreach ($options as $option) {
                                                $formattedOptions[trim($option)] = trim($option);
                                            }
                                        @endphp

                                        @if ($question->tipe === 'select')
                                            <x-select
                                                id="question-{{ $question->id }}"
                                                name="answers[{{ $question->id }}][jawaban]"
                                                :options="$formattedOptions"
                                                placeholder="Pilih salah satu"
                                                required
                                            />
                                        @elseif ($question->tipe === 'radio')
                                            <div class="mt-2 space-y-2">
                                                @foreach ($options as $option)
                                                    <div class="flex items-center">
                                                        <input
                                                            type="radio"
                                                            id="option-{{ $question->id }}-{{ $loop->index }}"
                                                            name="answers[{{ $question->id }}][jawaban]"
                                                            value="{{ trim($option) }}"
                                                            class="rounded-full border-gray-300 text-[#66003a] shadow-sm focus:border-[#66003a] focus:ring focus:ring-[#66003a] focus:ring-opacity-50"
                                                            required
                                                        >
                                                        <label for="option-{{ $question->id }}-{{ $loop->index }}"
                                                               class="ml-2 text-sm text-gray-600">
                                                            {{ trim($option) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif ($question->tipe === 'checkbox')
                                            <div class="mt-2 space-y-2">
                                                <div class="mb-2 text-xs text-gray-500">Pilih satu atau lebih opsi</div>
                                                @foreach ($options as $option)
                                                    <div class="flex items-center">
                                                        <input
                                                            type="checkbox"
                                                            id="option-{{ $question->id }}-{{ $loop->index }}"
                                                            name="answers[{{ $question->id }}][jawaban_array][]"
                                                            value="{{ trim($option) }}"
                                                            class="rounded border-gray-300 text-[#66003a] shadow-sm focus:border-[#66003a] focus:ring focus:ring-[#66003a] focus:ring-opacity-50"
                                                        >
                                                        <label for="option-{{ $question->id }}-{{ $loop->index }}"
                                                               class="ml-2 text-sm text-gray-600">
                                                            {{ trim($option) }}
                                                        </label>
                                                    </div>
                                                @endforeach

                                                <input type="hidden" name="answers[{{ $question->id }}][jawaban]"
                                                       id="hidden-answers-{{ $question->id }}">
                                            </div>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    // Get all checkboxes for this question
                                                    const checkboxes = document.querySelectorAll('input[name="answers[{{ $question->id }}][jawaban_array][]"]');
                                                    const hiddenField = document.getElementById('hidden-answers-{{ $question->id }}');

                                                    // Function to update the hidden field with selected values
                                                    function updateHiddenField() {
                                                        const selectedValues = Array.from(checkboxes)
                                                            .filter(cb => cb.checked)
                                                            .map(cb => cb.value);

                                                        hiddenField.value = selectedValues.join(', ');
                                                    }

                                                    // Add change event listener to all checkboxes
                                                    checkboxes.forEach(function (checkbox) {
                                                        checkbox.addEventListener('change', updateHiddenField);
                                                    });

                                                    // Initialize the hidden field
                                                    updateHiddenField();
                                                });
                                            </script>
                                        @endif
                                    @else
                                        <p class="mt-1 text-sm text-red-600">Opsi tidak tersedia untuk pertanyaan
                                            ini.</p>
                                    @endif
                                @endif
                                <x-input-error class="mt-2"
                                               :messages="$errors->get('answers.'.$question->id.'.jawaban')"/>
                            </div>
                        @endforeach

                        <div class="flex items-center justify-end gap-4">
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

                            <x-primary-button>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                {{ __('Simpan Jawaban') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
