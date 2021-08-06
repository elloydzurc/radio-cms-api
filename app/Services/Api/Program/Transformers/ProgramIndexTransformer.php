<?php
declare(strict_types=1);

namespace App\Services\Api\Program\Transformers;

use App\Models\Program;
use App\Traits\ImageAwareTrait;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

/**
 * Class ProgramIndexTransformer
 *
 * @package App\Services\Api\Program\Transformers
 */
class ProgramIndexTransformer extends TransformerAbstract
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
            'contents_count' => $program->getAttribute('contents_count'),
            'thumbnail' => $thumbnail
        ];
    }
}
