<?php
declare(strict_types=1);

use App\Http\Controllers\Api\AdsController;
use App\Http\Controllers\Api\AppUserController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\SecurityController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\StationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

### Security ###
Route::group(['prefix' => 'user'], function () {
    Route::post('/forgot-password', [SecurityController::class, 'forgotPassword'])
        ->name('security.forgot_password');

    Route::post('/login', [SecurityController::class, 'login'])
        ->name('security.login');

    Route::post('/signup', [SecurityController::class, 'signUp'])
        ->name('security.signup');

    Route::post('/sso', [SecurityController::class, 'singleSignOn'])
        ->name('security.single_sign_on');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/change-password', [SecurityController::class, 'changePassword'])
            ->name('security.change_password');

        Route::post('/logout', [SecurityController::class, 'logout'])
            ->name('security.logout');
    });
});

### Station ###
Route::group(['prefix' => 'stations', 'middleware' => 'auth:api'], function () {
    Route::get('/', [StationController::class, 'listStation'])
        ->name('station.list');

    Route::get('/featured', [StationController::class, 'featuredStation'])
        ->name('station.featured');

    Route::get('/featured-content', [StationController::class, 'featuredContentStation'])
        ->name('station.featured.content');

    Route::get('/tune-in/{stationId}', [StationController::class, 'tuneInStation'])
        ->name('station.tune.in');

    Route::get('/{stationId}/programs', [ProgramController::class, 'listStationProgram'])
        ->name('station.programs');

    Route::get('/{stationId}', [StationController::class, 'detailsStation'])
        ->name('station.details');
});

### Program ###
Route::group(['prefix' => 'programs', 'middleware' => 'auth:api'], function () {
    Route::get('/', [ProgramController::class, 'listProgram'])
        ->name('program.list');

    Route::get('/featured-content', [ProgramController::class, 'featuredContentProgram'])
        ->name('program.featured.content');

    Route::get('/{programId}/contents', [ContentController::class, 'listProgramContent'])
        ->name('programs.content.list');

    Route::get('/{programId}', [ProgramController::class, 'detailsProgram'])
        ->name('program.details');
});

### Content ###
Route::group(['prefix' => 'contents', 'middleware' => 'auth:api'], function () {
    Route::get('/{contentId}', [ContentController::class, 'detailsContent'])
        ->name('content.details');

    Route::get('/{contentId}/tune-in', [ContentController::class, 'tuneInContent'])
        ->name('content.tune-in');
});

### Playlist ###
Route::group(['prefix' => 'playlists', 'middleware' => 'auth:api'], function () {
    Route::post('/', [PlaylistController::class, 'createPlaylist'])
        ->name('playlist.create');

    Route::put('/', [PlaylistController::class, 'updatePlaylist'])
        ->name('playlist.update');

    Route::delete('/', [PlaylistController::class, 'deletePlaylist'])
        ->name('playlist.delete');

    Route::get('/', [PlaylistController::class, 'listPlaylist'])
        ->name('playlist.list');

    Route::get('/{playlistId}/contents', [PlaylistController::class, 'contentsPlaylist'])
        ->name('playlist.contents');

    Route::get('/{playlistId}', [PlaylistController::class, 'detailsPlaylist'])
        ->name('playlist.details');

    Route::post('/add-content', [PlaylistController::class, 'addContentToPlaylist'])
        ->name('playlist.add.content');

    Route::post('/remove-content', [PlaylistController::class, 'removeContentToPlaylist'])
        ->name('playlist.remove.content');
});

### App User ###
Route::group(['prefix' => 'app-users', 'middleware' => 'auth:api'], function () {
    Route::get('/me', [AppUserController::class, 'detailsAppUser'])
        ->name('app.user.details');

    Route::get('/inbox', [AppUserController::class, 'inboxAppUser'])
        ->name('app.user.inbox');

    Route::put('/me', [AppUserController::class, 'updateAppUser'])
        ->name('app.user.update');

    Route::post('/avatar', [AppUserController::class, 'uploadAvatarAppUser'])
        ->name('app.user.upload.avatar');

    Route::post('/device', [AppUserController::class, 'addDeviceAppUser'])
        ->name('app.user.add.device');

    Route::delete('/device', [AppUserController::class, 'deleteDeviceAppUser'])
        ->name('app.user.delete.device');

    Route::post('/favorites', [AppUserController::class, 'addFavoriteAppUser'])
        ->name('app.user.add.favorites');

    Route::delete('/favorites', [AppUserController::class, 'deleteFavoriteAppUser'])
        ->name('app.user.delete.favorites');

    Route::get('/favorites', [AppUserController::class, 'listFavoriteAppUser'])
        ->name('app.user.list.favorites');
});

### Ads ###
Route::group(['prefix' => 'ads', 'middleware' => 'auth:api'], function () {
    Route::get('/', [AdsController::class, 'listAds'])
        ->name('ads.list');
});

### Comments ###
Route::group(['prefix' => 'comments', 'middleware' => 'auth:api'], function () {
    Route::get('/', [CommentController::class, 'listComment'])
        ->name('comment.list');

    Route::post('/', [CommentController::class, 'postComment'])
        ->name('comment.post');
});
