<tr>
    <td class="pl-5 px-2 py-3.5 text-sm font-medium text-slate-800 whitespace-nowrap dark:text-slate-200">
        {{ $account->name }}
    </td>

    <td class="px-2 py-3.5 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
        {{ Str::title($account->type->label()) }}
    </td>

    <td class="px-2 py-3.5 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
        ${{ Number::format($account->balance ?? 0, 2) }}
    </td>

    <td class="pr-3 py-2.5 text-sm font-medium whitespace-nowrap text-end">
        <a class="text-sm font-medium text-indigo-500 duration-200 ease-in-out hover:text-indigo-600 dark:hover:text-indigo-400"
            href="{{ route('pure-finance.account.overview', $account) }}" wire:navigate>
            <div class="flex items-center justify-end">
                View

                <x-heroicon-o-eye class="w-[19px] h-[19px] ml-1" />
            </div>
        </a>
    </td>
</tr>
