<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DesignJobStatus;
use App\Models\PaymentStatus;
use App\Models\PaymentType;
use App\Models\TransLinkType;
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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $henry =  User::create([
            'name' => 'Henry',
            'email' => 'rhfaul@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        $demo_1 =  User::create([
            'name' => 'Demo 1',
            'email' => 'demo@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        $demo_2 =  User::create([
            'name' => 'Demo 2',
            'email' => 'demo2@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        //

        DesignJobStatus::create([
            'name' => 'unallocated'
        ]);

        DesignJobStatus::create([
            'name' => 'Created'
        ]);

        //Payment Type

        PaymentType::create([
            'name' => 'unallocated'
        ]);

        PaymentType::create([
            'name' => 'EFT'
        ]);

        PaymentType::create([
            'name' => 'Payfast'
        ]);

        PaymentType::create([
            'name' => 'Contract'
        ]);

        PaymentStatus::create([
            'name' => 'Submitted'
        ]);

        PaymentStatus::create([
            'name' => 'Pending'
        ]);

        PaymentStatus::create([
            'name' => 'Cleared'
        ]);

        PaymentStatus::create([
            'name' => 'Reversed'
        ]);


    }
}
