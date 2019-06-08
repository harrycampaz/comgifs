<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('registered_model');
        $this->load->helper('string');
        
    }
    public function index()
    {
        if (!$this->is_logged_in()) {

            $data = $this->ui_model->cargar_nav();
            $data['title'] = 'Usuarios';
            $data['main_content'] = 'user/form_login';

            $this->load->view('template',$data);
        } else {
            redirect('gifs');
        }
    }
    public function check()
    {
        $this->load->helper('email');
        $data = $this->ui_model->cargar_nav();           
        $this->form_validation->set_rules('username', 'Username', 'required||xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[20]|alpha_numeric|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Usuarios';
            $data['mensaje'] = "<div class='alert alert-danger alert-dismissable'> <strong>Error!! </strong>Username o contraseña es incorrecto</div>";
            $data['main_content'] = 'user/form_login';
            $this->load->view('template',$data);
        } else {
            if (valid_email($this->input->post('username')))
            {
                 $is_user = $this->user_model->is_mail($this->input->post('username'), sha1($this->input->post('password')));
            }
            else
            {
                $is_user = $this->user_model->is($this->input->post('username'), sha1($this->input->post('password')));

            }
            
            if ($is_user) {
                
                $data = array(
                    'username' => $is_user['username'],
                    'rol' => $is_user['roles_id_rol'],
                    'id_user' => $is_user['id_user'],
                    'is_logged_in' => TRUE,
                    'estado' => $is_user['estado'],
                    'myname' => $is_user['myname'],
                    'strike' => $is_user['strike']
                );
                $this->session->set_userdata($data);
                
                redirect('partner');
            } else {
                $data['title'] = 'Usuarios';
            $data['mensaje'] = "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error!! </strong>Username o contraseña es incorrecto</div>";
            $data['main_content'] = 'user/form_login';
            $this->load->view('template',$data);
            }
        }
    }
    public function register()
    {
        if (!$this->is_logged_in()) {
            
            $this->load->library('recaptcha');
            $data = $this->ui_model->cargar_nav();
            

            //Store the captcha HTML for correct MVC pattern use.
            $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
            $data['title'] = 'Registrarse';
            $data['register_js'] = $this->lang->line('nav_register_js');
            $data['name'] = $this->lang->line('nav_name');
            $data['password'] = $this->lang->line('nav_password');
            $data['repassword'] = $this->lang->line('nav_repassword');
            $data['term'] = $this->lang->line('nav_term');
            $data['send'] = $this->lang->line('nav_send');
            $data['main_content'] = 'user/form_register';
            
            $data['datos_r'] = $this->gif_model->gif_aleatorio();
            $this->load->view('template',$data);
        }
        else{
            redirect('gifs');
        }
    }

    public function check_register()
    {
        $this->load->library('recaptcha');
        $this->recaptcha->recaptcha_check_answer();
        $this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[12]|callback__check_username|alpha_dash|xss_clean');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|callback__check_email|xss_clean');
        $this->form_validation->set_rules('password', '6', 'trim|required|min_length[6]|max_length[20]|alpha_numeric|xss_clean');
        $this->form_validation->set_rules('re_password', 'Repita Contaseña', 'trim|required|matches[password]|xss_clean');
        $this->form_validation->set_rules('check', 'Check', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->register();
        }
        /*elseif(!$this->recaptcha->getIsValid()){
             $this->session->set_flashdata('error','incorrect captcha');
             $data['error'] = $this->recaptcha->getError();
             $this->register();
        }*/
        else{

            $datos = array(
                    'myname'    =>  $this->input->post('name'),
                    'username'  =>   $this->input->post('username'),
                    'email'     =>  $this->input->post('email'),
                    'password'  =>  sha1($this->input->post('password')),
                    'estado'    =>  '0',
                    'roles_id_rol' => 3,
                    'activation_code' => random_string('unique'));

            $success = $this->user_model->add_user($datos);

            if($success == 1){    
                $data['mensaje'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Registro exitoso!</strong> Revisa tu E-mail para validar tu cuenta</div>";
                $data['title'] = 'Bienvenido';
                $this->registered_model->star_mail($datos['myname'], $datos['username'], $datos['activation_code'],$datos['email']);
            }
            else{
                $data['mensaje'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error!!</strong> se produjo un error al realizar el registro</div>";
                $data['title'] = 'Error al registrar';
            }
             $data = array(
                    'username' =>  $this->input->post('username'),
                    'rol' => 3,
                    'id_user' => $this->user_model->get_id($this->input->post('username')),
                    'estado' => '0',
                    'myname' => $this->input->post('name'),
                    'is_logged_in' => TRUE
                );
                $this->session->set_userdata($data);
                
                redirect('gifs');
        }
        
    }
    function _check_username($username)
    {

        return $this->user_model->check_username($username);
    }
    function _check_email($email)
    {
        return $this->user_model->check_email($email);
    }


    function check_username()
    {
        
        echo json_encode($this->user_model->check_username($this->input->post('username')));
    }
    function check_email()
    {
        echo json_encode($this->user_model->check_email($this->input->post('email')));
    }


    public function logout()
    {
        $data = $this->ui_model->cargar_nav();
        if (!$this->is_logged_in()) {
            redirect('login');

        } else {
            $this->session->set_userdata(array('is_logged_in' => FALSE));
            $this->session->sess_destroy();
            redirect('gifs');
        }
    }
    
    private function is_logged_in()
    {
        return $this->session->userdata('is_logged_in');
    }
}
/*End of file login.php*/