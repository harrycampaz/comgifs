<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Videos_Model extends CI_Model {

    public function construct() {
        parent::__construct();
    }

    public function insert_video($datos) {
        return $this->db->insert('videos', $datos);
    }

    public function get_video($enlace) {

        $this->db->select('videos.enlace,videos.id_video, videos.avatar_video, videos.video,videos.titulo,videos.descripcion,videos.vistas,videos.fecha,categorias.id_categoria,categorias.nombre_categoria,');
        $this->db->join('categorias', 'videos.id_categoria = categorias.id_categoria AND videos.enlace = "' . $enlace . '"');

        $query = $this->db->get('videos');
        if ($query->num_rows() < 1) {
            return 0;
        } else {
            foreach ($query->result() as $row) {
                $dato = array(
                    'id_video' => $row->id_video,
                    'titulo' => $row->titulo,
                    'avatar_video' => $row->avatar_video,
                    'video' => $row->video,
                    'enlace' => $row->enlace,
                    'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                    'id_categoria' => $row->id_categoria,
                    'descripcion' => $row->descripcion,
                    'vistas' => $row->vistas,
                    'fecha' => $this->ui_model->relativeTime($row->fecha));
            }
        }

        return $dato;
    }

    public function get_all($por_pagina, $segmento, $orden = 'fecha') {

        switch ($orden) {
            case $orden == 'id_video':
                # code...
                break;
            case $orden == 'titulo':
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
        $this->db->select('videos.id_video,videos.avatar_video, videos.video,videos.enlace,videos.titulo,videos.descripcion,videos.vistas,videos.fecha,categorias.id_categoria,categorias.nombre_categoria,');
        $this->db->join('categorias', 'videos.id_categoria = categorias.id_categoria');
        $this->db->order_by($orden, "desc");
        $query = $this->db->get('videos', $por_pagina, $segmento);

        if ($query->num_rows() > 1) {

            foreach ($query->result() as $row) {
                $dato [$row->id_video] = array('id_video' => $row->id_video,
                    'titulo' => $row->titulo,
                    'avatar_video' => $row->avatar_video,
                    'video' => $row->video,
                    'enlace' => $row->enlace,
                    'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                    'id_categoria' => $row->id_categoria,
                    'descripcion' => $row->descripcion,
                    'vistas' => $row->vistas,
                    'fecha' => $this->ui_model->relativeTime($row->fecha));
            }
            return $dato;
        }
    }

    public function count_videos() {
        $query = $this->db->get('videos');
        return $query->num_rows();
    }
    
     public function count_Misvideos() {
        $query = $this->db->get_where('videos', array('users_id_user' => $this->session->userdata('id_user')));
        return $query->num_rows();
    }

    public function get_most($por_pagina, $segmento) {

        if (empty($segmento)) {
            $segmento = 0;
        }

        $sql = "SELECT * FROM `videos` INNER JOIN `categorias` ON `videos`.`id_categoria` = `categorias`.`id_categoria`"
                . " AND DATE_SUB(CURDATE(),INTERVAL 90 DAY) <= `videos`.`fecha` ORDER BY `videos`.`vistas` DESC limit " . $this->db->escape_str($por_pagina) . " offset " . $this->db->escape_str($segmento);

        $query = $this->db->query($sql);

        if ($query->num_rows() > 1) {

            foreach ($query->result() as $row) {
                $dato [$row->id_video] = array('id_video' => $row->id_video,
                    'titulo' => $row->titulo,
                    'avatar_video' => $row->avatar_video,
                    'video' => $row->video,
                    'enlace' => $row->enlace,
                    'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                    'id_categoria' => $row->id_categoria,
                    'descripcion' => $row->descripcion,
                    'vistas' => $row->vistas,
                    'fecha' => $this->ui_model->relativeTime($row->fecha));
            }
            return $dato;
        }
    }

    public function count_most() {
        $sql = "SELECT * FROM `videos` WHERE DATE_SUB(CURDATE(),INTERVAL 90 DAY) <= fecha\n";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function get_random() {

        $this->db->select('videos.id_video, videos.video,videos.enlace,videos.titulo,videos.descripcion,videos.vistas,videos.fecha,categorias.id_categoria,categorias.nombre_categoria,');
        $this->db->join('categorias', 'videos.id_categoria = categorias.id_categoria');
        $this->db->order_by("id_video", "RANDOM");
        $query = $this->db->get('videos', 6);

        if ($query->num_rows() > 1) {

            foreach ($query->result() as $row) {
                $dato [$row->id_video] = array('id_video' => $row->id_video,
                    'titulo' => $row->titulo,
                    'video' => $row->video,
                    'enlace' => $row->enlace,
                    'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                    'id_categoria' => $row->id_categoria,
                    'descripcion' => $row->descripcion,
                    'vistas' => $row->vistas,
                    'fecha' => $this->ui_model->relativeTime($row->fecha));
            }
            return $dato;
        }
    }

    public function get_edit($enlace) {
        $query = $this->db->get_where('videos', array('enlace' => $enlace));
        return $query->result_array();
    }

    public function update_video($enlace, $data) {
        $this->db->where('enlace', $enlace);
        $this->db->update('videos', $data);
    }

    //cada ves que alguien visite una imagen se le sumara 1 para asi ver cuales son las imagenes mas populares
    function sumar($data, $campo) {
        $this->db->set($campo, $campo . '+1', FALSE);
        $this->db->where('enlace', $data);
        $this->db->update('videos');
    }

    public function delete_video($id_video) {
        $this->db->delete('videos', array('id_video' => $id_video));
    }
    
    
    ///////////////PARTNER///////////////////////
    
     public function get_mis($por_pagina, $segmento, $orden = 'fecha') {

        switch ($orden) {
            case $orden == 'id_video':
                # code...
                break;
            case $orden == 'titulo':
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
        $this->db->select('videos.id_video,videos.avatar_video, videos.video,videos.enlace,videos.titulo,videos.descripcion,videos.vistas,videos.fecha,categorias.id_categoria,categorias.nombre_categoria,');
        $this->db->join('categorias', 'videos.id_categoria = categorias.id_categoria');
        $this->db->where('videos.users_id_user',$this->session->userdata('id_user'));
        $this->db->order_by($orden, "desc");
        $query = $this->db->get('videos', $por_pagina, $segmento);

        if ($query->num_rows() > 1) {

            foreach ($query->result() as $row) {
                $dato [$row->id_video] = array('id_video' => $row->id_video,
                    'titulo' => $row->titulo,
                    'avatar_video' => $row->avatar_video,
                    'video' => $row->video,
                    'enlace' => $row->enlace,
                    'nombre_categoria' => $this->lang->line($row->nombre_categoria),
                    'id_categoria' => $row->id_categoria,
                    'descripcion' => $row->descripcion,
                    'vistas' => $row->vistas,
                    'fecha' => $this->ui_model->relativeTime($row->fecha));
            }
            return $dato;
        }
    }

}
