<?php
class RoomController extends BaseController{
    private $cinemaModel, $roomModel, $data = [];
    public function __construct()
    {
        $this->middleware('auth');
        $this->model('admin.cinema');
        $this->cinemaModel = new CinemaModel();
        $this->model('admin.room');
        $this->roomModel = new RoomModel();
    }
    public function index(){
        $rooms = $this->roomModel->getAll();
        $cinema = $this->cinemaModel->getAll();
        $this->data['sub_content']['cinemas'] = $cinema;
        $this->data['sub_content']['rooms'] = $rooms;
        $this->data['content'] = 'admin.room.list';
        return $this->view('admin.layouts.app', $this->data);
    }
    public function add(){
        $cinema = $this->cinemaModel->getAll();
        return $this->view('admin.room.add', ['cinemas' => $cinema]);
    }
    public function create(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $cinema_id = isset($_POST['cinema_id']) ? $_POST['cinema_id'] : '';
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $validation = [];
            if(empty($cinema_id)){
                $validation[] = 'Select cinema is required';
            }
            if(empty($name)){
                $validation[] = 'The name is required';
            }
            if(!empty($validation)){
                return $this->view('admin.room.add', ['validation' => $validation]);
            }else{
                $data = [
                    'cinema_id'=> $cinema_id,
                    'name' => $name
                ];
                $this->roomModel->store($data);    
                header('Location: ' . __WEB_ROOT__ . '/room/list');               
            }
        }
    }
    public function delete($id){
        $this->roomModel->deletData($id);
        header('Location: ' . __WEB_ROOT__ . '/room/list');               
    }
    public function update($id){
        $room = $this->roomModel->findById($id);
        $cinema = $this->cinemaModel->getAll();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
           if($room){
            $cinema_id = isset($_POST['cinema_id']) ? $_POST['cinema_id'] : $room['cinema_id'];
            $name = isset($_POST['name']) ? $_POST['name'] : $room['name'];
            $validation = [];
            if(empty($cinema_id)){
                $validation[] = 'Select cinema is required';
            }
            if(empty($name)){
                $validation[] = 'The name is required';
            }
            if(!empty($validation)){
                return $this->view('admin.room.update', 
                [
                    'validation' => $validation,
                    'room' => $room,
                    'cinemas' => $cinema
                ]  
              );
            }else{
                $data = [
                    'cinema_id'=>$cinema_id,
                    'name' => $name
                ];
                $this->roomModel->updateData($id, $data);
                header('Location: ' . __WEB_ROOT__ . '/room/list');
            }
           }
        }else{
            return $this->view('admin.room.update', [
                'room' => $room,
                'cinemas' => $cinema
            ]);
        }
    
    }

}
?>