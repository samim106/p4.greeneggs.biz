<?php


class practice_controller extends base_controller {

	public function test_db() {
		/*
		$q = 'UPDATE users SET email = "asef@aol.com" WHERE first_name = "Albert"';
		DB::instance(DB_NAME)->query($q);
		*/
		
		$new_user = Array(
			'first_name' => 'Albert',
			'last_name' => 'Einstein',
			'email' => 'albert@gmail.com',
			);
		
		DB::instance(DB_NAME)->insert('users',$new_user);
		
		
		// sanitize the post variables
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
	}




}



?>