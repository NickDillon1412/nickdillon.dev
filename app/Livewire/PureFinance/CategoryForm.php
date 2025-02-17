<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Models\PureFinance\Category;
use Filament\Notifications\Notification;

class CategoryForm extends Component
{
    public bool $modal_open = false;

    public ?int $parent_id = null;

    public ?array $category = null;

    public string $name = '';

    protected function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                'integer',
                'numeric',
                Rule::in($this->parentCategories->pluck('id')->toArray())
            ],
            'name' => [
                'required_if:modal_open,true',
                'string',
                'unique:categories,name,NULL,id,user_id,' . auth()->id()
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'parent_id.integer' => 'The parent category must be an integer.',
            'parent_id.in' => 'The selected parent category is invalid.',
            'name.required_if' => 'The name field is required.',
            'name.unique' => 'The provided name has already been taken.'
        ];
    }

    #[On('open-category-edit-form')]
    public function loadCategory(?array $category = null): void
    {
        $this->resetValidation();

        if ($category) {
            $this->category = $category;
            $this->name = $this->category['name'];
            $this->parent_id = $this->category['parent_id'];
        }
    }

    #[Computed]
    public function parentCategories(): Collection
    {
        return auth()
            ->user()
            ->categories()
            ->select(['id', 'name'])
            ->whereNull('parent_id')
            ->get();
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
