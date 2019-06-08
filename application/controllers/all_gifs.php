<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class All_Gifs extends CI_Controller
{
	 public function __construct() {
        parent::__construct();
        
        if (!$this->is_logged_in()) {
            redirect('login');
        }
        elseif ($this->session->userdata('rol') >= 3)
        {
            redirect('gifs');
        }
        $this->load->model('all_gifs_model');
        $this->load->model('user_model');
        
    }
    public function index($orden = 'fecha')
    {
        $data = $this->ui_model->cargar_nav();
        $data['title'] = 'Todos los GIFS';

        $pages=20; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'all_gifs/index/'.$orden; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->all_gifs_model->count_gifs();//calcula el número de filas 
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 8; //Número de links mostrados en la paginación
        
        $config['num_tag_open'] = '<span class="badge blanquear">';
        $config['num_tag_close'] = '</span>';

        $config['cur_tag_open'] = '<span class="badge badge-info">';
        $config['cur_tag_close'] = '</span>';

        $config['first_link'] = $this->lang->line('nav_first');//primer link
        $config['first_tag_open'] = '<li class="next">';
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
        $data["gifs"] = $this->all_gifs_model->get_gifs($config['per_page'],$this->uri->segment(4),$orden);           
                //cargamos la vista y el array data
        $data['main_content'] = 'all_gifs/index';
        
        $this->load->view('template',$data);

    }


    public function editar_gif($img)
    {
        $data = $this->ui_model->cargar_nav();
        $data['select_categoria'] = $this->categoria_model->get_select_categoria();
        $data['gif'] = $this->gif_model->get_gif($img);
        $data['main_content'] = 'all_gifs/edit_gif';
        $this->load->view('template', $data);
    }

    public function user_gifs($username = 'anonimo')
    {
        $data = $this->ui_model->cargar_nav();
        $data['title'] = 'Todos los GIFS';
        if(!$this->user_model->check_username($username)){
            $pages=10; //Número de registros mostrados por páginas
            $config['base_url'] = base_url().'all_gifs/index/'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
            $config['total_rows'] = $this->all_gifs_model->count_gifs_user($username);//calcula el número de filas 
            $config['per_page'] = $pages; //Número de registros mostrados por páginas
            $config['num_links'] = 8; //Número de links mostrados en la paginación
            
            $config['num_tag_open'] = '<span class="badge blanquear">';
            $config['num_tag_close'] = '</span>';

            $config['cur_tag_open'] = '<span class="badge badge-info">';
            $config['cur_tag_close'] = '</span>';

            $config['first_link'] = $this->lang->line('nav_first');//primer link
            $config['first_tag_open'] = '<li class="next">';
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
            $data["gifs"] = $this->all_gifs_model->get_gifs_user($config['per_page'],$this->uri->segment(3),$username);           
                    //cargamos la vista y el array data
            $data['main_content'] = 'all_gifs/index';
        }
        else{
            $data['main_content'] = 'all_gifs/error_404';
            $data['usuario'] = $username;
            $data['mensaje'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error!</strong> Usuario no existe</div>";
            
        }
         
        $this->load->view('template',$data);
        

    }
    private function is_logged_in()
    {
        return $this->session->userdata('is_logged_in');
    }
}