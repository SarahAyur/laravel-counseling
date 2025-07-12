<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <x-breadcrumb :items="[
                            ['name' => 'Daftar Pertanyaan', 'url' => route('form-questions.index')],
                            ['name' => 'Tambah Pertanyaan']
                        ]"/>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold leading-tight mb-6">
                        {{ __('Tambah Pertanyaan') }}
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

                    <form action="{{ route('form-questions.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="pertanyaan" :value="__('Pertanyaan')"/>
                            <x-text-input
                                id="pertanyaan"
                                name="pertanyaan"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('pertanyaan')"
                                required
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('pertanyaan')"/>
                        </div>

                        <div>
                            <x-input-label for="tipe" :value="__('Tipe')"/>
                            <x-select
                                id="tipe"
                                name="tipe"
                                :options="[
                                                        'text' => 'Text',
                                                        'textarea' => 'Textarea',
                                                        'select' => 'Select',
                                                        'radio' => 'Radio',
                                                        'checkbox' => 'Checkbox'
                                                    ]"
                                :selected="old('tipe')"
                                required
                                onchange="toggleOpsiField()"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('tipe')"/>
                        </div>

                        <div id="opsiField">
                            <x-input-label for="opsi" :value="__('Opsi (pisahkan dengan koma)')"/>
                            <textarea
                                id="opsi"
                                name="opsi"
                                rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-[#66003a] focus:ring-[#66003a] rounded-md shadow-sm"
                                oninput="updateOpsiPreview()"
                            >{{ old('opsi') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('opsi')"/>
                            <div class="mt-2">
                                <span class="text-sm text-gray-600">Preview:</span>
                                <div id="opsiPreview" class="mt-1 flex flex-wrap gap-2"></div>
                            </div>
                        </div>

                    <div>
                        <x-input-label for="urutan" :value="__('Urutan')"/>
                        <x-text-input
                            id="urutan"
                            name="urutan"
                            type="number"
                            class="mt-1 block w-full"
                            :value="old('urutan', $nextOrder ?? 1)"
                            required
                            readonly
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('urutan')"/>
                    </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('form-questions.index') }}">
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
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleOpsiField() {
            const tipeDropdown = document.getElementById('tipe');
            const opsiField = document.getElementById('opsiField');

            if (tipeDropdown.value === 'text' || tipeDropdown.value === 'textarea') {
                opsiField.style.display = 'none';
            } else {
                opsiField.style.display = 'block';
            }
        }

        function updateOpsiPreview() {
            const opsiTextarea = document.getElementById('opsi');
            const opsiPreview = document.getElementById('opsiPreview');

            opsiPreview.innerHTML = '';

            if (opsiTextarea.value) {
                const opsiArray = opsiTextarea.value.split(',').map(item => item.trim()).filter(item => item);

                opsiArray.forEach(opsi => {
                    const badge = document.createElement('span');
                    badge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800';
                    badge.textContent = opsi;
                    opsiPreview.appendChild(badge);
                });
            }
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', function () {
            toggleOpsiField();
            updateOpsiPreview();
        });
    </script>
</x-app-layout>
