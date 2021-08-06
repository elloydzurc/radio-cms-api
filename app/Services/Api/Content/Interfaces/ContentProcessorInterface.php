<?php
declare(strict_types=1);

namespace App\Services\Api\Content\Interfaces;

use App\Services\Api\Domain\Common\Interfaces\ProcessorInterface;

/**
 * Interface ContentProcessorInterface
 *
 * @package App\Services\Api\Content\Interfaces
 */
interface ContentProcessorInterface extends ProcessorInterface
{
    /**
     * @var string
     */
    public const DETAILS_CONTENT_PROCESSOR = 'details_content';

    /**
     * @var string
     */
    public const LIST_PROGRAM_CONTENT_PROCESSOR = 'list_program_content';

    /**
     * @var string
     */
    public const TUNE_IN_CONTENT_PROCESSOR = 'tune_in_content';
}