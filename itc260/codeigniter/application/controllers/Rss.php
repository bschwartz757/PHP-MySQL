<?php
//Rss.php

class Rss extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('rss_model');
        $this->config->set_item('banner','Entertainment News');
        $this->config->set_item('title','Rss Entertainment News');    
    }//close constructor
        
            public function index()
            {
                $data['rss'] = $this->rss_model->get_rss();
                $this->load->view('rss/index', $data);
                                
            }//close index

}//close Rss