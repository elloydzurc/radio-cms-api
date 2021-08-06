<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Api\Interfaces\AppUserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

/**
 * Class VerifyEmailController
 *
 * @package App\Http\Controllers\Cms\Auth
 */
class AppUserVerifyEmailController extends Controller
{
    /**
     * @var \App\Repositories\Api\Interfaces\AppUserRepositoryInterface
     */
    private AppUserRepositoryInterface $appUserRepository;

    /**
     * AppUserVerifyEmailController constructor.
     *
     * @param \App\Repositories\Api\Interfaces\AppUserRepositoryInterface $appUserRepository
     */
    public function __construct(AppUserRepositoryInterface $appUserRepository)
    {
        $this->appUserRepository = $appUserRepository;
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $view = view('auth.app-user-verify-email-failed');

        if (! hash_equals((string) $request->route('hash'), sha1((string) $request->route('id')))) {
            return $view;
        }

        if ($this->appUserRepository->verifiedAppUser((int)$request->route('id')) === null) {
            return $view;
        }

        return Redirect::away(\config('cms.app_mobile_url'));
    }
}
