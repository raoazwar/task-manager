<div x-data="{ show: false, message: '', type: 'success' }"
     x-init="
        @if(session('success'))
            show = true; message = '{{ session('success') }}'; type = 'success';
            setTimeout(() => show = false, 3000);
        @elseif(session('error'))
            show = true; message = '{{ session('error') }}'; type = 'error';
            setTimeout(() => show = false, 3000);
        @endif
     "
     x-show="show"
     x-transition
     style="position: fixed; top: 2rem; right: 2rem; z-index: 9999;"
     x-cloak
>
    <div :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'" class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
        <template x-if="type === 'success'">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
        </template>
        <template x-if="type === 'error'">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </template>
        <span x-text="message"></span>
    </div>
</div> 