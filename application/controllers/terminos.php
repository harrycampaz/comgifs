<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terminos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = $this->ui_model->cargar_nav();
	    //Si la imagen no existe nos muestra una pagina de error personalizada
	    $data['main_content'] = 'terminos/uso';
	    $data['title'] = 'Términos de Uso';
	    $this->load->view('template',$data);
	    
	}
	public function privacidad($value='')
	{
		$data = $this->ui_model->cargar_nav();
	    //Si la imagen no existe nos muestra una pagina de error personalizada
	    $data['main_content'] = 'terminos/privacidad';
	    $data['title'] = 'Términos de Uso';
	    $this->load->view('template',$data);
	}

}

/* End of file  */
/* Location: ./application/controllers/ */