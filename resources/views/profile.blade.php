<x-app-layout>
    <div class="py-8">
        <div class="w-full px-6 mx-auto space-y-6 lg:px-8">
            <div class="p-8 bg-white rounded-lg shadow dark:bg-slate-800">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-8 bg-white rounded-lg shadow dark:bg-slate-800">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-8 bg-white rounded-lg shadow dark:bg-slate-800">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>

            <div class="p-8 bg-white rounded-lg shadow dark:bg-slate-800">
                <div class="max-w-xl">
                    <livewire:profile.github-auth />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
