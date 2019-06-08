<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registered_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


    
    /*****************Comprobar si existe el username y el email para podes actualizar el registro*****************/

    public function check_update_username($username)
    {
        $this->db->where(array('username' => $username, 'id_user !=' => $this->session->userdata('id_user')));
        $query = $this->db->get('users');
        
        if ($query->num_rows > 0)
            return True;
        else
            return FALSE;
    }
    public function check_update_email($email)
    {
        $this->db->where(array('email' => $email, 'id_user !=' => $this->session->userdata('id_user')));
        $query = $this->db->get('users');
        
        if ($query->num_rows > 0)
            return TRUE;
        else
            return FALSE;
    }
//Actualiza el usuario
     public function update_user($datos)
    {
        $this->db->update('users',$datos, array('id_user' => $this->session->userdata('id_user')));
    }

     /****************FIN******************/

 /*****************Comprobar si el password que ingreso el usuario coincida con el de la base de datos*****************/
    public function check_password($password)
    {
        $check = $this->db->get_where('users', array('id_user' => $this->session->userdata('id_user'), 'password' => $password));
        
        return ($check->num_rows == 1) ? TRUE : FALSE;
    }

    public function update_password($password)
    {
        return $this->db->update('users', $password, array('id_user' => $this->session->userdata('id_user')));
    }

    public function get_user($id_user = FALSE)
    {
        if(isset($id_user)){
            /*$this->db->select('myname, username,avatar, email, ubicacion, fecha_registro,website');
            $query = $this->db->get_where('users', array('id_user' => $id_user));
            return $query->result_array();*/
            $this->db->select('myname, username,avatar,email, ubicacion, fecha_registro,website, estrellas');
            $query = $this->db->get_where('users', array('id_user' => $id_user));
            foreach ($query->result() as $row)
            {
                $data = array('myname'=>$row->myname,
                                'username'=>$row ->username,
                                'avatar' => $row->avatar,
                                'email' => $row->email,
                                'ubicacion' => $row->ubicacion,
                                'fecha_registro' =>  $this->ui_model->relativeTime($row->fecha_registro),
                                'website'=> $row->website,
                                'estrellas' => $row->estrellas);

            }

            return $data;
        }
       return 0;
    }

     public function update_session($id_user = FALSE)
    {
        if(isset($id_user)){
        
            $this->db->select('myname, username,roles_id_rol, estado,strike');
            $query = $this->db->get_where('users', array('id_user' => $id_user));
            foreach ($query->result() as $row)
            {
                $data = array('myname'=>$row->myname,
                                'username'=>$row ->username,
                                'rol' => $row->roles_id_rol,
                                'id_user' => $id_user,
                                'is_logged_in' => TRUE,
                                'estado' => $row->estado,
                                'strike'=> $row->strike);
            }

            return $data;
        }
       return 0;
    }
    
    public function get_email($username)
    {   
        $row = $this->db->get_where('users', array('username' => $username))->row();
        return $row->email;
    }
    
    public function user_data($email, $username)
    {
        if($username === FALSE){
            $query = $this->db->get_where('users', array('email' => $email));
        }
        else {
            $query = $this->db->get_where('users', array('username' => $username));
        }
        foreach ($query->result() as $row)
        {
            $data = array(  'id_user'=>$row->id_user,
                            'myname'=>$row->myname,
                            'username'=>$row ->username,
                            'email' => $row->email,
                            'code' => $row->activation_code);

        }
        return $data;
     
    }

    public function star_mail($myname, $username, $code, $correo)
    {
         $subject = 'Ganaste una estrella - ComGIFS';
         $to = $correo;
         $message = 'Hola : '.$myname.' Visita el enlace para verificar tu Cuenta y ganaras tu primera o una estrella mas en comgifs. 
                            '.base_url().'profile/star/'.$username.'/'.$code.'
                            Gracias de nuevo por usar este servicio  GO!! http://comgifs.com';

         $this->send_email($to,$subject,$message);
    }
    public function password_mail($email,$username)
    {
         $correo = $this->user_data($email, $username);
         $subject = 'Restaurar Password - ComGIFS';
         $to = $correo['email'];
         $message = 'Hola :'.$correo['myname'].' Para reestableser tu contraseña ve a la siguiente direccion:
                            '.base_url().'profile/new_pass/'.$correo['username'].'/'.$correo['code'].'
                            Gracias de nuevo por usar este servicio GO!! http://comgifs.com';
         $this->send_email($to,$subject,$message);
    }
    
    public function send_email($to,$subject,$message) {
       
        $this->load->library('email');

        $this->email->from('no-reply@comgifs.com','comgifs.com');
        $this->email->to($to); 
        $this->email->subject($subject);
        $this->email->message($message);
       
       

        $this->email->send();

    }
    
    function check_code($username, $code) {
        $this->db->where(array('username' => $username, 'activation_code' => $code));
        $query = $this->db->get('users');
        if ($query->num_rows > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function new_password($password,$username)
    {
        return $this->db->update('users', $password, array('username' => $username));
    }

}
