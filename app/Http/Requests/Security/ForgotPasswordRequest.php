<?php
declare(strict_types=1);

namespace App\Http\Requests\Security;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Security\ForgotPasswordRequestDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class ForgotPasswordRequest
 *
 * @package App\Http\Requests\Security
 */
final class ForgotPasswordRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email']
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
            'email.required' => 'Email is required!',
            'email.email' => 'Email is invalid!'
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new ForgotPasswordRequestDto($this);
    }
}
