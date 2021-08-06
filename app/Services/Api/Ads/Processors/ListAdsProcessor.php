<?php
declare(strict_types=1);

namespace App\Services\Api\Ads\Processors;

use App\Http\Dto\AbstractDto;
use App\Models\Interfaces\AdInterface;
use App\Services\Api\Ads\AbstractAdsProcessor;
use App\Services\Api\Ads\Interfaces\AdsProcessorInterface;
use App\Services\Api\Ads\Transformers\AdsDetailsTransformer;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ListAdsProcessor
 *
 * @package App\Services\Api\Ads\Processors
 */
final class ListAdsProcessor extends AbstractAdsProcessor implements AdsProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Ads\ListAdsDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $ads = $this->adsGenerator($this->adsRepository->listAds($data));

        return new DefaultResponse($ads, AdsDetailsTransformer::class);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return AdsProcessorInterface::LIST_ADS_PROCESSOR === $processor;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $ads
     *
     * @return \Illuminate\Support\Collection
     */
    private function adsGenerator(Collection $ads): \Illuminate\Support\Collection
    {
        $presentAdTypes = [];
        $presentAds = collect();

        /** @var \App\Models\Ad $ad */
        foreach ($ads as $ad) {
            $type = $ad->getAttribute('type');

            if (\in_array($type, $presentAdTypes, true) === false) {
                $presentAds->push($ad);
                $presentAdTypes[] = $type;
            }
        }

        return $presentAds;
    }
}
