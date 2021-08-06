<?php
declare(strict_types=1);

namespace App\Nova\Actions;

use App\Models\Interfaces\AppUserInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

/**
 * Class ExportPrograms
 *
 * @package App\Nova\Actions
 */
class ExportPrograms extends DownloadExcel
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Program Name',
            'Description',
            'Status',
            'Thumbnail',
            'Deleted At',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        $thumbnail = $row->getAttribute('thumbnail') ?? '';

        if (Storage::exists($thumbnail) === true) {
            $thumbnail = Storage::url($thumbnail);
        }

        return [
            $row->getAttribute('id'),
            $row->getAttribute('name'),
            $row->getAttribute('description'),
            $this->getStatus($row),
            $thumbnail,
            $row->getAttribute('deleted_at'),
            $row->getAttribute('created_at'),
            $row->getAttribute('updated_at'),
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return string
     */
    private function getStatus(Model $model): string
    {
        if ($model->getAttribute('deleted_at') !== null) {
            return AppUserInterface::DELETED;
        }

        if ($model->getAttribute('active') === false) {
            return AppUserInterface::INACTIVE;
        }

        return AppUserInterface::ACTIVE;
    }
}
