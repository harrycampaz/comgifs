<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Controlador principal, que nos gestiona todas las funcionalidades
 * de la aplicacion web
 */

class Videos extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

//Funcion que nos muestra la pagina principal del la aplicacion
    public function index() {
        $this->destacados();
    }

    public function add_videos() {

        if ($this->session->userdata('rol') != 1 && $this->session->userdata('rol') != 4) {
            redirect('videos');
        } else {
            $data = $this->ui_model->cargar_nav();

            $data['title'] = 'Agregar Video';
            $data['select_categoria'] = $this->categoria_model->get_select_categoria();
            $data['main_content'] = 'video/form_agregar';

            $this->load->view('template', $data);
        }
    }

    public function check_video() {
        $data = $this->ui_model->cargar_nav();
        $this->form_validation->set_rules('titulo', 'Titulo', 'required|min_length[5]|max_length[180]|trim|xss_clean');
        $this->form_validation->set_rules('Avatar', 'Avatar', 'min_length[5]|max_length[500]|trim|xss_clean');

        $this->form_validation->set_rules('video', 'video', 'min_length[5]|max_length[1500]|trim');
        $this->form_validation->set_rules('descripcion', 'descripcion', 'required|min_length[5]|max_length[50000]|trim|xss_clean');
        $this->form_validation->set_rules('categoria[]', 'Categoria', 'required|trim|callback__validar_categoria');

        $this->form_validation->set_message('_validar_categoria', '%s no es validad');
        if ($this->form_validation->run() == FALSE) {

            $this->add_videos();
        } else {

            if ($this->input->post('check')) {
                $link = '<video id="video" loop controls="controls" width="280" height="215" muted >
                        <source src="' . $this->input->post('video') . '">';
            } else {
                $link = $this->input->post('video');
            }

            $enlace = rand(0, 99) . '' . url_title($this->input->post('titulo'), 'dash', TRUE);
            $datos = array('enlace' => $enlace,
                'avatar_video' => $this->input->post('avatar'),
                'titulo' => $this->input->post('titulo'),
                'video' => $link,
                'descripcion' => nl2br($this->input->post('descripcion')),
                'id_categoria' => $this->input->post('categoria'),
                'users_id_user' => $this->session->userdata('id_user'));

            $this->videos_model->insert_video($datos);

            redirect('videos/view/' . $enlace);
        }

        //$this->load->view('includes_admin/template', $data);
    }

    function _validar_categoria($categoria) {
        if ($categoria == 1) {
            return FALSE;
        } else {
            return $this->categoria_model->check_categoria($categoria);
        }
    }

    public function view($enlace, $p = 'muygifs') {
        $data = $this->ui_model->cargar_nav();


        $data['video'] = $this->videos_model->get_video($enlace);


        if (empty($data['video'])) {
            //Si la imagen no existe nos muestra una pagina de error personalizada

            $data['datos'] = $this->videos_model->get_random();
            $data['video_error'] = $enlace;
            $data['titulo'] = $data['title'] = 'Error[Pagina no encontrada]';
            $data['main_content'] = 'video/error_404';
        } else {
            $data['title'] = $data['video']['titulo'];

            $this->videos_model->sumar($enlace, 'vistas');

            $data['main_content'] = 'video/view';
            $data['mivideo'] = 1;
            $data['banner'] = 1;
            
        }

        if ($p != 'muygifs') {

            if ($this->gif_model->check_partner($p)) {
                $this->gif_model->sumar_par($p);
            } else {
                $this->gif_model->sumar_par('muygifs');
            }
        } else {
            $this->gif_model->sumar_par('muygifs');
        }

        if ($this->session->userdata('rol') == 4) {
            $data["p"] = $this->session->userdata('username');
        } else {
            $data["p"] = 'muygifs';
        }


        $this->load->view('template', $data);
    }

    public function ultimos() {

        $data = $this->ui_model->cargar_nav();


        $data['encabezado'] = $data['title'] = 'Ultimos Videos';


        $pages = 6; //Número de registros mostrados por páginas
        $config['base_url'] = base_url() . 'videos/ultimos/'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['total_rows'] = $this->videos_model->count_videos(); //calcula el número de filas 
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 4; //Número de links mostrados en la paginación


        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_link'] = $this->lang->line('nav_next') . '>>'; //siguiente link
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_link'] = '<<' . $this->lang->line('nav_previous'); //anterior link
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_link'] = $this->lang->line('nav_first'); //primer link
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_link'] = $this->lang->line('nav_last'); //último link
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        // $config['display_pages'] = FALSE;
        $this->pagination->initialize($config); //inicializamos la paginación        
        $data["datos"] = $this->videos_model->get_all($config['per_page'], $this->uri->segment(3));
        //cargamos la vista y el array data

        $data['main_content'] = 'video/page_view';


        $this->load->view('template', $data);
    }

    public function destacados() {

        $data = $this->ui_model->cargar_nav();


        $data['encabezado'] = $data['title'] = 'Videos Destacados';


        $pages = 6; //Número de registros mostrados por páginas
        $config['base_url'] = base_url() . 'videos/destacados/'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['total_rows'] = $this->videos_model->count_most(); //calcula el número de filas 
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 4; //Número de links mostrados en la paginación


        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_link'] = $this->lang->line('nav_next') . '>>'; //siguiente link
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_link'] = '<<' . $this->lang->line('nav_previous'); //anterior link
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_link'] = $this->lang->line('nav_first'); //primer link
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_link'] = $this->lang->line('nav_last'); //último link
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        // $config['display_pages'] = FALSE;
        $this->pagination->initialize($config); //inicializamos la paginación        
        $data["datos"] = $this->videos_model->get_most($config['per_page'], $this->uri->segment(3));
        //cargamos la vista y el array data


        $data['main_content'] = 'video/page_view';


        $this->load->view('template', $data);
    }

    public function listar($orden = 'fecha') {

        if (!$this->is_logged_in() || $this->session->userdata('rol') > 1) {
            redirect('videos');
        } else {
            $data = $this->ui_model->cargar_nav();


            $data['encabezado'] = $data['title'] = 'Todos los Videos';


            $pages = 6; //Número de registros mostrados por páginas
            $config['base_url'] = base_url() . 'videos/listar/' . $orden; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
            $config['total_rows'] = $this->videos_model->count_videos(); //calcula el número de filas 
            $config['per_page'] = $pages; //Número de registros mostrados por páginas
            $config['num_links'] = 4; //Número de links mostrados en la paginación
            $config['uri_segment'] = 4;

            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] = "</ul>";
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_link'] = $this->lang->line('nav_next') . '>>'; //siguiente link
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_link'] = '<<' . $this->lang->line('nav_previous'); //anterior link
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_link'] = $this->lang->line('nav_first'); //primer link
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_link'] = $this->lang->line('nav_last'); //último link
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";
            // $config['display_pages'] = FALSE;
            $this->pagination->initialize($config); //inicializamos la paginación        
            $data["datos"] = $this->videos_model->get_all($config['per_page'], $this->uri->segment(4), $orden);
            //cargamos la vista y el array data
            $data['main_content'] = 'video/listar_videos';


            $this->load->view('template', $data);
        }
    }

    public function editar_video($enlace) {

        if (!$this->is_logged_in() || $this->session->userdata('rol') > 1) {
            redirect('videos');
        } else {

            $data = $this->ui_model->cargar_nav();

            $data['title'] = 'Editar video ';
            $data['video_item'] = $this->videos_model->get_edit($enlace);
            $data['select_categoria'] = $this->categoria_model->get_select_categoria();
            $data['main_content'] = 'video/form_edit';

            $this->load->view('template', $data);
        }
    }

    public function check_edit() {
        if (!$this->is_logged_in() || $this->session->userdata('rol') > 1) {
            redirect('videos');
        } else {

            $data = $this->ui_model->cargar_nav();
            $this->form_validation->set_rules('avatar', 'Avatar', 'min_length[5]|max_length[1000]|trim|xss_clean');

            $this->form_validation->set_rules('titulo', 'Titulo', 'required|min_length[5]|max_length[180]|trim|xss_clean');
            $this->form_validation->set_rules('video', 'video', 'min_length[5]|max_length[1500]|trim');
            // $this->form_validation->set_rules('descripcion', 'descripcion', 'required|min_length[5]|max_length[5000]|trim');
            $this->form_validation->set_rules('categoria[]', 'Categoria', 'required|trim|callback__validar_categoria|xss_clean');

            $this->form_validation->set_message('_validar_categoria', '%s no es validad');
            if ($this->form_validation->run() == FALSE) {

                $this->add_videos();
            } else {

                if ($this->input->post('check')) {
                    $link = '<video id="video" loop controls="controls" width="280" height="215" muted >
                        <source src="' . $this->input->post('video') . '">';
                } else {
                    $link = $this->input->post('video');
                }


                $datos = array(
                    'titulo' => $this->input->post('titulo'),
                    'video' => $link,
                    'avatar_video' => $this->input->post('avatar'),
                    'id_categoria' => $this->input->post('categoria'),
                    'users_id_user' => $this->session->userdata('id_user'));

                $this->videos_model->update_video($this->input->post('enlace'), $datos);

                redirect('videos/view/' . $this->input->post('enlace'));
                //$this->load->view('includes_admin/template', $data);
            }
        }
    }

    public function borrar($enlace) {
        if (!$this->is_logged_in() || $this->session->userdata('rol') > 1) {
            redirect('videos');
        } else {

            $data = $this->ui_model->cargar_nav();

            $data['title'] = 'Editar video ';
            $data['video_item'] = $this->videos_model->get_video($enlace);

            $data['main_content'] = 'video/delete_video';

            $this->load->view('template', $data);
        }
    }

    public function confirmar_borrar($id) {
        if (!$this->is_logged_in() || $this->session->userdata('rol') > 1) {
            redirect('videos');
        } else {
            $this->videos_model->delete_video($id);
            redirect('videos/listar');
        }
    }

    private function is_logged_in() {
        return $this->session->userdata('is_logged_in');
    }
    
    ////////////////////////////////////////////PARTNER//////////////
    
    public function MisPost($orden = 'fecha') {

        if (!$this->is_logged_in() || ($this->session->userdata('rol')> 1 && $this->session->userdata('rol') < 4) ) {
            redirect('videos');
        } else {
            $data = $this->ui_model->cargar_nav();


            $data['encabezado'] = $data['title'] = 'Todos los Videos';


            $pages = 6; //Número de registros mostrados por páginas
            $config['base_url'] = base_url() . 'videos/MisPost/' . $orden; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
            $config['total_rows'] = $this->videos_model->count_Misvideos(); //calcula el número de filas 
            $config['per_page'] = $pages; //Número de registros mostrados por páginas
            $config['num_links'] = 4; //Número de links mostrados en la paginación
            $config['uri_segment'] = 4;

            $config['full_tag_open'] = "<ul class='pagination'>";
            $config['full_tag_close'] = "</ul>";
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
            $config['next_link'] = $this->lang->line('nav_next') . '>>'; //siguiente link
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_link'] = '<<' . $this->lang->line('nav_previous'); //anterior link
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_link'] = $this->lang->line('nav_first'); //primer link
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_link'] = $this->lang->line('nav_last'); //último link
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";
            // $config['display_pages'] = FALSE;
            $this->pagination->initialize($config); //inicializamos la paginación        
            $data["datos"] = $this->videos_model->get_mis($config['per_page'], $this->uri->segment(4), $orden);
            //cargamos la vista y el array data
            $data['main_content'] = 'video/listar_videos';


            $this->load->view('template', $data);
        }
    }

}
