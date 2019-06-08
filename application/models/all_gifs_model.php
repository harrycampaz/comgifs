<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class All_Gifs_Model extends CI_Model {
 
    public function construct() {
        parent::__construct();
    }

    public function get_gifs($por_pagina,$segmento = 3,$orden)
    {
        switch ($orden) {
            case $orden == 'id_imagen':
                # code...
                break;
            case $orden == 'titulo':
                # code...
                break;
            case $orden == 'video':
                # code...
                break;
            case $orden == 'username':
                # code...
                break;
            case $orden == 'nombre_categoria':
                # code...
                break;
            case $orden == 'fecha':
                # code...
                break;
            case $orden == 'vista':
                # code...
                break;
            default:
                $orden = 'fecha';
                break;
        }
    	$this->db->join('users','imagenes.users_id_user = users.id_user');
        $this->db->join('categorias', 'imagenes.id_categoria = categorias.id_categoria');
        $this->db->order_by($orden, 'desc');
        $query = $this->db->get('imagenes',$por_pagina,$segmento);
        if($query->num_rows()>0)
        {        
           foreach ($query->result() as $row)
            {
                $data[$row->id_imagen] = array ('id_imagen'=>$row->id_imagen,
                                            'titulo'=>$row ->titulo,
                                            'username'=>$row ->username,
                                            'imagen' => $row->imagen,
                                            'video' => $row->video,
                                            'nombre_categoria' => $row->nombre_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                        
                                            );

            }
        return $data;
        }
    }

    public function count_gifs()
    {
        //$this->db->select('imagenes.id_imagen, imagenes.titulo, imagenes.imagen, users.username');

        $query = $this->db->get('imagenes');
        return $query->num_rows();
    }

    public function get_gifs_user($por_pagina,$segmento = 3,$username)
    {
        $this->db->join('users',"imagenes.users_id_user = users.id_user AND users.username ='$username'");
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
                                            'nombre_categoria' => $row->nombre_categoria,
                                            'vista' => $row->vista,
                                            'fecha' => $this->ui_model->relativeTime($row->fecha),
                                            );

            }
        return $data;
        }
    }
     public function count_gifs_user($username)
    {
        //$this->db->select('imagenes.id_imagen, imagenes.titulo, imagenes.imagen, users.username');
        $this->db->join('users',"imagenes.users_id_user = users.id_user AND users.username ='$username'");
        $query = $this->db->get('imagenes');
        return $query->num_rows();
    }
    
}