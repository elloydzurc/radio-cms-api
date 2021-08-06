<?php
declare(strict_types=1);

namespace App\Services\Api\AppUser\Transformers;

use App\Models\PushNotification;
use App\Services\Api\Content\Transformers\ContentIndexTransformer;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\TransformerAbstract;

/**
 * Class AppUserInboxTransformer
 *
 * @package App\Services\Api\AppUser\Transformers
 */
class AppUserInboxTransformer extends TransformerAbstract
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'content'
    ];

    /**
     * @param \App\Models\PushNotification $pushNotification
     *
     * @return array
     */
    public function transform(PushNotification $pushNotification): array
    {
        return [
            'id' => $pushNotification->getAttribute('id'),
            'name' => $pushNotification->getAttribute('name'),
            'description' => $pushNotification->getAttribute('description'),
            'trigger_datetime' => $pushNotification->getAttribute('trigger_datetime'),
            'active' => $pushNotification->getAttribute('active'),
        ];
    }

    /**
     * @param \App\Models\PushNotification $pushNotification
     *
     * @return \League\Fractal\Resource\ResourceAbstract
     */
    public function includeContent(PushNotification $pushNotification): ResourceAbstract
    {
        $resource = $this->null();
        $content = $pushNotification->getRelation('content');

        if ($content !== null) {
            $resource = $this->item($content, new ContentIndexTransformer());
        }

        return $resource;
    }
}
