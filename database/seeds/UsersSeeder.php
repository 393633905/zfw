<?php

use Illuminate\Database\Seeder;
use App\Models\Users;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::truncate();
        factory(Users::class, 100)->create();
        Users::where('id',1)->update(['username'=>'admin']);
    }
}
