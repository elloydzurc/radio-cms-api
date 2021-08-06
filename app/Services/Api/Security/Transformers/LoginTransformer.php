<?php
declare(strict_types=1);

namespace App\Services\Api\Security\Transformers;

use App\Models\AppUser;
use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class LoginTransformer
 *
 * @package App\Services\Api\Security\Transformers
 */
class LoginTransformer extends TransformerAbstract
{
    /**
     * @param \App\Models\AppUser $appUser
     *
     * @return array
     */
    public function transform(AppUser $appUser): array
    {
        $dataOfBirth = $appUser->getAttribute('date_of_birth');

        if ($dataOfBirth !== null) {
            $dataOfBirth  = Carbon::parse($dataOfBirth)->toDateString();
        }

        return [
            'id' => $appUser->getAttribute('id'),
            'name' => $appUser->getAttribute('name'),
            'first_name' => $appUser->getAttribute('first_name'),
            'last_name' => $appUser->getAttribute('last_name'),
            'date_of_birth' => $dataOfBirth,
            'email' => $appUser->getAttribute('email'),
            'avatar' => $appUser->getAttribute('avatar'),
            'token' => $appUser->getAttribute('token'),
            'password_expired' => $appUser->getAttribute('password_expired')
        ];
    }
}