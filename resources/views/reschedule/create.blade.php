<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <x-breadcrumb :items="[
                                            ['name' => 'Daftar Konseling', 'url' => route('konseling-konselor.index')],
                                            ['name' => 'Reschedule Konseling']
                                        ]"/>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold leading-tight mb-6">
                        {{ __('Reschedule Konseling') }}
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

                    <form action="{{ route('reschedule.store', $konseling) }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-6">
                            <div class="p-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="font-medium text-gray-700">Jadwal Lama</h3>
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
                                            {{ $konseling->session->name }} ({{ $konseling->session->start_time }}
                                            - {{ $konseling->session->end_time }})
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="new_tanggal" :value="__('Tanggal Baru')"/>
                            <div class="relative">
                                <x-text-input
                                    id="new_tanggal"
                                    name="new_tanggal"
                                    type="date"
                                    class="mt-1 block w-full cursor-pointer"
                                    :value="old('new_tanggal')"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    onclick="this.showPicker()"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('new_tanggal')"/>
                        </div>

                        <div>
                            <x-input-label for="new_sesi_id" :value="__('Pilih Waktu Baru')"/>
                            <x-select
                                id="new_sesi_id"
                                name="new_sesi_id"
                                :options="$waktuSesi->pluck('name_with_time', 'id')->prepend('Pilih Waktu', '')"
                                :selected="old('new_sesi_id')"
                                required
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('new_sesi_id')"/>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('konseling-konselor.index') }}">
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
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('Ajukan Reschedule') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('new_tanggal');
            const sessionSelect = document.getElementById('new_sesi_id');
            const konselorId = "{{ $konseling->konselor_id }}";
            const konselingId = "{{ $konseling->id }}";
    
            // Function to fetch available slots
            function fetchAvailableSlots() {
                const tanggal = dateInput.value;
    
                // Clear session select if date is empty
                if (!tanggal) {
                    resetSessionSelect('Pilih tanggal terlebih dahulu');
                    return;
                }
    
                // Show loading state
                resetSessionSelect('Loading...', true);
    
                // Make Ajax request
                fetch(`/check-reschedule-slots?konselor_id=${konselorId}&tanggal=${tanggal}&current_konseling_id=${konselingId}`)
                    .then(response => response.json())
                    .then(data => {
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
                                sessionSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resetSessionSelect('Error loading slots');
                    });
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
            dateInput.addEventListener('change', fetchAvailableSlots);
    
            // Check if date is pre-filled (e.g., on form validation error)
            if (dateInput.value) {
                fetchAvailableSlots();
            }
        });
    </script>
    @endpush
</x-app-layout>
