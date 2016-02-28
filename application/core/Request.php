<?php
/**
 * Created by PhpStorm.
 * User: ukito
 * Date: 2016/02/27
 * Time: 17:43
 */


/*
 * 管理を簡単にするためリクエストの情報はすべてrequestクラスで扱う
 * */
class Request {
    public function isPost() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            return true;
        }

        return false;
    }

    public function getGet($name,$default = "") {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }

        return false;
    }

    public function getHost() {
        if (isset($_SERVER["HTTP_HOST"])) {
            return $_SERVER["HTTP_HOST"];
        }
        return $_SERVER["SERVER_NAME"];
    }

    public function getRequestUri() {
        return $_SERVER["REQUEST_URI"];
    }

    //フロントコントローラまでのパスを取得
    //※index.phpが含まれる場合はそれを含む
    //例）"/foo/bar", "/foo/index.php"
    public function getBaseUrl() {
        $script_name = $_SERVER["SCRIPT_NAME"];
        $request_uri = $this->getRequestUri();

        //urlにindex.phpが含まれる場合
        if (strpos($request_uri,$script_name) === 0) {
            return $script_name;
        //urlにindex.phpが含まれない場合
        } else if (0 === strpos($request_uri, dirname($script_name))) {
            return rtrim(dirname($script_name),"/");
        }

        return "";

    }
    //フロントコントローラURLより後ろの値を取得
    //※GETパラメータは含まない
    //例）"/list", "/"
    public function getPathInfo() {
        $base_url = $this->getBaseUrl();
        $request_uri = $this->getRequestUri();

        if($param_pos = (strpos($request_uri,"?")) !== false) {
            $request_uri = substr($request_uri,0,$param_pos);
        }

        $path_info =  substr($request_uri,strlen($base_url));

        return $path_info;
    }

}
