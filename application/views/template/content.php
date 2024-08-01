<main id="main" class="main">

    <div class="pagetitle mb-15">
        <h1><?= $title ?></h1>
    </div><!-- End Page Title -->

<?php

if($content){
    $this->load->view($content);
}

?>

</main><!-- End #main -->