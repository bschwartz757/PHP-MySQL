<?php
//views/news/feedback.php

$this->load->view($this->config->item('theme') . 'header');

?>

<h2><?php echo $title ?></h2>

<p><?=$success?></p>

<?php
  
$this->load->view($this->config->item('theme') . 'footer');        
    
?>    