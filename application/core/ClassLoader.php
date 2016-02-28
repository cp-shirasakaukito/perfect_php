<?php
/**
 * Created by PhpStorm.
 * User: ukito
 * Date: 2016/02/27
 * Time: 12:36
 */

class ClassLoader {

    protected $dirs;

    public function register(){
    spl_autoload_register("loadClass");
}

    public function registerDir($dir) {
        $this->$dirs[] = $dir;
    }

    public function loadClass($class) {
        foreach($this->$dirs as $dir){
            $filePath = $dir."/".$class.".php";
            if(file_exists($filePath)){
                require($filePath);

                return;
            }
        }
    }
}