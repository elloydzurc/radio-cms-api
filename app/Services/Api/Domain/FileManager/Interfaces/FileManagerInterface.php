<?php
declare(strict_types=1);

namespace App\Services\Api\Domain\FileManager\Interfaces;

use Illuminate\Http\UploadedFile;

/**
 * Interface FileManagerInterface
 *
 * @package App\Services\Api\Domain\FileManager\Interfaces
 */
interface FileManagerInterface
{
    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     *
     * @param string $visibility
     *
     * @return string
     */
    public function upload(UploadedFile $file, string $directory, string $visibility = 'public'): string;

    /**
     * @param \Illuminate\Http\UploadedFile[] $files
     * @param string $directory
     * @param string $visibility
     *
     * @return array
     */
    public function uploadMultiple(iterable $files, string $directory, string $visibility = 'public'): array;
}
