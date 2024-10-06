<?php
class MemberController extends BaseController{

    private $userModel , $countryModel; 
    
    public function __construct()
    {
        $this->model('user');
        $this->userModel = new UserModel();     
        $this->model('admin.country');
        $this->countryModel = new CountryModel();
    }
    public function register(){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $id_gender = isset($_POST['id_gender']) ? $_POST['id_gender'] : '';
            $id_country = isset($_POST['id_country']) ? $_POST['id_country'] : '';
            $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $emailCheck = $this->userModel->findData($email);
            $validation = [];

            if(empty($name)){
                $validation[] = 'The name is required';
            }
            if(empty($email)){
                $validation[] = 'The email is required';
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $validation[] = 'The email required a valid email format ';
            }else{
                if($emailCheck){
                    $validation[] = 'The email already exit';
                }
            }
            if(empty($password)){
                $validation[] = 'The password is required';
            }
            if(empty($id_gender)){
                $validation[] = 'Select gender is required';
            }
            if(empty($id_country)){
                $validation[] = 'Select country is required';
            }
            if(empty($address)){
                $validation[] = 'The address is required';
            }
            if(empty($birthday)){
                $validation[] = 'The birthday is required';
            }
            if(empty($phone)){
                $validation[] = 'The phone is required';
            }
            if(!empty($_FILES['avatar']['name'])){
                if($_FILES['avatar']['error'] > 0){
                    $validation[] = 'File upload is errored';
                }else if($_FILES['avatar']['size'] > 1024*1024){
                    $validation[] = 'The image is required to be no longer than 1MB';
                }else{
                    $fileType = ['png', 'jpg', 'jpeg'];
                    $filename = explode('.', $_FILES['avatar']['name']);
                    $fileExtension = strtolower(end($filename));
                    if(!in_array($fileExtension, $fileType)){
                        $validation[] = 'The image must have the extension png , jpg, jpeg';
                    }else{
                        $uploadDir = __DIR_ROOT__ . '/public/upload/member/avatar/' . $_FILES['avatar']['name'];
                        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir);
                    }
                }
            }else{
                $validation[] = 'The avatar is required';
            }
            if(!empty($validation)){
                $response = json_encode([
                    'status' => 'error',
                    'message' => $validation
                ]);
                echo $response;
            }else {
                $avatar = isset($_FILES['avatar']['name']) ? $_FILES['avatar']['name'] : '';
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'id_gender'=> $id_gender,
                    'id_country'=> $id_country,
                    'phone' => $phone,
                    'address'=> $address,
                    'avatar' => $avatar,
                    'birthday'=>$birthday,
                    'level' => 0
                ];   
                $this->userModel->store($data);  
                $response = json_encode([
                    'status' => 200,
                    'message' => 'Register Successfully'
                ]);
                echo $response;  
            }         
        }
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email =  isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $remember = isset($_POST['remember_me']) ? true : false;
            $level = 0;
            $validation = [];
            if (empty($email)) {
                $validation[] = "The email is required";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $validation[] = 'The email requires a valid email format ';
            }
            if (empty($password)) {
                $validation[] = "The password is required";
            }

            if (!empty($validation)) {
                $response = json_encode([
                    'status' => 'error',
                    'message' => $validation
                ]);
                echo $response;
            } else {
                $find = [
                    'email' => $email,
                    'level' => $level
                ];
                $data = $this->userModel->findbycondition($find);

                if (password_verify($password, $data['password'])) {
                    $token = $this->createToken($data['id']); 
                    $_SESSION['memberId'] = $data['id'];
                    if ($remember) {
                        setcookie("remember_me", $token, time() + 3*24*60*60, "/");  
                    } else {
                        setcookie("remember_me", $token, time() + 3600, "/");
                    }      
                    $response = json_encode([
                        'status' => 200,
                        'token' => $token,
                        'Auth' => [
                            'id' => $data['id'],
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'password' => $data['password'],
                            'id_gender' => $data['id_gender'],
                            'id_country' => $data['id_country'],
                            'phone' => $data['phone'],
                            'address' => $data['address'],
                            'avatar' => $data['avatar'],
                            'birthday' => $data['birthday']
                        ]
                    ]);
                    echo $response;
                } else {
                    $response = json_encode([
                        'status' => 'error',
                        'message' => 'Invalid password or email'
                    ]);
                    echo $response;
                }
            }
        }
    }

    public function update(){
        $this->checkToken();
        $userId = $this->userId;
        if($userId){
            $user = $this->userModel->findById($userId);
            if($_SERVER['REQUEST_METHOD'] === "POST"){
                $name = isset($_POST['name']) ? $_POST['name'] : $user['name'];
                $email = isset($_POST['email']) ? $_POST['email'] : $user['email'];
                $password = isset($_POST['password']) ? $_POST['password'] : $user['password'];
                $id_gender = isset($_POST['id_gender']) ? $_POST['id_gender'] : $user['id_gender'];
                $phone = isset($_POST['phone']) ? $_POST['phone'] : $user['phone'];
                $address = isset($_POST['address']) ? $_POST['address'] : $user['address'];
                $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : $user['birthday'];
                $id_country = isset($_POST['id_country']) ? $_POST['id_country'] : $user['id_country'];
                $validation = [];
                $emailCheck = $this->userModel->findData($email);
                if(empty($email)){
                    $validation[] = 'The email is required';
                }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $validation[] = 'The email requires valid email format';
                }else if($email != $user['email']){
                    if($emailCheck){
                        $validation[] = "This email already exit";
                    }
                }
                if(empty($name)){
                    $validation[] = "The name is required";
                }
                if(!empty($_FILES['avatar']['name'])){
                    if($_FILES['avatar']['error'] > 0){
                        $validation[] = 'File upload is errored';
                    }else if($_FILES['avatar']['size'] > 1024*1024){
                        $validation[] = 'The image is required to be no longer than 1MB';
                    }else{
                        $fileType = ['png', 'jpg', 'jpeg'];
                        $filArr = explode('.', $_FILES['avatar']['name']);
                        $fileExtension  = strtolower(end($filArr));
                        if(!in_array($fileExtension, $fileType)){
                            $validation[] = "The image must have the extension png, jpg, jpeg";
                        }else{
                            $uploadDir = __DIR_ROOT__ . '/public/upload/member/avatar/'. $_FILES['avatar']['name'];
                            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir);
                        }
                    }
                }
                if(!empty($validation)){
                    $response = json_encode([
                        'status' => 'error',
                        'message' => $validation
                    ]);
                    echo $response;
                }else{
                    $token = $this->createToken($user['id']);
                    $data = [
                        'name' => $name,
                        'email' =>$email,
                        'password'=> !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $user['password'],
                        'id_gender' => $id_gender,
                        'phone' => $phone,
                        'address'=> $address,
                        'birthday' => $birthday,
                        'id_country' => $id_country,
                        'avatar' => !empty($_FILES['avatar']['name']) ? $_FILES['avatar']['name'] : $user['avatar']
                    ];
                    $this->userModel->updateData($userId, $data);
                    setcookie("remember_me", $token, time() + 3600, "/");
                    $response = json_encode([
                        'status' => 200,
                        'token' => $token,
                        'data' => $data
                    ]);
                    echo $response;
                }
            }
        }
    }
    
    public function logout(){
        if(isset($_SESSION['memberId']) && isset($_COOKIE['remember_me'])){
            session_destroy();
            setcookie("remember_me", "", time() -3600);
            
            $response = json_encode([
                'status' => 'success',
                'message' => 'Logout Successfully'
            ]);
            echo $response;
        }
    }
    
    public function getcountry(){
        $country = $this->countryModel->getAll();
        $response = json_encode([
            'status' => 200,
            'data' => $country
        ]);
        echo $response;
    }
}