<?php

use Illuminate\Database\Seeder;
use App\AccessRight;
class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ar = new AccessRight;
        $ar->AccessName = 'Administrator';
        $ar->save();

        $ar = new AccessRight;
        $ar->AccessName = 'User';
        $ar->save();
    }
}
