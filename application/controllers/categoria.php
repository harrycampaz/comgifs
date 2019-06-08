<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoria extends CI_Controller
{
	 public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in()) {
            redirect('login');
        }
        elseif ($this->session->userdata('rol') != 1 && $this->session->userdata('estado') == 1)
        {
            redirect('gifs');
        }
    }
	
	public function index(){
		$data = $this->ui_model->cargar_nav();
        $data['title'] = 'Cgifs - Sube y descarga Gratis imagenes animadas gifs graciosas de todo tipo';
        $data['main_content'] = 'categoria/index';
        $this->load->view('includes_admin/template',$data);

	}

	public function form_editar(){
		$data = $this->ui_model->cargar_nav();
		$data['get'] = $this->uri->segment(3);
		$data['value'] = $this->categoria_model->get_categoria($data['get']);
		$data['title'] = 'Editar categoria';
		$data['main_content'] = 'categoria/form_editar';
		$this->load->view('includes_admin/template',$data);
	}

	public function update_categoria(){
		$data = $this->ui_model->cargar_nav();
        $this->form_validation->set_rules('categoria', 'Categoria', 'required|min_length[5]|max_length[70]|trim|xss_clean');
        $this->form_validation->set_message('required', 'La %s no puede ir vacío!');
        if ($this->form_validation->run() == TRUE){
        	$success = $this->categoria_model->update_categoria($this->input->post('segment'),$this->input->post('categoria'));

            $data = $this->ui_model->cargar_nav();
            $data['mensaje'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Categoria actualizada!</strong> La categoria se acualizo con exito</div>";
            $data['title'] = 'Categoria actualizada';	
        	$data['main_content'] = 'categoria/index';
        	$this->load->view('includes_admin/template',$data);
        }
        else{
            $data['get'] = $this->input->post('segment');
        	$data['title'] = 'Editar categoria';
			$data['main_content'] = 'categoria/form_editar';
			$this->load->view('includes_admin/template',$data);
        }

	}

	public function form_add(){
		$data = $this->ui_model->cargar_nav();
		$data['title'] = 'Agregar categoria';
		$data['main_content'] = 'categoria/form_agregar';
		$this->load->view('includes_admin/template',$data);
	}

	public function add_categoria(){
        $data = $this->ui_model->cargar_nav(); 
        $this->form_validation->set_rules('categoria', 'Categoria', 'required|min_length[5]|max_length[70]|trim|xss_clean');
        $this->form_validation->set_message('required', 'La %s no puede ir vacío!');
        if ($this->form_validation->run() == TRUE){
       		
       		$success = $this->categoria_model->add_categoria($this->input->post('categoria'));
             
       		if($success == 1){
       		 	
        	$data['mensaje'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Categoria añadida!</strong> La categoria se añadio con exito</div>";
            $data['title'] = 'Categoria añadida';
            }
            else{
                $data['mensaje'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error!!</strong> se produjo un error al añadir la categoria</div>";
                $data['title'] = 'Error al añadir categoria';
            }
        	
        	$data['main_content'] = 'categoria/index';
        	$this->load->view('includes_admin/template',$data);
        }
        else{
        	
        	$data['title'] = 'Editar categoria';
			$data['main_content'] = 'categoria/form_agregar';
			$this->load->view('includes_admin/template',$data);
        }

	}

	public function delete_categoria(){
		
		$delete = $this->categoria_model->delete($this->uri->segment(3));
		$data = $this->ui_model->cargar_nav();
		$data['title'] = 'Categoria eliminada';
		$data['mensaje'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Categoria borrada!!</strong> Categoria eliminada con exito. </div>";
		$data['main_content'] = 'categoria/index';
		$this->load->view('includes_admin/template',$data);
	}


    private function is_logged_in()
    {
        return $this->session->userdata('is_logged_in');
    }

}