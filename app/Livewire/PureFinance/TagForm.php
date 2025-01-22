<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Contracts\View\View;
use Filament\Notifications\Notification;

class TagForm extends Component
{
    public bool $modal_open = false;

    public ?array $tag = null;

    #[Validate(
        'required_if:modal_open,true|string',
        message: 'The name field is required.'
    )]
    public string $name = '';

    public function mount(): void
    {
        if ($this->tag) {
            $this->name = $this->tag['name'];
        }
    }

    public function submit(): void
    {
        $validated_data = $this->validate();

        if ($this->tag) {
            auth()->user()->tags()->update($validated_data);
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
