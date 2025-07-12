<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <x-breadcrumb :items="[
                                        ['name' => 'Dashboard', 'url' => route('dashboard')],
                                        ['name' => 'Konseling', 'url' => route('konseling-mahasiswa.index')],
                                        ['name' => 'Berikan Feedback']
                                    ]"/>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold leading-tight mb-6">
                        {{ __('Berikan Feedback') }}
                    </h2>

                    <!-- Session Details Summary -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Anda memberikan feedback untuk sesi konseling pada tanggal: <span
                                        class="font-semibold">{{ $session->tanggal }}</span> dengan konselor <span
                                        class="font-semibold">{{ $session->konselor->name }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

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

                    <form action="{{ route('feedback.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="sesi_id" value="{{ $session->id }}">

                        <div>
                            <x-input-label for="rating" :value="__('Rating')"/>
                            <div class="flex items-center mt-2">
                                <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}" required>
                                <div class="flex space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                                class="rating-star text-gray-300 hover:text-yellow-400"
                                                data-value="{{ $i }}">
                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                <span class="ml-3 text-sm text-gray-500" id="rating-text">Belum ada rating</span>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('rating')"/>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const stars = document.querySelectorAll('.rating-star');
                                const ratingInput = document.getElementById('rating');
                                const ratingText = document.getElementById('rating-text');

                                // Function to update stars display
                                function updateStars(rating) {
                                    stars.forEach((star, index) => {
                                        if (index < rating) {
                                            star.classList.remove('text-gray-300');
                                            star.classList.add('text-yellow-400');
                                        } else {
                                            star.classList.remove('text-yellow-400');
                                            star.classList.add('text-gray-300');
                                        }
                                    });

                                    // Update rating text
                                    if (rating > 0) {
                                        ratingText.textContent = `${rating} Bintang`;
                                    } else {
                                        ratingText.textContent = 'Belum ada rating';
                                    }
                                }

                                // Handle star click
                                stars.forEach(star => {
                                    star.addEventListener('click', () => {
                                        const value = parseInt(star.dataset.value);
                                        ratingInput.value = value;
                                        updateStars(value);
                                    });

                                    // Fill stars on mouse enter
                                    star.addEventListener('mouseenter', () => {
                                        const value = parseInt(star.dataset.value);

                                        stars.forEach((s, index) => {
                                            if (index < value) {
                                                s.classList.add('text-yellow-400');
                                                s.classList.remove('text-gray-300');
                                            } else {
                                                s.classList.remove('text-yellow-400');
                                                s.classList.add('text-gray-300');
                                            }
                                        });
                                    });

                                    // Reset stars to selected value on mouse leave
                                    star.addEventListener('mouseleave', () => {
                                        const currentRating = parseInt(ratingInput.value) || 0;
                                        updateStars(currentRating);
                                    });
                                });

                                // Mouse leave for the entire star container
                                document.querySelector('.flex.space-x-1').addEventListener('mouseleave', () => {
                                    const currentRating = parseInt(ratingInput.value) || 0;
                                    updateStars(currentRating);
                                });

                                // Initialize with any existing value (for edit forms)
                                const initialRating = parseInt(ratingInput.value) || 0;
                                updateStars(initialRating);
                            });
                        </script>

                        <div>
                            <x-input-label for="komentar" :value="__('Komentar')"/>
                            <x-textarea
                                id="komentar"
                                name="komentar"
                                rows="4"
                                required
                            >{{ old('komentar') }}</x-textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('komentar')"/>
                        </div>

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

                            <x-primary-button type="submit">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('Kirim Feedback') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
