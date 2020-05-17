<?php

namespace App\Repository;

use App\Db\Database;
use \PDO;

/**
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * Class ServiceReportRepository
 * @package App\Repository
 */
class IndexRepository
{

    public function __construct()
    {
        $this->db = Database::getInstance();
        Database::setCharsetEncoding();
    }

    /**
     * @return array
     */
    public function getTest()
    {

        $sqlExample = 'SELECT * FROM test WHERE id = 1';
        $stm = $this->db->prepare($sqlExample);

        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    public function getTaskData()
    {
        $sqlExample = 'SELECT * FROM task where Del = 0';
        $stm = $this->db->prepare($sqlExample);
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkOneTaskData($arr)
    {
        $stmt = $this->db->prepare("SELECT * FROM task WHERE id=:id AND Task=:Task");
        $stmt->execute(['id' => (int) $arr->id,'Task'=> $arr->Task]);
        return $stmt->fetch();
    }

    public function rowInserted($arr)
    {
        $data = [
            'Name' => $arr->Name,
            'Email' => $arr->Email,
            'Status' => 0,
            'Task' => $arr->Task,
            'Status' => ((int)$arr->Status==0) ? 1 : $arr->Status,
            'Del' => 0,
        ];

        $sql = "INSERT INTO task (Name, Email, Status,Task,Del) VALUES (:Name, :Email, :Status, :Task, :Del)";
        $stmt= $this->db->prepare($sql);
        $stmt->execute($data);
        return;
    }

    public function rowRemoved($arr)
    {
        $data = [
            'Del' => 1,
            'Email' => $arr->Email,
            'Status' => (int) $arr->Status,
            'Task' => $arr->Task,
        ];
        $sql = "UPDATE task SET Del=:Del WHERE Email=:Email AND Status=:Status AND Task=:Task ";
        $stmt= $this->db->prepare($sql);
        $stmt->execute($data);
        return;
    }

    public function rowIfEditUpdated($arr)
    {

        $this->checkOneTaskData($arr);
        $data = [
            'id' => (int) $arr->id,
            'Email' => $arr->Email,
            'Status' => (int) $arr->Status,
            'Task' => $arr->Task,
        ];

        $strEdited = '';
        if (false == $this->checkOneTaskData($arr)) {
            $data["Edited"] = 1;
            $strEdited = " , Edited=:Edited ";
        }

        $sql = "UPDATE task SET Email=:Email,Status=:Status,Task=:Task " . $strEdited .
        " WHERE id=:id";

        $stmt= $this->db->prepare($sql);
        $stmt->execute($data);
        return;

    }



}
