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
        <a class="flex justify-end text-sm font-medium text-indigo-500"
            href="{{ route('pure-finance.account.overview', $account) }}" wire:navigate>
            <div
                class="flex items-center -mr-0.5 px-2 py-1 duration-200 ease-in-out hover:bg-slate-200 dark:hover:bg-slate-700 rounded-md justify-end">
                <span>View</span>

                <x-heroicon-o-eye class="w-[19px] h-[19px] ml-1" />
            </div>
        </a>
    </td>
</tr>
