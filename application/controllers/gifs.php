<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*Controlador principal, que nos gestiona todas las funcionalidades
 * de la aplicacion web
 */


class Gifs extends CI_Controller { 
    public function __construct() {
        parent::__construct();

    
    }
    //Funcion que nos muestra la pagina principal del la aplicacion
    public function index($mensaje =   FALSE){
        $data = $this->ui_model->cargar_nav();
        if ($mensaje != FALSE) {
            $data['mensaje'] = $mensaje;
        }
         if($data['end'] == 1){
         	redirect('gifs/destacado');
         }
         $data['anuncio'] = 1;
         
         
        $data['title'] = 'ComGIFS '. $this->lang->line('nav_titulo');
        $data['main_content'] = 'gif/index';
        $data['datos']= $this->gif_model->get_imagenes();
        $data['most_view'] = $this->gif_model->get_most_view();
        $this->load->view('template',$data);
    }

    
    /*********Editar mis GIFS**********/
    public function editar_gif($img)
    {
        $data = $this->ui_model->cargar_nav();
        if (!$this->session->userdata('id_user')){
             redirect('gifs');
        }
        else{


            $comprobar = $this->gif_model->get_imagenes($img);
            if(empty($comprobar))
            {   
                //Si la imagen no existe nos muestra una pagina de error personalizada
                $data['main_content'] = 'gif/error_404';
                $data['imagen'] = $img;
                $data['titulo'] = $data['title'] = 'Error[Pagina no encontrada]';
                
                
            }
            else{

                if($this->session->userdata('username') === $comprobar['username'] || $this->session->userdata('rol') < 3){
                    $data['select_categoria'] = $this->categoria_model->get_select_categoria();
                    $data['gif'] = $this->gif_model->get_gif($img);
                    $data['title'] = 'Editar imagen';
                    $data['imagen'] = $img;
                    $data['main_content'] = 'gif/edit_gif';
                }
                else{
                    $data['main_content'] = 'gif/error_404';
                    $data['imagen'] = $img;
                    $data['titulo'] = $data['title'] = 'Error[Pagina no encontrada]';
                    $data['mensaje'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error!!</strong> verifica bien el enlace de tu foto imagen</div>";
                    
                }
            }
            $this->load->view('template',$data);
        }
    }


    public function check_edit_gif()
    {
        $data = $this->ui_model->cargar_nav();
        $this->form_validation->set_rules('titulo', 'Titulo', 'required|min_length[4]|max_length[120]|trim|xss_clean');
        $this->form_validation->set_rules('categoria[]', 'Categoria', 'required|trim|xss_clean|callback__validar_categoria');
        $this->form_validation->set_rules('etiquetas', 'Etiqueta', 'max_length[160]|trim|xss_clean');
        $this->form_validation->set_message('required', 'El %s no puede ir vacío!');
        $this->form_validation->set_message('_validar_categoria', '%s no es validad');
        
        $this->form_validation->set_message('min_length', 'El %s debe tener al menos %s carácteres');
        $this->form_validation->set_message('max_length', 'El %s no puede tener más de %s carácteres');
        if ($this->form_validation->run() == TRUE){
            $datos['titulo'] = $this->input->post('titulo');
            $datos['etiquetas'] = $this->input->post('etiquetas');
            $datos['video'] = $this->input->post('video');
            $datos['id_categoria'] = $this->input->post('categoria');
            $this->gif_model->update_gif($this->input->post('imagen'),$datos);

            $this->view($this->input->post('imagen'));
        }
        else{
            $this->editar_gif($this->input->post('imagen'));
        }
        
    }
    ///////////////**///
    public function delete_gif($img)
    {   
        $data = $this->ui_model->cargar_nav();
        $data['imagen'] = $img;
        if (!$this->session->userdata('id_user')){
             redirect('gifs');
        } 
        else{
            $comprobar = $this->gif_model->get_gif($img);
            if(empty($comprobar))
            {   
                //Si la imagen no existe nos muestra una pagina de error personalizada
                $data['main_content'] = 'gif/error_404';
                $data['titulo'] = $data['title'] = 'Error[Pagina no encontrada]';
            }
            else
            {
                if($comprobar[0]['users_id_user'] === $this->session->userdata('id_user') || $this->session->userdata('rol') < 3){
                    $this->gif_model->borrar_gifs($img);
                    


                    $data['username'] = $this->session->userdata('username');
                    $data['mensaje'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>GIF Eliminado</strong> El Gif fue eliminado</div>";

                    $data['title'] = 'Gif eliminado';
                    $data['main_content'] = 'gif/eliminado';
                }
                else{
                    $data['main_content'] = 'gif/error_404';
                    $data['titulo'] = $data['title'] = 'Error[Pagina no encontrada]';
                }
            }
            $this->load->view('template',$data);
        }
    }

    //Funcion que muestra las imagenes depeniendo si la imagen exite
    public function view($img, $p = 'muygifs', $origen = FALSE) {

        $data = $this->ui_model->cargar_nav();
        $data['datos'] = $this->gif_model->get_imagenes($img);
        if (empty($data['datos'])) {
            //Si la imagen no existe nos muestra una pagina de error personalizada
            $data['main_content'] = 'gif/error_404';
            $data['most_view'] = $this->gif_model->get_most_view();
            $data['imagen'] = $img;
            $data['titulo'] = $data['title'] = 'Error[Pagina no encontrada]';
            $this->load->view('template', $data);
        } else {

            //Partner

            if ($p != 'muygifs') {

                if ($this->gif_model->check_partner($p)) {
                    $this->gif_model->sumar_par($p);
                }
                else {
                    $this->gif_model->sumar_par('muygifs');
                }
            } else {
                $this->gif_model->sumar_par('muygifs');
            }

            if($this->session->userdata('rol') == 4){
                $data["p"] = $this->session->userdata('username');
            } else {
                $data["p"] = 'muygifs';
            }
        

            $this->gif_model->sumar($img, 'vista');
            if ($data['end'] == 1) {
                $data['datos_r'] = $this->gif_model->buscar_categoria($data['datos']['id_categoria'], 3, 1, TRUE);
            } else {
                $data['datos_r'] = $this->gif_model->buscar_categoria($data['datos']['id_categoria'], 5, 1, TRUE);
            }
//Si existe un video 
            if (isset($data['datos']['video'])) {

                //Si el usuario fuerza a ver el GIF original
                if ($origen != FALSE) {
                    $data['main_content'] = 'gif/view';
                } else {
                    $data['main_content'] = 'gif/view_video';
                }
            }
            //Si no
            else {
                $data['main_content'] = 'gif/view';
            }

            
            $data['abuso'] = 'disabled';
             $data['view'] = 1;
             $data['banner'] = 1;
            //$data['gusta'] = 'disabled';
            $data['title'] = $data['datos']['titulo'];

            $this->load->view('template', $data);
        }
    }

    public function denunciar($img)
    {
        $this->gif_model->sumar($img,'denunciar');
    }

    //Funcion para mostrar el formulario para subir las imagenes
    public function subirgif(){
        
        if ($this->session->userdata('rol') > 1) {
            redirect('videos');
        }
        
        $data = $this->ui_model->cargar_nav();
        $data['select_categoria'] = $this->categoria_model->get_select_categoria();
        $data['title'] = $data['upload'];
        $data['error'] = ' ';
        $data['title_holder'] = $this->lang->line('nav_title_placeholder');
        $data['tag_holder'] = $this->lang->line('nav_tag_placeholder');
        $data['term'] = $this->lang->line('nav_term');
        $data['send'] = $this->lang->line('nav_send');
        $data['datos_r'] = $this->gif_model->gif_aleatorio();
        $data['main_content'] = 'gif/subir_form';
        $this->load->view('template',$data);
    }
    //Funcion para subir las imagenes al servidor
    public function do_upload(){
        $data = $this->ui_model->cargar_nav();
        $this->form_validation->set_rules('titulo', 'Titulo', 'required|min_length[4]|max_length[120]|trim|xss_clean');
        $this->form_validation->set_rules('categoria[]', 'Categoria', 'required|trim|xss_clean|callback__validar_categoria');
        $this->form_validation->set_rules('etiquetas', 'Etiqueta', 'max_length[160]|trim|xss_clean');
        $this->form_validation->set_rules('userfile', 'Userfile', 'xss_clean');
        $this->form_validation->set_rules('check', 'Los terminos', 'required');
        $this->form_validation->set_rules('etiquetas', 'Tags', 'max_length[160]|trim|xss_clean');

        //$this->form_validation->set_message('required', 'El %s no puede ir vacío!');
        $this->form_validation->set_message('_validar_categoria', '%s no es validad');
        
        $this->form_validation->set_message('min_length', 'El %s debe tener al menos %s carácteres');
        $this->form_validation->set_message('max_length', 'El %s no puede tener más de %s carácteres');
        if ($this->form_validation->run() == TRUE){
            $slug = rand(0, 99).''.url_title($this->input->post('titulo'), 'dash', TRUE);
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif';
            $config['max_size'] = '10000';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['file_name']= $slug;
    

            $this->load->library('upload', $config);

      
            
            if (!$this->upload->do_upload()) {
                $data['error'] = $this->upload->display_errors();
                $data['main_content'] = 'gif/subir_form';
                $data['select_categoria'] = $this->categoria_model->get_select_categoria();
                $data['title_holder'] = $this->lang->line('nav_title_placeholder');
                $data['tag_holder'] = $this->lang->line('nav_tag_placeholder');
                $data['term'] = $this->lang->line('nav_term');
                $data['send'] = $this->lang->line('nav_send');
                $data['datos_r'] = $this->gif_model->gif_aleatorio();
                $data['title'] = 'Error';
                $this->load->view('template',$data);    
               
            }
            else {
                $file_info = $this->upload->data();
                //echo $file_info['file_name'];
                
                $campo['imagen'] = $file_info['file_name'];
                $campo['titulo'] =  $this->input->post('titulo');
                $campo['etiquetas'] =  $this->input->post('etiquetas');
                $campo['categoria'] =  $this->input->post('categoria');
                $campo['id_user'] =  $this->session->userdata('id_user');
                $this->gif_model->subir($campo);
                
                $this->_create_thumbnail($file_info['file_name']);
                
                //$this->gif_model->subir_servers3($file_info['file_name'],'/uploads/','gifs/');
                //$this->view($campo['imagen']);
                redirect('gifs/view/'.$campo['imagen']);
            }

        }
        else{
             $this->subirgif();
        }
    }
    
    function _validar_categoria($categoria) {
        if($categoria == 1)
        {
            return FALSE;
        }
        else{
            return $this->categoria_model->check_categoria($categoria);
        }
        
    }

    //Funcion para crear imagenes de vista previa o thumbnail
    function _create_thumbnail($filename){
        $config['image_library'] = 'gd2';
        //CARPETA EN LA QUE EST�? LA IMAGEN A REDIMENSIONAR
        $config['source_image'] = 'uploads/'.$filename;
        $config['thumb_marker'] = '';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
        $config['new_image']='uploads/thumbs/';
        $config['width'] = 150;
        $config['height'] = 150;
       

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
     
        //Se sube al servidor de amazon s3
        //$this->gif_model->subir_servers3($filename,'/uploads/thumbs/','thumbs/');
       
    }

    //Funcion para la paginacion
    function ultimos(){
        
        $data = $this->ui_model->cargar_nav();
        $data['encabezado'] = $data['title'] = $data['most_recent'];
	$data['anuncio'] = 1;
        $pages=16; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'gifs/ultimos/'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
        $config['total_rows'] = $this->gif_model->filas_nuevos();//calcula el número de filas 
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 4; //Número de links mostrados en la paginación
        
        $config['num_tag_open'] = '<span class="badge  ">';
        $config['num_tag_close'] = '</span>';

        $config['cur_tag_open'] = '<span class="badge badge-success">';
        $config['cur_tag_close'] = '</span>';

        $config['first_link'] = $this->lang->line('nav_first');//primer link
        $config['first_tag_open'] = '<li class="previous">';
        $config['first_tag_close'] = '</li>';

       $config['last_link'] = $this->lang->line('nav_last');//último link
            $config['last_tag_open'] = '<li class="next" >';
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
        $data["datos"] = $this->gif_model->total_paginados($config['per_page'],$this->uri->segment(3));           
                //cargamos la vista y el array data
        $data['main_content'] = 'gif/page_view';
        
        $this->load->view('template',$data);
    }
    function destacado(){
        $data = $this->ui_model->cargar_nav();
        $data['encabezado'] = $data['title'] = $data['most_viewed'];
        $data['anuncio'] = 1;
        $pages=16; //Número de registros mostrados por páginas
        $config['base_url'] = base_url().'gifs/destacado/'; // parametro base de la aplicación, si tenemos un .htaccess 
        $config['total_rows'] = $this->gif_model->filas_vistos();
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 4; //Número de links mostrados en la paginación
        
       $config['num_tag_open'] = '<span class="badge  ">';
        $config['num_tag_close'] = '</span>';

        $config['cur_tag_open'] = '<span class="badge badge-success">';
        $config['cur_tag_close'] = '</span>';

         $config['first_link'] = $this->lang->line('nav_first');//primer link
        $config['first_tag_open'] = '<li class="previous">';
        $config['first_tag_close'] = '</li>';

       $config['last_link'] = $this->lang->line('nav_last');//último link
            $config['last_tag_open'] = '<li class="next" >';
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
        $data["datos"] = $this->gif_model->vistos_paginados($config['per_page'],$this->uri->segment(3));         
                //cargamos la vista y el array data
        $data['main_content'] = 'gif/page_view';
        $this->load->view('template',$data);
    }

    function gifsbuscar(){
        $data = $this->ui_model->cargar_nav();

        if($this->input->post('buscar_text')){
        
        	$campo =  $this->input->post('buscar_text',TRUE);
        	 $campo = preg_replace('[%20]'," ", $campo);
        }
        else{
        	$campo= $this->uri->segment(3);
        	 $campo = preg_replace('[%20]'," ", $campo);
        }

            

            $data['encabezado'] = $data['title'] = $data['search_term'].$campo;
            $data['anuncio'] = 1;

            $pages=12; //Número de registros mostrados por páginas

            $config['base_url'] = base_url().'gifs/gifsbuscar/'.$campo; // parametro base de la aplicación, si tenemos un .htaccess 
            $config['total_rows'] = $this->gif_model->num_buscar_gif($campo);
            if($config['total_rows'] < 1 && $this->gif_model->num_buscar_user($campo) < 1){
                
                $data['result']= $this->lang->line('nav_result');
                $data['main_content'] = 'gif/noresult';
                
            }
            else{
                
                $config['per_page'] = $pages; //Número de registros mostrados por páginas
                $config['num_links'] = 4; //Número de links mostrados en la paginación
                $config['uri_segment'] = 4; 
                $config['num_tag_open'] = '<span class="badge blanquear">';
                $config['num_tag_close'] = '</span>';

                $config['cur_tag_open'] = '<span class="badge badge-info">';
                $config['cur_tag_close'] = '</span>';

               $config['first_link'] = $this->lang->line('nav_first');//primer link
        $config['first_tag_open'] = '<li class="previous">';
        $config['first_tag_close'] = '</li>';

       $config['last_link'] = $this->lang->line('nav_last');//último link
            $config['last_tag_open'] = '<li class="next" >';
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
                $data["datos"] = $this->gif_model->buscar_gif($campo,$config['per_page'],$this->uri->segment(4));         
                        //cargamos la vista y el array data
                $data['dato_user'] = $this->gif_model->buscar_user($campo);
                $data['main_content'] = 'gif/page_buscar';
                
            }
           
        
        $this->load->view('template',$data);
    }
    
    function gifscategoria(){
        $data = $this->ui_model->cargar_nav();
        $data['anuncio'] = 1;
        $cate =  $this->categoria_model->get_categoria($this->uri->segment(3));
        if(isset($cate)){

            $data['title'] = $data['category_li'].' : '.$cate;
            $pages=16; //Número de registros mostrados por páginas
            $config['total_rows'] = $this->gif_model->num_buscar_categoria($this->uri->segment(3));
            $data['encabezado']=  $this->lang->line('nav_category').' : '.$cate;
            if ($config['total_rows'] > 0) {
                $config['uri_segment'] = 4; 
                $config['base_url'] = base_url().'gifs/gifscategoria/'.$this->uri->segment(3); // parametro base de la aplicación, si tenemos un .htaccess        
                $config['per_page'] = $pages; //Número de registros mostrados por páginas
                $config['num_links'] = 4; //Número de links mostrados en la paginación
                $config['num_tag_open'] = '<span class="badge blanquear">';
                $config['num_tag_close'] = '</span>';
                
                $config['cur_tag_open'] = '<span class="badge badge-info">';
                $config['cur_tag_close'] = '</span>';

                $config['first_link'] = $this->lang->line('nav_first');//primer link
        $config['first_tag_open'] = '<li class="previous">';
        $config['first_tag_close'] = '</li>';

       $config['last_link'] = $this->lang->line('nav_last');//último link
            $config['last_tag_open'] = '<li class="next" >';
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
                $data["datos"] = $this->gif_model->buscar_categoria($this->uri->segment(3),$config['per_page'], $this->uri->segment(4));         
                
                }        //cargamos la vista y el array data
        }
        
        else{
            $data['encabezado']=  $this->lang->line('nav_category').' : '.$this->lang->line('nav_exist');
        }

        $data['main_content'] = 'gif/page_view';
        $this->load->view('template',$data);
    }
    
    function gifsetiquetas(){
        $data = $this->ui_model->cargar_nav();
        $data['anuncio'] = 1;
        $campo =  $this->uri->segment(3);
        $campo = preg_replace('[%20]'," ", $campo);
        $data['title'] = $data['tags_li'].' : '.$campo;

        $pages=16; //Número de registros mostrados por páginas


        $config['base_url'] = base_url().'gifs/gifsetiquetas/'.$campo; // parametro base de la aplicación, si tenemos un .htaccess 
        $config['uri_segment'] = 4;
        $config['total_rows'] = $this->gif_model->num_buscar_etiqueta($campo);
        if($config['total_rows'] < 1){
           $data['encabezado']=  $this->lang->line('nav_tags_li').' : '.$this->lang->line('nav_exist');
        }
        else{
           $data['encabezado']=  $this->lang->line('nav_tags_li').' : '.$campo;
        
            
        $config['per_page'] = $pages; //Número de registros mostrados por páginas
        $config['num_links'] = 4; //Número de links mostrados en la paginación
        $config['num_tag_open'] = '<span class="badge blanquear">';
        $config['num_tag_close'] = '</span>';
        
        $config['cur_tag_open'] = '<span class="badge badge-info">';
        $config['cur_tag_close'] = '</span>';

        $config['first_link'] = $this->lang->line('nav_first');//primer link
        $config['first_tag_open'] = '<li class="previous">';
        $config['first_tag_close'] = '</li>';

       $config['last_link'] = $this->lang->line('nav_last');//último link
            $config['last_tag_open'] = '<li class="next" >';
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
        $data["datos"] = $this->gif_model->buscar_etiqueta($campo,$config['per_page'], $this->uri->segment(4));         
                //cargamos la vista y el array data
    }
        $data['main_content'] = 'gif/page_view';
        $this->load->view('template',$data);
    }

    function aleatorio(){
        $data = $this->ui_model->cargar_nav();
        $dato_random = $this->gif_model->imagen_aleatoria();
        
         redirect('gifs/view/'.$dato_random['imagen']);
    }
    function forzar_descarga(){
        
        $direccion = $this->input->post('descarga');
        header("Content-disposition: attachment; filename=$direccion");
        header("Content-type: application/octet-stream");
        readfile($direccion);
        $this->gif_model->sumar($gif, 'numero_descargas');
    }

}