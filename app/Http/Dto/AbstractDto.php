<?php
declare(strict_types=1);

namespace App\Http\Dto;

use App\Traits\DataTypeAwareTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * Class AbstractRequestData
 *
 * @package App\Http\Dto
 */
abstract class AbstractDto
{
    use DataTypeAwareTrait;

    /**
     * @param \Illuminate\Foundation\Http\FormRequest $formRequest
     *
     * @throws UnableToParseRequestDataException
     */
    public function __construct(FormRequest $formRequest)
    {
        try {
            $formData = $formRequest->all();
            $reflection = new \ReflectionClass($this);

            foreach ($formData as $property => $data) {
                $property = Str::camel((string)$property);

                if ($reflection->hasProperty($property) === false) {
                    continue;
                }

                $property = $reflection->getProperty($property);

                if ($property instanceof \ReflectionProperty === true) {
                    $propertyType = $property->getType();
                    $property->setAccessible(true);

                    if ($propertyType !== null) {
                        $property->setValue(
                            $this,
                            $this->convert($propertyType->getName(), $data)
                        );
                    }
                }
            }
        } catch (\ReflectionException $exception) {
            throw new UnableToParseRequestDataException(trans(
                'exception.http.data.unable_to_parse',
                ['data' => $exception->getMessage()]
            ));
        }
    }
}
