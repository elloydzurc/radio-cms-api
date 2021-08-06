<?php
declare(strict_types=1);

namespace App\Services\Api\AppUser\Transformers;

use App\Models\AppUser;
use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class AppUserDetailsTransformer
 *
 * @package App\Services\Api\AppUser\Transformers
 */
class AppUserIndexTransformer extends TransformerAbstract
{
    /**
     * @param \App\Models\AppUser $appUser
     *
     * @return array
     */
    public function transform(AppUser $appUser): array
    {
        return [
            'id' => $appUser->getAttribute('id'),
            'name' => $appUser->getAttribute('name'),
            'avatar' => $appUser->getAttribute('avatar'),
        ];
    }
}