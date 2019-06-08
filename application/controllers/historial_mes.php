<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of historial_mes
 *
 * @author harry
 */
class historial_mes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('bpartner_model');
        $this->load->model('historial_mes_model');
        $this->load->model('user_model');

        if (!$this->is_logged_in()) {
            redirect('login');
        } elseif ($this->session->userdata('rol') != 1 && $this->session->userdata('estado') == 1) {
            redirect('gifs');
        }
    }

    public function index($orden = "fecha_mes") {
        $data = $this->ui_model->cargar_nav();
        $data['title'] = 'Historial de los meses';

        $pages = 40; //Número de registros mostrados por páginas
        $config['base_url'] = base_url() . 'historial_mes/index/' . $orden; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->historial_mes_model->count_dias(); //calcula el número de filas 
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
        $data["mes"] = $this->historial_mes_model->get_all($config['per_page'], $this->uri->segment(4), $orden);
        //cargamos la vista y el array data
        $data['main_content'] = 'historial_mes/index';

        $this->load->view('template', $data);
    }

    public function editar_mes($id) {
        if ($this->session->userdata('rol') == 1) {
            $data = $this->ui_model->cargar_nav();

            $data['title'] = 'Editar Partner';
            $data['main_content'] = 'historial_mes/form_editar';
            $data['mes'] = $this->historial_mes_model->get_mes($id);
            $this->load->view('template', $data);
        } else {
            redirect('gifs');
        }
    }

    public function check_mes() {

        $this->form_validation->set_rules('valor_pago', 'Valor pago', 'trim|required|xss_clean');
        $this->form_validation->set_rules('impresiones_mes', 'Impresiones_mes', 'trim|required|xss_clean');
 
        if ($this->form_validation->run() == FALSE) {
            $this->editar_mes($this->input->post('id_historial_mes'));
        } else {

            $data = array('valor_pago_mes' => $this->input->post('valor_pago'),
                'impresiones_mes' => $this->input->post('impresiones_mes'));

            $this->historial_mes_model->update_mes($this->input->post('id_historial_mes'), $data);

            redirect('historial_mes');
        }
    }

    private function is_logged_in() {
        return $this->session->userdata('is_logged_in');
    }

}
