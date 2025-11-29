<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Konten Pembelajaran</h1>
            <p class="text-gray-600 mt-2 text-lg">Tingkatkan pengetahuan Anda dengan materi pembelajaran berkualitas</p>
        </div>

        <!-- Search -->
        <div class="mb-8 flex justify-center">
            <div class="relative w-full max-w-md">
                <input type="text" wire:model.live="search" 
                       placeholder="Cari konten pembelajaran..." 
                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                <svg class="absolute left-4 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Content Cards -->
        @if($contents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($contents as $item)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                        <!-- Image -->
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
                        <div class="p-6">
                            <h3 class="font-bold text-xl text-gray-800 mb-3 line-clamp-2 leading-tight">{{ $item->title }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($item->content), 120) }}
                            </p>
                            
                            <!-- Meta & Action -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                                <a href="{{ route('user.learning-contents.detail', $item->id) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm flex items-center">
                                    Baca
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $contents->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-6 text-2xl font-medium text-gray-900">Belum ada konten</h3>
                <p class="mt-3 text-gray-500 text-lg">Konten pembelajaran akan segera tersedia.</p>
                @if($search)
                    <p class="mt-2 text-gray-400">Coba dengan kata kunci lain</p>
                @endif
            </div>
        @endif
    </div>
</div>