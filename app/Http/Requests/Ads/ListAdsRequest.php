<?php
declare(strict_types=1);

namespace App\Http\Requests\Ads;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Ads\ListAdsDto;
use App\Http\Requests\AbstractFormRequest;
use App\Models\Interfaces\AdInterface;
use Illuminate\Validation\Rule;

/**
 * Class ListRequest
 *
 * @package App\Http\Requests
 */
final class ListAdsRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $section = $this->get('section');

        return [
            'section' => ['required', Rule::in(\array_keys(AdInterface::ALL_AD_SECTIONS))],
            'id' => [Rule::requiredIf(static function () use ($section) {
                return \in_array($section, [
                    AdInterface::CHANNEL_SECTION,
                    AdInterface::CONTENT_SECTION,
                    AdInterface::PROGRAM_SECTION,
                ], true);
            })],
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
            'section.required' => 'Section is required.',
            'section.in' => 'Invalid section value.',
            'id.required_if' => 'ID is required.'
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new ListAdsDto($this);
    }
}
