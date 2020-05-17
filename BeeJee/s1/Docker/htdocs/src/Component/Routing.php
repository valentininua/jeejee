<?php

namespace App\Component;

/**
 * Class IndexController
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * @package App\Controller
 */
class Routing
{
    /**
     * @var false|string[]
     */
    public $uri = null;

    public $routing = null;

    /**
     * Routing constructor.
     */
    public function __construct($routing)
    {
        $this->routing = $routing;
        if (!$routing[$_SERVER["REQUEST_URI"]]) {
            $this->e404();
        } else {
            $this->uri = explode('::', $routing[$_SERVER["REQUEST_URI"]]);
        }
    }


    /**
     * @param $_this
     * @return mixed
     */
    public function getFunctionClass($_this)
    {
        $AppController = '\App\Controller\\'; // todo will edit this
        $controllerClass = $AppController . $this->uri[0];
        $funcName = $this->uri[1];
        $newController = new $controllerClass($_this);

        return $newController->{$funcName}();
    }

    public function e404()
    {
        header("HTTP/1.0 404 Not Found");
        echo ' Error 404 not found  <br />';
        echo "The HTTP error 404, or more commonly called \"404 error\", means that the page you are trying to open could not be found on the server.";
        exit(''); // todo will return
    }
}
