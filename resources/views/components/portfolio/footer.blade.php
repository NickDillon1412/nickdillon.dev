<div class="pb-10 text-slate-50">
    <div class="border-t w-10/12 max-w-[450px] mx-auto"></div>
    <footer class="flex flex-col items-center justify-center p-6 pb-4 mt-2 space-y-4 text-center">
        <div class="max-w-lg">
            <div
                class="flex flex-col items-center justify-between max-w-sm space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row">
                <div class="relative inline-flex w-full group/button">
                    <div
                        class="absolute transition-all duration-1000 bg-pink-500 -inset-px rounded-xl blur-lg group-hover/button:opacity-100 group-hover/button:-inset-1 group-hover/button:duration-200 animate-pulse">
                    </div>

                    <a href="mailto:nickhds@gmail.com" target="_blank"
                        class="relative inline-flex items-center justify-center w-full px-4 py-2 text-lg font-bold text-white transition-all duration-300 ease-in-out bg-pink-500 sm:w-auto hover:-rotate-3 hover:scale-110 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500"
                        role="button">
                        Send me a message!
                    </a>
                </div>

                <span class="hidden sm:inline-block">|</span>

                @livewire('portfolio.socials')
            </div>
        </div>

        <h1>
            &copy; {{ now()->format('Y') }} Nick Dillon
        </h1>
    </footer>
</div>
