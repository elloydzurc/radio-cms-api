<?php
declare(strict_types=1);

namespace App\Http\Controllers\Cms;

use App\Events\Cms\LastLoginEvent;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Controllers\LoginController;

/**
 * Class RadyoNowLoginController
 *
 * @package App\Http\Controllers\Cms
 */
class RadyoNowLoginController extends LoginController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     *
     * @return mixed|void
     */
    protected function authenticated(Request $request, $user)
    {
        LastLoginEvent::dispatch($user);
    }
}
