<?php

class msgs_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		if(!$this->user) {
			Router::redirect('/');
		}
	}
	
	public function index() {
		# Set up the View
		$this->template->content = View::instance('v_msgs_index');
		$this->template->title   = "Chatroom";

		# Build the query -- get the last 5 records to the global chat room
		$q = "SELECT 
				messages.content,
				messages.created,
				messages.sender_id,
				messages.receiver_id, 
				users.first_name
			FROM messages
			INNER JOIN users 
				ON messages.sender_id = users.user_id
			WHERE messages.receiver_id=0
			ORDER BY messages.created DESC LIMIT 5";

		# Run the query
		$msgs = DB::instance(DB_NAME)->select_rows($q);

		# Pass data to the View
		$this->template->content->msgs = $msgs;

		// Build query for users list
		$q = "SELECT
				user_id,
				first_name,
				last_name
			FROM users";
		
		// Run the query
		$users = DB::instance(DB_NAME)->select_rows($q);

		// Pass data to the View
		$this->template->content->users = $users;
		
		// Load JS files
		$client_files_body = Array(
			"/js/jquery.form.js"
		);
		$this->template->client_files_body = Utils::load_client_files($client_files_body);
		
		# Render the View
		echo $this->template;
	}
	
	// put the post into the db
	public function p_add($receiver_id = 0) {
		// check if there is content, if not, just go back to the same page
		if ($_POST['content'] == null) {
			Router::redirect('/msgs/');
		}
		
		// Set up the data
		$_POST['created']		= Time::now();
		$_POST['sender_id']		= $this->user->user_id;
		$_POST['receiver_id']	= $receiver_id;			// global chatroom = 0
		
		// Insert the post
		DB::instance(DB_NAME)->insert('messages',$_POST);

		// data to send back
		$data = Array();
		$data['sender_fname']	= $this->user->first_name;
		$data['sender_id']		= $this->user->user_id;
		$data['receiver_id']	= $receiver_id;
		echo json_encode($data);
	}

// -------------------------------------------------------------------------
	/*
	// get profiles?
	public function p_get_profile() {
	
	}
	*/
	
	// get the last 10 people you talked with
	public function p_get_msg_userlist($sender_id) {
		// create the query
		$q = "SELECT 
				message
				messages.sender_id,
				messages.receiver_id,
				users.first_name,
				users.last_name
			FROM messages 
			INNER JOIN users 
				ON messages.sender_id = users.user_id
			WHERE messages.sender_id=" . $sender_id .
			"ORDER BY messages.created DESC LIMIT 10";

			// !@# might possibly wnat to use users of users
			
		// Run the query
		$msgs = DB::instance(DB_NAME)->select_rows($q);

		// Pass data to the View
		$this->template->content->msgs = $msgs;
	}
	
	public function edit() {
		$this->template->content = View::instance("v_msgs_edit");
		$this->template->title   = "View / Edit / Delete Messages";
		
		$myID = $this->user->user_id;
		
		// Build the query for the messages
		$q = 'SELECT msg_id, sender_id, receiver_id, content, created 
			FROM messages
			WHERE sender_id = '.$myID.' OR receiver_id = '.$myID;
		
		// Run the query
		$msgs = DB::instance(DB_NAME)->select_rows($q);

		// Build the query for users
		$q = 'SELECT 
				users.first_name,
				users.last_name
			FROM messages
			INNER JOIN users
				ON messages.sender_id = users.user_id
			WHERE messages.sender_id ='.$myID.' OR receiver_id = '.$myID.'
			GROUP BY users.user_id';

		$users = DB::instance(DB_NAME)->select_rows($q);
		
		// Pass data to the View
		$this->template->content->msgs = $msgs;
		$this->template->content->users = $users;
		echo $this->template;
	}
	
	
	// get the last XX messages you sent
	public function p_get_msg_history($sender_id, $receiver_id) {
		// create the query
		$q = "SELECT 
				messages.content,
				messages.created,
				messages.sender_id,
				messages.receiver_id, 
				users.first_name
			FROM messages
			INNER JOIN users 
				ON messages.sender_id = users.user_id
			WHERE messages.receiver_id=" + $receiver_id + 
			"ORDER BY messages.created DESC LIMIT 20";

		// Run the query
		$msgs = DB::instance(DB_NAME)->select_rows($q);

		// Pass data to the View
		$this->template->content->msgs = $msgs;
	}
	
	// private chatrooms
	public function p_private_chat($sender_id, $receiver_id) {
		// 0 = global chat room
		if ($receiver_id == 0) {
			return;
		}
		
		// check if there is content
		if ($_POST['content'] == null) {
			return;
		}

		// Set up the data
		$_POST['created']		= Time::now();
		$_POST['sender_id']		= $this->user->user_id;
		$_POST['receiver_id']	= '0';

		// Insert the post
		DB::instance(DB_NAME)->insert('messages',$_POST);

		// Return back the user id's we need
		$data = Array();
		$data['sender_fname']	= $this->user->first_name;
		$data['sender_id']		= $this->user->user_id;
		echo json_encode($data);
	
	}
	
	
	
}
?>
