<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if($end == 1){
	$this->load->view($includes.'/header');
	$this->load->view($includes.'/open');
	$this->load->view($main_content);
	$this->load->view($includes.'/close');
	$this->load->view($includes.'/sidebar');
	$this->load->view($includes.'/footer');
    }
    else{
        $this->load->view($includes.'/header');
        $this->load->view($includes.'/sidebar');
	$this->load->view($includes.'/open');
	$this->load->view($main_content);
	$this->load->view($includes.'/close');
	$this->load->view($includes.'/footer');
    }

?>