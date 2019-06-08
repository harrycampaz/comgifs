<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


    public function get_all($por_pagina,$segmento = 3,$orden)
    {
        switch ($orden) {
            case $orden == 'id_user':
                # code...
                break;
            case $orden == 'nombre':
                # code...
                break;
            case $orden == 'username':
                # code...
                break;
            case $orden == 'estado':
                # code...
                break;
            case $orden == 'strike':
                # code...
                break;
            case $orden == 'estrellas':
                # code...
                break;
            default:
                $orden = 'fecha_registro';
                break;
        }
        if ($this->session->userdata('rol') > 1) {
            $this->db->where('roles_id_rol >', 2);
        }
            
        $this->db->order_by($orden, 'desc');
        $query = $this->db->get('users',$por_pagina,$segmento);
        if($query->num_rows()>0)
        {        
           foreach ($query->result() as $row)
            {
                $data[$row->id_user] = array ('id_user'=>$row->id_user,
                                            'myname'=>$row->myname,
                                            'username'=>$row->username,
                                            'email'=>$row->email,
                                            'avatar'=>$row->avatar,
                                            'estado' => $row->estado,
                                            'website' => $row->website,
                                            'ubicacion' => $row->ubicacion,
                                            'strike' => $row->strike,
                                            'estrellas'=>$row->estrellas,
                                            'rol' => $row->roles_id_rol,
                                            'fecha_registro' => $this->ui_model->relativeTime($row->fecha_registro),
                                            'gifs' => $this->gif_model->num_imagenes_id($row->id_user)
                        
                                            );

            }
        return $data;
        }
    }

    public function count_user()
    {
        $users = $this->db->get('users');
        return $users->num_rows();
    }

    public function get_best()
    {
        $this->db->select('id_user, username');
        $this->db->where('estrellas >', 2);
        $this->db->order_by("id_user", "random");
        $query = $this->db->get('users',10);
        foreach ($query->result() as $row)
        {
            $data [$row->id_user] = array('id_user' =>$row->id_user,
                                        'username' => $row ->username);
    
        }
        return $data;
    }

    public function star($star)
    {

        $this->db->select('id_user,username, ubicacion,fecha_registro,estrellas');
        $this->db->where('estrellas >', $star);
        $this->db->order_by("id_user", "random");
        $query = $this->db->get('users',20);
        foreach ($query->result() as $row)
        {
            $data[$row->id_user] = array( 'id_user' =>$row->id_user,
                        'username'=>$row->username,
                        'ubicacion' => $row->ubicacion,
                        'fecha_registro' =>  $this->ui_model->relativeTime($row->fecha_registro),
                        'estrellas' => $row->estrellas);

        }
        return $data;
    }

    public function get_emails()
    {
        $users = $this->db->select('email')
            ->order_by('email')
            ->get('users')
            ->result_array();

        return $users;
    }

    

    public function delete($id_user)
    {
        $this->db->delete('acceso', array('acceso_id_user' => $id_user));
        $update = array('users_id_user' => 3, 'vista' => 0);       
        $this->db->update('imagenes',$update, array('users_id_user' => $id_user));
        $this->db->delete('users', array('id_user' => $id_user));
        
    }

    public function update_user($datos)
    {
        $this->db->update('users',$datos, array('id_user' => $this->session->userdata('id_user')));
    }




    public function check_password($uid, $password)
    {
        $check = $this->db->get_where('users', array('uid' => $uid, 'password' => md5($password)));
        
        return ($check->num_rows == 1) ? TRUE : FALSE;
    }

    public function check_id($id_user)
    {
        $query = $this->db->get_where('users', array('id_user' => $id_user));
        
        if ($query->num_rows > 0)
            return FALSE;
        else
            return TRUE;
    }

    public function is($username, $password)
    {
        //$query = $this->db->get_where('users', array('username' => $email, 'password' => md5($password)));
        $query = $this->db->get_where('users', array('username' => $username, 'password' => $password));
        
        if($query->num_rows == 1){
            $this->update_acceso($this->get_id($username));
            return $query->row_array();
        }
        else  {
            return FALSE;
        } 
    }

    public function is_mail($email, $password)
    {
        //$query = $this->db->get_where('users', array('username' => $email, 'password' => md5($password)));
        $query = $this->db->get_where('users', array('email' => $email, 'password' => $password));
        
        if($query->num_rows == 1){
            $this->update_acceso($this->get_id_email($email));
            return $query->row_array();
        }
        else  {
            return FALSE;
        } 
    }

    public function check_username($username)
    {
        $query = $this->db->get_where('users', array('username' => $username));
        
        if ($query->num_rows > 0)
            return FALSE;
        else
            return TRUE;
    }
    public function check_email($email)
    {
        $query = $this->db->get_where('users', array('email' => $email));
        
        if ($query->num_rows > 0)
            return FALSE;
        else
            return TRUE;
    }

    public function add_user($datos)
    {
        $success = $this->db->insert('users',$datos);
        if($success == 1){
            $query = $this->get_id($datos['username']);
            $this->db->insert('acceso', array('acceso_id_user' => $query));
        }
        return $success;  
    }
    public function get_user($username)
    {
        if(isset($username)){
            $this->db->select('myname, username,avatar, ubicacion, fecha_registro,website, estrellas');
            $query = $this->db->get_where('users', array('username' => $username));
            if ($query->num_rows > 0) {
                foreach ($query->result() as $row)
                {
                    $data = array('myname'=>$row->myname,
                                'username'=>$row ->username,
                                'avatar' => $row->avatar,
                                'ubicacion' => $row->ubicacion,
                                'fecha_registro' =>  $this->ui_model->relativeTime($row->fecha_registro),
                                'website'=> $row->website,
                                'estrellas' => $row->estrellas);

                }
                return $data;
            }
        }
       return 0;
    }

    public function get_id($username)
    {   
        $row = $this->db->get_where('users', array('username' => $username))->row();
        return $row->id_user;
    }
    public function get_id_email($email)
    {   
        $row = $this->db->get_where('users', array('email' => $email))->row();
        return $row->id_user;
    }

    public function update_acceso($id_user)
    {
        $this->db->set('numero_acceso', 'numero_acceso+1', FALSE);
        $this->db->where('acceso_id_user', $id_user);
        $this->db->update('acceso');
    }

    public function change_estado($estado,$id_user)
    {
        $this->db->update('users',$estado, array('id_user' => $id_user));
    }

    public function plus_strike($id_user)
    {
        $this->db->set('strike', 'strike+1', FALSE);
        $this->db->where('id_user', $id_user);
        $this->db->update('users');
    }

    public function estrella($id_user,$accion)
    {
        $this->db->set('estrellas', $accion, FALSE);
        $this->db->where('id_user', $id_user);
        $this->db->update('users');
    }

    public function zero_strike($id_user)
    {
        $dato = array('strike' => 0);
        $this->db->update('users',$dato, array('id_user' => $id_user));
    }

    public function get_data($id_user)
    {
        if(isset($id_user)){
            $query = $this->db->get_where('users', array('id_user' => $id_user));
            foreach ($query->result() as $row)
            {
                $data = array(  'id_user'=>$row->id_user,
                                'myname'=>$row->myname,
                                'username'=>$row ->username,
                                'email' => $row->email,
                                'ubicacion' => $row->ubicacion,
                                'website'=> $row->website,
                                'roles_id_rol' => $row->roles_id_rol,
                                'estrellas' => $row->estrellas);

            }
            return $data;
        }
       return 0;
    }

    public function get_roles()
    {
        $query = $this->db->get('roles');

        foreach ($query->result() as $row)
        {
            $data[$row->id_rol] = $row ->nombre_rol;
        
        }
        return $data;
    }
    
    
    public function get_rol($id_user)
    {   
        $row = $this->db->get_where('users', array('id_user' => $id_user))->row();
        return $row->roles_id_rol;
    }
    
    public function update_users($datos, $id_user)
    {
        $this->db->update('users',$datos, array('id_user' => $id_user));
    }

    public function check_update_username($username,$id_user)
    {
        $this->db->where(array('username' => $username, 'id_user !=' => $id_user));
        $query = $this->db->get('users');
        
        if ($query->num_rows > 0)
            return FALSE;
        else
            return TRUE;
    }
    public function check_update_email($email,$id_user)
    {
        $this->db->where(array('email' => $email, 'id_user !=' => $id_user));
        $query = $this->db->get('users');
        
        if ($query->num_rows > 0)
            return FALSE;
        else
            return TRUE;
    }
    
    function restaurar_avatar($datos, $id_user) {
        $this->db->update('users',$datos, array('id_user' => $id_user));
        
    }

    public function get_user_star($username, $code)
    {
            $this->db->select('id_user,username,estado');
            $query = $this->db->get_where('users', array('username' => $username, 'activation_code' => $code));
            if ($query->num_rows > 0) {
                foreach ($query->result() as $row)
                {
                    $data = array( 
                                    'username'=>$row ->username,
                                    'id_user' => $row->id_user,
                                    'estado'=> $row->estado,);

                }
                return $data;
        }
    }

}
