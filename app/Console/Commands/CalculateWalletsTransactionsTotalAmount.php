<?php

namespace App\Console\Commands;

use App\Internal\Repositories\TransactionRepository;
use Illuminate\Console\Command;

class CalculateWalletsTransactionsTotalAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:wallets:calculate-total {--type=} {--date-from=} {--date-to=} {--confirm-only=true}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates total amount of transactions and prints it on terminal';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private TransactionRepository $transactionRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $type = $this->option('type');
        $from = $this->option('date-from');
        $to = $this->option('date-to');
        $confirmOnly = $this->option('confirm-only');

        $data = $this->transactionRepository->getWalletsSumTotal($from, $to, $type, $confirmOnly);

        $this->table(
            ['Wallet ID', 'User ID', 'Transactions Total', 'Balance'],
            $data->toArray()
        );

        return 0;
    }
}
