<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Check;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        $factoryIncomeAccepted = Transaction::factory()
            ->income()
            ->has(Check::factory()->accepted())
            ->count(10);

        $factoryIncomePending = Transaction::factory()
            ->income()
            ->has(Check::factory()->pending())
            ->count(2);

        $factoryIncomeRejected = Transaction::factory()
            ->income()
            ->has(Check::factory()->rejected())
            ->count(2);

        $factoryExpenses = Transaction::factory()
            ->count(3);

        User::factory()
            ->has($factoryIncomeAccepted)
            ->has($factoryIncomePending)
            ->has($factoryIncomeRejected)
            ->has($factoryExpenses)
            ->create([
                'name' => 'test',
                'email' => 'test@example.com',
                'is_admin' => true
            ]);
        
        User::factory()
            ->has($factoryIncomePending)
            ->create([
                'name' => 'guest',
                'email' => 'guest@example.com',
            ]);
    }
}
