@forelse ($contacts as $contact)
    <tr class="group hover:bg-indigo-50/30 transition-all duration-200">
        <td class="px-8 py-6">
            <input type="checkbox" x-model="selected" value="{{ $contact->id }}" class="contact-checkbox w-5 h-5 rounded-lg border-gray-200 text-indigo-600 focus:ring-indigo-500 transition-all">
        </td>
        <td class="px-8 py-6 whitespace-nowrap">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center text-indigo-600 font-black shadow-sm group-hover:scale-110 transition-transform duration-300 border border-gray-100">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    @if($contact->favorite)
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-amber-400 rounded-full border-2 border-white"></div>
                    @endif
                </div>
                <div>
                    <div class="text-sm font-black text-gray-900 leading-tight">{{ $contact->name }}</div>
                    <div class="text-xs font-bold text-gray-400 mt-0.5">{{ $contact->company ?: 'Independent' }}</div>
                </div>
            </div>
        </td>
        <td class="px-8 py-6 whitespace-nowrap">
            <div class="space-y-1.5">
                <div class="flex items-center text-sm font-bold text-gray-700">
                    <div class="w-6 h-6 rounded-lg bg-indigo-50 flex items-center justify-center mr-2 text-indigo-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    {{ $contact->phone_number }}
                </div>
                @if($contact->email)
                    <div class="flex items-center text-xs font-bold text-gray-400">
                        <div class="w-6 h-6 rounded-lg bg-emerald-50 flex items-center justify-center mr-2 text-emerald-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        {{ $contact->email }}
                    </div>
                @endif
            </div>
        </td>
        <td class="px-8 py-6 whitespace-nowrap">
            <span class="inline-flex items-center px-3 py-1 bg-white border border-gray-200 rounded-full text-[10px] font-black text-gray-500 uppercase tracking-widest shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-2"></span>
                {{ $contact->group->group_name }}
            </span>
        </td>
        <td class="px-8 py-6 whitespace-nowrap text-center">
            @if($contact->favorite)
                <span class="inline-flex items-center p-2 bg-amber-50 text-amber-500 rounded-xl shadow-sm ring-1 ring-amber-100">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </span>
            @else
                <button class="inline-flex items-center p-2 text-gray-300 hover:text-amber-400 hover:bg-amber-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </button>
            @endif
        </td>
        <td class="px-8 py-6 whitespace-nowrap text-right">
            <div class="flex justify-end items-center space-x-2">
                <a href="{{ route('contacts.show', $contact) }}" class="p-2.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </a>
                <a href="{{ route('contacts.edit', $contact) }}" class="p-2.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="px-8 py-24 text-center">
            <div class="flex flex-col items-center max-w-xs mx-auto">
                <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mb-6 border border-gray-100">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">No connections found</h3>
                <p class="text-sm font-bold text-gray-400 mt-2">We couldn't find any contacts matching your current search or filters.</p>
                <button @click="search = ''; $nextTick(() => document.getElementById('search').dispatchEvent(new Event('input')))" class="mt-6 text-indigo-600 font-black text-xs uppercase tracking-widest hover:text-indigo-800 transition-colors">Clear Search</button>
            </div>
        </td>
    </tr>
@endforelse

