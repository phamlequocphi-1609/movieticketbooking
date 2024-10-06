<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class BaseController{   
    
    private $jwtSecretKey = 'eb4a1a2851feb2ac2d239f2fc751684b8d5aaacf64a8cb8b014730e8d61576b4';
    protected $userId;
    protected function view($viewPath, array $data = []){
        foreach($data as $key=>$value){
            $$key = $value;
        }
        require('app/views/' . str_replace('.', '/', $viewPath) . '.php');
    }
    
    protected function model($modelPath){    
        $modelPath = str_replace('.', '/', $modelPath);
        $modelArr = explode('/', $modelPath);
        $modelArr[count($modelArr) - 1] = ucfirst($modelArr[count($modelArr) - 1]);
        $modelFolder = implode('/', $modelArr);
        require('app/models/'.$modelFolder. 'Model' . '.php');
    }
    
    protected function middleware($middleware){
        if($middleware){
            if(!isset($_SESSION['userId'])){
                header('Location: ' . __WEB_ROOT__ . '/admin/showLogin');
                exit();
            }
        }
    }
    
    protected function createToken($userId) {
        $payload = [
            'iat' => time(), 
            'exp' => time() + 3600, 
            'sub' => $userId 
        ];
        return JWT::encode($payload, $this->jwtSecretKey, 'HS256');
    }
    
    protected function checkToken(){
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $authArr = explode(" ", $authHeader);
            if ($authArr) {             
                $jwt = $authArr[1];
                try {
                    $decode = JWT::decode($jwt, new Key($this->jwtSecretKey, 'HS256'));
                    $this->userId = $decode->sub;
                    return $decode;
                } catch (\Exception $e) {
                    http_response_code(401);
                    $response = json_encode([
                        'status' => 'error',
                        'message' => 'Invalid or expired token',
                    ]);
                    echo $response;
                }
            } 
        } else {
            http_response_code(401);
            $response = json_encode([
                'status' => 'error',
                'message' => 'Authorization header not found',
            ]);
            echo $response;
        }
    } 
}
?>