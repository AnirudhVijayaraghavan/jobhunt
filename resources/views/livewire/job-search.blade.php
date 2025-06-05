<div class="space-y-6">
    {{-- Search Form --}}
    <div class="flex items-center space-x-2">
        <input type="text" wire:model.defer="query" placeholder="Enter keyword…"
            class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            autofocus />

        <button wire:click="search" wire:loading.attr="disabled" wire:target="search"
            class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white font-semibold px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
            {{-- Inline SVG for a search icon --}}
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35m1.93-4.15a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Search
        </button>
    </div>

    {{-- Error Message --}}
    @if ($errorMessage)
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error:</strong>
            <span class="block sm:inline">{{ $errorMessage }}</span>
        </div>
    @endif

    {{-- Loading Indicator --}}
    @if ($isSearching)
        <div class="flex justify-center py-6">
            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>
    @endif

    {{-- Results Table --}}
    @if (!$isSearching && count($results) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 bg-white shadow-lg rounded-lg">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                            Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                            Company
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                            Location
                        </th>
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($results as $job)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-normal break-words">
                                {{ $job['title'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-normal break-words">
                                {{ $job['company'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-normal break-words">
                                {{ $job['location'] }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <a href="{{ $job['link'] }}" target="_blank"
                                    class="inline-flex items-center px-3 py-1 border border-indigo-600 text-indigo-600 text-xs font-semibold rounded hover:bg-indigo-50 transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
