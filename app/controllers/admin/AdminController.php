<?php
class AdminController extends BaseController{
    private $genderModel, $countryModel, $userModel ,$data = [];
    public function __construct()
    {
        $this->model('admin.gender');
        $this->model('admin.country');
        $this->model('user');
        $this->genderModel = new GenderModel();
        $this->countryModel = new CountryModel();
        $this->userModel = new UserModel();
    }
    public function add(){
        $gender = $this->genderModel->getAll();
        $country = $this->countryModel->getAll();
        return $this->view('admin.user.add', [
            'genders' => $gender,
            'countries'=> $country
        ]);
    }
    public function create(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $id_gender = isset($_POST['id_gender']) ? $_POST['id_gender'] : '';
            $id_country = isset($_POST['id_country']) ? $_POST['id_country'] : '';
            $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';   
            $phone =isset($_POST['phone']) ? $_POST['phone'] : '';
            $emailCheck = $this->userModel->findData($email);
            $validation = [];
            if(empty($name)){
                $validation[] = 'The name is required';
            }
            if(empty($email)){
                $validation[] = 'The email is required';
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $validation[] = 'The email required a valid email format';
            }else{
                if($emailCheck){
                    $validation[] = 'The email already exit';
                }
            }
            if(empty($password)){
                $validation[] = 'The password is required';
            }
            if(empty($id_gender)){
                $validation[] = 'The gender is required';
            }
            if(empty($id_country)){
                $validation[] = 'The country is required';
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
                    $fileType = ['png','jpg', 'jpeg'];
                    $fileName = explode('.', $_FILES['avatar']['name']);
                    $filecheck = strtolower(end($fileName));
                    if(!in_array($filecheck, $fileType)){
                        $validation[] = 'The image must have the extension png, jpg, jpeg';
                    }else{
                        $uploadDir = __DIR_ROOT__ . '/public/upload/admin/avatar/' . $_FILES['avatar']['name'];
                        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir);
                    }
                }
            }else{
                $validation[] = 'The avatar is required';
            }
            $avatar = isset($_FILES['avatar']['name']) ? $_FILES['avatar']['name'] : '';
            if(!empty($validation)){
                return $this->view('admin.user.add', ['validation' => $validation]);
            }else{
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password'=> password_hash($password, PASSWORD_DEFAULT),
                    'id_gender'=>$id_gender,
                    'phone'=>$phone,
                    'address'=>$address,
                    'avatar' => $avatar,
                    'birthday'=>$birthday,
                    'id_country'=>$id_country,
                ];

                $this->userModel->store($data);
                header('Location:' .__WEB_ROOT__ .'/dashboard');
            }
        }
    }
    public function show(){
        $this->view('admin.user.login');
    }
    public function login(){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $validation = [];
            if(empty($email)){
                $validation[] = 'The email is required';
            }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $validation = 'The email requires a valid email format';
            }
            if(empty($password)){
                $validation[] = 'The password is required';
            }
            if(!empty($validation)){
                return $this->view('admin.user.login', ['validation'=> $validation]);
            }else{
                $admin = $this->userModel->findData($email);
                if($admin && password_verify($password, $admin['password'])){
                    $_SESSION['userId'] = $admin['id'];
                    $_SESSION['userName'] = $admin['name'];     
                    $_SESSION['userAvatar'] = $admin['avatar'];           
                    header('Location:' .__WEB_ROOT__ . '/dashboard');
                }else{
                    $validation[] = 'Invalid email or password';
                    return $this->view('admin.user.login', ['validation'=> $validation]);
                }
            }      
        }
    }
    public function profile(){
        if(isset($_SESSION['userId'])){
            $id = $_SESSION['userId'];
            $user = $this->userModel->findById($id);
            $gender = $this->genderModel->getAll();
            $country = $this->countryModel->getAll();
            $this->data['sub_content']['user'] = $user;
            $this->data['sub_content']['genders'] = $gender;
            $this->data['sub_content']['countrys'] = $country;
            $this->data['content'] = 'admin.user.profile';
            return $this->view('admin.layouts.app', $this->data);
        }
    }
    public function update(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_SESSION['userId'])){
                $id = $_SESSION['userId'];
                $user = $this->userModel->findById($id);
                if($user){
                    $name = isset($_POST['name']) ? $_POST['name'] : $user['name'];
                    $password = isset($_POST['password']) ? $_POST['password'] : $user['password'];
                    $id_gender = isset($_POST['id_gender']) ? $_POST['id_gender'] : $user['id_gender'];
                    $id_country = isset($_POST['id_country']) ? $_POST['id_country'] : $user['id_country'];
                    $address = isset($_POST['address']) ? $_POST['address'] : $user['address'];
                    $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : $user['birthday'];
                    $phone = isset($_POST['phone']) ? $_POST['phone'] : $user['phone'];
                    $email = isset($_POST['email']) ? $_POST['email'] : $user['email'];
                    $validation = [];
                    $emailCheck = $this->userModel->findData($email);
                    if(empty($name)){
                        $validation[] = 'The name is required';
                    }
                    if(empty($email)){
                        $validation[] = 'The email is required';
                    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $validation[] = 'The email requires a valid email format';
                    }else if($email != $user['email']){
                        if($emailCheck){
                            $validation[] = 'This email already exit';
                        }
                    }
                    if(!empty($_FILES['avatar']['name'])){
                        if($_FILES['avatar']['error'] > 0){
                            $validation[] = 'File upload is errored';
                        }else if($_FILES['avatar']['size'] > 1024*1024){
                            $validation[] = 'The image is required to be no longer than 1MB';
                        }else{
                            $fileType = ['png', 'jpg', 'jpeg'];
                            $fileArr = explode('.', $_FILES['avatar']['name']);
                            $fileName = strtolower(end($fileArr));
                            if(!in_array($fileName, $fileType)){
                                $validation[] = 'The image must have the extension png, jpg, jpeg';
                            }else{
                                $uploadDir = __DIR_ROOT__ . '/public/upload/admin/avatar/' .$_FILES['avatar']['name'];
                                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir);
                            }
                        }
                    }               
                    if(!empty($validation)){                       
                        $gender = $this->genderModel->getAll();
                        $country = $this->countryModel->getAll();
                        $this->data['sub_content']['validation'] = $validation;               
                        $this->data['sub_content']['user'] = $user;
                        $this->data['sub_content']['genders'] = $gender;
                        $this->data['sub_content']['countries'] = $country;
                        $this->data['content'] = 'admin.user.profile';          
                        return $this->view('admin.layouts.app', $this->data);
                          header('Location:' .__WEB_ROOT__ .'/admin-profile');
                    }else{
                        $data = [
                            'name'=>$name,
                            'email'=>$email,
                            'password'=> !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $user['password'],
                            'id_gender'=>$id_gender,
                            'id_country'=>$id_country,
                            'birthday' => $birthday,
                            'address'=>$address,
                            'phone'=>$phone,
                            'avatar'=>!empty($_FILES['avatar']['name']) ? $_FILES['avatar']['name'] : $user['avatar']
                        ];     
                        $_SESSION['userName'] = $data['name']; 
                        $_SESSION['userAvatar'] = $data['avatar'];      
                        $this->userModel->updateData($id, $data);
                        header('Location: ' . __WEB_ROOT__ . '/admin-profile');
                    }
                }
            }
        }
    }
    public function logout(){
        if(isset($_SESSION['userId']) && isset($_SESSION['userName']) && isset($_SESSION['userAvatar'])){
           session_destroy();
           header('Location: ' . __WEB_ROOT__. '/admin/showLogin');
        }
    }
}
?>