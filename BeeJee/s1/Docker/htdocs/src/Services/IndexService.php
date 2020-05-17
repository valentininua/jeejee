<?php

namespace App\Services;

use App\Repository\AuthRepository;
use App\Repository\IndexRepository;

/**
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * Class IndexService
 * @package App\Services
 */
class IndexService
{
    /**
     * @var IndexRepository
     */
    public $repository;

    /**
     * AuthService constructor.
     */
    public function __construct()
    {
        $this->repository = new IndexRepository();
    }

    /**
     * @param $data
     * @return string
     */
    public function checkEmailString($data):string
    {
        if (filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
            return 'true';
        }
        return 'false';
    }

    public function getTaskData()
    {
        return $this->repository->getTaskData();
    }

}
