<?php

namespace App;

use \App\Db\Database;
use http\Env\Request;
use \PDO;
use App\Component\Routing;

/**
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * Class Kernel
 * @package App
 */
class Kernel
{
    /**
     * @var PDO|null
     */
    public $db = null;

    /**
     * @var array
     */
    public $routing = [];

    /**
     * @var Routing|null
     */
    public $newRouting = null;

    /**
     * Kernel constructor.
     * @param array $routing
     */
    public function __construct($routing = [])
    {
        $this->routing = $routing;
        $this->db = Database::getInstance();   // use the singleholton
        // Database::setCharsetEncoding();
        $this->newRouting = new Routing($this->routing);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        return $this->newRouting->getFunctionClass($this);
    }

}
