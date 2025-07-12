<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Daftar Sesi Konseling') }}
                        </h2>
                        <a href="{{ route('sessions.create') }}">
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('Tambah') }}
                            </x-primary-button>
                        </a>
                    </div>

                    @if(session('success'))
                        <div
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4 md:hidden">
                        @foreach($sessions as $session)
                            <div class="bg-white rounded-lg shadow mb-4 overflow-hidden">
                                <div class="p-4 border-b">
                                    <h3 class="font-medium mb-2">{{ $session->name }}</h3>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><span class="font-medium">Waktu Mulai:</span> {{ $session->start_time }}</p>
                                        <p><span class="font-medium">Waktu Selesai:</span> {{ $session->end_time }}</p>
                                    </div>
                                </div>
                                <div class="bg-gray-50 p-3 flex flex-wrap gap-2">
                                    <a href="{{ route('sessions.edit', $session) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('sessions.destroy', $session) }}" method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus?')"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="overflow-x-auto rounded-lg shadow hidden md:block">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Sesi
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu Mulai
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu Selesai
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sessions as $session)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $session->name }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $session->start_time }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $session->end_time }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <x-dropdown-action>
                                            <a href="{{ route('sessions.edit', $session) }}"
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

                                            <form action="{{ route('sessions.destroy', $session) }}"
                                                  method="POST" class="block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus?')"
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
