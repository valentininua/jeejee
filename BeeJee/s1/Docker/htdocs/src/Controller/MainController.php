<?php

namespace App\Controller;

use  App\Repository\IndexRepository;
use  App\Services\IndexService;

/**
 * Class IndexController
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * @package App\Controller
 */
class MainController extends Controller
{
    /**
     * @var IndexRepository
     */
    public $repository;

    /**
     * @var IndexService
     */
    public $service;

    public function __construct($_this)
    {
        parent::__construct($_this);
        $this->repository = new IndexRepository();
        $this->service = new IndexService();
    }

    private function checkSession()
    {
        return $_SESSION["auth"][0]['id']?true:false;
    }

    public function main()
    {
        return $this->render('main_main.php', [
            'allTaskData' => json_encode($this->service->getTaskData()),
        ]);
    }

    public function checkUniqueEmailAddress()
    {
        return $this->renderString(
            $this->service->checkEmailString(
                json_decode(
                    file_get_contents("php://input")
                )
            )
        );
    }

    public function rowInserted()
    {
        if ($this->checkSession()) {
            return $this->renderJson(['session' => 'exit']);
        }
        $rawData = json_decode(file_get_contents("php://input"));
        return $this->repository->rowInserted($rawData);
    }

    public function rowRemoved()
    {
        if ($this->checkSession()) {
            return $this->renderJson(['session' => 'exit']);
        }
        $rawData = json_decode(file_get_contents("php://input"));
        return $this->repository->rowRemoved($rawData);
    }

    public function rowUpdated()
    {
        if ($this->checkSession()) {
            return $this->renderJson(['session' => 'exit']);
        }
        $rawData = json_decode(file_get_contents("php://input"));
        return $this->repository->rowIfEditUpdated($rawData);
    }

}
