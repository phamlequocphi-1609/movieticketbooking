<?php
class GenderController extends BaseController{
    private $genderModel;
    private $data = [];
    public function __construct()
    {
        $this->middleware('auth');
        $this->model('admin.gender');
        $this->genderModel = new GenderModel();  
    }
    public function index(){
        $gender = $this->genderModel->getAll();
        $this->data['sub_content']['genders'] = $gender;
        $this->data['content'] = 'admin.gender.list';
        return $this->view('admin.layouts.app', $this->data);
    }
    public function add(){
        return $this->view('admin.gender.add');
    }
    public function create(){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
            $validation = [];
            if(empty($gender)){
                $validation[] = 'The gender is required';
            }
            if(!empty($validation)){
                return $this->view('admin.gender.add', ['validation' => $validation]);
            }else{
                $data = [
                    'gender'=>$gender
                ];
                $this->genderModel->store($data);
                header('Location: ' .__WEB_ROOT__.'/gender-list');      
            }
        }
    }
}
?>