<?php

namespace App\Controller;
/**
 * Class Controller
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * @package App\Controller
 */
class Controller
{
    /**
     * @var null
     */
    public $kernel = null;

    /**
     * Controller constructor.
     * @param $_this
     */
    public function __construct($_this)
    {
        session_start();
        $this->kernel = $_this;
    }

    /**
     * @param $template
     * @param array $arr
     */
    public function render($template, $arr = [])
    {
        //@header('Content-Type: text/html; charset=utf-8');
        $urlTemplate = __DIR__ . '/../Template/';
        include  $urlTemplate . "_header.php";
        include  $urlTemplate . $template;
        include  $urlTemplate . "_footer.php";
        return;
    }

    /**
     * @param array $arr
     */
    public function renderJson($arr = [])
    {
        header("Content-type:application/json; charset=utf-8");
        echo json_encode($arr);
        return;
    }
    /**
     * @param $template
     * @param array $arr
     */
    public function renderJsonPhp($template, $arr = [])
    {
        //@header('Content-Type: text/html; charset=utf-8');
        header("Content-type:application/json; charset=utf-8");
        $urlTemplate = __DIR__ . '/../Template/';
        include  $urlTemplate . $template;
        return;
    }

    /**
     * @param array $arr
     */
    public function renderString($string = '')
    {
        header("Content-type:application/json; charset=utf-8");
        echo  $string;
        return;
    }

}
