<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <x-breadcrumb :items="[
                                                 ['name' => 'Daftar Konseling', 'url' => route('konseling-mahasiswa.index')],
                                                 ['name' => 'Ajukan Konseling']
                                             ]"/>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold leading-tight mb-6">
                        {{ __('Ajukan Konseling') }}
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

                    <form action="{{ route('konseling-mahasiswa.store') }}" method="POST" class="space-y-6">
                        @csrf
                    
                        <!-- Form basic fields section -->
                        <div x-data="{ step: 1 }">
                            <!-- Step 1: Basic Counseling Details -->
                            <div x-show="step === 1">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Langkah 1: Isi Detail Konseling</h3>
                                
                                <!-- Original form fields (konselor, tanggal, sesi, topik) -->
                                <div>
                                    <x-input-label for="konselor_id" :value="__('Pilih Konselor')"/>
                                    <x-select
                                        id="konselor_id"
                                        name="konselor_id"
                                        :options="$konselors->mapWithKeys(function($konselor) {
                                            return [$konselor->id => $konselor->name];
                                        })->prepend('Pilih Konselor', '')"
                                        :selected="old('konselor_id')"
                                        required
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('konselor_id')"/>
                                </div>
                    
                                <div class="mt-4">
                                    <x-input-label for="tanggal" :value="__('Tanggal Konseling')"/>
                                    <div class="relative">
                                        <x-text-input
                                            id="tanggal"
                                            name="tanggal"
                                            type="date"
                                            class="mt-1 block w-full cursor-pointer"
                                            :value="old('tanggal')"
                                            min="{{ date('Y-m-d') }}"
                                            required
                                            onclick="this.showPicker()"
                                        />
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('tanggal')"/>
                                </div>
                    
                                <div class="mt-4">
                                    <x-input-label for="sesi_id" :value="__('Pilih Waktu')"/>
                                    <x-select
                                        id="sesi_id"
                                        name="sesi_id"
                                        :options="[]"
                                        :selected="old('sesi_id')"
                                        required
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('sesi_id')"/>
                                </div>
                    
                                <div class="mt-4">
                                    <x-input-label for="topik" :value="__('Topik Konseling')"/>
                                    <x-text-input
                                        id="topik"
                                        name="topik"
                                        type="text"
                                        class="mt-1 block w-full"
                                        :value="old('topik')"
                                        required
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('topik')"/>
                                </div>
                    
                                <div class="flex justify-end mt-6">
                                    <x-primary-button type="button" @click="step = 2">
                                        Lanjutkan
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </x-primary-button>
                                </div>
                            </div>
                    
                            <!-- Step 2: Form Questions -->
                            <div x-show="step === 2" x-cloak>
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Langkah 2: Isi Form Pertanyaan</h3>
                                    <button type="button" @click="step = 1" class="text-sm text-gray-600 hover:text-gray-900">
                                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        Kembali
                                    </button>
                                </div>
                    
                                <!-- Questions from FormQuestion -->
                                @foreach ($questions as $index => $question)
                                    <div class="mb-6">
                                        <div class="flex items-center mb-1">
                                            <span class="inline-flex justify-center items-center min-w-6 h-6 px-2 bg-[#66003a]/10 text-[#66003a] rounded-full font-medium text-sm mr-2">
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
                                                    <!-- Checkbox implementation as in your form-answers.create -->
                                                @endif
                                            @endif
                                        @endif
                                        <x-input-error class="mt-2" :messages="$errors->get('answers.'.$question->id.'.jawaban')"/>
                                    </div>
                                @endforeach
                    
                                <!-- Terms and Conditions -->
                                <div x-data="{
                                    hasScrolledToBottom: false,
                                    checked: false,
                                    language: 'id',
                                    checkScrollPosition($el) {
                                        if ($el.scrollTop + $el.clientHeight >= $el.scrollHeight - 10) {
                                            this.hasScrolledToBottom = true;
                                        }
                                    }
                                }">
                                    <!-- Button to show the modal -->
                                    <div class="flex items-center">
                                        <input
                                            type="checkbox"
                                            id="option"
                                            name="option"
                                            value="1"
                                            x-model="checked"
                                            required
                                            x-on:click.prevent="$dispatch('open-modal', 'terms-modal')"
                                            class="rounded border-gray-300 text-[#66003a] shadow-sm focus:border-[#66003a] focus:ring focus:ring-[#66003a] focus:ring-opacity-50">
                                        <label for="option" class="ml-2 text-sm text-gray-600">
                                            {{ __('Saya menyetujui Syarat dan Ketentuan yang berlaku') }}
                                        </label>
                                    </div>

                                    <!-- Terms and Conditions Modal -->
                                    <x-modal name="terms-modal" :show="false" maxWidth="xl">
                                        <div class="p-6" x-data="{
                                        termsData: {{ Illuminate\Support\Js::from(json_decode(file_get_contents(public_path('locale/snk-form.json')), true)) }}
                                            }">
                                            <div class="flex justify-between items-center mb-4">
                                                <h2 class="text-lg font-medium text-gray-900">
                                                    <span x-show="language === 'id'" x-text="termsData.id.title"></span>
                                                    <span x-show="language === 'en'" x-cloak x-text="termsData.en.title"></span>
                                                </h2>
                                                <div class="flex items-center">
                                                    <button @click.prevent="language = 'id'"
                                                            :class="language === 'id' ? 'bg-[#66003a] text-white' : 'bg-gray-200 text-gray-700'"
                                                            class="px-3 py-1 text-xs rounded-l-md">ID
                                                    </button>
                                                    <button @click.prevent="language = 'en'"
                                                            :class="language === 'en' ? 'bg-[#66003a] text-white' : 'bg-gray-200 text-gray-700'"
                                                            class="px-3 py-1 text-xs rounded-r-md">EN
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Scrollable Terms and Conditions Content -->
                                            <div class="mt-4 p-4 max-h-60 overflow-y-auto border border-gray-200 rounded-md"
                                                x-on:scroll="checkScrollPosition($el)">
                                                <!-- Indonesian Content -->
                                                <div x-show="language === 'id'">
                                                    <p class="text-sm text-gray-600 mb-4 font-medium"
                                                    x-text="termsData.id.introduction.heading"></p>
                                                    <ol class="list-decimal pl-5 mb-4 text-sm text-gray-600 space-y-2">
                                                        <template x-for="(item, index) in termsData.id.introduction.services"
                                                                :key="index">
                                                            <li x-text="item"></li>
                                                        </template>
                                                    </ol>
                                                    <p class="text-sm text-gray-600 mb-6 italic"
                                                    x-text="termsData.id.introduction.closing"></p>

                                                    <h3 class="text-sm font-semibold text-gray-700 mb-3"
                                                        x-text="termsData.id.informedConsent.heading"></h3>
                                                    <p class="text-sm text-gray-600 mb-4"
                                                    x-text="termsData.id.informedConsent.introduction"></p>
                                                    <ol class="list-decimal pl-5 mb-4 text-sm text-gray-600 space-y-2">
                                                        <template x-for="(item, index) in termsData.id.informedConsent.points"
                                                                :key="index">
                                                            <li x-text="item"></li>
                                                        </template>
                                                    </ol>
                                                    <p class="text-sm text-gray-600 mb-4"
                                                    x-text="termsData.id.informedConsent.closing"></p>
                                                    <p class="text-sm text-gray-600 mb-4"
                                                    x-text="termsData.id.informedConsent.contact"></p>
                                                </div>

                                                <!-- English Content -->
                                                <div x-show="language === 'en'" x-cloak>
                                                    <p class="text-sm text-gray-600 mb-4 font-medium"
                                                    x-text="termsData.en.introduction.heading"></p>
                                                    <ol class="list-decimal pl-5 mb-4 text-sm text-gray-600 space-y-2">
                                                        <template x-for="(item, index) in termsData.en.introduction.services"
                                                                :key="index">
                                                            <li x-text="item"></li>
                                                        </template>
                                                    </ol>
                                                    <p class="text-sm text-gray-600 mb-6 italic"
                                                    x-text="termsData.en.introduction.closing"></p>

                                                    <h3 class="text-sm font-semibold text-gray-700 mb-3"
                                                        x-text="termsData.en.informedConsent.heading"></h3>
                                                    <p class="text-sm text-gray-600 mb-4"
                                                    x-text="termsData.en.informedConsent.introduction"></p>
                                                    <ol class="list-decimal pl-5 mb-4 text-sm text-gray-600 space-y-2">
                                                        <template x-for="(item, index) in termsData.en.informedConsent.points"
                                                                :key="index">
                                                            <li x-text="item"></li>
                                                        </template>
                                                    </ol>
                                                    <p class="text-sm text-gray-600 mb-4"
                                                    x-text="termsData.en.informedConsent.closing"></p>
                                                    <p class="text-sm text-gray-600 mb-4"
                                                    x-text="termsData.en.informedConsent.contact"></p>
                                                </div>
                                            </div>

                                            <div class="mt-5 flex items-center" :class="{'opacity-50': !hasScrolledToBottom}">
                                                <input
                                                    type="checkbox"
                                                    id="modal-option"
                                                    x-model="checked"
                                                    :disabled="!hasScrolledToBottom"
                                                    class="rounded border-gray-300 text-[#66003a] shadow-sm focus:border-[#66003a] focus:ring focus:ring-[#66003a] focus:ring-opacity-50">
                                                <label for="modal-option" class="ml-2 text-sm text-gray-600">
                                                    <span x-show="language === 'id'" x-text="termsData.id.checkbox"></span>
                                                    <span x-show="language === 'en'" x-cloak
                                                        x-text="termsData.en.checkbox"></span>
                                                </label>
                                            </div>

                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close-modal', 'terms-modal')">
                                                    <span x-show="language === 'id'" x-text="termsData.id.closeButton"></span>
                                                    <span x-show="language === 'en'" x-cloak
                                                        x-text="termsData.en.closeButton"></span>
                                                </x-secondary-button>
                                            </div>
                                        </div>
                                    </x-modal>                                
                                </div>
                    
                                <!-- Submit Button -->
                                <div class="flex items-center justify-end gap-4 mt-6">
                                    <a href="{{ route('konseling-mahasiswa.index') }}">
                                        <x-secondary-button>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                            </svg>
                                            {{ __('Batal') }}
                                        </x-secondary-button>
                                    </a>
                    
                                    <x-primary-button type="submit" x-bind:disabled="!checked">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                        </svg>
                                        {{ __('Simpan') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    @push('scripts')
                        <!-- Keep existing script for session slot fetch -->
                    @endpush
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const konselorSelect = document.getElementById('konselor_id');
                const dateInput = document.getElementById('tanggal');
                const sessionSelect = document.getElementById('sesi_id');

                // Function to fetch available slots
                function fetchAvailableSlots() {
                    const konselorId = konselorSelect.value;
                    const tanggal = dateInput.value;

                    // Clear session select if either field is empty
                    if (!konselorId || !tanggal) {
                        resetSessionSelect('Pilih konselor dan tanggal terlebih dahulu');
                        return;
                    }

                    // Show loading state
                    resetSessionSelect('Loading...', true);

                    // Make Ajax request
                    fetch(`/check-slots?konselor_id=${konselorId}&tanggal=${tanggal}`)
                        .then(response => response.json())
                        .then(data => {
                            // Log debug info
                            // console.log('Slot data from server:', data);
                            
                            // Reset session select
                            sessionSelect.innerHTML = '<option value="">Pilih Waktu</option>';
                    
                            if (data.length === 0) {
                                // No available slots
                                const option = document.createElement('option');
                                option.value = "";
                                option.textContent = "Tidak ada sesi tersedia";
                                option.disabled = true;
                                sessionSelect.appendChild(option);
                            } else {
                                // Add available slots
                                data.forEach(session => {
                                    const option = document.createElement('option');
                                    option.value = session.id;
                                    option.textContent = `${session.name} (${session.start_time} - ${session.end_time})`;
                                    // Add debug info as a data attribute
                                    if (session.debug) {
                                        option.dataset.debug = JSON.stringify(session.debug);
                                    }
                                    sessionSelect.appendChild(option);
                                });
                            }
                    })
                }

                function resetSessionSelect(message, disabled = true) {
                    sessionSelect.innerHTML = '';
                    const defaultOption = document.createElement('option');
                    defaultOption.value = "";
                    defaultOption.textContent = message || 'Pilih Waktu';
                    defaultOption.disabled = disabled;
                    defaultOption.selected = true;
                    sessionSelect.appendChild(defaultOption);
                }

                // Add event listeners
                konselorSelect.addEventListener('change', fetchAvailableSlots);
                dateInput.addEventListener('change', fetchAvailableSlots);

                // Check if both fields are pre-filled (e.g., on form validation error)
                if (konselorSelect.value && dateInput.value) {
                    fetchAvailableSlots();
                }
            });
        </script>
    @endpush
</x-app-layout>
