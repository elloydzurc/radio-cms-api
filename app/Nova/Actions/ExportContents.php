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
 * Class ExportContents
 *
 * @package App\Nova\Actions
 */
class ExportContents extends DownloadExcel
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Content Title',
            'Program',
            'Description',
            'Content URL',
            'Format',
            'Type',
            'Thumbnail',
            'Age Restriction',
            'Broadcast Date',
            'Status',
            'Featured',
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
        $program = $row->getRelation('program');

        if (Storage::exists($thumbnail) === true) {
            $thumbnail = Storage::url($thumbnail);
        }

        if ($program !== null) {
            $program = $program->getAttribute('name');
        }

        return [
            $row->getAttribute('id'),
            $row->getAttribute('name'),
            $program,
            $row->getAttribute('description'),
            $row->getAttribute('content_url'),
            $row->getAttribute('format'),
            $row->getAttribute('type'),
            $thumbnail,
            $row->getAttribute('age_restriction'),
            $row->getAttribute('broadcast_date'),
            $this->getStatus($row),
            $row->getAttribute('featured'),
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
