<?php

use Illuminate\Database\Seeder;
use App\Mop;

class MopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $mop = new Mop;
        $mop->title = 'Cash On Delivery';
        $mop->code 	= 'COD';
        $mop->save();

        $mop = new Mop;
        $mop->title = 'Paypal';
        $mop->code 	= 'PPL';
        $mop->save();

        $mop = new Mop;
        $mop->title = 'Bank to Bank';
        $mop->code 	= 'BTB';
        $mop->save();
    }
}
