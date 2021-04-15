<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'bagiangudang',
                'password' => 'gudang01',
                'email' => 'gudang@ta.com'
            ],
            [
                'username' => 'bagiankeuangan1',
                'password' => 'keuangan01',
                'email' => 'keuangan@ta.com'
            ],
            [
                'username' => 'bagianpelayanan',
                'password' => 'kasir01',
                'email' => 'kasir@ta.com'
            ],
            [
                'username' => 'owner1',
                'password' => 'owner01',
                'email' => 'owner@ta.com'
            ]
        ];
        
        foreach ($users as $user) {
            $newUser = new User();
            $newUser->username = $user['username'];
            $newUser->password = Hash::make($user['password']);
            $newUser->email = $user['email'];
            $newUser->email_verified_at = now();
            $newUser->save();
        }
    }
}
