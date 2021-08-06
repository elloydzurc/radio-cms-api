<?php
declare(strict_types=1);

namespace App\Services\Api\Content;

use App\Repositories\Api\Interfaces\ContentRepositoryInterface;
use App\Traits\AppConfigurationAwareTrait;
use App\Traits\AppUserAwareTrait;
use App\Traits\ModelStatusAwareTrait;

/**
 * Class AbstractContentContentProcessor
 *
 * @package App\Services\Api\ContentContent
 */
abstract class AbstractContentProcessor
{
    use AppConfigurationAwareTrait, AppUserAwareTrait, ModelStatusAwareTrait;

    /**
     * @var \App\Repositories\Api\Interfaces\ContentRepositoryInterface
     */
    protected ContentRepositoryInterface $contentRepository;

    /**
     * AbstractSecurityProcessor constructor.
     *
     * @param \App\Repositories\Api\Interfaces\ContentRepositoryInterface $contentRepository
     */
    public function __construct(ContentRepositoryInterface $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }
}
