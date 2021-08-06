<?php
declare(strict_types=1);

namespace App\Http\Requests\AppUser;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\AppUser\DeviceAppUserDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class AddDeviceAppUserRequest
 *
 * @package App\Http\Requests\AppUser
 */
final class DeviceAppUserRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric'],
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
            'id.required' => 'App User ID is required',
            'id.numeric' => 'Invalid App user ID value.',
            'device_id.required' => 'Device ID is required.',
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new DeviceAppUserDto($this);
    }
}
