<x-app-layout>
    <div>
        <x-portfolio.header />

        <x-portfolio.intro />

        @livewire('portfolio.work')

        @livewire('portfolio.technologies')

        <x-portfolio.footer />
    </div>
</x-app-layout>
