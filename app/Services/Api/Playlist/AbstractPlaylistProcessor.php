<?php
declare(strict_types=1);

namespace App\Services\Api\Playlist;

use App\Repositories\Api\Interfaces\PlaylistRepositoryInterface;
use App\Repositories\Api\Interfaces\ContentRepositoryInterface;
use App\Traits\AppUserAwareTrait;
use App\Traits\ModelStatusAwareTrait;

/**
 * Class AbstractPlaylistProcessor
 *
 * @package App\Services\Api\Playlist
 */
abstract class AbstractPlaylistProcessor
{
    use AppUserAwareTrait, ModelStatusAwareTrait;

    /**
     * @var \App\Repositories\Api\Interfaces\PlaylistRepositoryInterface
     */
    protected PlaylistRepositoryInterface $playlistRepository;

    /**
     * @var \App\Repositories\Api\Interfaces\ContentRepositoryInterface
     */
    protected ContentRepositoryInterface $stationContentRepository;

    /**
     * AbstractSecurityProcessor constructor.
     *
     * @param \App\Repositories\Api\Interfaces\PlaylistRepositoryInterface $playlistRepository
     * @param \App\Repositories\Api\Interfaces\ContentRepositoryInterface $stationContentRepository
     */
    public function __construct(
        PlaylistRepositoryInterface $playlistRepository,
        ContentRepositoryInterface $stationContentRepository
    ) {
        $this->playlistRepository = $playlistRepository;
        $this->stationContentRepository = $stationContentRepository;
    }
}
