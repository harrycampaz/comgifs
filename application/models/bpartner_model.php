<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bpartner_model
 *
 * @author harry
 */
class bpartner_model extends CI_Model {

    public function construct() {
        parent::__construct();
    }

    public function get_all($por_pagina, $segmento = 3, $orden) {
        switch ($orden) {
            case $orden == 'id_partner':
                # code...
                break;
            case $orden == 'username':
                # code...
                break;
            case $orden == 'ingresos_actuales':
                # code...
                break;
            case $orden == 'pag_vistas_actuales':
                $orden = 'impresiones_actual';
                break;
            case $orden == 'ultimo_pago':
                # code...
                break;
            case $orden == 'estado':
                # code...
                break;
            default:
                $orden = 'fecha_registro';
                break;
        }

        $this->db->order_by($orden, 'asc');
        $query = $this->db->get('bpartner', $por_pagina, $segmento);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[$row->id_partner] = array('id_partner' => $row->id_partner,
                    'username' => $row->username,
                    'correo_pago' => $row->correo_pago,
                    'ingresos_actuales' => $row->ingresos_actuales,
                    'pag_vistas_actuales' => $row->pag_vistas_actuales,
                    'ultimo_pago' => $row->ultimo_pago,
                    'impresiones_actual' => $row->impresiones_actual,
                    'estado' => $row->estado,
                    'fecha_registro' => $this->ui_model->relativeTime($row->fecha_registro),
                );
            }
            return $data;
        }
    }

    public function count_partner() {
        $query = $this->db->get('bpartner');
        return $query->num_rows();
    }

    function add_partner($partner, $correo) {
        if ($this->session->userdata('rol') == 1) {
            $insert = array('username' => $partner, 'correo_pago' => $correo);

            return $this->db->insert('bpartner', $insert);
        } else {
            return 0;
        }
    }

    public function check_username($username) {
        $query = $this->db->get_where('users', array('username' => $username));

        return ($query->num_rows == 1) ? TRUE : FALSE;
    }

    function update_estado($partner, $estado) {
        if ($this->session->userdata('rol') == 1) {
            $this->db->where('username', $partner);
            $this->db->update('bpartner', array('estado' => $estado));
        }
    }

    function check_estado($partner) {
        $query = $this->db->get_where('bpartner', array('username' => $partner, 'estado' => '1'));
        return ($query->num_rows == 1) ? TRUE : FALSE;
    }

    //Editar Partner

    public function check_partner($username) {
        $query = $this->db->get_where('bpartner', array('username' => $username));

        return ($query->num_rows == 1) ? TRUE : FALSE;
    }

    function update_partner($partner, $data) {
        if ($this->session->userdata('rol') == 1) {
            $this->db->where('username', $partner);
            $this->db->update('bpartner', $data);
        }
    }

    function edit_mailpartner($partner, $data) {

        $this->db->where('username', $partner);
        $this->db->update('bpartner', $data);
    }

    //Optiene datos para Editar o Mostrar datos
    function get_data($username) {

        $this->db->select('id_partner, impresiones_actual, pag_vistas_actuales,username,correo_pago, ingresos_actuales,act_ingresos, ultimo_pago');
        $query = $this->db->get_where('bpartner', array('username' => $username));

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data = array('id_partner' => $row->id_partner,
                    'username' => $row->username,
                    'pag_vistas_actuales' => $row->pag_vistas_actuales,
                    'correo_pago' => $row->correo_pago,
                    'ingresos_actuales' => $row->ingresos_actuales,
                    'act_ingresos' => $row->act_ingresos,
                    'ultimo_pago' => $row->ultimo_pago,
                    'impresiones_actual' => $row->impresiones_actual
                );
            }
        }

        return $data;
    }

    ///Suma el dinero
    function plus_money($partner, $plus, $impresiones) {

        if ($this->session->userdata('rol') == 1) {
            $plus = $plus / 2;
            $impresiones = $impresiones / 2;

            $this->db->set('ingresos_actuales', 'ingresos_actuales +' . $plus, FALSE);
            $this->db->set('impresiones_actual', 'impresiones_actual +' . $impresiones, FALSE);
            $this->db->set('act_ingresos', 'NOW()', FALSE);
            $this->db->where(array('username' => $partner, 'estado' => '1'));
            $this->db->update('bpartner');

            //Cargar a historial del Dia


            $this->db->where(array('username' => $partner, 'estado' => '1'));
            return $this->db->insert('historial_dia', array('dia_username' => $partner, 'valor_pago_dia' => $plus, 'impresiones_dia' => $impresiones));
        }
    }

    function add_pago($partner, $valor_pago) {

        if ($this->session->userdata('rol') == 1 && $valor_pago >= 50) {

            return $this->db->insert('pago_partnert', array('pago_username' => $partner,
                        'valor_pago' => $valor_pago));
        }
        return FALSE;
    }

    function pagado_partner($partner, $ingresos) {

        if ($this->session->userdata('rol') == 1) {

            $this->db->set('ingresos_actuales', 0, FALSE);
            $this->db->set('pag_vistas_actuales', 0, FALSE);
            $this->db->set('impresiones_actual', 0, FALSE);
            $this->db->set('ultimo_pago', 'ultimo_pago +' . $ingresos, FALSE);

            $this->db->where(array('username' => $partner, 'estado' => '1'));
            $this->db->update('bpartner');
        }
    }

    function reset_saldo($partner) {

        if ($this->session->userdata('rol') == 1) {

            $this->db->set('ultimo_pago', 0, FALSE);

            $this->db->where(array('username' => $partner, 'estado' => '1'));
            $this->db->update('bpartner');
        }
    }

    function add_historial_mes($partner, $valor_pago_mes, $pag_vistas_mes, $impresiones_actual) {

        if ($this->session->userdata('rol') == 1) {

            return $this->db->insert('historial_mes', array('mes_username' => $partner,
                        'valor_pago_mes' => $valor_pago_mes,
                        'pag_vistas_mes' => $pag_vistas_mes,
                        'impresiones_mes' => $impresiones_actual));
        }
        return FALSE;
    }

    //Obtener tabla de pagos para el Partner.
    public function get_pagos($orden, $username) {
        switch ($orden) {

            case $orden == 'valor_pago':
                # code...
                break;
            case $orden == 'fecha_pago':
                # code...
                break;
            default:
                $orden = 'id_pago';
                break;
        }

        $this->db->order_by($orden, 'desc');
        $query = $this->db->get_where('pago_partnert', array('pago_username' => $username), 7);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[$row->id_pago] = array(
                    'valor_pago' => $row->valor_pago,
                    'fecha_pago' => $row->fecha_pago,
                );
            }
            return $data;
        }
    }

    //Obtener ultimo pago / Mes

    public function ultimo_pago($username) {

        $this->db->order_by('fecha_mes', 'desc');
        $this->db->limit(1);
        $row = $this->db->get_where('historial_mes', array('mes_username' => $username))->row();




       echo $row->fecha_mes;
    }

    ///*******************
    //relacionado con el controlador del Partner
    //*******************/////
    public function get_historial_meses($orden, $username) {
        switch ($orden) {

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
        $query = $this->db->get_where('historial_mes', array('mes_username' => $username), 7);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[$row->id_historial_mes] = array(
                    'valor_pago_mes' => $row->valor_pago_mes,
                    'impresiones_mes' => $row->impresiones_mes,
                    'fecha_mes' => $row->fecha_mes,
                );
            }
            return $data;
        }
    }

    //Optener los dias.

    public function get_historial_dia($orden, $username) {
        switch ($orden) {

            case $orden == 'impresiones_dia':
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
        $query = $this->db->get_where('historial_dia', array('dia_username' => $username), 7);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[$row->id_historial_dia] = array(
                    'valor_pago_dia' => $row->valor_pago_dia,
                    'impresiones_dia' => $row->impresiones_dia,
                    'fecha_dia' => $row->fecha_dia,
                );
            }
            return $data;
        }
    }

    public function get_email($username) {
        $row = $this->db->get_where('bpartner', array('username' => $username))->row();
        return $row->correo_pago;
    }

    function max_vistas() {
        $this->db->select_max('pag_vistas_actuales');
        $query = $this->db->get('bpartner')->row();
        return $query->pag_vistas_actuales;
    }

}
