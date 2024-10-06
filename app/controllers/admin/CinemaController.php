<?php
class CinemaController extends BaseController{
    private $cinemaModel, $data = [];

    public function __construct()
    {
        $this->middleware('auth');
        $this->model('admin.cinema');
        $this->cinemaModel = new CinemaModel();
    }
    public function index(){
        $cinema = $this->cinemaModel->getAll();
        $this->data['sub_content']['cinemas'] = $cinema;
        $this->data['content'] = 'admin.cinema.list';
        return $this->view('admin.layouts.app', $this->data);
    }
    public function add(){
        return $this->view('admin.cinema.add');
    }
    public function create(){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $validation = [];
            if(empty($name)){
                $validation[] = 'The name is required';
            }
            if(empty($address)){
                $validation[] = 'The address is required';
            }
            if(!empty($validation)){
                return $this->view('admin.cinema.add', 
                    ['validation' => $validation]);
            }else{
                $data = [
                    'name'=>$name,
                    'address'=>$address
                ];
                $this->cinemaModel->store($data);
                header('Location: ' . __WEB_ROOT__ . '/cinema/list');
            }         
        }
    }
    public function delete($id){     
        $this->cinemaModel->deleteData($id);
    }
    public function update($id){   
        $cinema = $this->cinemaModel->findById($id);  
        if($_SERVER['REQUEST_METHOD'] == "POST"){          
            if($cinema){
                $name = isset($_POST['name']) ? $_POST['name'] : $cinema['name'];
                $address = isset($_POST['address']) ? $_POST['address'] : $cinema['address'];
                $validation = [];
                if(empty($name)){
                    $validation[] = 'The name is required';
                }
                if(empty($address)){
                    $validation[] = 'The address is required';
                }
                if(!empty($validation)){
                    return $this->view('admin.cinema.update', 
                        [
                            'validation' => $validation,
                            'cinema' => $cinema
                        ]
                        );
                }else{
                    $data = [
                        'name' => $name,
                        'address' => $address
                    ];
                    $this->cinemaModel->updateData($id, $data);
                    header('Location: ' . __WEB_ROOT__ . '/cinema/list');
                }
            }        
        }else{
            return $this->view('admin.cinema.update', ['cinema' => $cinema]);
        }     
    }
}
?>