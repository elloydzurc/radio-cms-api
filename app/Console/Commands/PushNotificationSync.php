<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Cms\Interfaces\PushNotificationSyncerInterface;
use Illuminate\Console\Command;

/**
 * Class PushNotificationSync
 *
 * @package App\Console\Commands
 */
final class PushNotificationSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push_notification:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Push Notification to Mobile';

    /**
     * @var \App\Services\Cms\Interfaces\PushNotificationSyncerInterface
     */
    private PushNotificationSyncerInterface $pushNotificationSyncer;

    /**
     * Create a new command instance.
     *
     * @param \App\Services\Cms\Interfaces\PushNotificationSyncerInterface $pushNotificationSyncer
     */
    public function __construct(PushNotificationSyncerInterface $pushNotificationSyncer)
    {
        $this->pushNotificationSyncer = $pushNotificationSyncer;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->pushNotificationSyncer->sync();

        return 0;
    }
}
