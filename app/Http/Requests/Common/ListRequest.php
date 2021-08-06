<?php
declare(strict_types=1);

namespace App\Http\Requests\Common;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Common\ListRequestDto;
use App\Http\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ListRequest
 *
 * @package App\Http\Requests
 */
final class ListRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'slug' => ['filled'],
            'page' => ['filled', 'numeric'],
            'perPage' => ['filled', 'numeric'],
            'sortOrder' => ['filled', Rule::in(['asc', 'desc'])]
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
            'page.numeric' => 'Invalid page value.',
            'perPage.numeric' => 'Invalid perPage value.',
            'sortOrder.in' => 'Invalid sort order value.'
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new ListRequestDto($this);
    }
}
