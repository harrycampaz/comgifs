<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in()) {
            redirect('login');
        } elseif ($this->session->userdata('rol') >= 3) {
            redirect('gifs');
        }
        $this->load->model('user_model');
        
        $this->load->model('registered_model');
    }

    public function index($orden = 'fecha_registro') {
        if ($this->session->userdata('strike') < 4) {


            $data = $this->ui_model->cargar_nav();
            if ($this->session->userdata('rol') == 1) {
                $data['accion'] = TRUE;
            }
            $data['title'] = 'Todos los Usuarios';

            $pages = 20; //Número de registros mostrados por páginas
            $config['base_url'] = base_url() . 'user/index/' . $orden; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
            $config['uri_segment'] = 4;
            $config['total_rows'] = $this->user_model->count_user(); //calcula el número de filas 
            $config['per_page'] = $pages; //Número de registros mostrados por páginas
            $config['num_links'] = 8; //Número de links mostrados en la paginación

            $config['num_tag_open'] = '<span class="badge blanquear">';
            $config['num_tag_close'] = '</span>';

            $config['cur_tag_open'] = '<span class="badge badge-info">';
            $config['cur_tag_close'] = '</span>';

            $config['first_link'] = $this->lang->line('nav_first'); //primer link
            $config['first_tag_open'] = '<li class="next">';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = $this->lang->line('nav_last'); //último link
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $config['prev_link'] = '&larr;' . $this->lang->line('nav_previous'); //anterior link
            $config['prev_tag_open'] = '<li class="previous">';
            $config['prev_tag_close'] = '</li>';

            $config['next_link'] = $this->lang->line('nav_next') . '&rarr;'; //siguiente link
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';


            //  $config['display_pages'] = FALSE;


            $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="pager">'; //el div que debemos maquetar
            $config['full_tag_close'] = '</ul></div>'; //el cierre pagination-centered del div de la paginación
            $this->pagination->initialize($config); //inicializamos la paginación        
            $data["users"] = $this->user_model->get_all($config['per_page'], $this->uri->segment(4), $orden);
            //cargamos la vista y el array data
            $data['main_content'] = 'user/index';

            $this->load->view('template', $data);
        } else {
            redirect('gifs');
        }
    }

    public function delete_user($username) {
        $data = $this->ui_model->cargar_nav();
        $data['user'] = $username;
        if ($this->session->userdata('rol') < 3) {
            if (!$this->user_model->check_username($username)) {
                $data['title'] = 'Eliminar cuenta';
                $data['main_content'] = 'user/form_delete';
                $this->load->view('template', $data);
            } else {
                $data['mensaje'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario no existe!!</strong> que pasa MOD. </div>";
                $data['title'] = 'Eliminar cuenta';
                $data['main_content'] = 'user/error_404';
                $this->load->view('template', $data);
            }
        } else {
            redirect('gifs');
        }
    }

    public function check_delete_user() {
        $data = $this->ui_model->cargar_nav();
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[70]|trim|callback__check_password|xss_clean');
        $this->form_validation->set_message('required', 'La %s no puede ir vacío!');
        $this->form_validation->set_message('_check_password', '%s Incorrecta');
        if ($this->form_validation->run() == TRUE) {

            $delete = $this->user_model->delete($this->user_model->get_id($this->input->post('username')));

            $data['title'] = 'Usuario eliminado';
            $data['mensaje'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario eliminado!!</strong> </div>";
            $data['main_content'] = 'user/success';
            $this->load->view('template', $data);
        } else {
            $this->delete_user($this->input->post('username'));
        }
    }

    public function _check_password($password) {
        return $this->registered_model->check_password(sha1($password));
    }

    public function edit_user($id_user) {
        if ($this->session->userdata('rol') == 1) {
            $data = $this->ui_model->cargar_nav();
            if (!$this->user_model->check_id($id_user)) {
                $data['title'] = 'Eliminar cuenta';
                $data['main_content'] = 'user/form_edit';
                $data['usuario'] = $this->user_model->get_data($id_user);
                $data['roles'] = $this->user_model->get_roles();
                $this->load->view('template', $data);
            } else {
                $data['mensaje'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario no existe!!</strong> que pasa MOD. </div>";
                $data['title'] = 'Editar cuenta';
                $data['main_content'] = 'user/error_404';
                $this->load->view('template', $data);
            }
        } else {
            redirect('user');
        }
    }

    public function check_update() {

        if ($this->session->userdata('rol') == 1) {

            $this->form_validation->set_rules('name', 'Nombre', 'trim|required');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|callback__check_username|alpha_dash|xss_clean');
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|callback__check_email|xss_clean');
            $this->form_validation->set_rules('website', 'Website', 'trim|prep_url|xss_clean');
            $this->form_validation->set_rules('estrellas', 'estrellas', 'trim|integer|xss_clean');
            $this->form_validation->set_rules('ubicacion', 'ubicacion', 'trim|xss_clean');

            $this->form_validation->set_message('required', 'El Campo %s Es requrido');
            $this->form_validation->set_message('valid_email', 'El E-mail ingresado no es valido');
            $this->form_validation->set_message('_check_email', '%s ya existe en la base de datos');
            $this->form_validation->set_message('_check_username', 'Este Usuario ya existe en la base de datos');
            if ($this->form_validation->run() == FALSE) {
                $this->edit_user($this->input->post('id_user'));
            } else {
                $datos = array(
                    'myname' => $this->input->post('name'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'ubicacion' => $this->input->post('ubicacion'),
                    'estrellas' => $this->input->post('estrellas'),
                    'website' => $this->input->post('website'),
                    'roles_id_rol' => $this->input->post('rol'),);
                $this->user_model->update_users($datos, $this->input->post('id_user'));
                $this->index('fecha');
            }
        }
    }

    function _check_username($username) {
        if (!$this->is_logged_in()) {
            redirect('login');
        } else {
            return $this->user_model->check_update_username($username, $this->input->post('id_user'));
        }
    }

    function _check_email($email) {
        if (!$this->is_logged_in()) {
            redirect('login');
        } else {
            return $this->user_model->check_update_email($email, $this->input->post('id_user'));
        }
    }

    public function edit_estado($estado, $id_user) {
        if ($this->session->userdata('rol') < 3 && $this->session->userdata('strike') < 4) {
            $comprobar = $this->user_model->get_rol($id_user);
            if (isset($comprobar)) {
                if ($comprobar > 2 || $this->session->userdata('rol') == 1) {
                    if ($estado === '0') {
                        $estado = array('estado' => '1');
                    } elseif ($estado === '1') {
                        $estado = array('estado' => '0');
                    } else {
                        $estado = array('estado' => '0');
                    }
                    $this->user_model->change_estado($estado, $id_user);
                    redirect('user');
                }
            } else {
                $data = $this->ui_model->cargar_nav();
                $data['mensaje'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario no existe!!</strong> que pasa MOD. </div>";
                $data['title'] = 'Cambiar estado';
                $data['main_content'] = 'user/error_404';
                $this->load->view('template', $data);
            }
        } else {
            redirect('gifs');
        }
    }

    public function sumar_strike($id_user, $strike) {
        if ($this->session->userdata('rol') < 3 && $this->session->userdata('strike') < 4) {
            if (!$this->user_model->check_id($id_user)) {
                if ($strike < 4) {
                    $this->user_model->plus_strike($id_user);
                    
                }

                redirect('user');
            } else {
                $data = $this->ui_model->cargar_nav();
                $data['mensaje'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario no existe!!</strong> que pasa MOD. </div>";
                $data['title'] = 'Cambiar estado';
                $data['main_content'] = 'user/error_404';
                $this->load->view('template', $data);
            }
        } else {
            redirect('gifs');
        }
    }
    public function zero_strike($id_user) {
        if ($this->session->userdata('rol') < 3 && $this->session->userdata('strike') < 4) {
            if (!$this->user_model->check_id($id_user)) {
                $this->user_model->zero_strike($id_user);
                redirect('user');
            } else {
                $data = $this->ui_model->cargar_nav();
                $data['mensaje'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario no existe!!</strong> que pasa MOD. </div>";
                $data['title'] = 'Cambiar estado';
                $data['main_content'] = 'user/error_404';
                $this->load->view('template', $data);
            }
        } else {
            redirect('gifs');
        }
    }

    public function accion_estrella($accion, $id_user) {
        if ($this->session->userdata('rol') < 3 && $this->session->userdata('strike') < 4) {
            if (!$this->user_model->check_id($id_user)) {
                if ($accion == 'sumar') {
                    $this->user_model->estrella($id_user, 'estrellas+1');
                } else {
                    $this->user_model->estrella($id_user, 'estrellas-1');
                }

                redirect('user');
            } else {
                $data = $this->ui_model->cargar_nav();
                $data['mensaje'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Usuario no existe!!</strong> que pasa MOD. </div>";
                $data['title'] = 'Cambiar estado';
                $data['main_content'] = 'user/error_404';
                $this->load->view('template', $data);
            }
        } else {
            redirect('gifs');
        }
    }

    public function restaurar_avatar($id_user) {
        if ($this->session->userdata('rol') < 3 && $this->session->userdata('strike') < 4) {
            $datos = array('avatar' => '0be35ad538bdc3927ba4050dc2b7d6c7.gif');
            $this->user_model->restaurar_avatar($datos, $id_user);
            $this->index();
        } else {
            redirect('user');
        }
    }

    
    private function is_logged_in() {
        return $this->session->userdata('is_logged_in');
    }

}