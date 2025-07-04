<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2 bg-gradient-to-r from-indigo-600 to-blue-400 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest shadow-md hover:from-blue-500 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
