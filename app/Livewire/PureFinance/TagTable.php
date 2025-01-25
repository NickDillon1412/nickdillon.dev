<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\PureFinance\Tag;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Database\Eloquent\Builder;

#[Layout('layouts.app')]
class TagTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $tag_id): void
    {
        $tag = Tag::find($tag_id);

        Notification::make()
            ->title("Successfully deleted the {$tag?->name} tag")
            ->success()
            ->send();

        $tag?->delete();
    }

    #[On('tag-saved')]
    public function render(): View
    {
        return view('livewire.pure-finance.tag-table', [
            'tags' => auth()
                ->user()
                ->tags()
                ->select(['id', 'name'])
                ->when(strlen($this->search) >= 1, function (Builder $query): void {
                    $query->where('name', 'like', "%{$this->search}%");
                })
                ->orderBy('name')
                ->paginate(15)
        ]);
    }
}
