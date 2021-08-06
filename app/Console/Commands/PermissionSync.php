<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Cms\Interfaces\PermissionSyncerInterface;
use Illuminate\Console\Command;

/**
 * Class PermissionSync
 *
 * @package App\Console\Commands
 */
final class PermissionSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync CMS Permissions';

    /**
     * @var \App\Services\Cms\Interfaces\PermissionSyncerInterface
     */
    private PermissionSyncerInterface $permissionSyncer;

    /**
     * Create a new command instance.
     *
     * @param \App\Services\Cms\Interfaces\PermissionSyncerInterface $permissionSyncer
     */
    public function __construct(PermissionSyncerInterface $permissionSyncer)
    {
        $this->permissionSyncer = $permissionSyncer;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->permissionSyncer->sync();

        return 0;
    }
}
