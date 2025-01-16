<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Spatie\LivewireFilepond\WithFilePond;

class FileUploader extends Component
{
    use WithFilePond;

    #[Validate([
        'files' => ['required', 'array'],
        'files.*' => ['file', 'mimes:jpg,jpeg,png,heic,svg,avif,webp']
    ])]
    public ?array $files = [];

    public Collection $uploaded_files;

    public string $selected_file = '';

    public string $s3_path = 'pure-finance/files';

    protected function messages(): array
    {
        return [
            'files.*' => 'File must be of type: jpg, jpeg, png, heic, svg, avif, webp'
        ];
    }

    public function mount(): void
    {
        $this->uploaded_files = collect();

        if ($this->files) {
            foreach ($this->files as $file) {
                $this->uploaded_files->push($file);
            }
        }
    }

    public function formatFileSize(int $bytes): string
    {
        return match (true) {
            $bytes >= 1073741824 => round($bytes / 1073741824, 2) . ' GB',
            $bytes >= 1048576 => round($bytes / 1048576, 2) . ' MB',
            $bytes >= 1024 => round($bytes / 1024, 2) . ' KB',
            default => $bytes . ' Bytes',
        };
    }

    public function validateUploadedFile()
    {
        $this->validate();

        return true;
    }

    public function updatedFiles(): void
    {
        $this->validate();

        foreach ($this->files as $file) {
            $this->uploaded_files->push([
                'name' => $file->getClientOriginalName(),
                'size' => $this->formatFileSize($file->getSize()),
            ]);

            $file->storePubliclyAs(
                'pure-finance/files',
                $file->getClientOriginalName(),
                's3'
            );

            $this->dispatch('file-uploaded', file: [
                'name' => $file->getClientOriginalName(),
                'size' => $this->formatFileSize($file->getSize()),
            ]);
        }
    }

    public function removeFile(string $file_name): void
    {
        if (Storage::disk('s3')->exists("{$this->s3_path}/{$file_name}")) {
            Storage::disk('s3')->delete("{$this->s3_path}/{$file_name}");
        }

        $this->uploaded_files = $this->uploaded_files
            ->reject(fn(array $file): bool => $file['name'] === $file_name)
            ->values();

        $this->dispatch('file-deleted');
    }

    #[On('file-deleted')]
    public function render(): View
    {
        return view('livewire.file-uploader');
    }
}
