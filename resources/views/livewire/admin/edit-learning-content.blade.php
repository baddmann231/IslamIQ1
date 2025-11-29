<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Edit Konten Pembelajaran</h2>
                    <p class="text-gray-600 mt-2">Perbarui konten yang sudah ada</p>
                </div>
                <a href="{{ route('admin.learning-contents') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit="update" class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Konten <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" wire:model="title" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                           placeholder="Masukkan judul yang menarik">
                    @error('title') 
                        <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Konten (Opsional)
                    </label>
                    
                    <!-- Current Image -->
                    @if ($oldImage)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $oldImage) }}" 
                                 class="max-w-xs rounded-lg shadow-sm border-2 border-green-200">
                        </div>
                    @endif
                    
                    <input type="file" id="image" wire:model="image" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                           accept="image/*">
                    @error('image') 
                        <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                    @enderror
                    
                    <!-- Preview New Image -->
                    @if ($image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Preview Gambar Baru:</p>
                            <img src="{{ $image->temporaryUrl() }}" 
                                 class="max-w-xs rounded-lg shadow-sm border-2 border-blue-200">
                        </div>
                    @endif
                    
                    <p class="text-sm text-gray-500 mt-2">
                        Format: JPG, JPEG, PNG (Maksimal 2MB)
                    </p>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Isi Konten <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" wire:model="content" rows="15"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                              placeholder="Tulis konten pembelajaran disini..."></textarea>
                    @error('content') 
                        <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-6">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200 flex items-center shadow-lg">
                        <svg wire:loading wire:target="update" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Update Konten
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>