<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        Router::redirect('/');
    }

	// display information
    public function signup($msg = NULL) {
		// set up the view
		$this->template->content = View::instance('v_users_signup');
		$this->template->title = "Green Eggs - Sign up";
		$this->template->content->msg = $msg;
		
		// render the view
		echo $this->template;
    }

	// process the information
	public function p_signup() {
		// Confirm all fields at least have one character in them
		// This is a sad check, but it'll suffice for now
		if (($_POST['first_name'] == null) ||
			($_POST['last_name'] == null) ||
			($_POST['email'] == null) ||
			($_POST['password'] == null)) {
			Router::redirect('/users/signup/502');
		}
		
		// sanitize the data we get
		$_POST 				= DB::instance(DB_NAME)->sanitize($_POST);
		$_POST['password'] 	= sha1(PASSWORD_SALT.$_POST['password']);
		$_POST['token'] 	= sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
	
		// add in the time
		$_POST['created']	= Time::now();
		$_POST['modified']	= Time::now();

		// check if the email already exists
		$q = 'SELECT email FROM users WHERE email="'.$_POST['email'].'"';
		$bCheck = DB::instance(DB_NAME)->select_field($q);
		if ($bCheck) {
			// email is already in use
			Router::redirect('/users/signup/501');
		}
		else {
			// insert data into db & redirect to login screen
			DB::instance(DB_NAME)->insert_row('users', $_POST);
			Router::redirect('/users/login');
		}
	}
	
	public function login($msg = null) {
		$this->template->content = View::instance('v_users_login');
		$this->template->title = "Login";
		$this->template->content->msg = $msg;
    
		echo $this->template;
	}
	
	public function p_login() {
		// get the password
		$_POST['password'] 	= sha1(PASSWORD_SALT.$_POST['password']);
		
		$q = 'SELECT token 
				FROM users
				WHERE email = "'.$_POST['email'].'"
				AND password = "'.$_POST['password'].'"';
				
		$token = DB::instance(DB_NAME)->select_field($q);
		
		if ($token) {
			setcookie('token', $token, strtotime('+500 minutes'), '/');
			
			// Redirect the user to the posts page
			Router::redirect('/posts');
		}
		else {
			// redirect to the login page with an error msg
			Router::redirect('/users/login/510');
		}
		echo $token;
	}

    public function logout() {
		// make sure the user is logged in prior to logout
		if(!$this->user) {
			Router::redirect('/');
		}

		// create new token & insert into db
		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());
		$data = Array('token' => $new_token);
		DB::instance(DB_NAME)->update('users', $data, 'WHERE user_id='.$this->user->user_id);
		
		// expire cookie on user's computer
		setcookie('token', '', strtotime('-1 year'), '/');
		
		// go to home page when logged out
		Router::redirect('/');
    }

    public function profile($user_name = NULL) {
		// if the user isn't logged in, drop them back to the homepage
		if (!$this->user) {
			Router::redirect('/');
		}
	
		// set up the view
		$this->template->content = View::instance('v_users_profile');
		$this->template->title = "Green Eggs - Your Profile";
		
		$data = Array(
			"first_name"	=> $this->user->first_name,
			"last_name"		=> $this->user->last_name,
			"email"			=> $this->user->email,
			"created"		=> $this->user->created,
			"modified"		=> $this->user->modified
		);
	
		$this->template->content->user_data = $data;
	
		echo $this->template;
    }

} # end of the class
