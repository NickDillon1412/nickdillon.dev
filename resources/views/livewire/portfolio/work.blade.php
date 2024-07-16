<?php

use Livewire\Volt\Component;

new class extends Component {
    public function calculateDuration(string $date): string
    {
        $start_date = new DateTime($date);

        $diff = now()->diff($start_date);

        $years = $diff->y;

        $months = $diff->m;

        return match (true) {
            $years === 0 && $months === 1 => "{$months} month",
            $years === 0 && $months !== 1 => "{$months} months",
            $years === 1 && $months === 0 => "{$years} year",
            $years === 1 && $months === 1 => "{$years} year {$months} month",
            $years === 1 && $months !== 1 => "{$years} year {$months} months",
            $years !== 1 && $months === 0 => "{$years} years",
            default => "{$years} years {$months} months",
        };
    }

    public function with(): array
    {
        return [
            'work_experience' => [
                'gray' => [
                    'url' => 'https://gray.tv/',
                    'company' => 'Gray Television',
                    'position' => 'Digital Applications Developer',
                    'time' => 'April 2023 - Present',
                    'duration' => $this->calculateDuration('2023-04-24'),
                    'image' => 'gray-logo.png',
                ],
                'buildOnline' => [
                    'url' => 'https://www.buildonline.io',
                    'company' => 'Build Online',
                    'position' => 'Full Stack Developer',
                    'time' => 'Summer 2021',
                    'duration' => '2 months',
                    'image' => 'build-online.png',
                ],
            ],
        ];
    }
}; ?>

<div class="mt-32 px-7 sm:mt-40 text-slate-50">
    <h1 class="w-9/12 mx-auto text-3xl font-semibold text-center mb-7">
        My work experience:
    </h1>

    <div class="flex justify-center mx-auto border-2 rounded-md bg-[#18192c] md:max-w-xl border-slate-700">
        <div class="w-10/12 px-2 py-8 rounded-md text-slate-50">
            <ul class="relative border-l-2 border-slate-700 space-y-14">
                @foreach ($work_experience as $work)
                    <li class="ml-6">
                        <span
                            class="absolute flex items-center justify-center w-8 h-8 rounded-full -left-4 ring-8 ring-[#18192c] bg-[#18192c]">
                            <img class="shadow-lg" src="{{ asset($work['image']) }}" />
                        </span>

                        <div class="ml-2 shadow-sm sm:grid sm:grid-cols-2 sm:items-center">
                            <div>
                                <a class="duration-300 ease-in-out cursor-pointer hover:text-slate-400"
                                    href="{{ $work['url'] }}" target="_blank">
                                    <h1 class="text-xl font-semibold">
                                        {{ $work['company'] }}
                                    </h1>
                                </a>

                                <h2 class="text-sm">
                                    {{ $work['position'] }}
                                </h2>
                            </div>

                            <div class="flex mt-1 text-xs font-normal sm:flex-col sm:items-center sm:pl-24">
                                <span>{{ $work['time'] }}</span>

                                <span class="block px-1 sm:hidden">•</span>

                                <span>{{ $work['duration'] }}</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
