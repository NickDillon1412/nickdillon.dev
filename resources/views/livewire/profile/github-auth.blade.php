<div class="space-y-3">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Add GitHub Credentials?') }}
        </h2>
    </header>

    <flux:button variant="primary" href="{{ route('github.redirect') }}" class="uppercase !px-5 text-xs">
        Redirect to GitHub
    </flux:button>
</div>