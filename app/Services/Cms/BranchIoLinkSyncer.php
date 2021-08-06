<?php
declare(strict_types=1);

namespace App\Services\Cms;

use App\Models\Content;
use App\Repositories\Cms\Interfaces\PermissionRepositoryInterface;
use App\Services\Cms\Interfaces\BranchIoLinkSyncerInterface;
use Iivannov\Branchio\Client;
use Iivannov\Branchio\Exceptions\BranchioNotFoundException;
use Iivannov\Branchio\Link;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

/**
 * Class BranchIoLinkSyncer
 *
 * @package App\Services\Cms
 */
final class BranchIoLinkSyncer implements BranchIoLinkSyncerInterface
{
    /**
     * @var array
     */
    private array $branchIoLinks;

    /**
     * @var string
     */
    private string $branchIoKey;

    /**
     * @var string
     */
    private string $branchIoSecret;

    /**
     * @var \Iivannov\Branchio\Client
     */
    private Client $client;

    /**
     * BranchIoLinkSyncer constructor.
     *
     * @param string $branchIoKey
     * @param string $branchIoSecret
     * @param array $branchIoLinks
     */
    public function __construct(string $branchIoKey, string $branchIoSecret, array $branchIoLinks)
    {
        $this->branchIoKey = $branchIoKey;
        $this->branchIoSecret = $branchIoSecret;
        $this->branchIoLinks = $branchIoLinks;

        $this->initClient();
    }

    /**
     * @param \App\Models\Content $content
     *
     * @throws \Throwable
     */
    public function sync(Content $content): void
    {
        $contentId = $content->getAttribute('id');
        $linkUrl = \sprintf('https://%s/%d', $this->branchIoLinks['domain'], $contentId);

        $data = [
            '$og_title' => $content->getAttribute('name'),
            '$marketing_title' => $content->getAttribute('name'),
            '$og_description' => $content->getAttribute('description'),
            '$og_image_url' => Storage::url($content->getAttribute('thumbnail')),
            '$android_url' => $this->branchIoLinks['android'],
            '$ios_url' => $this->branchIoLinks['ios'],
            '$desktop_url' => $this->branchIoLinks['desktop'],
            '$deeplink_path' => (string)$contentId,
            '$uri_redirect_mode' => 2,
            '$content_type' => $content->getAttribute('format'),
            'url' => $linkUrl,
            '+url' => $linkUrl,
            '$one_time_use' => false,
            '$android_deepview' => $this->branchIoLinks['android'],
            '$ios_deepview' => $this->branchIoLinks['ios'],
            '$desktop_deepview' => $this->branchIoLinks['desktop'],
            '~marketing' => true,
            '~feature' => 'marketing',
            '~creation_source' => 0
        ];

        try {
            $link = $this->client->getLink($linkUrl);
            $link->setData($data);
            $this->client->updateLink($linkUrl, $link);
        } catch (BranchioNotFoundException $exception) {
            $link = (new Link())
                ->setAlias((string)$contentId)
                ->setData($data)
                ->setFeature('marketing')
                ->setType(2);
            $this->client->createLink($link);
        }
    }

    /**
     * Initialize client
     */
    private function initClient(): void
    {
        $this->client = new Client($this->branchIoKey, $this->branchIoSecret);
    }
}
