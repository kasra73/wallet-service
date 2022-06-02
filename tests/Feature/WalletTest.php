<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletBalanceTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Test wallet not found
     *
     * @return void
     */
    public function test_wallet_not_found()
    {
        $response = $this->get('/api/get-balance/31');

        $response->assertJsonStructure([
            'title',
            'message'
        ]);

        $response->assertStatus(404);
    }

    /**
     * Test Add Money
     *
     * @return void
     */
    public function test_add_money()
    {
        $response = $this->post('/api/add-money', [
            "user_id" => 31,
            "amount" => "2000.01"
        ]);

        $response->assertJsonStructure([ 'reference_id' ]);

        $response->assertStatus(200);
    }

    /**
     * Test wallet get balance
     *
     * @return void
     */
    public function test_get_wallet_balance()
    {
        $response = $this->get('/api/get-balance/31');

        $response->assertExactJson([
            'balance' => "2000.01"
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test Withdraw Money
     *
     * @return void
     */
    public function test_withdraw_money()
    {
        $response = $this->post('/api/add-money', [
            "user_id" => 31,
            "amount" => "-1000"
        ]);

        $response->assertJsonStructure([ 'reference_id' ]);

        $response->assertStatus(200);
    }

    /**
     * Test Withdraw Money
     *
     * @return void
     */
    public function test_withdraw_money_failed()
    {
        $response = $this->post('/api/add-money', [
            "user_id" => 31,
            "amount" => "-2000"
        ]);

        $response->assertJsonFragment([ 'message' => 'Insufficient funds' ]);

        $response->assertStatus(422);
    }

    /**
     * Test Withdraw Money
     *
     * @return void
     */
    public function test_get_wallet_balance_after_withdraw()
    {
        $response = $this->get('/api/get-balance/31');

        $response->assertExactJson([
            'balance' => "1000.01"
        ]);

        $response->assertStatus(200);
    }
}
