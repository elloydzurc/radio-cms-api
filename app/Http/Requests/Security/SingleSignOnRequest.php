<?php
declare(strict_types=1);

namespace App\Http\Requests\Security;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Security\SingleSignOnRequestDto;
use App\Http\Requests\AbstractFormRequest;
use App\Models\Interfaces\AppUserInterface;
use Illuminate\Validation\Rule;

/**
 * Class SignUpRequest
 *
 * @package App\Http\Requests\Security
 */
final class SingleSignOnRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'provider' => ['required', Rule::in(\array_keys(AppUserInterface::PROVIDERS_SOCIAL_MEDIA))],
            'access_token' => ['required'],
            'device_id' => ['required'],
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
            'provider.required' => 'Provider is required.',
            'provider.in' => 'Invalid provider value.',
            'access_token.required' => 'Access token is required.',
            'device_id.required' => 'Device ID token is required.',
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new SingleSignOnRequestDto($this);
    }
}
