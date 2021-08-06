<?php
declare(strict_types=1);

namespace App\Services\Api\Program\Transformers;

use App\Models\Program;
use App\Traits\ImageAwareTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

/**
 * Class ProgramDetailsTransformer
 *
 * @package App\Services\Api\Program\Transformers
 */
class ProgramDetailsTransformer extends TransformerAbstract
{
    use ImageAwareTrait;

    /**
     * @param \App\Models\Program $program
     *
     * @return array
     */
    public function transform(Program $program): array
    {
        $thumbnail = $program->getAttribute('thumbnail') ?? $this->getDefaultImage();

        if (Storage::exists($thumbnail) === true) {
            $thumbnail = Storage::url($thumbnail);
        }

        return [
            'id' => $program->getAttribute('id'),
            'name' => $program->getAttribute('name'),
            'description' => $program->getAttribute('description'),
            'thumbnail' => $thumbnail,
            'active' => $program->getAttribute('active'),
            'created_at' => Carbon::parse($program->getAttribute('created_at'))->toDateTimeString(),
            'updated_at' => Carbon::parse($program->getAttribute('updated_at'))->toDateTimeString(),
        ];
    }
}
