<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Users extends MY_Controller {
	
    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
    }
 
    public function index()
    {
        $this->load->view('welcome_message');
    }
 
    public function login()
    {
        log_message("debug", "=== enter Users:login method");
 
        $this->data['title'] = "Login";
		
	$this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('ajax','AJAX','trim|is_natural');

        if ($this->form_validation->run() === FALSE)
        {

            log_message("debug", "=== Users:login: failed form validation");

            if($this->input->post('ajax'))
	    {
		$response['username_error'] = form_error('username');
                $response['password_error'] = form_error('password');
		header("content-type:application/json");
		echo json_encode($response);
		exit;
	    }
	    $this->load->helper('form');
            $this->render('users/login_view');
        }
        else
        {

            log_message("debug", "=== Users:login success form validation");

            $remember = (bool) $this->input->post('remember');
            $username = $this->input->post('username');
	    $password = $this->input->post('password');

            $this->ion_auth->set_hook('post_login_successful', 'get_gravatar_hash', $this, '_gravatar', array());
  
            if ($this->ion_auth->login($username, $password, $remember))
            {

                log_message("debug", "=== Users:login ion auth login success");

                if($this->input->post('ajax'))
	        {

                    log_message("debug", "=== Users:login success post ajax");

		    $response['logged_in'] = 1;
		    header("content-type:application/json");
		    echo json_encode($response);
		    exit;
	        } 
                redirect('dashboard');
            }
            else
            {

                log_message("debug", "=== Users:login ion auth login failed");

                if($this->input->post('ajax'))
      	        {

                    log_message("debug", "=== Users:login failed post ajax");

                    $response['username'] = $username;
		    $response['password'] = $password;
		    $response['error'] = $this->ion_auth->errors();
		    header("content-type:application/json");

                    log_message("debug", "=== Users:login post ajax: response " . $response['error']);

		    echo json_encode($response);
		    exit;
	        }

                $_SESSION['auth_message'] = $this->ion_auth->errors();
                $this->session->mark_as_flash('auth_message');
                redirect('users/login');
            }
        }
    }

    public function _gravatar()
    {
        if($this->form_validation->valid_email($_SESSION['email']))
        {
            $gravatar_url = md5(strtolower(trim($_SESSION['email'])));
            $_SESSION['gravatar'] = $gravatar_url;
        }
        return TRUE;
    }
/*
    public function ajax_login()
    {
	$response['message'] = 'hello';
	header("content-type:application/json");
	echo json_encode($response);
    }
 */
    public function logout()
    {
	$this->ion_auth->logout();
	redirect('users/login');
    } 
}

?>
