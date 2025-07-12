<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Edit Konselor') }}
                        </h2>
                    </div>

                    <form method="POST" action="{{ route('konselor-management.update', $konselor) }}" enctype="multipart/form-data">
                    @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $konselor->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $konselor->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Foto Profil -->
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Foto Profil')" />
                            
                            @if($konselor->image)
                            <div class="mt-2 mb-3">
                                <img src="{{ asset('storage/' . $konselor->image) }}" alt="{{ $konselor->name }}" class="w-24 h-24 object-cover rounded-full border-2 border-[#66003a]">
                            </div>
                            @endif
                            
                            <input id="image" name="image" type="file" accept="image/*" 
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#66003a] file:text-white hover:file:bg-[#420026]" />
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF (Maks. 2MB). Biarkan kosong jika tidak ingin mengubah foto.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Status Admin -->
                        @if(auth()->user()->isAdminKonselor())
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input id="is_admin" name="is_admin" type="checkbox" value="1" {{ $konselor->is_admin ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-[#66003a] focus:ring-[#66003a]">
                                <label for="is_admin" class="ml-2 block text-sm text-gray-900">Admin Konselor</label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Admin konselor dapat mengelola konselor lainnya</p>
                        </div>
                        @endif

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('konselor-management.index') }}" class="mr-3">
                                <x-secondary-button>
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </a>

                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>