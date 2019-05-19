<?php

use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
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
	    	DB::table('subject')->insert([
	            'name' => Str::random(10)
	        ]);
    	}
    }
}
