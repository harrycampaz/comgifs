<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ui_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        if($this->agent->accept_lang('es-us') || $this->agent->accept_lang('es') || $this->agent->accept_lang('es-es') || $this->agent->accept_lang('es-mx') ){
            $this->lang->load('nav', 'spanish');
        }
        else
        {
            $this->lang->load('nav', 'english');
        }

    }

    public function cargar_nav(){
        $this->load->model('user_model');
        $data['tag']= $this->tag_model->get_tag();
        //$data['categoria']= $this->cargar_categoria();
        $data['categoria']= $this->categoria_model->get_categoria();
        
        $data['best_users'] = $this->user_model->get_best();
        $data['welcome'] = $this->lang->line('nav_welcome');
        $data['home'] = $this->lang->line('nav_home');
        $data['upload'] = $this->lang->line('nav_upload_gif');
        $data['most_recent'] = $this->lang->line('nav_most_recent');
        $data['most_viewed'] = $this->lang->line('nav_most_viewed');
        $data['share'] = $this->lang->line('nav_share');
        $data['fun'] = $this->lang->line('nav_fun_random');
        
        $data['download'] = $this->lang->line('nav_download');
        $data['search_placeholder'] = $this->lang->line('nav_search_placeholder');
        $data['search'] = $this->lang->line('nav_search');
        $data['more'] = $this->lang->line('nav_more');
        $data['search_term'] = $this->lang->line('nav_search_term');
        
        $data['category_li'] = $this->lang->line('nav_category_li');
        
        $data['tags'] = $this->lang->line('nav_tags');
        $data['tags_li'] = $this->lang->line('nav_tags_li');
        
        $data['viewed'] = $this->lang->line('nav_viewed');

        $data['best'] = $this->lang->line('nav_best');

        $data['signin'] = $this->lang->line('nav_signin');
        $data['signup'] = $this->lang->line('nav_signup');

        $data['login_js'] = $this->lang->line('nav_login_js');

        $data['forgot'] = $this->lang->line('nav_forgot');

        $data['includes'] = $this->cargar_template();
        $data['end'] = $this->cargar_end();
        
        if($this->session->userdata('rol') == 4){
             $this->load->model('bpartner_model');
             $data['max_vistas'] = $this->bpartner_model->max_vistas();
        }

        if($this->session->userdata('myname')){
            $data['myname'] = $this->session->userdata('myname');
            $data['user'] = $this->session->userdata('username');
        }

        if ($this->session->userdata('strike') > 3) {
            $data['mensaje'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Cuenta suspendida temporalmente!</strong> Tu cuenta ha sido suspendida por incumplir los terminos de usos,<br/> tal vez por subir contenido para adultos</div>";
        }
        
        return $data;
    }

    public function cargar_template()
    {   
        if ($this->session->userdata('rol') == 1)
        {
            return 'includes_admin';
        }
        elseif ($this->session->userdata('rol') == 2) {
          if ($this->session->userdata('strike') < 4) {
              return 'includes_mod';
          }
          else{
            return 'includes_registered';
          }
            
        }
        elseif($this->session->userdata('rol') == 3){
           return 'includes_registered';
        }
        elseif($this->session->userdata('rol') == 4){
            
            
           return 'includes_partner';
        }
        else{
            
            return 'includes';

        }
    }
    function cargar_end() {
        if ($this->agent->is_mobile())
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    private function cargar_categoria()
    {
      $categoria = $this->categoria_model->get_categoria();
      foreach ($categoria as $row)
        {
            $data[$row['id_categoria']] = array('id_categoria' =>$row['id_categoria'],
                            'nombre_categoria' => $this->lang->line($row['nombre_categoria']));
        
        }
      return $data;
    }
/*
    public function seleccion_categoria()
    {
        $categoria $this->categoria_model->get_select_categoria();
        {

        }
    }
*/
    function relativeTime($datetime, $seconds = false, $ago = true) {
         $time = time(); // Store time to ensure consistency.
         $datetime = (is_int($datetime) && strlen($datetime) >= 1 && strlen($datetime) <= strlen($time)) ? $datetime : strtotime($datetime);
         // Determines if $datetime is in date format or if it's the number of seconds since the Unix Epoch.
         $shift = $time - $datetime;
         // Calculates time difference in seconds.

         $minute = 60;
         $hour = 3600;
         $day = 86400;
         $week = 604800;
         $month = 2592000;
         $year = 31536000;
         $decade = 315360000;

         if ($seconds == true) {
          return $shift;
         } else {
          if ($shift < 0) { // Date in the future
           $diff = "future";
           $term = "event";
          } elseif ($shift < 2) { // Less than 2 seconds
           $diff = "just a";
           $term = "moment";
          } elseif ($shift < $minute) { // Less than 60 seconds
           $diff = $shift;
           $term = "second";
          } elseif ($shift < $minute+30) { // Less than 1 minute, 30 seconds
           $diff = "about a";
           $term = "minute";
          } elseif ($shift < $minute*3) { // Less than 3 minutes
           $diff = "a few";
           $term = "minutes";
          } elseif ($shift >= $minute*30 && $shift < $minute*40) { // About half an hour
           $diff = "about half an";
           $term = "hour";
          } elseif ($shift < $hour) { // Less than 60 minutes
           $diff = floor($shift / $minute);
           $term = "minute";
          } elseif ($shift < 4200) { // Less than 1 hour, 10 minutes
           $diff = "about an";
           $term = "hour";
          } elseif ($shift < $day) { // Less than 1 day
           $diff = floor($shift / $hour);
           $term = "hour";
           $diff2 = floor($shift / $minute);
           $term2 = "minute";

           $maxdiff = $minute;
           $modulus = $diff * $maxdiff;
           $diff2 = $diff2 % $modulus;
          } elseif ($shift < $week) { // Less than 1 week
           $diff = floor($shift / $day);
           $term = "day";
           $diff2 = floor($shift / $hour);
           $term2 = "hour";

           $maxdiff = 24;
           $modulus = $diff * $maxdiff;
           $diff2 = $diff2 % $modulus;
          } elseif ($shift < $month) { // Less than 1 month
           $diff = floor($shift / $week);
           $term = "week";
           $diff2 = floor($shift / $day);
           $term2 = "day";

           $maxdiff = 7;
           $modulus = $diff * $maxdiff;
           $diff2 = $diff2 % $modulus;
          } elseif ($shift < $year) { // Less than 1 year
           $diff = floor($shift / $month);
           $term = "month";
           $diff2 = floor($shift / $day);
           $term2 = "day";

           $maxdiff = 30;
           $modulus = $diff * $maxdiff;
           $diff2 = $diff2 % $modulus;
           if ($diff2 == 7 || $diff2 == 14 || $diff2 == 21) {
            $diff2 = $diff2 / 7;
            $term2 = "week";
           }
          } elseif ($shift < $decade) { // Less than 10 years
           $diff = floor($shift / $year);
           $term = "year";
           $diff2 = floor($shift / $month);
           $term2 = "month";

           $maxdiff = 12;
           $modulus = $diff * $maxdiff;
           $diff2 = $diff2 % $modulus;
          } elseif ($shift < $decade*3) { // Less than 30 years
           $diff = floor($shift / $decade);
           $term = "decade";
           $diff2 = floor($shift / $year);
           $term2 = "year";

           $maxdiff = 10;
           $modulus = $diff * $maxdiff;
           $diff2 = $diff2 % $modulus;
          } elseif ($shift >= $decade*3) { // More than 30 years
           $diff = "many";
           $term = "year";
          }

          if (($term == "year" && $diff == "many") || ($diff != 1 && $diff != '' && preg_match("/^[0-9]+$/", $diff))) {
           $term .= "s"; // Makes term plural
          }
          
          if ($diff != "future" && (!isset($ago) || $ago != false)) { // Appends "ago" to the end of the relative time stamp unless event is in the future.
           $ago = " ago";
          } else {
           $ago = ""; // Remove "ago" for future date.
          }
          if (isset($diff2) && $diff2 != '' && isset($term2) && $term2 != '') {
           return "$diff $term ";
          } else {
           return "$diff $term";
          }
         }
        }
}