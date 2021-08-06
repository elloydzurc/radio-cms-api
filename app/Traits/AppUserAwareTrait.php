<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Carbon;

/**
 * Trait AppUserAwareTrait
 *
 * @package App\Traits
 */
trait AppUserAwareTrait
{
    use ConfigAwareTrait;

    /**
     * @return array
     */
    public function getAppUserAgeRestrictions(): array
    {
        $request = request();
        $ageRestrictions = $this->getConfig('cms.age_restrictions');

        $allowedContent = [];
        $age = 0;

        if ($request !== null && \is_array($ageRestrictions) === true && \count($ageRestrictions) >= 1) {
           $birthday = $request->user()->getAttribute('date_of_birth');

            if ($birthday !== null) {
                $age = Carbon::parse($birthday)->age;
            }

            foreach ($ageRestrictions as $ageRestriction) {
                if ($age >= $ageRestriction['minimum_age'] && $age <= $ageRestriction['maximum_age']) {
                    $allowedContent[] = $ageRestriction['code'];
                }
            }
        }

        return $allowedContent;
    }

    /**
     * @return int
     */
    public function getCurrentUserId(): int
    {
        $request = request();

        if ($request !== null) {
            return $request->user()->getAttribute('id');
        }

        return 0;
    }
}
