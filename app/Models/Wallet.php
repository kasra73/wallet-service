<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Wallet as WalletInterface;

class Wallet extends Model implements WalletInterface
{
    use HasFactory;

    protected $attributes = [
        'balance' => '0',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id'
    ];

    public function getUserId(): int
    {
        return $this->user_id;
    }
}
