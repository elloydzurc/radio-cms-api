<?php
declare(strict_types=1);

namespace App\Http\Requests\Security;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Security\ChangePasswordRequestDto;
use App\Http\Requests\AbstractFormRequest;
use App\Traits\PasswordAwareTrait;

/**
 * Class ForgotPasswordRequest
 *
 * @package App\Http\Requests\Security
 */
final class ChangePasswordRequest extends AbstractFormRequest
{
    use PasswordAwareTrait;

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
            'new_password' => [
                'required',
                'confirmed',
                $this->getPasswordValidation(),
            ],
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
            'email.email' => 'Email is invalid!',
            'password.required' => 'Password is required',
            'new_password.required' => 'New password is required!',
            'new_password.confirmed' => 'New password confirmation failed!',
            'new_password.min' => 'New password should be minimum 8 of characters!',
            'new_password.regex' => 'New password should contain 1 uppercase, 1 number and 1 special character!',
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new ChangePasswordRequestDto($this);
    }
}
