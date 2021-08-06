<?php
declare(strict_types=1);

namespace App\Services\Api\Program\Interfaces;

use App\Services\Api\Domain\Common\Interfaces\ProcessorInterface;

/**
 * Interface ProgramProcessorInterface
 *
 * @package App\Services\Api\Program\Interfaces
 */
interface ProgramProcessorInterface extends ProcessorInterface
{
    /**
     * @var string
     */
    public const DETAILS_PROGRAM_PROCESSOR = 'details_program';

    /**
     * @var string
     */
    public const FEATURED_CONTENT_PROGRAM_PROCESSOR = 'featured_content_program';

    /**
     * @var string
     */
    public const LIST_PROGRAM_PROCESSOR = 'list_program';


    /**
     * @var string
     */
    public const LIST_STATION_PROGRAM_PROCESSOR = 'list_station_program';
}