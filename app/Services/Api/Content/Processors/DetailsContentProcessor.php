<?php
declare(strict_types=1);

namespace App\Services\Api\Content\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Content\AbstractContentProcessor;
use App\Services\Api\Content\Exceptions\ContentApiException;
use App\Services\Api\Content\Interfaces\ContentProcessorInterface;
use App\Services\Api\Content\Transformers\ContentDetailsTransformer;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class DetailsContentProcessor
 *
 * @package App\Services\Api\Content\Processors
 */
final class DetailsContentProcessor extends AbstractContentProcessor implements ContentProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Content\Exceptions\ContentApiException
     * @var \App\Http\Dto\Common\DetailsRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $appUserId = $this->getCurrentUserId();

        $criteria = [
            'id' => $data->getId(),
            'active' => true,
            'deleted_at' => null,
        ];

        /** @var null|\App\Models\Content $stationContent */
        $stationContent = $this->contentRepository->findOneByCriteria(
            $criteria,
            ['program'],
            ['appUsers' => static function (Builder $query) use ($appUserId) {
                if ($appUserId !== null) {
                    $query->where('app_user_id', '=', $appUserId);
                }
            }]
        );

        if ($stationContent === null) {
            throw ContentApiException::notExists($data->getId());
        }

        if ($this->isModelActive($stationContent) === false) {
            throw ContentApiException::notExists($data->getId());
        }

        return new DefaultResponse($stationContent, ContentDetailsTransformer::class);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return ContentProcessorInterface::DETAILS_CONTENT_PROCESSOR === $processor;
    }
}
