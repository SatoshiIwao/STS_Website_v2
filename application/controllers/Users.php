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
        $this->data['title'] = "Login";
		
	$this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() === FALSE)
        {
	    $this->load->helper('form');
            $this->render('users/login_view');
        }
        else
        {
            $this->ion_auth->set_hook('post_login_successful', 'get_gravatar_hash', $this, '_gravatar', array());
            $remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember))
            {
                redirect('dashboard');
            }
            else
            {
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
 
    public function logout()
    {
	$this->ion_auth->logout();
	redirect('users/login');
    }
}

?>
