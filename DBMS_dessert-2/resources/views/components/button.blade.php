<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2.5 bg-[#f7be5b] border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-[#ffb42f] focus:bg-[#ffb42f] active:bg-[#d99d33] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
