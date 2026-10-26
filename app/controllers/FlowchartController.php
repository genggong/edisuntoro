<?php
class FlowchartController
{
    public function index()
    {
        $title = 'Alur Sistem'; $active = 'alur'; $view = BASE_PATH . '/views/alur.php';
        require BASE_PATH . '/views/layout.php';
    }
}
