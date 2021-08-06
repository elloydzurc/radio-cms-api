<?php
declare(strict_types=1);

namespace App\Http\Requests\AppUser;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\AppUser\UpdateAppUserDto;
use App\Http\Requests\AbstractFormRequest;
use App\Models\Interfaces\AppUserInterface;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

/**
 * Class UpdateAppUserRequest
 *
 * @package App\Http\Requests\AppUser
 */
final class UpdateAppUserRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', "regex:/^[a-z ,.'-]+$/i"],
            'last_name' => ['required', "regex:/^[a-z ,.'-]+$/i"],
            'gender' => ['required_if:screen,profile', Rule::in(\array_keys(AppUserInterface::GENDERS))],
            'date_of_birth' => ['required', 'date', 'date_format:Y-m-d', 'before:today'],
            'city' => ['required_if:screen,profile', 'string'],
            'region' => ['required_if:screen,profile', 'string'],
            'screen' => ['required', Rule::in('sso', 'profile')]
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
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'Invalid first name value.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Invalid last name value.',
            'gender.required_if' => 'Gender is required.',
            'gender.in' => 'Invalid gender value.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.date' => 'Invalid date of birth value.',
            'date_of_birth.date_format' => 'Invalid date of birth format.',
            'date_of_birth.before' => 'Date of birth should not be greater than today\'s date.',
            'city.required_if' => 'City is required.',
            'city.regex' => 'Invalid city value.',
            'region.required_if' => 'Region is required.',
            'region.regex' => 'Invalid region value.',
            'screen.required' => 'Screen type is required',
            'screen.in' => 'Invalid screen type value.',
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new UpdateAppUserDto($this);
    }
}
