<?php

use Illuminate\Database\Seeder;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for($x=0; $x<=5;$x++)
    	{
	    	DB::table('section')->insert([
	            'name' => Str::random(10)
	        ]);
    	}
    }
}
