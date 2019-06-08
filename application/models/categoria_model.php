<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Categoria_Model extends CI_Model {
 
    public function construct() {
        parent::__construct();

    }

    //Esta funcion nos retorna las categorias que aparecen en el formulario para subir las imagenes
    function get_categoria($id = FALSE){
    	if(empty($id)){
            $this->db->where('id_categoria >', 1);
            $this->db->order_by("nombre_categoria", "asc");
       		$query = $this->db->get('categorias');
        	foreach ($query->result() as $row)
            {
                $data [$row->id_categoria] = array('id_categoria' =>$row->id_categoria,
                            'nombre_categoria' => $this->lang->line($row->nombre_categoria));
        
            }
            return $data;
    	}	
    	else{

    		$query = $this->db->get_where('categorias', array('id_categoria' => $id));
    		return $this->lang->line($query->row()->nombre_categoria);
    	
    	}
    }
    
    function get_select_categoria(){
        $this->db->order_by("nombre_categoria", "asc");
        $query = $this->db->get('categorias');

        foreach ($query->result() as $row)
        {
            $data[$row->id_categoria] = $this->lang->line($row->nombre_categoria);
        
        }
        return $data;
    }

    function update_categoria($id_categoria, $nombre_categoria){
		$this->db->where('id_categoria', $id_categoria);
		$this->db->update('categorias', array('nombre_categoria' => $nombre_categoria));
    }

    function add_categoria($categoria){
        if($this->session->userdata('rol') == 1){
        	$insert = array('nombre_categoria' => $categoria,
                            'users_id_user' => $this->session->userdata('id_user'));

        	return $this->db->insert('categorias', $insert);
        }
        else
        {
            return 0;
        }
    }
    
    public function delete($value)
    {
    	$this->db->delete('categorias', array('id_categoria' => $value));
    }

    public function check_categoria($id_categoria)
    {
        $check = $this->db->get_where('categorias', array('id_categoria' => $id_categoria));
        
        return ($check->num_rows == 1) ? TRUE : FALSE;
    }
}