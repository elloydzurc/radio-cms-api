<?php
declare(strict_types=1);

namespace App\Nova\Rules;

use App\Models\Interfaces\AdInterface;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

/**
 * Class AdMediaRule
 *
 * @package App\Nova\Metrics
 */
class AdMediaSizeRule implements Rule
{
    /**
     * @var bool
     */
    private bool $exists;

    /**
     * @var \Illuminate\Http\Request
     */
    private Request $request;

    /**
     * @var string|null
     */
    private ?string $message = null;

    /**
     * AdMediaSizeRule constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @param bool $exists
     */
    public function __construct(Request $request, bool $exists)
    {
        $this->request = $request;
        $this->exists = $exists;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $passed = true;
        $fileCount = \count($this->request->allFiles()['__media__']['assets'] ?? []);
        $type = $this->request->get('type');
        $singleAssetAd = [
            AdInterface::BANNER_AD,
            AdInterface::POPUP_AD,
        ];

        if ($this->exists === false && $fileCount > 1 && \in_array($type, $singleAssetAd, true)) {
            $this->message = \sprintf('The %s image should be limited to 1', $type);
            $passed = false;
        }

        if ($this->exists === true && $fileCount > 0 && \in_array($type, $singleAssetAd, true)) {
            $this->message = \sprintf('The %s image should be limited to 1', $type);
            $passed = false;
        }

        if ($this->exists === false && $fileCount < 1) {
            $this->message = \sprintf('The %s image is required.', $type);
            $passed = false;
        }

        return $passed;
    }

    /**
     * @return null|string
     */
    public function message(): ?string
    {
        return $this->message;
    }
}
