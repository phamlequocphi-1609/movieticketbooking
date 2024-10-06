<?php
class CountryController extends BaseController{
    private $countryModel;
    private $data = [];
    public function __construct()
    {
        $this->middleware('auth');
        $this->model('admin.country');
        $this->countryModel = new CountryModel();
    }
    public function index(){
        $country = $this->countryModel->getAll();
        $this->data['sub_content']['countries'] = $country;
        $this->data['content'] = 'admin.country.list';
        return $this->view('admin.layouts.app', $this->data);
    }
    public function add(){
        return $this->view('admin.country.add');
    }
    public function create(){
       if($_SERVER['REQUEST_METHOD'] === 'POST'){
          $name = isset($_POST['name']) ? $_POST['name'] : '';
          $validation = [];
          if(empty($name)){
            $validation[] = 'The name is required';
          }
          if(!empty($validation)){ 
            return $this->view('admin.country.add', ['validation' => $validation]); 
          }else{
            $data = [
                'name'=>$name,
            ];
            $this->countryModel->store($data);           
            header('Location: ' . __WEB_ROOT__ . '/country-list');
          }
       }
    }
    public function delete($id){
        $this->countryModel->deleteData($id);
    }
}
?>