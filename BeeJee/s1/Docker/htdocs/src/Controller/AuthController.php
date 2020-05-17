<?php

namespace App\Controller;

use  App\Repository\AuthRepository;
use App\Services\AuthService;

/**
 * Class AuthController
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * @package App\Controller
 */
class AuthController extends Controller
{
    /**
     * @var AuthRepository
     */
    public $repository;

    /**
     * @var AuthService
     */
    public $service;

    public function __construct($_this)
    {
        $_SESSION['auth'] = null;
        parent::__construct($_this);
        $this->repository = new AuthRepository();
        $this->service = new AuthService();
    }

    public function login()
    {
        $arr = [];
        $auth = $this->service->loginAuth();
        if (!isset($auth[0])) {
            if ('submitLogin' == $_POST['submit']) {
                $arr = [
                    'error' => 'Неверный логин или пароль',
                ] ;
            }
            return $this->render('main_index.php',$arr );
        } else {
            $_SESSION['auth'] = $auth;
            header('Location: //' . $_SERVER['SERVER_NAME']. '/');
            return;
        }
    }

    public function logout ()
    {
        session_destroy();
        header('Location: //' . $_SERVER['SERVER_NAME']. '/');
        return;
    }

}
