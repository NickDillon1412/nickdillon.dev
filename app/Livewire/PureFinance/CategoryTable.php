<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use App\Models\PureFinance\Category;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Database\Eloquent\Builder;

#[Layout('layouts.app')]
class CategoryTable extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $category_id): void
    {
        $category = Category::find($category_id);

        Notification::make()
            ->title("Successfully deleted the {$category?->name} category")
            ->success()
            ->send();

        $category?->delete();
    }

    #[On('category-saved')]
    public function render(): View
    {
        return view('livewire.pure-finance.category-table', [
            'categories' => auth()
                ->user()
                ->categories()
                ->with('parent')
                ->select(['id', 'name', 'parent_id'])
                ->when(strlen($this->search) >= 1, function (Builder $query): void {
                    $query->where('name', 'like', "%{$this->search}%");
                })
                ->orderBy('name')
                ->paginate(15)
        ]);
    }
}
