<?php
declare(strict_types=1);

namespace App\Services\Api\Program;

use App\Repositories\Api\Interfaces\ContentRepositoryInterface;
use App\Repositories\Api\Interfaces\ProgramRepositoryInterface;
use App\Repositories\Api\Interfaces\StationRepositoryInterface;
use App\Traits\AppUserAwareTrait;
use App\Traits\ModelStatusAwareTrait;

/**
 * Class AbstractProgramProcessor
 *
 * @package App\Services\Api\Program
 */
abstract class AbstractProgramProcessor
{
    use AppUserAwareTrait, ModelStatusAwareTrait;

    /**
     * @var \App\Repositories\Api\Interfaces\ContentRepositoryInterface
     */
    protected ContentRepositoryInterface $contentRepository;

    /**
     * @var \App\Repositories\Api\Interfaces\ProgramRepositoryInterface
     */
    protected ProgramRepositoryInterface $programRepository;

    /**
     * @var \App\Repositories\Api\Interfaces\StationRepositoryInterface
     */
    protected StationRepositoryInterface $stationRepository;

    /**
     * AbstractSecurityProcessor constructor.
     *
     * @param \App\Repositories\Api\Interfaces\ContentRepositoryInterface $contentRepository
     * @param \App\Repositories\Api\Interfaces\ProgramRepositoryInterface $programRepository
     * @param \App\Repositories\Api\Interfaces\StationRepositoryInterface $stationRepository
     */
    public function __construct(
        ContentRepositoryInterface $contentRepository,
        ProgramRepositoryInterface $programRepository,
        StationRepositoryInterface $stationRepository
    ) {
        $this->contentRepository = $contentRepository;
        $this->programRepository = $programRepository;
        $this->stationRepository = $stationRepository;
    }
}
