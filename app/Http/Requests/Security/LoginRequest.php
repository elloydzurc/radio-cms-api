<?php
declare(strict_types=1);

namespace App\Http\Requests\Security;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Security\LoginRequestDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class LoginRequest
 *
 * @package App\Http\Requests\Security
 */
final class LoginRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
            'device_id' => ['required'],
        ];
    }

    /**
     * Custom validation error messages
     *
     * @return array
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required!',
            'email.email' => 'Email is invalid!',
            'password.required' => 'Password is required!',
            'device_id.required' => 'Device ID is required!',
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new LoginRequestDto($this);
    }
}
