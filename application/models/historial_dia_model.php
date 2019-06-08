<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of historial_dia_model
 *
 * @author harry
 */
class historial_dia_model extends CI_Model {
    
     public function construct() {
        parent::__construct();
    }
 
    public function get_all($por_pagina,$segmento = 3,$orden) {
        switch ($orden) {
            case $orden == 'id_historial_dia':
                # code...
                break;
            case $orden == 'dia_username':
                # code...
                break;
            case $orden == 'valor_pago_dia':
                # code...
                break;
            default:
                $orden = 'fecha_dia';
                break;
        }
        
        $this->db->order_by($orden, 'desc');
        $query = $this->db->get('historial_dia',$por_pagina,$segmento);
        if($query->num_rows()>0)
        {        
           foreach ($query->result() as $row)
            {
                $data[$row->id_historial_dia] = array ('id_historial_dia'=>$row->id_historial_dia,
                                            'dia_username'=>$row->dia_username,
                                            'valor_pago_dia'=>$row->valor_pago_dia,                                        
                                            'fecha_dia' => $row->fecha_dia,
                                            );

            }
        return $data;
        }
    }
    
     public function count_dias()
    {
        $query = $this->db->get('historial_dia');
        return $query->num_rows();
    }
}
