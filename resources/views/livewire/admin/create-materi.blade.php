<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Buat Materi Baru</h2>
                <a href="{{ route('admin.materi') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Kembali
                </a>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit="save" class="space-y-6">
                <!-- Judul Materi -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Materi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" wire:model="title" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Masukkan judul materi">
                    @error('title') 
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Gambar Materi -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Materi (Opsional)
                    </label>
                    <input type="file" id="image" wire:model="image" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           accept="image/*">
                    @error('image') 
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                    
                    <!-- Preview Image -->
                    @if ($image)
                        <div class="mt-3">
                            <p class="text-sm text-gray-600 mb-2">Preview:</p>
                            <img src="{{ $image->temporaryUrl() }}" 
                                 class="max-w-xs rounded-lg shadow-sm border">
                        </div>
                    @endif
                    
                    <p class="text-sm text-gray-500 mt-1">
                        Format: JPG, JPEG, PNG (Maksimal 2MB)
                    </p>
                </div>

                <!-- Konten Materi -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Konten Materi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="content" wire:model="content" rows="15"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Tulis konten materi disini..."></textarea>
                    @error('content') 
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200 flex items-center">
                        <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Simpan Materi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>