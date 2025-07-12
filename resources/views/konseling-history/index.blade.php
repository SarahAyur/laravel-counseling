<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('History Konseling') }}
                        </h2>
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
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="font-medium">Mahasiswa: {{ $session->mahasiswa->name }}</h3>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                                                                 {{ $session->status === 'finished' ? 'bg-green-100 text-green-800' :
                                                                                                                    ($session->status === 'approved' ? 'bg-blue-100 text-blue-800' :
                                                                                                                    ($session->status === 'canceled' ? 'bg-red-100 text-red-800' :
                                                                                                                    'bg-yellow-100 text-yellow-800')) }}">
                                                                                                                 {{ ucfirst($session->status) }}
                                                                                                             </span>
                                    </div>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><span
                                                class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($session->tanggal)->format('d F Y') }}
                                        </p>
                                        <p><span class="font-medium">Waktu:</span> {{ $session->sesi->name }}</p>
                                        <p><span class="font-medium">Topik:</span> {{ $session->topik }}</p>
                                        <p><span
                                                class="font-medium">Catatan:</span> {{ $session->catatan_konselor ?: '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="bg-gray-50 p-3 flex flex-wrap gap-2">
                                    <a href="{{ route('konseling-history.show', $session) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ __('Detail') }}
                                    </a>

                                    @if($session->status !== 'canceled')
                                        <a href="{{ route('konseling-konselor.edit', $session) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            {{ __('Edit Catatan') }}
                                        </a>
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
                                    Tanggal
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    Waktu
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mahasiswa
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Topik
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    Catatan
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sessions as $session)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($session->tanggal)->format('d F Y') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                                        {{ $session->sesi->name }}
                                        <span class="text-gray-500 text-xs block">
                                                                                                                 {{ $session->sesi->start_time }} - {{ $session->sesi->end_time }}
                                                                                                             </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $session->mahasiswa->name }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                                                                                             <span
                                                                                                                 class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                                                                 {{ $session->status === 'finished' ? 'bg-green-100 text-green-800' :
                                                                                                                    ($session->status === 'approved' ? 'bg-blue-100 text-blue-800' :
                                                                                                                    ($session->status === 'canceled' ? 'bg-red-100 text-red-800' :
                                                                                                                    'bg-yellow-100 text-yellow-800')) }}">
                                                                                                                 {{ ucfirst($session->status) }}
                                                                                                             </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900">{{ $session->topik }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-900 hidden lg:table-cell">{{ $session->catatan_konselor ?: '-' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <x-dropdown-action>
                                            <a href="{{ route('konseling-history.show', $session) }}"
                                               class="inline-flex w-full items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                {{ __('Detail') }}
                                            </a>

                                            <div>
                                                @if($session->status !== 'canceled')
                                                    <a href="{{ route('konseling-konselor.edit', $session) }}"
                                                       class="inline-flex w-full items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                                        <svg class="w-4 h-4 mr-2"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             fill="none" viewBox="0 0 24 24"
                                                             stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                        Edit Catatan
                                                    </a>
                                                @endif
                                            </div>
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
