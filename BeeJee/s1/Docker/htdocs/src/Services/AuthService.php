<?php

namespace App\Services;

use  App\Repository\AuthRepository;

/**
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * Class AuthService
 * @package App\Services
 */
class AuthService
{

    /**
     * @var AuthRepository
     */
    public $repository;

    /**
     * AuthService constructor.
     */
    public function __construct()
    {
        $this->repository = new AuthRepository();
    }

    /**
     * Mandatory field and client checking
     * @param string $name
     * @return bool
     */

    public function checkFirstName($name = '')
    {
        if (preg_match("/^([A-Za-z0-9_\-\.]){2,40}$/", $name)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function loginAuth()
    {
        if (
            $this->checkFirstName($_POST['FirstName'])
        ) {
            return $this->repository->getAuth(array(
                'FirstName' => $_POST['FirstName'],
                'accountPassword' => $_POST['accountPassword'],
            ));
        } else {
            return false;
        }
    }

}
