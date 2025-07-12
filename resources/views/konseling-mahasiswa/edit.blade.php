<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Edit Pengajuan Konseling') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <!-- Breadcrumb -->
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('konseling-mahasiswa.index') }}"
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit Konseling</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="!pt-0 p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="!pt-6">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                                <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('konseling-mahasiswa.update', $konseling) }}" method="POST"
                          class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="konselor_id" :value="__('Pilih Konselor')"/>
                            <select
                                id="konselor_id"
                                name="konselor_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Pilih Konselor</option>
                                @foreach($konselors as $konselor)
                                    <option
                                        value="{{ $konselor->id }}" {{ $konseling->konselor_id == $konselor->id ? 'selected' : '' }}>
                                        {{ $konselor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('konselor_id')"/>
                        </div>

                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal Konseling')"/>
                            <div class="relative">
                                <x-text-input
                                    id="tanggal"
                                    name="tanggal"
                                    type="date"
                                    class="mt-1 block w-full cursor-pointer"
                                    :value="$konseling->tanggal"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    onclick="this.showPicker()"
                                />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal')"/>
                        </div>

                        <div>
                            <x-input-label for="sesi_id" :value="__('Pilih Waktu')"/>
                            <select
                                id="sesi_id"
                                name="sesi_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Pilih Waktu</option>
                                @foreach($waktuSesi as $sesi)
                                    <option
                                        value="{{ $sesi->id }}" {{ $konseling->sesi_id == $sesi->id ? 'selected' : '' }}>
                                        {{ $sesi->name }} ({{ $sesi->start_time }} - {{ $sesi->end_time }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('sesi_id')"/>
                        </div>

                        <div>
                            <x-input-label for="topik" :value="__('Topik Konseling')"/>
                            <x-text-input
                                id="topik"
                                name="topik"
                                type="text"
                                class="mt-1 block w-full"
                                :value="$konseling->topik"
                                required
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('topik')"/>
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

                            <x-primary-button>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
