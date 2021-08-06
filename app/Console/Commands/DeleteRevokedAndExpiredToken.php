<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\Api\Interfaces\TokenRepositoryInterface;
use Illuminate\Console\Command;

/**
 * Class DeleteRevokedAndExpiredToken
 *
 * @package App\Console\Commands
 */
final class DeleteRevokedAndExpiredToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:delete-revoked-and-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Expired Token';

    /**
     * @var \App\Repositories\Api\Interfaces\TokenRepositoryInterface
     */
    private TokenRepositoryInterface $tokenRepository;

    /**
     * Create a new command instance.
     *
     * @param \App\Repositories\Api\Interfaces\TokenRepositoryInterface $tokenRepository
     */
    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        parent::__construct();

        $this->tokenRepository = $tokenRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->tokenRepository->deleteRevokedTokens();

        $this->tokenRepository->deleteExpiredTokens();

        return 0;
    }
}
