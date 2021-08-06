<?php
declare(strict_types=1);

namespace App\Traits;

/**
 * Trait ImageAwareTrait
 *
 * @package App\Traits
 */
trait ImageAwareTrait
{
    use ConfigAwareTrait;

    /**
     * @return string
     */
    public function getDefaultDimensions(): string
    {
        $imageConfig = $this->getConfig('cms.avatar_logo_thumbnail');

        return $imageConfig['dimensions'];
    }

    /**
     * @return string
     */
    public function getDefaultFileTypes(): string
    {
        $imageConfig = $this->getConfig('cms.avatar_logo_thumbnail');

        return $imageConfig['allowed_file_type'];
    }

    /**
     * @return string
     */
    public function getDefaultImage(): string
    {
        return asset('images/default-transparent.png');
    }

    /**
     * @return string
     */
    public function getDefaultStorage(): string
    {
        return (string)$this->getConfig('filesystems.default');
    }

    /**
     * @return array
     */
    public function getImageCreationRules(): array
    {
        $imageConfig = $this->getConfig('cms.avatar_logo_thumbnail');

        return [
            'dimensions:' . $imageConfig['dimensions'],
            'mimes:' . $imageConfig['allowed_file_type']
        ];
    }
}
