<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\ReportInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Report
 *
 * @package App\Models
 */
class Report extends Model implements ReportInterface
{
    /**
     * @var string
     */
    protected $table = 'reports';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appUsers(): HasMany
    {
        return $this->hasMany(AppUser::class, 'report_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class, 'report_id', 'id')
                ->with(['program' => function (BelongsTo $query) {
                    $query->withTrashed();
                }]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'report_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stations(): HasMany
    {
        return $this->hasMany(Station::class, 'report_id', 'id');
    }
}
