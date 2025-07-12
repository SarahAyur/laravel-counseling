<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <x-breadcrumb :items="[
                                            ['name' => 'Daftar Sesi', 'url' => route('sessions.index')],
                                            ['name' => 'Tambah Sesi']
                                        ]"/>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-semibold leading-tight mb-6">
                        {{ __('Tambah Sesi Konseling') }}
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

                    <form action="{{ route('sessions.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nama Sesi')"/>
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('name')"
                                required
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                        </div>

                        <div>
                            <x-input-label for="start_time" :value="__('Waktu Mulai')"/>
                            <div class="relative">
                                <x-text-input
                                    id="start_time"
                                    name="start_time"
                                    type="time"
                                    class="mt-1 block w-full"
                                    :value="old('start_time')"
                                    required
                                    onclick="this.showPicker()"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('start_time')"/>
                        </div>

                        <div>
                            <x-input-label for="end_time" :value="__('Waktu Selesai')"/>
                            <div class="relative">
                                <x-text-input
                                    id="end_time"
                                    name="end_time"
                                    type="time"
                                    class="mt-1 block w-full"
                                    :value="old('end_time')"
                                    required
                                    onclick="this.showPicker()"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('end_time')"/>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('sessions.index') }}">
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
</x-app-layout>
