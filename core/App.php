<?php
class App{
    private $controller, $action , $params , $routes;
    public function __construct()
    {
        global $routes;
        $this->routes = new Route();
        if(!empty($routes['dashboard'])){
            $this->controller = $routes['dashboard'];
        }
        $this->action = 'index';
        $this->params = [];
        $this->handleUrl();
    }
    public function geturl(){
        if(!empty($_SERVER['PATH_INFO'])){
            $url = $_SERVER['PATH_INFO'];
        }else{
            $url = '/dashboard';
        }
        return $url;
    }
    public function handleUrl() {
        $url = $this->getUrl();
        $url = $this->routes->handleRoute($url);
        $urlArr = array_filter(explode('/', $url));
        $urlArr = array_values($urlArr);       
        $urlcheck = '';      
        if(!empty($urlArr)){
            foreach($urlArr as $key=>$val){
                $urlcheck .= $val . '/';
                $filecheck = rtrim($urlcheck, '/');
                $fileArr = explode('/', $filecheck);
                $fileArr[count($fileArr) - 1] = ucfirst($fileArr[count($fileArr) - 1]);
                $filecheck = implode('/', $fileArr);               
                if(!empty($urlArr[$key - 1])){
                    unset($urlArr[$key - 1 ]);
                }                
                if(file_exists('app/controllers/' . $filecheck . 'Controller.php')){
                    $urlcheck = $filecheck;
                    break;
                }
            }
            $urlArr = array_values($urlArr);
        }
        if (!empty($urlArr[0])) {
            $this->controller = ucfirst($urlArr[0]);
        } else {
            $this->controller = ucfirst($this->controller);
        }
        if(empty($urlcheck)){
            $urlcheck = $this->controller;
        }
        if (file_exists('app/controllers/' . $urlcheck . 'Controller.php')) {
            require_once('app/controllers/' . $urlcheck . 'Controller.php');
            $controllerClass = $this->controller . 'Controller';
            if (class_exists($controllerClass)) {
                $this->controller = new $controllerClass();
                unset($urlArr[0]);
            } else {
                $this->loadError();
            }
        } else {
            $this->loadError();
        }
        if(!empty($urlArr[1])){
            $this->action = $urlArr[1];
            unset($urlArr[1]);
        }
        $this->params = array_values($urlArr);
  
        call_user_func_array([$this->controller, $this->action], $this->params);   
    }
    public function loadError($name = '404'){
        require_once('app/error/'.$name . '.php');
    }
}   
?>