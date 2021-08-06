<?php
declare(strict_types=1);

namespace App\Http\Requests\Common;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Common\EmptyRequestDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class ListRequest
 *
 * @package App\Http\Requests
 */
final class EmptyRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Custom validation error messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new EmptyRequestDto($this);
    }
}
