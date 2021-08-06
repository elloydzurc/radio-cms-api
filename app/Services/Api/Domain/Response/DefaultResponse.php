<?php
declare(strict_types=1);

namespace App\Services\Api\Domain\Response;

use App\Services\Api\Domain\Common\Serializers\DefaultSerializer;
use App\Services\Api\Domain\Response\Exceptions\InvalidTransformerClassException;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/**
 * Class DefaultResponse
 *
 * @package App\Services\Response
 */
final class DefaultResponse implements ResponseInterface
{
    /**
     * @var null|string
     */
    private ?string $customMessage = null;

    /**
     * @var $entity
     */
    private $entity = null;

    /**
     * @var \League\Fractal\Manager
     */
    private Manager $manager;

    /**
     * @var null|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private ?LengthAwarePaginator $paginator = null;

    /**
     * @var null|string
     */
    private ?string $transformerClass = null;

    /**
     * @var null|\League\Fractal\TransformerAbstract
     */
    private ?TransformerAbstract $transformer = null;

    /**
     * DefaultResponse constructor.
     *
     * @param $entity
     * @param null|string $transformerClass
     * @param null|\Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     * @param null|string $customMessage
     */
    public function __construct(
        $entity,
        ?string $transformerClass = null,
        ?LengthAwarePaginator $paginator = null,
        ?string $customMessage = null
    ) {
        $this->entity = $entity;
        $this->transformerClass = $transformerClass;
        $this->paginator = $paginator;
        $this->customMessage = $customMessage;

        /** @var \League\Fractal\Manager manager */
        $this->manager = app(Manager::class);
        $this->manager->setSerializer(new DefaultSerializer());
    }

    /**
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function getEntity(): ?Model
    {
        return ($this->entity instanceof Model) === true ? $this->entity : null;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Services\Api\Domain\Response\Exceptions\InvalidTransformerClassException
     */
    public function getEntityArray(): JsonResponse
    {
        $data = null;
        $message = $this->customMessage ?? 'Success.';
        $statusCode = Response::HTTP_OK;

        if ($this->transformerClass !== null) {
            try {
                $this->transformer = resolve($this->transformerClass);
            } catch (\Exception $exception) {
                throw new InvalidTransformerClassException(
                    trans('messages.domain.response.invalid_transformer_class', [
                        'class' => $this->transformerClass
                    ]),
                    0,
                    $exception
                );
            }

            $data = $this->entity instanceof Model === true ? $this->getItem() : $this->getCollection();

            if ($data === null) {
                $message = 'Not Found.';
                $statusCode = Response::HTTP_NOT_FOUND;
            }
        }

        return \response()->json(
            \array_merge(['message' => $message], $data ?? []),
            $statusCode
        );
    }

    /**
     * @return array
     */
    private function getItem(): array
    {
        /** @var Model $data */
        $data = $this->entity;
        $resource = new Item($data, $this->transformer, 'data');

        return $this->manager->createData($resource)
            ->toArray();
    }

    /**
     * @return null|array
     */
    private function getCollection(): ?array
    {
        /** @var \Illuminate\Support\Collection $data */
        $data = $this->entity;
        $resources = null;

        if ($data->isEmpty() === false) {
            $resources = new Collection($data, $this->transformer, 'data');

            if ($this->paginator !== null) {
                $resources->setPaginator(new IlluminatePaginatorAdapter($this->paginator));
            }

            $resources = $this->manager->createData($resources)
                ->toArray();
        }

        return $resources;
    }
}
