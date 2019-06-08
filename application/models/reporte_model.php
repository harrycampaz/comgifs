<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		
	}
public function get_reportes($orden)
{
    switch ($orden) {
        case $orden == 'id_pena':
            # code...
            break;
        case $orden == 'username':
            # code...
            break;
       
        default:
            $orden = 'fecha_suspencion';
            break;
    }
	$this->db->join('users','penalizacion.users_id_user = users.id_user');
    $this->db->order_by($orden, 'desc');
    $query = $this->db->get('penalizacion');
    if($query->num_rows()>0)
    {        
       foreach ($query->result() as $row)
        {
            $data[$row->reporte] = array ('id_pena'=>$row->id_pena,
                                        'username' => $row->username,
                                        'reporte' => $row->reporte,
                                        'fecha' => $this->ui_model->relativeTime($row->fecha_suspencion),
                    
                                        );

        }
    return $data;
    }
}

	public function add_reporte($datos)
	{
		return $this->db->insert('penalizacion',$datos);
	}
}

/* End of file reporte_model.php */
/* Location: ./application/models/reporte_model.php */