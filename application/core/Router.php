<?php
/**
 * Created by PhpStorm.
 * User: ukito
 * Date: 2016/02/28
 * Time: 14:27
 */
class Router {
    protected $routes;

    function __construct($definitions){
        $this->routes = $this->compileRoutes($definitions);
    }

    /*
     * $definitions:ルーティング定義配列
     * コロン(:user_idなど)で指定された動的箇所は正規表現の名前付きキャプチャで取得し、
     * ルーティング定義配列が連想配列で動的箇所を表現できるようにコンパイル
     * */
    public function compileRoutes($definitions) {
        $routes = array();

        foreach($definitions as $url => $params){
            $tokens = explode("/", ltrim($url,"/"));
            foreach($tokens as $i => $token){
                if (strpos($token,":") === 0){
                    $name =substr($token, 1);
                    $token = "(?P<" . $name . ">[^/]+)";
                }
                $tokens[$i] = $token;
            }
            $pattern = "/" . implode("/", $tokens);
            $routes[$pattern] = $params;
        }
        return $routes;
    }

    /*
     * $path_info:フロントコントローラより後ろのURL
     * $path_infoからルーティング配列を作成する
     * $ルーティング定義配列で定義されていない場合はfalseを返す
     * 定義されている場合はルーティング配列を返す
     * */
    public function resolve($path_info) {
        if (substr($path_info,0,1) !== "/"){
            $path_info = "/" . $path_info;
        }

        foreach ($this->routes as $pattern => $params) {
            if(preg_match("#^" . $pattern . "$#",$path_info,$matches)) {
                $params = array_merge($params,$matches);
            }
            return $params;
        }
        return false;
    }
}