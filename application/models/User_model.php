<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function login_with_facebook($email, $username)
  {
    $this->db->where('email',$email);
    $this->db->limit(1);
    $users = $this->db->count_all_results('users'); // are there any users with that email address?
    if(!isset($users) || $users<1)
    {
      return FALSE;
    }
    else
    {
      $user = $this->db->where(array('email'=>$email))->limit(1)->get('users')->row();
      $_SESSION['identity'] = $user->username; // if you've set up email as the login identity column, you shouls use $user->email in here...
      $_SESSION['username'] = $user->username;
      $_SESSION['email'] = $user->email;
      $_SESSION['user_id'] = $user->id;
      $_SESSION['old_last_login'] = $user->last_login;
      return TRUE;
    }
  }
}
