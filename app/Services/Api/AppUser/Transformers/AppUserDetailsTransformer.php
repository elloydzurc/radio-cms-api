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
class AppUserDetailsTransformer extends TransformerAbstract
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
            'first_name' => $appUser->getAttribute('first_name'),
            'last_name' => $appUser->getAttribute('last_name'),
            'date_of_birth' => Carbon::parse($appUser->getAttribute('date_of_birth'))->toDateString(),
            'gender' => $appUser->getAttribute('gender'),
            'email' => $appUser->getAttribute('email'),
            'avatar' => $appUser->getAttribute('avatar'),
            'city' => $appUser->getAttribute('city'),
            'region' => $appUser->getAttribute('region'),
        ];
    }
}