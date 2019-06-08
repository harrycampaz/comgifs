<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 

define('PUBPATH',str_replace(SELF,'',FCPATH));

class Gif_Model extends CI_Model {
 
    public function construct() {
        parent::__construct();
    }
 
    //FUNCIÓN PARA INSERTAR LOS DATOS DE LA IMAGEN SUBIDA
    function subir($data)
    {
        if(empty($data['id_user']) || $this->session->userdata('strike') > 3){
            $data['id_user']  = 2;
        }
        $insert = array(
            'titulo' => $data['titulo'],
            'imagen' => $data['imagen'],
            'etiquetas' => $data['etiquetas'],
            'id_categoria' => $data['categoria'],
            'users_id_user' => $data['id_user'],
        );
        return $this->db->insert('imagenes', $insert);
    }
    
    //Esta funcion nos retorna las categorias que aparecen en el En la parte derecha de la pantalla
    
    function get_imagenes($data = FALSE){
        //Cuando no tiene parametros obtiene todas las imagenes y las retorna a la funcion index del controlador Gif
        if(empty($data)){
            $this->db->select('imagenes.id_imagen,imagenes.titulo,imagenes.imagen,imagenes.vista,imagenes.fecha,categorias.id_categoria,categorias.nombre_categoria,users.username');
            $this->db->from('imagenes');
            $this->db->join('categorias', 'imagenes.id_categoria = categorias.id_categoria');
            $this->db->join('users', 'imagenes.users_id_user = users.id_user');
            $this->db->order_by("fecha", "desc");
            $this->db->limit(12);
            $query = $this->db->get();
            foreach ($query->result() as $row)
            {
                $dato[$row->id_imagen] = array ('id_imagen'=>$row->id_imagen,
                                            'titulo'=>$row ->titulo,
                                            'username'=>$row ->username,
                                            'imagen' => $row->imagen,
                                            'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                                            'id_categoria' => $row->id_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                                            );

            }
        }
        //Cuando tiene parametros obtiene la imagen que solicito el usuario
        else{
            //obtiene el valor del titulo para retornarlo a la funcion view del controlador Gif
            $this->db->select('imagenes.id_imagen,imagenes.titulo,imagenes.imagen,imagenes.video,imagenes.etiquetas, imagenes.numero_descargas,imagenes.vista,imagenes.fecha,categorias.id_categoria,categorias.nombre_categoria,users.username');
            $this->db->join('users', "imagenes.users_id_user = users.id_user AND imagenes.imagen = '$data'");
            $this->db->join('categorias', 'imagenes.id_categoria = categorias.id_categoria');
            $query = $this->db->get('imagenes');
            //$data = $query->row_array();
            if($query->num_rows() < 1)
            {
                return 0;
            }
            else{
                foreach ($query->result() as $row)
                {
                    $dato = array (
                                    'titulo'=>$row ->titulo,
                                    'username'=>$row ->username,
                                    'imagen' => $row->imagen,
                                    'video' => $row->video,
                                    'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                                    'id_categoria' => $row->id_categoria,
                                    'etiquetas' => $row->etiquetas,
                                    'vista' => $row->vista,
                                    'fecha' => $this->ui_model->relativeTime($row->fecha),
                                    'numero_descargas' => $row->numero_descargas);

                }
            }
        }
        return $dato;
    }

    //*********Obtener datos de un gifs con el nombre, y comprobar si existe***********//

    public function get_gif($img){
        $query = $this->db->get_where('imagenes', array('imagen' => $img));
        return $query->result_array();

    }

    public function update_gif($img, $data){
        $this->db->where('imagen', $img);
        $this->db->update('imagenes', $data);
    }


    
    public function delete_gif($img)
    {
        $this->db->delete('imagenes', array('imagen' => $img));
    }
    //cada ves que alguien visite una imagen se le sumara 1 para asi ver cuales son las imagenes mas populares
    function sumar($data, $campo){
        $this->db->set($campo, $campo.'+1', FALSE);
        $this->db->where('imagen', $data);
        $this->db->update('imagenes');

    }

    //Nos devuelve las imagenes mas vistas
    public function get_most_view(){
        $sql = "SELECT * FROM `imagenes` INNER JOIN `users` ON `imagenes`.`users_id_user` = `users`.`id_user`"
            ."INNER JOIN `categorias` ON `imagenes`.`id_categoria` = `categorias`.`id_categoria`"
            ." AND DATE_SUB(CURDATE(),INTERVAL 20 DAY) <= `imagenes`.`fecha` ORDER BY `imagenes`.`vista` DESC limit 12";
        $query = $this->db->query($sql);

        if($query->num_rows()>0)
        {        
           foreach ($query->result() as $row)
            {
            $data[$row->id_imagen] = array ('id_imagen'=>$row->id_imagen,
                                            'titulo'=>$row ->titulo,
                                            'username'=>$row ->username,
                                            'imagen' => $row->imagen,
                                            'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                                            'id_categoria' => $row->id_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                                            );

            }
        return $data;
    }
}

    //Retorna el numero de imagenes que hay para asi hacer la paginagion de imagenes mas recientes
    function filas_nuevos()
    {
        $consulta = $this->db->get('imagenes');
        return  $consulta->num_rows() ;
    }
//Retorna el numero de imagenes que hay para asi hacer la paginagion de imagenes mas vistas
    function filas_vistos()
    {
        //$consulta = $this->db->get('imagenes');
        $sql = "SELECT * FROM `imagenes` WHERE DATE_SUB(CURDATE(),INTERVAL 20 DAY) <= fecha\n";
        $consulta = $this->db->query($sql);
        return  $consulta->num_rows() ;
    }
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    //Paginacion de las "Ultimas imagenes"
    function total_paginados($por_pagina,$segmento = 3) 
    {   
        $this->db->join('users','imagenes.users_id_user = users.id_user');
        $this->db->join('categorias', 'imagenes.id_categoria = categorias.id_categoria');
        $this->db->order_by('fecha', 'desc');
        $query = $this->db->get('imagenes',$por_pagina,$segmento);
        if($query->num_rows()>0)
        {        
           foreach ($query->result() as $row)
            {
                $data[$row->id_imagen] = array ('id_imagen'=>$row->id_imagen,
                                            'titulo'=>$row ->titulo,
                                            'username'=>$row ->username,
                                            'imagen' => $row->imagen,
                                            'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                                            'id_categoria' => $row->id_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                                            );

            }
        return $data;
        }
    }
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    //Paginacion de las "Imagenes mas vistas"
    function vistos_paginados($por_pagina,$segmento) 
    {   
        if(empty($segmento)){
            $segmento = 0;
        }

       $sql = "SELECT * FROM `imagenes` INNER JOIN `users` ON `imagenes`.`users_id_user` = `users`.`id_user`"
            ."INNER JOIN `categorias` ON `imagenes`.`id_categoria` = `categorias`.`id_categoria`"
            ." AND DATE_SUB(CURDATE(),INTERVAL 20 DAY) <= `imagenes`.`fecha` ORDER BY `imagenes`.`vista` DESC limit ".$this->db->escape_str($por_pagina)." offset ".$this->db->escape_str($segmento);
        $query = $this->db->query($sql);

        if($query->num_rows()>0)
        {        
           foreach ($query->result() as $row)
            {
            $data[$row->id_imagen] = array ('id_imagen'=>$row->id_imagen,
                                            'titulo'=>$row ->titulo,
                                            'username'=>$row ->username,
                                            'imagen' => $row->imagen,
                                            'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                                            'id_categoria' => $row->id_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                                            );

            }
        return $data;
        }
    }

    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    //Nos devuelve una imagen aleatoria
    function imagen_aleatoria(){

        $this->db->order_by('id_imagen', 'RANDOM');
        $this->db->limit(1);
        $query = $this->db->get('imagenes');
        $data = $query->row();

        $dato['imagen'] = $data->imagen;
        $dato['titulo'] = $data->titulo;

        return $dato;
    }


    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    //Retorna las imagenes que se necesitan para la paginacion al buscar
    function buscar_gif($match,$por_pagina,$segmento){
         if(empty($segmento)){
            $segmento = 0;
        }
        $this->db->select('imagenes.id_imagen,imagenes.titulo,imagenes.imagen,imagenes.vista,imagenes.fecha,categorias.nombre_categoria,categorias.id_categoria,users.username');
        $this->db->join('users',"imagenes.users_id_user = users.id_user");
        $this->db->join('categorias', 'imagenes.id_categoria = categorias.id_categoria');
        $this->db->like('titulo', $match);
        $this->db->or_like('etiquetas', $match);
        $this->db->order_by("fecha", "desc");
        $query = $this->db->get('imagenes',$por_pagina,$segmento);
        foreach ($query->result() as $row)
        {
            $data[$row->id_imagen] = array ('id_imagen'=>$row->id_imagen,
                                            'titulo'=>$row ->titulo,
                                            'username'=>$row ->username,
                                            'imagen' => $row->imagen,
                                            'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                                            'id_categoria' => $row->id_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                                            );

        }
        if (empty($data)) {
            return 0;
        }
        else{
            return $data;
        }
    }
    //El numero de imagenes que coinciden con lo que buscamos
    function num_buscar_gif($match){
        $this->db->join('users',"imagenes.users_id_user = users.id_user");
        $this->db->like('titulo', $match);
        $this->db->or_like('etiquetas', $match);
        $data = $this->db->get('imagenes');

        return $data->num_rows();
    }

    //Buscar usuarios
    public function buscar_user($match)
    {

        $this->db->select('users.id_user,users.ubicacion,users.fecha_registro,users.username,users.estrellas');
        $this->db->like('username', $match);
        $this->db->or_like('myname', $match);
        $this->db->or_like('ubicacion', $match);
        $this->db->order_by("estrellas", "desc");
        $query = $this->db->get('users', 10);
        foreach ($query->result() as $row)
        {
            $data[$row->id_user] = array (
                                            'username'=>$row ->username,
                                            'ubicacion' => $row->ubicacion,
                                            'estrellas' => $row->estrellas,
                                            'fecha_registro' => $this->ui_model->relativeTime($row->fecha_registro),
                                            );

        }
        if (empty($data)) {
            return 0;
        }
        else{
            return $data;
        }
        
       
    }

    function num_buscar_user($match){
        
        $this->db->like('username', $match);
        $this->db->or_like('myname', $match);
        $this->db->or_like('ubicacion', $match);
        $data = $this->db->get('users');

        return $data->num_rows();
    }
    /***********************Gifs Aleatorios para columna recomendado******************************/
    function gif_aleatorio(){
 $this->db->select('imagenes.id_imagen,imagenes.titulo,imagenes.imagen,imagenes.vista,imagenes.fecha,categorias.nombre_categoria,categorias.id_categoria,users.username');
        $this->db->join('users',"imagenes.users_id_user = users.id_user");
        $this->db->join('categorias', 'imagenes.id_categoria = categorias.id_categoria');
        $this->db->order_by('id_imagen', 'RANDOM');
        $query = $this->db->get('imagenes',4);

        foreach ($query->result() as $row)
            {
            $data[$row->id_imagen] = array ('id_imagen'=>$row->id_imagen,
                                            'titulo'=>$row ->titulo,
                                            'username'=>$row ->username,
                                            'imagen' => $row->imagen,
                                            'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                                            'id_categoria' => $row->id_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                                            );

            }
        return $data;
    }
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    //Pagina las imagenes por categorias
    function buscar_categoria($match,$por_pagina,$segmento, $orden = FALSE) {
        if(empty($segmento)){
            $segmento = 0;
        }
        
        $this->db->select('imagenes.id_imagen,imagenes.titulo,imagenes.imagen,imagenes.vista,imagenes.fecha,categorias.id_categoria,categorias.nombre_categoria,users.username');
        $this->db->join('categorias',"imagenes.id_categoria = categorias.id_categoria and categorias.id_categoria = '$match'");
        $this->db->join('users',"imagenes.users_id_user = users.id_user");
        if($orden == FALSE)
        {
        	 $this->db->order_by("fecha", "desc");
        }
        else 
        {
         	$this->db->order_by('id_imagen', 'RANDOM');
        }
       
        $query = $this->db->get('imagenes',$por_pagina, $segmento);

        foreach ($query->result() as $row)
        {
            $data[$row->id_imagen] = array ('id_imagen'=>$row->id_imagen,
                                            'titulo'=>$row ->titulo,
                                            'username'=>$row ->username,
                                            'imagen' => $row->imagen,
                                            'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                                            'id_categoria' => $row->id_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                                            );

        }
        return $data;
    }
    //Devuelve el numero de imagenes de dicha categoria 
    function num_buscar_categoria($match) {
        /*$sql = "select imagenes.id_imagen from imagenes,categorias where imagenes.id_categoria = categorias.id_categoria and categorias.nombre_categoria = '$match'";
        $data = $this->db->query($sql);
        return $data->num_rows();*/
        $this->db->join('categorias',"imagenes.id_categoria = categorias.id_categoria and categorias.id_categoria = '$match'");
        $this->db->join('users',"imagenes.users_id_user = users.id_user");
        //$this->db->like('etiquetas', $match);
        $data = $this->db->get('imagenes');
        return $data->num_rows();
    }

/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    //Pagina Imagenes por etiqueta
    function buscar_etiqueta($match,$por_pagina,$segmento){
        $this->db->select('imagenes.id_imagen,imagenes.titulo,imagenes.imagen,imagenes.vista,imagenes.fecha,categorias.id_categoria,categorias.nombre_categoria,users.username');
        $this->db->join('categorias',"imagenes.id_categoria = categorias.id_categoria");
        $this->db->join('users',"imagenes.users_id_user = users.id_user");
        $this->db->like('etiquetas', $match);
        $this->db->order_by("fecha", "desc");
        $query = $this->db->get('imagenes',$por_pagina,$segmento);

       foreach ($query->result() as $row)
        {
            $data[$row->id_imagen] = array ('id_imagen'=>$row->id_imagen,
                                            'titulo'=>$row ->titulo,
                                            'username'=>$row ->username,
                                            'imagen' => $row->imagen,
                                            'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                                            'id_categoria' => $row->id_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                                            );

        }
        return $data;
    }
    //Devuelve el numero de imagenes de dicha etiqueta
    function num_buscar_etiqueta($match){
        $this->db->like('etiquetas', $match);
        $data = $this->db->get('imagenes');

        return $data->num_rows();
    }
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    //Me devuelve el numero de imagenes que tiene un determinado usuario
    public function num_imagenes_username($username)
    {
        $this->db->join('users',"imagenes.users_id_user = users.id_user AND users.username = '$username'");
        $query = $this->db->get('imagenes');
        return $query->num_rows();
        # code...
    }
    public function num_imagenes_id($id_user)
    {
        $query = $this->db->get_where('imagenes',array('users_id_user' => $id_user));
        return $query->num_rows();
        # code...
    }

    //Paginacion en el perfil de usuarios para ver todas sus imagenes subidas
    public function username_gifs($username, $por_pagina,$segmento)
    {
        $this->db->select('imagenes.id_imagen, imagenes.fecha,imagenes.imagen,imagenes.titulo,imagenes.vista,users.username,categorias.id_categoria, categorias.nombre_categoria');
        $this->db->join('users',"imagenes.users_id_user = users.id_user AND users.username = '$username'");
        $this->db->join('categorias', 'imagenes.id_categoria = categorias.id_categoria');
        $this->db->order_by("fecha", "desc");
        $query = $this->db->get('imagenes',$por_pagina,$segmento);
        foreach ($query->result() as $row)
        {
            $data[$row->id_imagen] = array ('id_imagen'=>$row->id_imagen,
                                            'titulo'=>$row ->titulo,
                                            'imagen' => $row->imagen,
                                            'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                                            'id_categoria' => $row->id_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                                            );

        }
        return $data;
    }
    
    /*function subir_servers3($file,$dir,$folder) {
        $this->load->library('s3');
        $temp_file_path = $_SERVER['DOCUMENT_ROOT'].$dir.$file;
        //echo $temp_file_path;
        //$temp_file_path ='../..'.$dir.$file;
        $newFileName = $folder.$file;
        $this->s3->putObject(
                        $this->s3->inputFile($temp_file_path,false),
                        'comgifs',
                        $newFileName,
                        self::ACL_PUBLIC_READ);
        
        $this->eliminar_gifs($file,$dir); 
    }*/

    function eliminar_gifs($dir,$img) {
            $filestring = PUBPATH.$dir.$img;
            unlink($filestring);
            
    }
    function borrar_gifs($img) {
        $this->delete_gif($img);
        $this->eliminar_gifs('uploads/',$img);
        $this->eliminar_gifs('uploads/thumbs/',$img);
        
    }
    
    /*Esta seccion maneja lo que tenga que ver con los partner 
     * 
     * 
     */
    function check_partner($partner) {
        $query = $this->db->get_where('bpartner', array('username' => $partner, 'estado' => '1'));
        return ($query->num_rows == 1) ? TRUE : FALSE;
    }
    
     function sumar_par($data){
        $campo = 'pag_vistas_actuales'; 
        $this->db->set($campo, $campo.'+1', FALSE);
        $this->db->where('username', $data);
        $this->db->update('bpartner');
    }
}