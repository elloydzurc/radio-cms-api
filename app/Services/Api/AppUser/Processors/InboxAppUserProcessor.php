<?php
declare(strict_types=1);

namespace App\Services\Api\AppUser\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\AppUser\AbstractAppUserProcessor;
use App\Services\Api\AppUser\Interfaces\AppUserProcessorInterface;
use App\Services\Api\AppUser\Transformers\AppUserInboxTransformer;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;

/**
 * Class AddDeviceAppUserProcessor
 *
 * @package App\Services\Api\AppUser\Processors
 */
final class InboxAppUserProcessor extends AbstractAppUserProcessor implements AppUserProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $paginator = $this->pushNotificationRepository->listSentPushNotification($data);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, AppUserInboxTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return AppUserProcessorInterface::INBOX_APP_USER_PROCESSOR === $processor;
    }
}
