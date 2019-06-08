<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag_Model extends CI_Model {

	
	public function __construct()
	{
		parent::__construct();
		
	}
	function get_tag($id_etiqueta = false){
    if (empty($id_etiqueta)) {
    	    $this->db->order_by("nombre_etiqueta", "random");
       		$query = $this->db->get('etiquetas',20);
        	foreach ($query->result() as $row)
            {
                $data [$row->id_etiqueta] = array('id_etiqueta' =>$row->id_etiqueta,
                            'nombre_etiqueta' => $row ->nombre_etiqueta);
        
            }
           return $data;
       }
       else{

        $query = $this->db->get_where('etiquetas', array('id_etiqueta' => $id_etiqueta));
        return $query->row()->nombre_etiqueta;
      
      }
    }

  function main_tag(){
          $this->db->order_by("nombre_etiqueta", "asc");
          $query = $this->db->get('etiquetas');
          foreach ($query->result() as $row)
            {
                $data [$row->id_etiqueta] = array('id_etiqueta' =>$row->id_etiqueta,
                            'nombre_etiqueta' => $row ->nombre_etiqueta);
        
            }
           return $data;
       }

 function update_tag($id_etiqueta, $nombre_etiqueta){
    $this->db->where('id_etiqueta', $id_etiqueta);
    $this->db->update('etiquetas', array('nombre_etiqueta' => $nombre_etiqueta));
    }

    function add_tag($tag){
        if($this->session->userdata('rol') == 1){
          $insert = array('nombre_etiqueta' => $tag);

          return $this->db->insert('etiquetas', $insert);
        }
        else
        {
            return 0;
        }
    }
    
    public function delete($value)
    {
      $this->db->delete('etiquetas', array('id_etiqueta' => $value));
    }      
 	


}

/* End of file  */
/* Location: ./application/models/ */