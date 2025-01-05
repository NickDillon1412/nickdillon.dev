<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Modelable;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class FileUploader extends Component
{
    use WithFileUploads;

    #[Modelable, Validate([
        'files' => ['required', 'array'],
        'files.*' => ['image', 'mimes:jpg,jpeg,png,heic,svg,avif,webp']
    ])]
    public array $files = [];

    public Collection $uploaded_files;

    public string $selected_file = '';

    public string $s3_path = 'pure-finance/files';

    public function mount(): void
    {
        $this->uploaded_files = collect();
    }

    public function updatedFiles(): void
    {
        $this->validateOnly('files');

        foreach ($this->files as $file) {
            $this->uploaded_files->push($file->getClientOriginalName());

            $file->storePubliclyAs(
                'pure-finance/files',
                $file->getClientOriginalName(),
                's3'
            );
        }

        $this->files = [];
    }

    public function removeFile(string $file_name): void
    {
        if (Storage::disk('s3')->exists("{$this->s3_path}/{$file_name}")) {
            Storage::disk('s3')->delete("{$this->s3_path}/{$file_name}");
        }

        $this->uploaded_files = $this->uploaded_files
            ->reject(fn(string $file): bool => $file === $file_name)
            ->values();

        $this->dispatch('file-deleted');
    }

    public function viewFile(int $index): void
    {
        $this->selected_file = $this->uploaded_files[$index]->getClientOriginalName() ?? null;
    }

    #[On('file-deleted')]
    public function render(): View
    {
        return view('livewire.file-uploader');
    }
}
