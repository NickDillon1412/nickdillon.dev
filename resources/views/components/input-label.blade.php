@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium sm:text-sm text-slate-700 dark:text-slate-300']) }}>
    {{ $value ?? $slot }}
</label>
