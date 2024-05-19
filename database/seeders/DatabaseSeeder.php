<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DesignJobStatus;
use App\Models\FileType;
use App\Models\PaymentStatus;
use App\Models\PaymentType;
use App\Models\TransLinkType;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

        //user types

        UserType::create([
            'type' => 'client'
        ]);

        UserType::create([
            'type' => 'creator'
        ]);

        UserType::create([
            'type' => 'project_manager'
        ]);

        UserType::create([
            'type' => 'admin'
        ]);


        Permission::create(['name' => 'client']);
        Permission::create(['name' => 'creator']);
        Permission::create(['name' => 'project_manager']);
        Permission::create(['name' => 'admin']);


        $clientRole = Role::create(['name' => 'clientRole']);
        $creatorRole = Role::create(['name' => 'creatorRole']);
        $projectManagerRole = Role::create(['name' => 'projectManagerRole']);
        $adminRole = Role::create(['name' => 'adminRole']);

        $clientRole->givePermissionTo([
            'client',
        ]);

        $creatorRole->givePermissionTo([
            'creator',
        ]);

        $projectManagerRole->givePermissionTo([
            'project_manager',
        ]);

        $adminRole->givePermissionTo([
            'admin',
        ]);


        //create users and detail
        //['user_id','user_type_id','cv_link','is_approved'];
        $henry =  User::create([
            'name' => 'Henry',
            'email' => 'rhfaul@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        $detail_henry =  UserDetail::create([
            'first_name'=>'Henry',
            'user_id' => $henry->id,
            'user_type_id' => 4,
            'is_approved'=>1
        ]);

        //assign roles
        $henry->assignRole('adminRole');



        $demo_1 =  User::create([
            'name' => 'Demo 1',
            'email' => 'demo@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        $detail_1 =  UserDetail::create([
            'first_name'=>'Demo 1',
            'user_id' => $demo_1->id,
            'user_type_id' => 1,
            'is_approved'=>1
        ]);

        $demo_1->assignRole('clientRole');

        $demo_2 =  User::create([
            'name' => 'Demo 2',
            'email' => 'demo2@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        $detail_2 =  UserDetail::create([
            'first_name'=>'Demo 2',
            'user_id' => $demo_2->id,
            'user_type_id' => 2,
            'is_approved'=>1
        ]);

        $demo_2->assignRole('creatorRole');

        $demo_3 =  User::create([
            'name' => 'Demo 3',
            'email' => 'demo3@gmail.com',
            'password' => bcrypt('test1234')
        ]);

        $detail_3 =  UserDetail::create([
            'first_name'=>'Demo 3',
            'user_id' => $demo_3->id,
            'user_type_id' => 3,
            'is_approved'=>1
        ]);

        $demo_3->assignRole('projectManagerRole');


        //

        DesignJobStatus::create([
            'name' => 'Created'
        ]);

        DesignJobStatus::create([
            'name' => 'Cancelled'
        ]);

        DesignJobStatus::create([
            'name' => 'Allocated'
        ]);

        DesignJobStatus::create([
            'name' => 'Design-pending'
        ]);

        DesignJobStatus::create([
            'name' => 'Creator-submit-design'
        ]);

        DesignJobStatus::create([
            'name' => 'PM-review-design'
        ]);

        DesignJobStatus::create([
            'name' => 'PM-request-design-change'
        ]);

        DesignJobStatus::create([
            'name' => 'PM-accept-design'
        ]);
        DesignJobStatus::create([
            'name' => 'Client-review-design'
        ]);
        DesignJobStatus::create([
            'name' => 'Client-request-design-change'
        ]);
        DesignJobStatus::create([
            'name' => 'Client-accept-design'
        ]);
        DesignJobStatus::create([
            'name' => 'Release-final-design-client'
        ]);
        DesignJobStatus::create([
            'name' => 'Closed'
        ]);


        /*
        •	Created
        •	Cancelled
        •	Allocated
        •	Design-pending
        •	Creator-submit-design
        •	PM-review-design
        •	PM-request-design-change
        •	PM-accept-design
        •	Client-review-design
        •	Client-request-design-change
        •	Client-accept-design
        •	Release-final-design-client
        •	Closed
        */


        //Payment Type

        PaymentType::create([
            'name' => 'Unallocated'
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

        //File types


        FileType::create([
            'type' => 'unallocated'
        ]);

        FileType::create([
            'type' => 'raw'
        ]);

        FileType::create([
            'type' => 'test'
        ]);

        FileType::create([
            'type' => 'final'
        ]);








    }
}
