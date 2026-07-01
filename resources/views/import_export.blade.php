<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Data Management') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Export Section -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 sm:p-12">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6">
                            <!-- <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg> -->
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Export Contacts</h3>
                        <p class="text-gray-500 leading-relaxed mb-8 text-sm">Download your entire contact list as a professionally formatted CSV file. Perfect for backups or moving your data to other platforms.</p>
                        
                        <a href="{{ route('export') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-black font-bold rounded-2xl ">
                            Download CSV Backup
                        </a>
                    </div>
                </div>

                <!-- Import Section -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 sm:p-12">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6">
                            <!-- <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg> -->
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Import Contacts</h3>
                        <p class="text-gray-500 leading-relaxed mb-8 text-sm">Have a list ready? Upload your CSV file here to bulk-add contacts instantly. We'll automatically organize them for you.</p>
                        
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div class="relative">
                                <input type="file" name="file" id="file" class="hidden" required onchange="updateFileName(this)">
                                <label for="file" class="flex flex-col items-center justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-200 border-dashed rounded-2xl appearance-none cursor-pointer hover:border-emerald-400 focus:outline-none" id="drop-zone">
                                    <span class="flex items-center space-x-2">
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg> -->
                                        <span class="font-bold text-gray-600" id="file-name">Click to upload CSV file</span>
                                    </span>
                                </label>
                                <x-input-error class="mt-2" :messages="$errors->get('file')" />
                            </div>
                            
                            <button type="submit" class="items-center justify-center px-8 py-4 text-black font-bold ">
                                Start Import Process
                            </button>
                        </form>
                    </div>

                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                            <!-- <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg> -->
                            CSV Format Guidelines
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Required headers: <code class="bg-white px-2 py-0.5 rounded border border-gray-200 font-bold text-gray-600">name, phone_number, alternate_number, email, company, address, notes</code></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = input.files[0] ? input.files[0].name : 'Click to upload CSV file';
            document.getElementById('file-name').textContent = fileName;
            document.getElementById('drop-zone').classList.add('border-emerald-400', 'bg-emerald-50');
        }
    </script>
</x-app-layout>
