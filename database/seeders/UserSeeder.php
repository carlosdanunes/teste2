<?php

namespace Database\Seeders;

use App\Events\UserRegisteredEvent;
use App\Jobs\Utils\CreateFakeUserJob;
use App\Models\Gateway;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    public function run(): void
    {

      /*  $user_sub_affiliate = User::create([
            'username' => Str::random(),
            'name' => 'Afiliado Segundo',
            'email' => 'segundo@gmail.com',
            'document' => '633.647.510-72',
            'phone' => '(47) 98911-0172',
            'birth_date' => '1995-07-15',
            'ref_code' => Str::upper(Str::random(10)),
            'password' => 'asdasdasd',
        ]);


        $user_affiliate = User::create([
            'username' => Str::random(),
            'name' => 'Afiliado Primeiro',
            'email' => 'afiliado@gmail.com',
            'document' => '008.886.620-33',
            'phone' => '(47) 98911-0173',
            'birth_date' => '1995-07-15',
            'ref_code' => Str::upper(Str::random(10)),
            'password' => 'asdasdasd',
            'affiliate_id' => $user_sub_affiliate->id,
        ]);*/

        // ISTO AQUI RESETA O BANCO DE DADOS CUIDADO!!!

        $user = User::create([
            'username' => Str::random(),
            'name' => 'Ladismeérico Gonçalves',
            'email' => 'ladismerico@gmail.com',
            'document' => '064.276.743-23',
            'phone' => '(88) 98879-0387',
            'birth_date' => '1999-04-13',
            'ref_code' => Str::upper(Str::random(10)),
            'password' => 'zinBets123!'
            
        ]);

        $user->assignRole('admin');

        $user = User::create([
            'username' => Str::random(),
            'name' => 'Pedro Henrique',
            'email' => 'pedro.gekko@outlook.com',
            'document' => '522.534.418-64',
            'phone' => '(11) 93361-6777',
            'birth_date' => '2000-11-29',
            'ref_code' => Str::upper(Str::random(10)),
            'password' => 'zinBets123!'
            
        ]);

        $user->assignRole('admin');

        $user = User::create([
            'username' => Str::random(),
            'name' => 'Jose Vitor',
            'email' => 'joselrnccontato@gmail.com',
            'document' => '061.305.291-98',
            'phone' => '(66) 99983-1534',
            'birth_date' => '2002-08-08',
            'ref_code' => Str::upper(Str::random(10)),
            'password' => 'zinBets123!'
            
        ]);

        $user->assignRole('admin');

        $user = User::create([
            'username' => Str::random(),
            'name' => 'Tomaz Costa',
            'email' => 'tomazsecundaria@outlook.com',
            'document' => '493.245.768-52',
            'phone' => '(19) 99419-6022',
            'birth_date' => '1998-12-14',
            'ref_code' => Str::upper(Str::random(10)),
            'password' => 'zinBets123!'
            
        ]);

        $user->assignRole('admin');


        $countUserJobs = 10; //cada job cria 50 users fake

        while ($countUserJobs > 0) {
            CreateFakeUserJob::dispatch();
            $countUserJobs--;
        }
    }
}
