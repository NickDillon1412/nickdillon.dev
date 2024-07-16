<x-app-layout>
    <div>
        <x-portfolio.header />

        <x-portfolio.intro />

        @livewire('portfolio.work')

        @livewire('portfolio.technologies')
    </div>
</x-app-layout>
