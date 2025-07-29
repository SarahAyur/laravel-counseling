<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div>
            <x-input-label for="image" :value="__('Profile Photo')" />
            <div class="flex items-center gap-4 mt-2">
                <div class="shrink-0">
                    <img class="h-16 w-16 object-cover rounded-full" 
                         src="{{ $user->image ? asset('storage/' . $user->image) : 'https://www.gravatar.com/avatar/?d=mp&s=200' }}" 
                         alt="{{ $user->name }}">
                </div>
                <label class="block">
                    <span class="sr-only">Choose profile photo</span>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100"/>
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if($user->role === 'mahasiswa')
        <!-- Mahasiswa Fields -->
        <div>
            <x-input-label for="nim" :value="__('Student ID (NIM)')" />
            <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full" :value="old('nim', $user->nim)" required />
            <x-input-error class="mt-2" :messages="$errors->get('nim')" />
        </div>

        <div>
            <x-input-label for="whatsapp_number" :value="__('WhatsApp Number')" />
            <x-text-input id="whatsapp_number" name="whatsapp_number" type="text" class="mt-1 block w-full" :value="old('whatsapp_number', $user->whatsapp_number)" required />
            <x-input-error class="mt-2" :messages="$errors->get('whatsapp_number')" />
        </div>

        <div>
            <x-input-label for="prodi" :value="__('Program Studi')" />
            <select id="prodi" name="prodi"
                    class="block mt-1 w-full border-gray-300 focus:border-[#66003a] focus:ring-[#66003a] rounded-md shadow-sm"
                    required>
                <option value="" disabled>Pilih Program Studi</option>
                <option value="Teknik Informatika" {{ old('prodi', $user->prodi) == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                <option value="Teknik Mesin" {{ old('prodi', $user->prodi) == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                <option value="Teknik Sipil" {{ old('prodi', $user->prodi) == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                <option value="Teknik Elektro" {{ old('prodi', $user->prodi) == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                <option value="Desain Komunikasi Visual" {{ old('prodi', $user->prodi) == 'Desain Komunikasi Visual' ? 'selected' : '' }}>Desain Komunikasi Visual</option>
                <option value="Pendidikan Guru Sekolah Dasar" {{ old('prodi', $user->prodi) == 'Pendidikan Guru Sekolah Dasar' ? 'selected' : '' }}>Pendidikan Guru Sekolah Dasar</option>
                <option value="Hukum" {{ old('prodi', $user->prodi) == 'Hukum' ? 'selected' : '' }}>Hukum</option>
                <option value="Manajemen" {{ old('prodi', $user->prodi) == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                <option value="Akuntansi" {{ old('prodi', $user->prodi) == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
            </select>
            <x-input-error :messages="$errors->get('prodi')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="semester" :value="__('Semester')" />
            <select id="semester" name="semester"
                    class="block mt-1 w-full border-gray-300 focus:border-[#66003a] focus:ring-[#66003a] rounded-md shadow-sm"
                    required>
                <option value="" disabled>Pilih Semester</option>
                @foreach(['1', '2', '3', '4', '5', '6', '7', '8', '9', '>10'] as $sem)
                    <option value="{{ $sem }}" {{ old('semester', $user->semester) == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('semester')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="student_type" :value="__('Student Type')" />
            <select id="student_type" name="student_type"
                    class="block mt-1 w-full border-gray-300 focus:border-[#66003a] focus:ring-[#66003a] rounded-md shadow-sm"
                    required>
                <option value="" disabled>Pilih Jenis Mahasiswa</option>
                <option value="Local Student" {{ old('student_type', $user->student_type) == 'Local Student' ? 'selected' : '' }}>Local Student</option>
                <option value="International Student" {{ old('student_type', $user->student_type) == 'International Student' ? 'selected' : '' }}>International Student</option>
            </select>
            <x-input-error :messages="$errors->get('student_type')" class="mt-2" />
        </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>