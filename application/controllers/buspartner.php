<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Buspartner
 *
 * @author harry
 */
class Buspartner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('bpartner_model');
        $this->load->model('user_model');

        if (!$this->is_logged_in()) {
            redirect('login');
        } elseif ($this->session->userdata('rol') != 1 && $this->session->userdata('estado') == 1) {
            redirect('gifs');
        }
    }

    public function index($orden = "id_partner", $mensaje = FAlSE) {
        $data = $this->ui_model->cargar_nav();
        $data['title'] = 'Partners';

        if ($mensaje != FALSE) {
            $data['mensaje'] = $mensaje;
        }


        $pages = 30; //Número de registros mostrados por páginas
        $config['base_url'] = base_url() . 'buspartner/index/' . $orden; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->bpartner_model->count_partner(); //calcula el número de filas 
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
        $data["partner"] = $this->bpartner_model->get_all($config['per_page'], $this->uri->segment(4), $orden);
        //cargamos la vista y el array data
        $data['main_content'] = 'buspartner/index';

        $this->load->view('template', $data);
    }

    public function form_buspartner() {
        $data = $this->ui_model->cargar_nav();
        $data['title'] = 'Agregar Partner';
        $data['main_content'] = 'buspartner/form_partner';
        $this->load->view('includes_admin/template', $data);
    }

    function check_partner() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[20]|callback__check_username|alpha_dash|xss_clean');
        $this->form_validation->set_rules('correo', 'E-mail', 'trim|required|valid_email|callback__check_email|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->form_buspartner();
        } else {
            $this->bpartner_model->add_partner($this->input->post('username'), $this->input->post('correo'));

            redirect('buspartner');
        }
    }

    function _check_username() {

        return $this->bpartner_model->check_username($this->input->post('username'));
    }

    function update_estado($partner, $estado) {
        if ($this->session->userdata('rol') == 1) {
            $this->bpartner_model->update_estado($partner, $estado);
        }
        redirect('buspartner');
    }

    function plus_money($partner) {
        if ($this->session->userdata('rol') == 1) {
            if ($this->bpartner_model->check_estado($partner)) {
                $data = $this->ui_model->cargar_nav();
                $data['title'] = 'Cargar dinero';
                $data['partner_hi'] = $partner;
                $data['main_content'] = 'buspartner/form_plus';
                $this->load->view('includes_admin/template', $data);
            } else {

                redirect('buspartner');
            }
        }
    }

    function check_plus_money() {
        $this->form_validation->set_rules('money', 'Dinero', 'trim|max_length[12]|xss_clean');
        $this->form_validation->set_rules('impresiones', 'Impresiones', 'trim|max_length[12]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->plus_money($this->input->post('partner_hi'));
        } else {
            $this->bpartner_model->plus_money($this->input->post('partner_hi'), $this->input->post('money'), $this->input->post('impresiones'));
            redirect('buspartner');
        }
    }

    public function edit_partner($username) {
        if ($this->session->userdata('rol') == 1) {
            $data = $this->ui_model->cargar_nav();
            if ($this->bpartner_model->check_partner($username)) {
                $data['title'] = 'Editar Partner';
                $data['main_content'] = 'buspartner/edit_partner';
                $data['partner'] = $this->bpartner_model->get_data($username);
                $this->load->view('template', $data);
            } else {
                $data['mensaje'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Partner no existe!!</strong> que pasa Admin. </div>";
                $data['title'] = 'Editar cuenta';
                $data['main_content'] = 'user/error_404';
                $this->load->view('template', $data);
            }
        } else {
            redirect('partner');
        }
    }

    function check_update_part() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[20]|callback__check_username|alpha_dash|xss_clean');
        $this->form_validation->set_rules('correo_pago', 'E-mail', 'trim|required|valid_email|callback__check_email|xss_clean');
        $this->form_validation->set_rules('ingresos_actuales', 'Ingresos Actuales', 'trim|required|max_length[12]|xss_clean');
        $this->form_validation->set_rules('ultimo_pago', 'Ultimo Pago', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->edit_partner($this->input->post('yoPartner'));
        } else {

            $data = array('username' => $this->input->post('username'),
                'correo_pago' => $this->input->post('correo_pago'),
                'ingresos_actuales' => $this->input->post('ingresos_actuales'),
                'ultimo_pago' => $this->input->post('ultimo_pago'));

            $this->bpartner_model->update_partner($this->input->post('yoPartner'), $data);

            redirect('buspartner');
        }
    }

    function confirmar_mes($partner, $ingresos, $pag_vistas, $impresiones_actual) {
        $data = $this->ui_model->cargar_nav();

        $data['partner'] = $partner;
        $data['ingresos'] = $ingresos;
        $data['pag_vistas'] = $pag_vistas;
        $data['impresiones_actual'] = $impresiones_actual;
        $data['title'] = 'Confirmar pago';
        $data['main_content'] = 'buspartner/confirmar_mes';
        $this->load->view('template', $data);
    }

    function pagar_money($partner, $ingresos, $pag_vistas, $impresiones_actual) {
        $data = $this->ui_model->cargar_nav();
        if ($this->session->userdata('rol') == 1) {

            $this->bpartner_model->pagado_partner($partner, $ingresos);
            $this->bpartner_model->add_historial_mes($partner, $ingresos, $pag_vistas, $impresiones_actual);
            
            $mensaje = "<div class='alert alert-success' role='alert'> El pago se realizo satisfatoriamente </div>'";
        } else {
            $mensaje = "<div class='alert alert-danger' role='alert'> Error al tratar de hacer el pago </div>'";
        }

        redirect('buspartner');
        //$this->index('id_partner', $mensaje);
    }
    
    function done_paypal($partner, $saldo) {
         $data = $this->ui_model->cargar_nav();
        if ($this->session->userdata('rol') == 1 && $saldo >= 50) {

            $this->bpartner_model->add_pago($partner, $saldo);
            $this->bpartner_model->reset_saldo($partner);
            $mensaje = "<div class='alert alert-success' role='alert'> El pago se realizo satisfatoriamente </div>'";
        } else {
            $mensaje = "<div class='alert alert-danger' role='alert'> Error al tratar de hacer el pago </div>'";
        }

        redirect('buspartner');
    }

    private function is_logged_in() {
        return $this->session->userdata('is_logged_in');
    }

}
