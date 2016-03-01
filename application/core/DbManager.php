<?php
/**
 * Created by PhpStorm.
 * User: ukito
 * Date: 2016/02/28
 * Time: 21:46
 */

class DbManager {

    protected $connections = array();


    public function connect($name, $params) {
        //DBへのアクセス情報を設定
        $params = array_merge(array(
            "dsn" => null,
            "user" =>  "",
            "password" => "",
            "options" => array(),
        ), $params);

        //DBへアクセス
        $con = new PDO(
            $params["dsn"],
            $params["user"],
            $params["password"],
            $params["options"]
        );

        //例外を返さない設定がデフォルトなので返すように変更
        $con->setAttribute(PDO::ATTR_ERRMODE);
    }

    public function getConnection($name=null) {
        if(is_null($name)) {
            return current($this->connections);
        }

        return $this->connections[$name];
    }
}