<?php
//Rss_model.php

class Rss_model extends CI_Model {

    public function get_rss()
    {
        $request = "https://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=e&output=rss";
    
        $response = file_get_contents($request);
        $xml = simplexml_load_string($response);
        return $xml;
    }//close get_rss

}//close Rss_model