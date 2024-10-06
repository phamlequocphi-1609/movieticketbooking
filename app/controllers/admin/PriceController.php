<?php
class PriceController extends BaseController{
    private $priceModel, $scheduleModel, $seatTypeModel, $roomModel, $data = [];

    public function __construct()
    {
        $this->model('admin.price');
        $this->priceModel = new PriceModel();
        $this->model('admin.schedule');
        $this->scheduleModel = new ScheduleModel();
        $this->model('admin.seatType');
        $this->seatTypeModel = new SeatTypeModel();
        $this->model('admin.room');
        $this->roomModel = new RoomModel();
    }
    public function index(){
        $selectColums = [
            'schedule.id', 
            'schedule_date', 
            'movies.name as movie_name', 
            'room.name as room_name',
            'cinemas.name as cinema_name'
        ];
        $tableJoin = ['movies', 'room', 'cinemas'];
        $condition = [
            'schedule.movie_id' => 'movies.id',
            'schedule.room_id' => 'room.id',
            'room.cinema_id' => 'cinemas.id'
        ];
        $schedules = $this->scheduleModel->joinData($tableJoin, $condition, $selectColums);
        $seatType = $this->seatTypeModel->getAll(); 
        $prices = $this->priceModel->getAll();  
        $this->data['sub_content']['prices'] = $prices; 
        $this->data['sub_content']['schedules'] = $schedules;
        $this->data['sub_content']['seatType'] = $seatType;
        $this->data['content'] = 'admin.price.list';
        return $this->view('admin.layouts.app', $this->data);
    }
    public function add(){  
        $selectColums = [
            'schedule.id', 
            'schedule_date', 
            'movies.name as movie_name', 
            'room.name as room_name',
            'cinemas.name as cinema_name'
        ];
        $tableJoin = ['movies', 'room', 'cinemas'];
        $condition = [
            'schedule.movie_id' => 'movies.id',
            'schedule.room_id' => 'room.id',
            'room.cinema_id' => 'cinemas.id'
        ];
        $schedules = $this->scheduleModel->joinData($tableJoin, $condition, $selectColums);
        $seatType = $this->seatTypeModel->getAll(); 
        return $this->view('admin.price.add',
            [
                'schedules' => $schedules,
                'seatType' => $seatType,            
            ]
        );
    }

    public function create(){
        $selectColums = [
            'schedule.id', 
            'schedule_date', 
            'movies.name as movie_name', 
            'room.name as room_name',
            'cinemas.name as cinema_name'
        ];
        $tableJoin = ['movies', 'room', 'cinemas'];
        $condition = [
            'schedule.movie_id' => 'movies.id',
            'schedule.room_id' => 'room.id',
            'room.cinema_id' => 'cinemas.id'
        ];
        $schedules = $this->scheduleModel->joinData($tableJoin, $condition, $selectColums);
        $seatType = $this->seatTypeModel->getAll(); 
       if($_SERVER['REQUEST_METHOD'] === "POST"){
            $schedule_id = isset($_POST['schedule_id']) ? $_POST['schedule_id'] : '';
            $seat_type_id = isset($_POST['seat_type_id']) ? $_POST['seat_type_id'] : '';
            $price = isset($_POST['price']) ? $_POST['price'] : '';
            $validation = [];
            if(empty($schedule_id)){
                $validation[] =  "Select schedule is required";
            }
            if(empty($seat_type_id)){
                $validation[] =  "Select seat type is required";
            }
            if(empty($price)){
                $validation[] ="The price is required";
            }
            if(!empty($validation)){
                return $this->view('admin.price.add', [
                    'validation' => $validation,
                    'schedules' => $schedules,
                    'seatType' => $seatType,  
                ]);
            }else{
                $data = [
                    'schedule_id' => $schedule_id,
                    'seat_type_id' => $seat_type_id,
                    'price' => $price
                ];
                $this->priceModel->store($data);
            }
       }
    }
    public function update($id){
        $selectColums = [
            'schedule.id', 
            'schedule_date', 
            'movies.name as movie_name', 
            'room.name as room_name',
            'cinemas.name as cinema_name'
        ];
        $tableJoin = ['movies', 'room', 'cinemas'];
        $condition = [
            'schedule.movie_id' => 'movies.id',
            'schedule.room_id' => 'room.id',
            'room.cinema_id' => 'cinemas.id'
        ];
        $schedules = $this->scheduleModel->joinData($tableJoin, $condition, $selectColums);
        $seatType = $this->seatTypeModel->getAll(); 
        $price = $this->priceModel->findById($id);       
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $schedule_id = isset($_POST['schedule_id']) ? $_POST['schedule_id'] : $price['schedule_id'];
            $seat_type_id = isset($_POST['seat_type_id']) ? $_POST['seat_type_id'] : $price['seat_type_id'];
            $priceTicket = isset($_POST['price']) ? $_POST['price'] : $price['price'];
            $validation = [];
            if(empty($schedule_id)){
                $validation[] = "Select schedule is required";
            }
            if(empty($seat_type_id)){
                $validation[] = "Select seat type is required";
            }
            if(empty($priceTicket)){
                $validation[] = "The price ticket is required";
            }
            if(!empty($validation)){
                return $this->view('admin.price.update', [
                    'schedules' => $schedules,
                    'seatType' => $seatType, 
                    'price' => $price,
                    'validation' => $validation
                ]);
            }else{
                $data = [
                    'schedule_id' => $schedule_id,
                    'seat_type_id' => $seat_type_id,
                    'price' => $priceTicket
                ];
                $this->priceModel->updateData($id, $data);
                header('Location: ' .__WEB_ROOT__. '/price/list');
            }
        }else{
            return $this->view('admin.price.update' , [
                'schedules' => $schedules,
                'seatType' => $seatType, 
                'price' => $price
            ]);
        }
    }
    public function delete($id){
        $this->priceModel->deleteData($id);
    }
}
?>