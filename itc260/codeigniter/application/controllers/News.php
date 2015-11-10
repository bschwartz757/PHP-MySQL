<?php
//News.php

class News extends CI_Controller 
{
            public function __construct()
            {
                    parent::__construct();
                    $this->load->model('news_model');
                
                $this->config->set_item('banner', 'News Banner');
                
                
            }//end constructor

            public function index()
            {
                    $data['news'] = $this->news_model->get_news();
                    $data['title'] = 'News archive';
                    $this->load->view('news/index', $data);
    }// end index

    public function view($slug = NULL)
    {
            $data['news_item'] = $this->news_model->get_news($slug);

            if (empty($data['news_item']))
            {
                    show_404();
            }

            $data['title'] = $data['news_item']['title'];

            $this->load->view('news/view', $data);
    }//end view

    public function create()
    {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $data['title'] = 'Create a news item';

            $this->form_validation->set_rules('title','Title','required');
            $this->form_validation->set_rules('text','text','required');

            if($this->form_validation->run() === FALSE)
            {//data not submitted
                $this->load->view('news/create', $data);

            }
            else
            {//process data
                $success = $this->news_model->set_news();
                
                if($success)
                {
                    $success = "News successfully entered!";   
                }else
                {
                    $success = "News not entered!";   
                }
                $data['success'] = $success;                
                $this->load->view('news/feedback', $data);                
            }

    }//end create function

}//end News