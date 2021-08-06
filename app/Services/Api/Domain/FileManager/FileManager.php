<?php
declare(strict_types=1);

namespace  App\Services\Api\Domain\FileManager;

use App\Services\Api\Domain\FileManager\Interfaces\FileManagerInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class FileUploader
 *
 * @package App\Services\FileManager
 */
class FileManager implements FileManagerInterface
{
    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     *
     * @param string $visibility
     *
     * @return string
     */
    public function upload(UploadedFile $file, string $directory, string $visibility = 'public'): string
    {
        $fileName = $this->getFilename($file, $directory);
        $filePath = Storage::putFileAs($directory, $file, $fileName, $visibility);

        return Storage::url($filePath);
    }

    /**
     * @param \Illuminate\Http\UploadedFile[] $files
     * @param string $directory
     * @param string $visibility
     *
     * @return array
     */
    public function uploadMultiple(iterable $files, string $directory, string $visibility = 'public'): array
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            $fileName = $this->getFilename($file, $directory);
            $filePath = Storage::putFileAs($directory, $file, $fileName, $visibility);

            $uploadedFiles[] = [
                'file_name' => $fileName,
                'file_path' => Storage::url($filePath),
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize()
            ];
        }

        return $uploadedFiles;
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     *
     * @return string
     */
    private function getFilename(UploadedFile $file, string $directory): string
    {
        $filename = $file->getClientOriginalName();

        if (Storage::exists($directory . '/' . $filename)) {
            $name = \pathinfo($filename, PATHINFO_FILENAME);
            $extension = \pathinfo($filename, PATHINFO_EXTENSION);
            $filename = $name . '-' . \time() . '.' . $extension;
        }

        return $filename;
    }
}
