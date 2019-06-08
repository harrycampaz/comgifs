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
class historial_mes_model extends CI_Model {

    public function construct() {
        parent::__construct();
    }

    public function get_all($por_pagina, $segmento = 3, $orden) {
        switch ($orden) {
            case $orden == 'id_historial_mes':
                # code...
                break;
            case $orden == 'mes_username':
                # code...
                break;
            case $orden == 'pag_vistas_mes':
                
                    $orden = 'impresiones_mes';
                break;
            case $orden == 'valor_pago_mes':
                # code...
                break;
            default:
                $orden = 'fecha_mes';
                break;
        }

        $this->db->order_by($orden, 'desc');
        $query = $this->db->get('historial_mes', $por_pagina, $segmento);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[$row->id_historial_mes] = array('id_historial_mes' => $row->id_historial_mes,
                    'mes_username' => $row->mes_username,
                    'valor_pago_mes' => $row->valor_pago_mes,
                    'pag_vistas_mes' => $row->pag_vistas_mes,
                    'impresiones_mes' => $row->impresiones_mes,
                    'fecha_mes' => $row->fecha_mes,
                );
            }
            return $data;
        }
    }

    function get_mes($id) {

        $this->db->select('id_historial_mes, mes_username,valor_pago_mes,pag_vistas_mes, impresiones_mes');
        $query = $this->db->get_where('historial_mes', array('id_historial_mes' => $id));

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = array('id_historial_mes' => $row->id_historial_mes,
                    'mes_username' => $row->mes_username,
                    'valor_pago_mes' => $row->valor_pago_mes,
                    'pag_vistas_mes' => $row->pag_vistas_mes,
                    'impresiones_mes' => $row->impresiones_mes
                );
            }
        }
        return $data;
    }

    public function count_dias() {
        $query = $this->db->get('historial_mes');
        return $query->num_rows();
    }
    
    //Actualizar mes
     function update_mes($id, $data) {
        if ($this->session->userdata('rol') == 1) {
            $this->db->where('id_historial_mes', $id);
            $this->db->update('historial_mes', $data);
        }
    }

}
