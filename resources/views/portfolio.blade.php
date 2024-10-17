<x-app-layout>
    <x-snowfall />

    <x-portfolio.header />

    <x-portfolio.intro />

    @livewire('portfolio.work')

    @livewire('portfolio.technologies')

    @livewire('portfolio.projects')

    <x-portfolio.footer />
</x-app-layout>
