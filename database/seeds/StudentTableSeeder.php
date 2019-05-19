<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function random_digits($length) {
	    $length = intval($length, 10);
	    $output = '';
	    for ($i = 0; $i < $length; $i++) {
	        $output .= mt_rand(0, 9);
	    }
    	return $output;
	}

    public function run()
    {

    	for($x=0; $x<=20;$x++)
    	{
	    	DB::table('student')->insert([
	            'name' => Str::random(10),
	            'age' => '18',
	            'phone' => $this->random_digits(11),
	            'address' => Str::random(25,
	            'section_id' => '1'
	        ]);
    	}
    }
}
