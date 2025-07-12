<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <x-breadcrumb :items="[
                                        ['name' => 'Daftar Konseling', 'url' => route('konseling-konselor.index')],
                                        ['name' => 'Edit Catatan Konseling']
                                    ]"/>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold leading-tight mb-6">
                        {{ __('Edit Catatan Konseling') }}
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

                    <form action="{{ route('konseling-konselor.update', $konseling) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="catatan_konselor" :value="__('Catatan Konselor')"/>
                            <x-textarea
                                id="catatan_konselor"
                                name="catatan_konselor"
                                rows="4"
                                class="mt-1 block w-full"
                                required
                            >{{ old('catatan_konselor', $konseling->catatan_konselor) }}</x-textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('catatan_konselor')"/>
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
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                {{ __('Simpan Catatan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
