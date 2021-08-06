<?php
declare(strict_types=1);

namespace App\Http\Requests\Common;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Common\DetailsRequestDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class DetailsRequest
 *
 * @package App\Http\Requests\Common
 */
final class DetailsRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric']
        ];
    }

    /**
     * Custom validation error messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id.required' => 'Resource ID is required.',
            'id.numeric' => 'Invalid resource ID value',
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new DetailsRequestDto($this);
    }
}
