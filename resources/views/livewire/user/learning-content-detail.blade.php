<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('user.learning-contents') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Konten
            </a>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Header Image -->
            @if($content->image)
                <img src="{{ asset('storage/' . $content->image) }}" 
                     alt="{{ $content->title }}" 
                     class="w-full h-64 md:h-80 object-cover">
            @else
                <div class="w-full h-64 md:h-80 bg-gradient-to-r from-blue-50 to-indigo-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            @endif

            <!-- Content -->
            <div class="p-6 md:p-8">
                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 leading-tight">
                    {{ $content->title }}
                </h1>
                
                <!-- Meta Information -->
                <div class="flex flex-wrap items-center text-gray-500 text-sm mb-6 space-x-4">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Diposting {{ $content->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Oleh: {{ $content->admin->name }}</span>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 mb-6"></div>

                <!-- Content Body -->
                <div class="prose max-w-none text-gray-700 text-lg leading-relaxed">
                    <!-- Format content dengan nl2br dan htmlspecialchars untuk keamanan -->
                    {!! nl2br(e($content->content)) !!}
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <a href="{{ route('user.learning-contents') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar
                    </a>
                    
                    <div class="flex space-x-3">
                        <button onclick="window.print()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak
                        </button>
                        
                        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                                class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                            Ke Atas
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Content Suggestion -->
        <div class="mt-8 bg-blue-50 rounded-lg p-6 border border-blue-200">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-blue-800">Ingin belajar lebih banyak?</h3>
                    <p class="text-blue-600 mt-1">Jelajahi konten pembelajaran lainnya untuk meningkatkan pengetahuan Anda.</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('user.learning-contents') }}" 
                   class="inline-flex items-center text-blue-700 hover:text-blue-900 font-medium">
                    Lihat Semua Konten
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
        color: black !important;
    }
    
    .prose {
        font-size: 12pt !important;
        line-height: 1.6 !important;
    }
    
    .bg-white {
        background: white !important;
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }
}
</style>