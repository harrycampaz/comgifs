<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of partner
 *
 * @author harry
 */
class partner extends CI_Controller {
    
     public function __construct() {
        parent::__construct();
       
        if (!$this->is_logged_in()) {
            redirect('login');
        } elseif ($this->session->userdata('rol') != 4){
            redirect('gifs');
        }
         $this->load->model('bpartner_model');
         $this->load->model('all_gifs_model');
    }
    
     public function index($orden = "id_partner") {
        $data = $this->ui_model->cargar_nav();
        $data['historial_dia'] = $this->bpartner_model->get_historial_dia($orden, $this->session->userdata('username'));
        $data['historial_pagos'] = $this->bpartner_model->get_pagos($orden, $this->session->userdata('username'));
        $data['datos'] = $this->bpartner_model->get_data($this->session->userdata('username'));
       
        $data['title'] = 'Partners';
       
        $data['main_content'] = 'partner/index';

        $this->load->view('template', $data);
    }
    
    public function meses($orden = "id_partner") {
        $data = $this->ui_model->cargar_nav();
        $data['historial_meses'] = $this->bpartner_model->get_historial_meses($orden, $this->session->userdata('username'));
       
        $data['title'] = 'Ultimos 7 Meses';
       
        $data['main_content'] = 'partner/historial_mes';

        $this->load->view('template', $data);
    }
    
    
    
    function all_gifs($orden = 'fecha') {
         $data = $this->ui_model->cargar_nav();
        $data['title'] = 'Todos los GIFS';
        

        $pages=20; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'partner/all_gifs/'.$orden; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
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
        $data['main_content'] = 'partner/all_gifs';
        
        $this->load->view('template',$data);

    }
    
    function edit_correo() {
        $data = $this->ui_model->cargar_nav();
        $data['correo_paypal'] = $this->bpartner_model->get_email($this->session->userdata('username'));
        $data['title'] = 'Editar Correo de Paypal';
        
        
        $data['main_content'] = 'partner/edit_email';
        $this->load->view('template', $data);       
    }
    
    function check_paypal_mail() {
        $this->form_validation->set_rules('correo_pago', 'E-mail', 'trim|required|valid_email|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->edit_correo();
        } else {
            
            $data = array ('correo_pago' => $this->input->post('correo_pago'),);
            
            $this->bpartner_model->edit_mailpartner($this->session->userdata('username'),$data);

            redirect('partner');
        }
    }
    
    
    private function is_logged_in()
    {
        return $this->session->userdata('is_logged_in');
    }
}