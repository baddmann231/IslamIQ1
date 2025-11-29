<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Materi Pembelajaran</h1>
            <p class="text-gray-600 mt-2">Pelajari berbagai materi yang tersedia</p>
        </div>

        <!-- Search -->
        <div class="mb-6 flex justify-center">
            <div class="relative w-full max-w-md">
                <input type="text" wire:model.live="search" 
                       placeholder="Cari materi..." 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Materi Cards -->
        @if($materi->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($materi as $item)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition duration-200 transform hover:-translate-y-1">
                        <!-- Gambar Materi -->
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" 
                                 alt="{{ $item->title }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                                <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">{{ $item->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($item->content), 100) }}
                            </p>
                            
                            <!-- Actions -->
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                                <a href="{{ route('user.materi.detail', $item->id) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
                                    Baca
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $materi->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada materi</h3>
                <p class="mt-2 text-gray-500">Belum ada materi yang tersedia saat ini.</p>
            </div>
        @endif
    </div>
</div>