<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                          autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        
        <!-- NIM -->
        <div class="mt-4">
            <x-input-label for="nim" :value="__('Student ID (NIM)')"/>
            <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" :value="old('nim')" required/>
            <x-input-error :messages="$errors->get('nim')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                          autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>
        
        <!-- WhatsApp Number -->
        <div class="mt-4">
            <x-input-label for="whatsapp_number" :value="__('WhatsApp Number')"/>
            <x-text-input id="whatsapp_number" class="block mt-1 w-full" type="text" name="whatsapp_number" :value="old('whatsapp_number')" required/>
            <x-input-error :messages="$errors->get('whatsapp_number')" class="mt-2"/>
        </div>
        
        <!-- Program Studi -->
        <div class="mt-4">
            <x-input-label for="prodi" :value="__('Program Studi')"/>
            <select id="prodi" name="prodi"
                    class="block mt-1 w-full border-gray-300 focus:border-[#66003a] focus:ring-[#66003a] rounded-md shadow-sm"
                    required>
                <option value="" disabled selected>Pilih Program Studi</option>
                <option value="Teknik Informatika" {{ old('prodi') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                <option value="Teknik Mesin" {{ old('prodi') == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                <option value="Teknik Sipil" {{ old('prodi') == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                <option value="Teknik Elektro" {{ old('prodi') == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                <option value="Desain Komunikasi Visual" {{ old('prodi') == 'Desain Komunikasi Visual' ? 'selected' : '' }}>Desain Komunikasi Visual</option>
                <option value="Pendidikan Guru Sekolah Dasar" {{ old('prodi') == 'Pendidikan Guru Sekolah Dasar' ? 'selected' : '' }}>Pendidikan Guru Sekolah Dasar</option>
                <option value="Hukum" {{ old('prodi') == 'Hukum' ? 'selected' : '' }}>Hukum</option>
                <option value="Manajemen" {{ old('prodi') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                <option value="Akuntansi" {{ old('prodi') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
            </select>
            <x-input-error :messages="$errors->get('prodi')" class="mt-2"/>
        </div>
        
        <!-- Semester -->
        <div class="mt-4">
            <x-input-label for="semester" :value="__('Semester')"/>
            <select id="semester" name="semester"
                    class="block mt-1 w-full border-gray-300 focus:border-[#66003a] focus:ring-[#66003a] rounded-md shadow-sm"
                    required>
                <option value="" disabled selected>Pilih Semester</option>
                @foreach(['1', '2', '3', '4', '5', '6', '7', '8', '9', '>10'] as $sem)
                    <option value="{{ $sem }}" {{ old('semester') == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('semester')" class="mt-2"/>
        </div>
        
        <!-- Student Type -->
        <div class="mt-4">
            <x-input-label for="student_type" :value="__('Student Type')"/>
            <select id="student_type" name="student_type"
                    class="block mt-1 w-full border-gray-300 focus:border-[#66003a] focus:ring-[#66003a] rounded-md shadow-sm"
                    required>
                <option value="" disabled selected>Pilih Jenis Mahasiswa</option>
                <option value="Local Student" {{ old('student_type') == 'Local Student' ? 'selected' : '' }}>Local Student</option>
                <option value="International Student" {{ old('student_type') == 'International Student' ? 'selected' : '' }}>International Student</option>
            </select>
            <x-input-error :messages="$errors->get('student_type')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"/>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-[#66003a] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#66003a]"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>