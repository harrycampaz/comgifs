<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('registered_model');
        $this->load->model('user_model');
        
    } 
	
	public function index()
	{
        if (!$this->is_logged_in()){
             redirect('login');
        } 
        else{


            $data = $this->ui_model->cargar_nav();
            $data['main_content'] = 'profile/index';
            $data['usuario'] = $this->registered_model->get_user($this->session->userdata('id_user'));
            $data['numero'] = $this->gif_model->num_imagenes_username($data['usuario']['username']);
            $data['title'] = $data['usuario']['myname'];
            $this->load->view('template',$data);
        }

	}

    /*****Ver  los perfiles de los registrados***/
    public function user($username = 'teamgifs')
    {
            $data = $this->ui_model->cargar_nav();
            $data['usuario'] = $this->user_model->get_user($username);
            if (empty($data['usuario'])) {
                $data['mensaje'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario no existe!</strong></div>";
                $data['main_content'] = 'profile/error_404';
                $data['title'] = 'Error el usuario no existe';
            }
            else{
                $data['title'] = $data['usuario']['myname'];
                $data['numero'] = $this->gif_model->num_imagenes_username($username);
                if($data['numero'] > 0){
                    //$data['title'] = 'Imagenes de'.' : '.$username;
                    $pages=12; //Número de registros mostrados por páginas

                    $config['base_url'] = base_url().'profile/user/'.$username; // parametro base de la aplicación, si tenemos un .htaccess 
                    $config['uri_segment'] = 4;
                    $config['total_rows'] = $this->gif_model->num_imagenes_username($username);
                    if($config['total_rows'] < 1){
                       $data['encabezado']=  'El Usuario no existe';
                    }
                    else{
                         if($data['usuario']['estrellas'] < 1 && $this->session->userdata('rol') == 3){
                            $data['mensaje'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Gana tu primera estrella!</strong> Te hemos mandado un e-mail con el enlace para ganar la estrella</div>";
                        }
                       $data['encabezado']=  'Imagenes de '.' : '.$username;
                    }
                        
                    $config['per_page'] = $pages; //Número de registros mostrados por páginas
                    $config['num_links'] = 4; //Número de links mostrados en la paginación
                    $config['num_tag_open'] = '<span class="badge blanquear">';
                    $config['num_tag_close'] = '</span>';
                    
                    $config['cur_tag_open'] = '<span class="badge badge-info">';
                    $config['cur_tag_close'] = '</span>';

                    $config['first_link'] = $this->lang->line('nav_first');//primer link
                    $config['first_tag_open'] = '<li>';
                    $config['first_tag_close'] = '</li>';

                    $config['last_link'] = $this->lang->line('nav_last');//último link
                    $config['last_tag_open'] = '<li>';
                    $config['last_tag_close'] = '</li>';

                    $config['prev_link'] = '&larr;'.$this->lang->line('nav_previous');//anterior link
                    $config['prev_tag_open'] = '<li class="previous">';
                    $config['prev_tag_close'] = '</li>';

                    $config['next_link'] = $this->lang->line('nav_next').'&rarr;';//siguiente link
                    $config['next_tag_open'] = '<li class="next">';
                    $config['next_tag_close'] = '</li>';

                    
                  //  $config['display_pages'] = FALSE;

                   
                    $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="pager">';//el div que debemos maquetar
                    $config['full_tag_close'] = '</ul></div>';//el cierre pagination-centered del div de la paginación
                    $this->pagination->initialize($config); //inicializamos la paginación
                    $data["datos"] = $this->gif_model->username_gifs($username,$config['per_page'], $this->uri->segment(4));

                    if ($username === $this->session->userdata('username') || $this->session->userdata('rol') == 1 || $this->session->userdata('rol') == 2  ) {
                        $data['accion'] = TRUE;
                    }
                }
                $data['main_content'] = 'profile/user';   
            }

            $this->load->view('template',$data);
            
    }
    /*****************Fin de ver perfil de registrados*********************/
 
    /********************************bloque para eliminar un usuario**********************************************/

    public function delete_user($username){
       if (!$this->is_logged_in()){
             redirect('gifs');
        } 
        else{
            if ($username === $this->session->userdata('username')) {
                $data = $this->ui_model->cargar_nav();
                $data['title'] = 'Eliminar cuenta';
                $data['user'] = $username;
                $data['main_content'] = 'profile/form_delete';
                $this->load->view('template',$data);
            }
            else{
                redirect('gifs');
            }
            
        }
            
    }

    public function check_delete()
    {
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[70]|trim|xss_clean|callback__check_password');
        $this->form_validation->set_message('required', 'La %s no puede ir vacío!');
        $this->form_validation->set_message('_check_password', '%s Incorrecta');
        if ($this->form_validation->run() == TRUE){

            $delete = $this->user_model->delete($this->session->userdata('id_user'));
            $this->session->set_userdata(array('is_logged_in' => FALSE));
            $this->session->sess_destroy();
            $data = $this->ui_model->cargar_nav();
            $data['title'] = 'Usuario eliminado';
            $data['mensaje'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario eliminado!!</strong> Gracias por usar nuestra humilde aplicacion, esperamos que algun dia regreses ;). </div>";
            $data['main_content'] = 'gif/index';
            $data['datos']= $this->gif_model->get_imagenes();
            $data['most_view'] = $this->gif_model->get_most_view();
            $this->load->view('template',$data);

        }
        else{
            $this->delete_user($this->input->post('username'));
        }
    }


     /********************************bloque para Actualizar un usuario***************************************************/
    public function edit_user()
    {
        $data = $this->ui_model->cargar_nav();
        if (!$this->is_logged_in()){
             redirect('login');
        } 
        else{
            $data['title'] = 'Editar usuario';
            $data['main_content'] = 'profile/form_edit';
            $data['usuario'] = $this->registered_model->get_user($this->session->userdata('id_user'));
            $this->load->view('template',$data);
        }
    }


    public function check_update()
    {
          if (!$this->is_logged_in()){
             redirect('login');
            } 
            else{

                $data = $this->ui_model->cargar_nav();
                $this->form_validation->set_rules('name', 'Nombre', 'trim|required');
                $this->form_validation->set_rules('username', 'Username', 'trim|required|callback__check_username|alpha_dash|xss_clean');
                $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|callback__check_email|xss_clean');
                $this->form_validation->set_rules('website', 'Website', 'trim|prep_url|xss_clean');
                $this->form_validation->set_rules('ubicacion', 'ubicacion', 'trim|xss_clean');
                $this->form_validation->set_rules('userfile', 'Userfile', 'xss_clean');
                $this->form_validation->set_rules('notificar', 'Notificar', '|trim|xss_clean|callback__validar_notificar');
                
                $this->form_validation->set_message('required', 'El Campo %s Es requrido');
                $this->form_validation->set_message('valid_email', 'El E-mail ingresado no es valido');
                $this->form_validation->set_message('_check_email', '%s ya existe en la base de datos');
                $this->form_validation->set_message('_check_username', 'Este Usuario ya existe en la base de datos');
                $this->form_validation->set_message('_validar_notificar','No valido');
                if ($this->form_validation->run() == FALSE) {
                    $this->edit_user();
                }
                else{
                    
                    $slug = time();
                    $config['upload_path'] = './avatar/';
                    $config['allowed_types'] = 'gif';
                    $config['max_size'] = '1024';
                    $config['max_width'] = '700';
                    $config['max_height'] = '700';
                    $config['file_name']= $slug;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload()) {
                        $datos = array(
                            'myname'    =>  $this->input->post('name'),
                            'username'  =>  $this->input->post('username'),
                            'email'     =>  $this->input->post('email'),
                            'ubicacion' =>  $this->input->post('ubicacion'),
                            'notificar' =>  $this->input->post('notificar'),
                            'website'   =>  $this->input->post('website'));

                    }
                    else{
                        $file_info = $this->upload->data();
                    
                        $datos = array(
                            'myname'    =>  $this->input->post('name'),
                            'username'  =>  $this->input->post('username'),
                            'email'     =>  $this->input->post('email'),
                            'ubicacion' =>  $this->input->post('ubicacion'),
                            'website'   =>  $this->input->post('website'),
                            'notificar' =>  $this->input->post('notificar'),
                            'avatar'    =>   $file_info['file_name']);
                        
                        //$this->gif_model->subir_servers3($file_info['file_name'],'avatar/','avatar/');
                    }
                    $this->registered_model->update_user($datos);

                    $data['usuario'] = $this->registered_model->get_user($this->session->userdata('id_user'));
                    $this->session->set_userdata($this->registered_model->update_session($this->session->userdata('id_user')));
                    $data['mensaje'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario actualizado!</strong> El Usuario se acualizo con exito</div>";
                    $data['numero'] = $this->gif_model->num_imagenes_username($data['usuario']['username']);
                    $data['title'] = 'Usuario actualizado';   
                    $data['main_content'] = 'profile/index';
                    $this->load->view('template',$data);

                }
            }
        
    }
    function _check_username($username)
    {
        if (!$this->is_logged_in()){
             redirect('login');
        } 
        else{
            return !$this->registered_model->check_update_username($username);
        }
    }

    function _check_email($email)
    {
        if (!$this->is_logged_in()){
             redirect('login');
        } 
        else{
            return !$this->registered_model->check_update_email($email);
        }
    }

    function _validar_notificar($notificar)
    {
        if ($notificar == 1 || $notificar == 0){
             return TRUE;
        } 
        else{
            return FALSE;
        }
    }

    /********************************bloque para Actualizar contaseña***************************************************/


    public function update_password()
    {
        $data = $this->ui_model->cargar_nav();
        if (!$this->is_logged_in()){
             redirect('login');
        } 
        else{

            
            $data['main_content'] = 'profile/form_password';
            $data['title'] = 'Actualizar Contraseña';
            $this->load->view('template',$data);
        }
    }
    public function check_update_password()
    {
        $data = $this->ui_model->cargar_nav();
        if (!$this->is_logged_in()){
             redirect('login');
        } 
        else{
            
            $this->form_validation->set_rules('old_password', 'Contraseña actual', 'trim|required|callback__check_password|alpha_numeric|xss_clean');
            $this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[6]|max_length[20]|alpha_numeric|xss_clean');
            $this->form_validation->set_rules('re_password', 'Repita Contaseña', 'trim|required|matches[password]|xss_clean');

            $this->form_validation->set_message('required', 'El Campo %s Es requrida');
            $this->form_validation->set_message('_check_password', '%s Incorrecta');

            if ($this->form_validation->run() == FALSE) {
                $this->update_password();
            }
            else{
                $datos = array('password' => sha1($this->input->post('password')));
                $this->registered_model->update_password($datos);
                $data['usuario'] = $this->registered_model->get_user($this->session->userdata('id_user'));
                $data['mensaje'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Contraseña actualizada!</strong> La contaseña se acualizo con exito</div>";
                $data['title'] = 'Contraseña actualizado';
                $data['numero'] = $this->gif_model->num_imagenes_username($this->session->userdata('username'));   
                $data['main_content'] = 'profile/index';
                $this->load->view('template',$data);
            }
        }
    }

    function _check_password($old_password)
    {
        return $this->registered_model->check_password(sha1($old_password));
    }


     /********************************Cierra session y comprobar si hay secion***************************************************/
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
    function rest_pass() {
        if ($this->is_logged_in()){
             redirect('gifs');
        } 
        else{
                $data = $this->ui_model->cargar_nav();
                $data['title'] = 'Restaurar contraseña';
               // $data['main_content'] = 'profile/recovery';
                 $data['main_content'] = 'profile/form_user';
                $this->load->view('template',$data);
            
        }
    }
    
    function by_email() {
        if ($this->is_logged_in()){
             redirect('gifs');
        } 
        else{
            $data = $this->ui_model->cargar_nav();
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|callback__by_email|xss_clean');
            $this->form_validation->set_message('_by_email', '%s No existe');
           if ($this->form_validation->run() == FALSE) {
                    $data['title'] = 'Restaurar contraseña';
                    $data['main_content'] = 'profile/form_user';
                    $this->load->view('template',$data);
            }
            else {
                $this->registered_model->password_mail($this->input->post('email'), FALSE);
                $data['title'] = 'E-mail enviado';
                $data['enviado'] = 'Email enviado por email';
                $data['main_content'] = 'profile/success_email';
                $this->load->view('template',$data);
            }
        }
    }
    
    function by_username() {
        if ($this->is_logged_in()){
             redirect('gifs');
        } 
        else{

            $data = $this->ui_model->cargar_nav();
            $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash|callback__by_username|xss_clean');
      
            $this->form_validation->set_message('_by_username', '%s No existe');
           if ($this->form_validation->run() == FALSE) {
                    $data['title'] = 'Restaurar contraseña';
                    $data['main_content'] = 'profile/form_user';
                    $this->load->view('template',$data);
            }
            else {
                $this->registered_model->password_mail( FALSE , $this->input->post('username'));
                $data['title'] = 'E-mail enviado';
                $data['enviado'] = 'Email enviado por username';
                $data['main_content'] = 'profile/success_email';
                $this->load->view('template',$data);
            }
        }
    }
    
    function new_pass($username,$code) {
        if ($this->is_logged_in()){
             redirect('gifs');
        } 
        else{
            $data = $this->ui_model->cargar_nav();
            if($this->registered_model->check_code($username, $code)){
                $data['username'] = $username;
                $data['code'] = $code;
                $data['main_content'] = 'profile/recovery_password';
                $data['title'] = 'recuperar Contraseña';
                $this->load->view('template',$data);
            }
            else{
                $data['enviado'] = 'Que pasa esto no es valido';
                $data['title'] = 'Restaurar contraseña';    
                $data['main_content'] = 'profile/success_email';
                $this->load->view('template',$data);
            } 
        }
    }
    public function check_new_pass()
    {
        $data = $this->ui_model->cargar_nav();
        if ($this->is_logged_in()){
             redirect('gifs');
        } 
        else{

            if ($this->registered_model->check_code($this->input->post('username'), $this->input->post('code'))) {

                $this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[6]|max_length[20]|alpha_numeric|xss_clean');
                $this->form_validation->set_rules('re_password', 'Repita Contaseña', 'trim|required|matches[password]|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    $data['username'] = $this->input->post('username');
                    $data['code'] = $this->input->post('code');
                    $data['main_content'] = 'profile/recovery_password';
                    $data['title'] = 'recuperar Contraseña';
                    $this->load->view('template',$data);
                }
                else{
                    $datos = array('password' => sha1($this->input->post('password')));
                    $this->registered_model->new_password($datos,$this->input->post('username'));
                    $data['title'] = 'Usuarios';
                    $data['main_content'] = 'user/form_login';
                    $this->load->view('includes/template',$data);
                }

            }
            else{
                redirect('gifs');
            }
        }
    }

    function _by_username($username)
    {
        
            return $this->registered_model->check_update_username($username);
        
    }
    function _by_email($email)
    {
        
            return $this->registered_model->check_update_email($email);
    }

    public function star($username, $code)
    {
        $datos = $this->user_model->get_user_star($username, $code);
        if (isset($datos) && $datos['estado']  != '1') {
            $this->user_model->estrella($datos['id_user'], 'estrellas+1');
            $this->user_model->change_estado(array('estado' => '1'), $datos['id_user']);
            $this->user($username);
        }else{
            $data = $this->ui_model->cargar_nav();
            $data['mensaje'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario no existe o ya tienes tu regalo de regalo</strong></div>";
            $data['main_content'] = 'profile/error_404';
            $data['title'] = 'Error el usuario no existe';
            $this->load->view('template',$data);
        }
    }

    public function bestuser($value = 5)
    {
        $data = $this->ui_model->cargar_nav();
        if($value > 6){
        	$value = 6;
        }
        $data['datos_user'] = $this->user_model->star($value);
         $data['anuncio'] = 1;
        $data['title'] = $data['best'];
        $data['main_content'] = 'user/best_user';
        $this->load->view('template',$data);
    }
    
}