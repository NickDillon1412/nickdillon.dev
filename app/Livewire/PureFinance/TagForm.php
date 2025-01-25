<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PureFinance\Tag;
use Illuminate\Contracts\View\View;
use Filament\Notifications\Notification;

class TagForm extends Component
{
    public bool $modal_open = false;

    public ?array $tag = null;

    public string $name = '';

    protected function rules(): array
    {
        return [
            'name' => [
                'required_if:modal_open,true',
                'string',
                'unique:tags,name,NULL,id,user_id,' . auth()->id()
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required_if' => 'The name field is required.',
            'name.unique' => 'The provided name has already been taken.'
        ];
    }

    #[On('open-tag-edit-form')]
    public function loadTag(?array $tag = null): void
    {
        $this->resetValidation();

        if ($tag) {
            $this->tag = $tag;
            $this->name = $this->tag['name'];
        }
    }

    public function submit(): void
    {
        $validated_data = $this->validate();

        if ($this->tag) {
            Tag::query()
                ->where('id', $this->tag['id'])
                ->update($validated_data);
        } else {
            auth()->user()->tags()->create($validated_data);
        }

        $this->dispatch('tag-saved');

        if (!$this->tag) $this->reset();

        Notification::make()
            ->title("Tag successfully " . ($this->tag ? "updated" : "created"))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.pure-finance.tag-form');
    }
}
