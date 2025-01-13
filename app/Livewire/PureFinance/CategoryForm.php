<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use App\Models\PureFinance\Category;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Contracts\View\View;
use Filament\Notifications\Notification;

class CategoryForm extends Component
{
    public bool $modal_open = false;

    public ?array $category = null;

    #[Validate(
        'required_if:modal_open,true|string',
        message: 'The name field is required.'
    )]
    public string $name = '';

    public function mount(): void
    {
        if ($this->category) {
            $this->name = $this->category['name'];
        }
    }

    public function submit(): void
    {
        $validated_data = $this->validate();

        if ($this->category) {
            Category::query()
                ->where('id', $this->category['id'])
                ->update($validated_data);
        } else {
            auth()->user()->categories()->create($validated_data);
        }

        $this->dispatch('category-saved');

        if (!$this->category) $this->reset();

        Notification::make()
            ->title("Category successfully " . ($this->category ? "updated" : "created"))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.pure-finance.category-form');
    }
}
