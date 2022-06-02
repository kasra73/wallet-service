<?php

namespace App\Providers;

use App\Internal\Repositories\TransactionRepository;
use App\Internal\Repositories\TransactionRepositoryInterface;
use App\Internal\Repositories\WalletRepository;
use App\Internal\Repositories\WalletRepositoryInterface;
use App\Internal\Services\LockService;
use App\Internal\Services\LockServiceInterface;
use App\Internal\Services\MathService;
use App\Internal\Services\MathServiceInterface;
use App\Internal\Services\UuidFactoryService;
use App\Internal\Services\UuidFactoryServiceInterface;
use App\Services\AtomicService;
use App\Services\AtomicServiceInterface;
use App\Services\ConsistencyService;
use App\Services\ConsistencyServiceInterface;
use App\Services\PrepareService;
use App\Services\PrepareServiceInterface;
use App\Services\TransactionProcessorService;
use App\Services\TransactionProcessorServiceInterface;
use App\Services\TransactionService;
use App\Services\TransactionServiceInterface;
use App\Services\WalletService;
use App\Services\WalletServiceInterface;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


final class WalletServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @codeCoverageIgnore
     */

    public function boot(): void
    {
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->commands([TransferFixCommand::class]);

        $this->internal([]);
        $this->services([], []);
        $this->repositories([]);
    }


    private function repositories(array $configure): void
    {
        $this->app->singleton(
            TransactionRepositoryInterface::class,
            $configure['transaction'] ?? TransactionRepository::class
        );

        // $this->app->singleton(
        //     TransferRepositoryInterface::class,
        //     $configure['transfer'] ?? TransferRepository::class
        // );

        $this->app->singleton(WalletRepositoryInterface::class, $configure['wallet'] ?? WalletRepository::class);
    }


    private function internal(array $configure): void
    {
    //     $this->app->bind(StorageServiceInterface::class, $configure['storage'] ?? StorageService::class);

        // $this->app->singleton(ClockServiceInterface::class, $configure['clock'] ?? ClockService::class);
    //     $this->app->singleton(DatabaseServiceInterface::class, $configure['database'] ?? DatabaseService::class);
    //     $this->app->singleton(DispatcherServiceInterface::class, $configure['dispatcher'] ?? DispatcherService::class);
    //     $this->app->singleton(JsonServiceInterface::class, $configure['json'] ?? JsonService::class);
        $this->app->singleton(LockServiceInterface::class, $configure['lock'] ?? LockService::class);
        $this->app->singleton(MathServiceInterface::class, $configure['math'] ?? MathService::class);
    //     $this->app->singleton(TranslatorServiceInterface::class, $configure['translator'] ?? TranslatorService::class);
        $this->app->singleton(UuidFactoryServiceInterface::class, $configure['uuid'] ?? UuidFactoryService::class);
    }

    private function services(array $configure, array $cache): void
    {
    //     $this->app->singleton(AssistantServiceInterface::class, $configure['assistant'] ?? AssistantService::class);
    //     $this->app->singleton(AtmServiceInterface::class, $configure['atm'] ?? AtmService::class);
        $this->app->singleton(AtomicServiceInterface::class, $configure['atomic'] ?? AtomicService::class);
    //     $this->app->singleton(BasketServiceInterface::class, $configure['basket'] ?? BasketService::class);
    //     $this->app->singleton(CastServiceInterface::class, $configure['cast'] ?? CastService::class);
        $this->app->singleton(
            ConsistencyServiceInterface::class,
            $configure['consistency'] ?? ConsistencyService::class
        );
        // $this->app->singleton(DiscountServiceInterface::class, $configure['discount'] ?? DiscountService::class);
        // $this->app->singleton(
        //     EagerLoaderServiceInterface::class,
        //     $configure['eager_loader'] ?? EagerLoaderService::class
        // );
        // $this->app->singleton(ExchangeServiceInterface::class, $configure['exchange'] ?? ExchangeService::class);
        $this->app->singleton(PrepareServiceInterface::class, $configure['prepare'] ?? PrepareService::class);
        // $this->app->singleton(PurchaseServiceInterface::class, $configure['purchase'] ?? PurchaseService::class);
        // $this->app->singleton(TaxServiceInterface::class, $configure['tax'] ?? TaxService::class);
        $this->app->singleton(
            TransactionServiceInterface::class,
            $configure['transaction'] ?? TransactionService::class
        );
        $this->app->singleton(
            TransactionProcessorServiceInterface::class,
            $configure['transactionProcessor'] ?? TransactionProcessorService::class
        );
        // $this->app->singleton(TransferServiceInterface::class, $configure['transfer'] ?? TransferService::class);
        $this->app->singleton(WalletServiceInterface::class, $configure['wallet'] ?? WalletService::class);

        // $this->app->singleton(BookkeeperServiceInterface::class, fn () => $this->app->make(
        //     $configure['bookkeeper'] ?? BookkeeperService::class,
        //     [
        //         'storageService' => $this->app->make(
        //             StorageServiceInterface::class,
        //             [
        //                 'cacheRepository' => $this->app->make(CacheManager::class)
        //                     ->driver($cache['driver'] ?? 'array'),
        //             ],
        //         ),
        //     ]
        // ));

        // $this->app->singleton(RegulatorServiceInterface::class, fn () => $this->app->make(
        //     $configure['regulator'] ?? RegulatorService::class,
        //     [
        //         'storageService' => $this->app->make(
        //             StorageServiceInterface::class,
        //             [
        //                 'cacheRepository' => $this->app->make(CacheManager::class)
        //                     ->driver('array'),
        //             ],
        //         ),
        //     ]
        // ));
    }
}
