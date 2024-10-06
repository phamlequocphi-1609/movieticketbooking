<?php

use ParagonIE\Sodium\Core\Ed25519;

class SeatController extends BaseController{

    private $seatModel , $seatTypeModel , $priceModel;

    public function __construct()
    {
        $this->model('admin.seat');
        $this->seatModel = new SeatModel();
        $this->model('admin.seatType');
        $this->seatTypeModel = new SeatTypeModel();
        $this->model('admin.price');
        $this->priceModel = new PriceModel();
    }

    public function index($start_time = '', $end_time = '', $schedule_date = '', $room = '', $movie_id ='', $cinema_name = ''){    
        $start_time = $_GET['start_time'];
        $end_time = $_GET['end_time'];
        $schedule_date = $_GET['schedule_date'];
        $room = $_GET['room'];
        $movie_id = $_GET['movie_id'];
        $cinema_name = $_GET['cinema_name'];   
        $selectColums = [
            'seat.id as id',
            'seat_type.seat_type as seat_type',
            'room.name as room_name',
            'seat.row',
            'seat.number',
            'ticketprice.price as price',
            'seat.status',      
            'seat.create_at as created_at',
            'seat.update_at as updated_at'
        ];
        $tableJoin = ['seat_type', 'room', 'schedule', 'movies','cinemas', 'ticketprice'];
        $condition = [
            'seat.seat_type_id' => 'seat_type.id',
            'seat.room_id'      => 'room.id',
            'room.id'           => 'schedule.room_id',
            'movies.id'         => 'schedule.movie_id',
            'room.cinema_id'    => 'cinemas.id',
            'ticketprice.seat_type_id' => 'seat_type.id AND ticketprice.schedule_id = schedule.id'
        ];
        $where = [
            "schedule.schedule_date" => " = '$schedule_date'",
            "schedule.start_time"   => " = '$start_time'",
            "schedule.end_time"     => " = '$end_time'",
            "movies.id"             => " = '$movie_id'",
            "room.name"             => " = '$room'",
            "cinemas.name"          => " = '$cinema_name'"
        ];
        $order = [
            'column' => 'id',
            'orderby' => 'ASC'
        ];
        $seats = $this->seatModel->joinData($tableJoin, $condition, $selectColums, $where, $order);
        if($seats){
            $response = json_encode([
                'status' => 200,
                'data'   => $seats
            ]);
            echo $response;
        }else{
            $response = json_encode([
                'status'    => 500,
                'message'   => 'Internal Server Error' 
            ]);
            echo $response;
        } 
    }
  
    public function seatType(){
        $seatType = $this->seatTypeModel->getAll();
        if($seatType){
            $response = json_encode([
                'status' => 200,
                'data'   => $seatType
            ]);
            echo $response;
        }else{
            $response = json_encode([
                'status' => 500,
                'meassage' => 'Internal Server Error'
            ]);
        }
    }
    
    public function pricelist(){
        $selectColums = [
            'ticketprice.id as id',
            'movies.name as movie_name',
            'room.name as room_name',
            'schedule.schedule_date as schedule_date',
            'schedule.start_time as start_time',
            'schedule.end_time as end_time',
            'seat_type.seat_type as seat_type',
            'ticketprice.price as price',
            'ticketprice.create_at as created_at',
            'ticketprice.update_at as updated_at'
        ];
        $tableJoin = ['schedule', 'room', 'movies', 'seat_type'];
        $condition = [
            'schedule.id' => 'ticketprice.schedule_id',
            'schedule.room_id' => 'room.id',
            'schedule.movie_id' => 'movies.id',
            'seat_type.id' => 'ticketprice.seat_type_id'
        ];
        $data = $this->priceModel->joinData($tableJoin, $condition, $selectColums);      
        $response = json_encode([
            'status' => 200,
            'data'  => $data
        ]);
        echo $response;       
    }

    public function setBookSeat(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $seat_idBooked =  isset($_POST['seat_id']) ? explode(',',$_POST['seat_id']) : [];
            $schedule_id = isset($_POST['schedule_id']) ? $_POST['schedule_id'] : '';
            $validation = [];
            if(empty($seat_idBooked[0])){
                $validation[] = "Select seat to view movie is required";
            }
            if(empty($schedule_id)){
                $validation[] = 'Schedule id is required';
            }
            if(!empty($validation)){
                $response = json_encode([
                   'status'     => 'error',
                   'message'    => $validation
                ]);
                echo $response;
            }else{
                $wherein = "('". implode("','", $seat_idBooked)."')";
                $selectColums = [
                    'seat.id',
                    'seat.row',
                    'seat.number',
                    'ticketprice.price as price',
                    'seat.create_at as created_at',
                    'seat.update_at as updated_at'
                ];
                $tableJoin = ['ticketprice'];
                $condition = [
                    'seat.seat_type_id' => 'ticketprice.seat_type_id'
                ];
                $where = [
                    'seat.id' => "IN  ".$wherein,
                    'ticketprice.schedule_id' => "= '$schedule_id'"
                ];
                $orderby = [
                    'column' => 'seat.id',
                    'orderBy' => 'ASC'
                ];
                $seatBooks = $this->seatModel->joinData($tableJoin,$condition,$selectColums,$where, $orderby);
                $totalPrice = 0;
                foreach($seatBooks as $value){
                    $totalPrice += $value['price'];
                }
                if($seatBooks){
                    $response = json_encode([
                        'status' => 200,
                        'data' => $seatBooks,
                        'totalPrice' => $totalPrice
                    ]);
                    echo $response;
                }else{
                    $response = json_encode([
                        'status' => 500,
                        'message' => 'Internal Server Erro'
                    ]);
                    echo $response;
                }
            }       
        }
    }
    
    
}
?>