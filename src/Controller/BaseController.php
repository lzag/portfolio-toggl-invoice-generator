<?php
namespace App\Controller;

class BaseController
{
    public function view($name = 'index', $params = [])
    {
        $smarty = new \Smarty();
        $title = isset($params['title']) ? $params['title'] : 'Invoice Generator';
        $smarty->assign('page_title', $title);
        $smarty->assign('header', PROJECT_DIR . '/templates/includes/header.tpl');
        $smarty->assign('footer', PROJECT_DIR . '/templates/includes/footer.tpl');
        $smarty->display(PROJECT_DIR . '/templates/' . $name . '.tpl');
    }
}
