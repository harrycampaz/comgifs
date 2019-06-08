<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if (!$this->is_logged_in()) {
            redirect('login');
        }
        elseif ($this->session->userdata('rol') >= 3)
        {
            redirect('gifs');
        }
        $this->load->model('reporte_model');
	}

	public function index($orden = 'fecha_suspencion')
	{
            $data = $this->ui_model->cargar_nav();
            $data['reporte'] = $this->reporte_model->get_reportes($orden);
            $data['title'] = "Reportes";
            $data['main_content'] = 'reporte/index';
            $this->load->view('template',$data);
	}
	public function reportar($id_user)
    {
        if ($this->session->userdata('rol') < 3 && $this->session->userdata('strike') < 4) {
                $data = $this->ui_model->cargar_nav();
                $data['title'] = 'Reporte de penalizacion';
                $data['usuario'] = $id_user;
                $data['main_content'] = 'reporte/form_reporte';

                $this->load->view('template', $data);
        } else {
            redirect('user');
        }
    }

    public function check_reporte()
    {
         if ($this->session->userdata('rol') < 3 && $this->session->userdata('strike') < 4) {
             $data = $this->ui_model->cargar_nav();

            $this->form_validation->set_rules('reporte', 'reporte', 'required|max_length[200]|trim|xss_clean');
            $this->form_validation->set_rules('usuario', 'usuario', 'required|trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->index();
            } 
            else {
                $datos = array('users_id_user' => $this->input->post('usuario'), 'reporte' => $this->input->post('reporte'));
                $success = $this->reporte_model->add_reporte($datos);
                if ($success == 1) {
                
                    $data['mensaje'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Reporte añadido!</strong>El reporte fue creado</div>";
                    $data['title'] = 'Reporte escrito';
                    $data['main_content'] = 'reporte/index';
                	$this->load->view('template', $data);
                }
            }

        } else {
            redirect('user');
        }
        
    }
    private function is_logged_in()
    {
        return $this->session->userdata('is_logged_in');
    }

}

/* End of file reporte.php */
/* Location: ./application/controllers/reporte.php */