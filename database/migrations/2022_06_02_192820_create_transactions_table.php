<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('wallet_id');
            $table->enum('type', ['deposit', 'withdraw'])->index();
            $table->decimal('amount', 64, 4);
            $table->boolean('confirmed');
            $table->json('meta')->nullable();
            $table->uuid('uuid')->unique();
            $table->timestamps();

            $table->index(['type'], 'type_index');
            $table->index(['confirmed'], 'confirmed_index');
            $table->index(['type', 'confirmed'], 'type_confirmed_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
