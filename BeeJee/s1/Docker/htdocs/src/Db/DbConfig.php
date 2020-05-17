<?php

namespace App\Db;
/**
 * Interface DbConfig
 * @author Valentin Badiul S <ur5fes@ya.ru>
 * @package App\Db
 */
interface DbConfig
{
    const DbConfigHost = 'mysql';
    const DbConfigUser = 'default';
    const DbConfigPass = 'secret';
    const DbConfigName = 'default';
    const DbConfigDatabase = "default";
    const DbConfigPort = "3306";
    const DbConfigCharset = "UTF-8";
}
