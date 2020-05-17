<?php

namespace App\Repository;

use App\Db\Database;
use \PDO;

/**
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * User table, fields: login, password, etc.
 * Class ServiceReportRepository
 * @package App\Repository
 */
class AuthRepository
{

    public function __construct()
    {
        $this->db = Database::getInstance();
        // Database::setCharsetEncoding();
    }

    /**
     * @return array
     */
    public function getAuth($arr = [])
    {
        $sqlExample = 'SELECT * FROM users WHERE FirstName = "' . trim($arr['FirstName']) . '" AND Pass = "' . md5(trim($arr['accountPassword'])) . '"';
        $stm = $this->db->prepare($sqlExample);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setAuthRegistration()
    {

        $arr = array(
            'EmailAdres' => $_POST['accountEmailAddress'],
            'accountPassword' => $_POST['accountPassword'],
            'accountLastName' => $_POST['accountLastName'],
            'accountLoginFirstName' => $_POST['accountLoginFirstName'],
        );


        $sqlExample = 'SELECT * FROM users WHERE EmailAdres = "' . trim($arr['EmailAdres']) . '"';
        $stm = $this->db->prepare($sqlExample);
        $stm->execute();
        $dataExample = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (isset($dataExample[0]["id"])) {
            // if user exists
            return false;
        } else {
            //TODO :: will make a check
            $data = [
                'EmailAdres' => trim($_POST['accountEmailAddress']),
                'Pass' => md5(trim($_POST['accountPassword'])),
                'LastName' => $_POST['accountLastName'],
                'FirstName' => $_POST['accountLoginFirstName'],
                'Tel' => $_POST['accountTel'],

            ];
            $sql = "INSERT INTO users (EmailAdres,Pass,LastName,FirstName,Tel) VALUES (:EmailAdres,:Pass,:LastName,:FirstName,:Tel)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            return true;
        }

    }

}
