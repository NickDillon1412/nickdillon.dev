<div class="pt-32 text-slate-50">
    <div class="relative flex flex-col items-center max-w-xl mx-auto space-y-4 text-center group sm:px-4">
        <img src="{{ asset('blur.svg') }}"
            class="absolute top-0 sm:-top-10 -inset-px opacity-[.8s] animate-[pulse_3s_ease-in-out_infinite]" />

        <div class="z-0 flex flex-col items-center space-y-4">
            <img src="{{ asset('profile.jpg') }}"
                class="w-64 h-64 duration-500 ease-in-out rounded-full sm:w-56 sm:h-56 shadow-3xl" />

            <h1 class="italic font-bold">
                <div
                    class="relative items-center justify-center inline-block w-auto h-auto px-1 mb-2 text-base font-bold text-opacity-100 transition-all duration-300 rounded outline-none group active:ring-0 active:outline-none">
                    <span class="relative z-20 p-1 text-5xl">
                        Hi, I'm Nick!
                    </span>

                    <span
                        class="absolute bottom-0 left-0 z-10 w-full h-3 transition-all duration-300 ease-out -skew-x-12 bg-pink-400">
                    </span>
                </div>
            </h1>
        </div>

        <x-portfolio.typewriter />
    </div>
</div>
