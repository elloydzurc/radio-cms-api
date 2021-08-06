<?php
declare(strict_types=1);

namespace App\Nova\Rules;

use App\Models\Interfaces\AdInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class AdMediaResourceRequest
 *
 * @package App\Nova\Metrics
 */
class AdMediaSingleRule extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return self::ruleGetter($this);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param bool $exists
     *
     * @return array
     */
    public static function ruleGetter(Request $request, bool $exists = false): array
    {
        $rules = [];
        $filesCount = \count($request->allFiles());

        if ($filesCount > 0 || $exists === false) {
            $rules[] = 'required';
            $rules[] = 'image';
        }

        if ($filesCount > 0) {
            if ($request->get('type') === AdInterface::BANNER_AD) {
                $rules[] = 'dimensions:min_width=660,max_width=660,min_height=107,max_height=107';
            }

            if ($request->get('type') === AdInterface::POPUP_AD) {
                $rules[] = 'dimensions:min_width=600,max_width=600,min_height=900,max_height=900';
            }

            if ($request->get('type') === AdInterface::SLIDER_AD) {
                $rules[] = 'dimensions:min_width=660,max_width=660,min_height=199,max_height=199';
            }
        }

        return $rules;
    }
}
