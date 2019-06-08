<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Controller
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
        $data['title'] = 'ComGifs - Sube y descarga Gratis imagenes animadas gifs graciosas de todo tipo';
        $data['tag'] = $this->tag_model->main_tag();
        $data['main_content'] = 'tag/index';
        $this->load->view('includes_admin/template',$data);

	}

	public function form_editar(){
		$data = $this->ui_model->cargar_nav();
		$data['get'] = $this->uri->segment(3);
		$data['value'] = $this->tag_model->get_tag($data['get']);
		$data['title'] = 'Editar etiquetas';
		$data['main_content'] = 'tag/form_editar';
		$this->load->view('includes_admin/template',$data);
	}

	public function update_tag(){
		$data = $this->ui_model->cargar_nav();
        $this->form_validation->set_rules('tag', 'Etiqueta', 'required|min_length[2]|max_length[70]|trim|xss_clean');
        $this->form_validation->set_message('required', 'La %s no puede ir vacío!');
        if ($this->form_validation->run() == TRUE){
        	$success = $this->tag_model->update_tag($this->input->post('segment'),$this->input->post('tag'));

            $data = $this->ui_model->cargar_nav();
            $data['mensaje'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Etiqueta actualizada!</strong> La Etiqueta se acualizo con exito</div>";
            $data['title'] = 'Etiqueta actualizada';	
        	$data['main_content'] = 'tag/index';
        	$this->load->view('includes_admin/template',$data);
        }
        else{
            $data['get'] = $this->input->post('segment');
        	$data['title'] = 'Editar Etiqueta';
			$data['main_content'] = 'tag/form_editar';
			$this->load->view('includes_admin/template',$data);
        }

	}

	public function form_add(){
		$data = $this->ui_model->cargar_nav();
		$data['title'] = 'Agregar Etiqueta';
		$data['main_content'] = 'tag/form_agregar';
		$this->load->view('includes_admin/template',$data);
	}

	public function add_tag(){
        $data = $this->ui_model->cargar_nav(); 
        $this->form_validation->set_rules('tag', 'Etiqueta', 'required|min_length[2]|max_length[70]|trim|xss_clean');
        $this->form_validation->set_message('required', 'La %s no puede ir vacío!');
        if ($this->form_validation->run() == TRUE){
       		
       		$success = $this->tag_model->add_tag($this->input->post('tag'));
             
       		if($success == 1){
       		 	
        	$data['mensaje'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Etiqueta añadida!</strong> La etiqueta se añadio con exito</div>";
            $data['title'] = 'Etiqueta añadida';
            }
            else{
                $data['mensaje'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error!!</strong> se produjo un error al añadir la Etiqueta</div>";
                $data['title'] = 'Error al añadir Etiqueta';
            }
        	
        	$data['main_content'] = 'tag/index';
        	$this->load->view('includes_admin/template',$data);
        }
        else{
        	
        	$data['title'] = 'Editar Etiqueta';
			$data['main_content'] = 'tag/form_agregar';
			$this->load->view('includes_admin/template',$data);
        }

	}

	public function delete_categoria(){
		
		$delete = $this->tag_model->delete($this->uri->segment(3));
		$data = $this->ui_model->cargar_nav();
		$data['title'] = 'Etiqueta eliminada';
		$data['mensaje'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Etiqueta borrada!!</strong> Etiqueta eliminada con exito. </div>";
		$data['main_content'] = 'tag/index';
		$this->load->view('includes_admin/template',$data);
	}


    private function is_logged_in()
    {
        return $this->session->userdata('is_logged_in');
    }

}