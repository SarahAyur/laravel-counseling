<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Manajemen Konselor') }}
                        </h2>
                        <a href="{{ route('konselor-management.create') }}">
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('Tambah Konselor') }}
                            </x-primary-button>
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4 md:hidden">
                        @foreach($konselors as $konselor)
                            <div class="bg-white rounded-lg shadow mb-4 overflow-hidden">
                                <div class="p-4 border-b">
                                <div class="flex items-center gap-3 mb-2">
                                    @if($konselor->image)
                                        <img src="{{ asset('storage/' . $konselor->image) }}" alt="{{ $konselor->name }}" 
                                            class="w-12 h-12 rounded-full object-cover border border-gray-200">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <h3 class="font-medium">{{ $konselor->name }}</h3>
                                </div>
                                    <h3 class="font-medium mb-2">{{ $konselor->name }}</h3>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><span class="font-medium">Email:</span> {{ $konselor->email }}</p>
                                        <p><span class="font-medium">Status:</span> 
                                            @if($konselor->is_admin)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    Admin Konselor
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Konselor
                                                </span>
                                            @endif
                                            @if($konselor->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="bg-gray-50 p-3 flex flex-wrap gap-2">
                                    <a href="{{ route('konselor-management.edit', $konselor) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    <!-- Tambahkan tombol toggle status -->
                                        <form action="{{ route('konselor-management.toggle-status', $konselor) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 {{ $konselor->is_active ? 'bg-yellow-100 hover:bg-yellow-200 text-yellow-700' : 'bg-green-100 hover:bg-green-200 text-green-700' }} text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="{{ $konselor->is_active ? 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : 'M5 13l4 4L19 7' }}" />
                                                </svg>
                                                {{ $konselor->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    @if(!$konselor->is_admin)
                                        <form action="{{ route('konselor-management.destroy', $konselor) }}" method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus konselor ini?')"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="overflow-x-auto rounded-lg shadow hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Image
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($konselors as $konselor)
                                <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center gap-3">
                                        @if($konselor->image)
                                            <img src="{{ asset('storage/' . $konselor->image) }}" alt="{{ $konselor->name }}" 
                                                class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <!-- {{ $konselor->name }} -->
                                    </div>
                                </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $konselor->name }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $konselor->email }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($konselor->is_admin)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Admin Konselor
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Konselor
                                            </span>
                                        @endif

                                        @if($konselor->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <x-dropdown-action>
                                            <a href="{{ route('konselor-management.edit', $konselor) }}"
                                               class="inline-flex w-full items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- Tambahkan tombol toggle status -->
                                            <form action="{{ route('konselor-management.toggle-status', $konselor) }}" method="POST" class="block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="inline-flex w-full items-center px-3 py-2 {{ $konselor->is_active ? 'bg-yellow-100 hover:bg-yellow-200 text-yellow-700' : 'bg-green-100 hover:bg-green-200 text-green-700' }} text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                            d="{{ $konselor->is_active ? 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : 'M5 13l4 4L19 7' }}" />
                                                    </svg>
                                                    {{ $konselor->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>

                                            @if(!$konselor->is_admin)
                                                <form action="{{ route('konselor-management.destroy', $konselor) }}"
                                                      method="POST" class="block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('Yakin ingin menghapus konselor ini?')"
                                                            class="inline-flex w-full items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                             fill="none"
                                                             viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </x-dropdown-action>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>