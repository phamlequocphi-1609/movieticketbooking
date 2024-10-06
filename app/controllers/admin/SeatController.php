<?php
class SeatController extends BaseController{

    private $seatModel, $roomModel, $seatTypeModel, $data = [];
    
    public function __construct()
    {
        $this->model('admin.room');
        $this->roomModel = new RoomModel();
        $this->model('admin.seat');
        $this->seatModel = new SeatModel();
        $this->model('admin.seatType');
        $this->seatTypeModel = new SeatTypeModel();
    }
    
    public function index(){
        $seats = $this->seatModel->getAll();
        $rooms = $this->roomModel->getAll();
        $seatTypes = $this->seatTypeModel->getAll();
        $this->data['sub_content']['seats'] = $seats;
        $this->data['sub_content']['rooms'] = $rooms;
        $this->data['sub_content']['seatTypes'] = $seatTypes;
        $this->data['content'] = 'admin.seat.list';
        return $this->view('admin.layouts.app', $this->data);
    }

    public function add(){
        $rooms = $this->roomModel->getAll();
        $seatTypes = $this->seatTypeModel->getAll();
        return $this->view('admin.seat.add', [
            'rooms' => $rooms,
            'seatTypes'=> $seatTypes
        ]);
    }

    public function create(){
        $room = $this->roomModel->getAll();
        $seatTypes = $this->seatTypeModel->getAll();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $seat_type_id= isset($_POST['seat_type_id']) ? $_POST['seat_type_id'] : '';
            $room_id = isset($_POST['room_id']) ? $_POST['room_id'] : '';
            $row = isset($_POST['row']) ? $_POST['row'] : '';
            $number = isset($_POST['number']) ? $_POST['number'] : '';
            $validation = [];
            if(empty($seat_type_id)){
                $validation[] = 'The seat type is required';
            }
            if(empty($room_id)){
                $validation[] ='Select room is required';
            }
            if(empty($row)){
                $validation[] = 'The seat row is required';
            }
            if(empty($number)){
                $validation[] = 'The seat number is required';
            }
            if(!empty($validation)){
                return $this->view('admin.seat.add', [
                    'validation' => $validation,
                    'rooms' => $room,
                    'seatTypes' => $seatTypes
                ]);
            }else{
                $data = [
                    'seat_type_id' => $seat_type_id,
                    'room_id' => $room_id,
                    'row' => $row,
                    'number' => $number
                ];
                $this->seatModel->store($data);
                header('Location: ' .__WEB_ROOT__. '/seat/list');
            }
        }
    }

    public function update($id){
        $seat = $this->seatModel->findById($id);
        $rooms = $this->roomModel->getAll();
        $seatTypes = $this->seatTypeModel->getAll();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $seat_type_id = isset($_POST['seat_type_id']) ? $_POST['seat_type_id'] : $seat['seat_type_id'];
            echo $seat_type_id;
            $room_id = isset($_POST['room_id']) ? $_POST['room_id'] : $seat['room_id'];
            $row = isset($_POST['row']) ? $_POST['row'] : $seat['row'];
            $number = isset($_POST['number']) ? $_POST['number'] : $seat['number'];
            $validation = [];
            if(empty($seat_type_id)){
                $validation[] = 'The seat type is required';
            }
            if(empty($room_id)){
                $validation[] ='Select room is required';
            }
            if(empty($row)){
                $validation[] = 'The seat row is required';
            }
            if(empty($number)){
                $validation[] = 'The seat number is required';
            }
            if(!empty($validation)){
                return $this->view('admin.seat.update', 
                [
                    'validation' => $validation,
                    'rooms' => $rooms,
                    'seat' => $seat,
                    'seatTypes' => $seatTypes
                ]  
            );
            }else{
                $data = [
                    'seat_type_id' => $seat_type_id,
                    'room_id' => $room_id,
                    'row' => $row,
                    'number' => $number
                ];
                $this->seatModel->updateData($id, $data);
                header('Location: ' . __WEB_ROOT__ . '/seat/list');
            }
        }else{
            return $this->view('admin.seat.update', [
                'seat' => $seat,
                'rooms' => $rooms,
                'seatTypes' => $seatTypes
            ]);
        }
    }

    public function delete($id){
        $this->seatModel->deleteData($id);
    }

    public function seatTypeAdd(){
        return $this->view('admin.seatType.add');
    }

    public function seatTypeCreate(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $seat_type = isset($_POST['seat_type']) ? $_POST['seat_type'] : '';
            $validation = [];
            echo $seat_type;
            if(empty($seat_type)){
                $validation[] = 'The seat type is required';
            }
            if(!empty($validation)){
                return $this->view('admin.seatType.add', ['validation' => $validation]);
            }else{
                $data = [
                    'seat_type' => $seat_type
                ];
                $this->seatTypeModel->store($data);
                header('Location: ' . __WEB_ROOT__ . '/seatType/list');
            }
        }
    }

    public function seatTypeList(){
        $seatTypes = $this->seatTypeModel->getAll();
        $this->data['sub_content']['seatTypes'] = $seatTypes;
        $this->data['content'] = 'admin.seatType.list';
        return $this->view('admin.layouts.app', $this->data);
    }
    
    public function seatTypeDelete($id){
        $this->seatTypeModel->deleteData($id);
    }
}
?>