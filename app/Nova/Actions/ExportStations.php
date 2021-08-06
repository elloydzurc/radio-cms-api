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
 * Class ExportStations
 *
 * @package App\Nova\Actions
 */
class ExportStations extends DownloadExcel
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Channel Name',
            'Broadcast Wave URL',
            'Description',
            'Logo',
            'Type',
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
        $logo = $row->getAttribute('logo') ?? '';

        if (Storage::exists($logo) === true) {
            $logo = Storage::url($logo);
        }

        return [
            $row->getAttribute('id'),
            $row->getAttribute('name'),
            $row->getAttribute('broadcast_wave_url'),
            $row->getAttribute('description'),
            $logo,
            $row->getAttribute('type'),
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
