<?php
declare(strict_types=1);

namespace App\Http\Requests\Security;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Security\SignUpRequestDto;
use App\Http\Requests\AbstractFormRequest;
use App\Traits\PasswordAwareTrait;
use Illuminate\Validation\Rule;

/**
 * Class SignUpRequest
 *
 * @package App\Http\Requests\Security
 */
final class SignUpRequest extends AbstractFormRequest
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                $this->getPasswordValidation(),
            ],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            // 'city' => ['string'],
            // 'region' => ['string']
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
            'first_name.required' => 'First name is required!',
            'last_name.required' => 'Last name is required!',
            'email.required' => 'Email is required!',
            'email.email' => 'Invalid email value!',
            'password.required' => 'Password is required!',
            'password.confirmed' => 'Password confirmation failed!',
            'password.min' => 'Password should be minimum 8 of characters!',
            'password.regex' => 'Password should contain 1 uppercase, 1 number and 1 special character!',
            'date_of_birth.required' => 'Date of birth is required!',
            'date_of_birth.date' => 'Invalid date of birth value!',
            'gender.required' => 'Gender is required!',
            'gender.in' => 'Invalid gender value!',
            // 'city.required' => 'City is required!',
            // 'region.required' => 'Region is required!'
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new SignUpRequestDto($this);
    }
}
