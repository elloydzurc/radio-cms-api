<?php
declare(strict_types=1);

namespace App\Nova\Actions;

use App\Models\Interfaces\AppUserInterface;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

/**
 * Class ExportAppUsers
 *
 * @package App\Nova\Actions
 */
class ExportAppUsers extends DownloadExcel
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Email',
            'Date of Birth',
            'Gender',
            'Avatar',
            'City',
            'Region',
            'Provider',
            'Status',
            'Email Verified At',
            'Last Login',
            'Deleted At',
            'Created At',
            'Updated At'
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        $avatar = $row->getAttribute('avatar') ?? '';

        if (Storage::exists($avatar) === true) {
            $avatar = Storage::url($avatar);
        }

        return [
            $row->getAttribute('id'),
            $row->getAttribute('first_name'),
            $row->getAttribute('last_name'),
            $row->getAttribute('email'),
            Carbon::parse($row->getAttribute('date_of_birth'))->toDateString(),
            $row->getAttribute('gender'),
            $avatar,
            $row->getAttribute('city'),
            $row->getAttribute('region'),
            $row->getAttribute('provider'),
            $this->getStatus($row),
            $row->getAttribute('email_verified_at'),
            $row->getAttribute('last_login'),
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

        if ($model->getAttribute('email_verified_at') === null || $model->getAttribute('active') === false) {
            return AppUserInterface::INACTIVE;
        }

        return AppUserInterface::ACTIVE;
    }
}
