<?php

//helps to get the access the access the files within framework
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:Authorazation');

// below file is required to work on
include "/var/www/html/codeigniter/application/static/Constant.php";
class DatabaseConnection
{
    /**
     * @method DB Connection establish
     * @return PDO object
     */
    public function Connection()
    {
        $data = new Constant();
        return new PDO("$data->database:host=$data->host;dbname=$data->dbname", "$data->user", "$data->password");

    }
}
