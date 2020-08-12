<?php
namespace App\Controller;

class BaseController
{
    public function view($template_name = 'index', $params = [])
    {
        $smarty = new \Smarty();
        $title = isset($params['title']) ? $params['title'] : 'Invoice Generator';
        $smarty->assign('page_title', $title);
        $smarty->assign('header', PROJECT_DIR . '/templates/includes/header.tpl');
        $smarty->assign('footer', PROJECT_DIR . '/templates/includes/footer.tpl');
        foreach ($params as $name => $param) {
            $smarty->assign($name, $param);
        }
        $smarty->display(PROJECT_DIR . '/templates/' . $template_name . '.tpl');
    }
}
