<?php
class ScheduleController extends BaseController{
    private $movieModel, $roomModel, $scheduleModel, $data = [];
    public function __construct()
    {
        $this->model('admin.movie');
        $this->movieModel = new MovieModel();
        $this->model('admin.room');
        $this->roomModel = new RoomModel();
        $this->model('admin.schedule');
        $this->scheduleModel = new ScheduleModel();
    }
    public function index(){
        $movie = $this->movieModel->getAll();
        $room = $this->roomModel->getAll();
        $schedule = $this->scheduleModel->getAll();
        $this->data['sub_content']['movies'] = $movie;
        $this->data['sub_content']['rooms'] = $room;
        $this->data['sub_content']['schedules'] = $schedule;
        $this->data['content'] = 'admin.schedule.list';
        return $this->view('admin.layouts.app', $this->data);
    }
    public function add(){
        $movies = $this->movieModel->getAll();
        $rooms = $this->roomModel->getAll();
        return $this->view('admin.schedule.add', 
            [
                'movies' => $movies,
                'rooms' => $rooms
            ]
        );
    }
    public function create(){
        $movies = $this->movieModel->getAll();
        $rooms = $this->roomModel->getAll();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $movie_id = isset($_POST['movie_id']) ? $_POST['movie_id'] : '';
            $room_id = isset($_POST['room_id']) ? $_POST['room_id'] : '';
            $schedule_date = isset($_POST['schedule_date']) ? $_POST['schedule_date'] : '';
            $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
            $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '';
            $validation = [];
            if(empty($movie_id)){
                $validation[] = 'Select movie is required';
            }
            if(empty($room_id)){
                $validation[] = 'Select room is required';
            }
            if(empty($schedule_date)){
                $validation[] = 'The schedule date is required';
            }
            if(empty($start_time)){
                $validation[] = 'The start time is required';
            }
            if(empty($end_time)){
                $validation[] = 'The end time is required';
            }
            if(!empty($validation)){
                return $this->view('admin.schedule.add', 
                    ['validation' => $validation,
                        'movies' => $movies,
                        'rooms' => $rooms
                    ]
                );
            }else{
                $data = [
                    'movie_id' => $movie_id,
                    'room_id' => $room_id,
                    'schedule_date' => $schedule_date,
                    'start_time' => $start_time,
                    'end_time' => $end_time
                ];
                $this->scheduleModel->store($data);
                header('Location: ' .__WEB_ROOT__. '/schedule/list');
            }          
        }
    }
    public function update($id){
        $schedule = $this->scheduleModel->findById($id);
        $movies = $this->movieModel->getAll();
        $room = $this->roomModel->getAll();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $movie_id = isset($_POST['movie_id']) ? $_POST['movie_id'] : $schedule['movie_id'];
            $room_id = isset($_POST['room_id']) ? $_POST['room_id'] : $schedule['room_id'];
            $schedule_date = isset($_POST['schedule_date']) ? $_POST['schedule_date'] : $schedule['schedule_date'];
            $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : $schedule['start_time'];
            $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : $schedule['end_time'];
            $validation = [];
            if(empty($movie_id)){
                $validation[] = 'Select movie is required';
            }
            if(empty($room_id)){
                $validation[] = 'Select room is required';
            }
            if(empty($schedule_date)){
                $validation[] = 'The schedule date is required';
            }
            if(empty($start_time)){
                $validation[] = 'The start time is required';
            }
            if(empty($end_time)){
                $validation[] = 'The end time is required';
            }
            if(!empty($validation)){
                return $this->view('admin.schedule.update', [
                    'schedule' => $schedule,
                    'movies' => $movies,
                    'rooms' => $room,
                    'validation' => $validation
                ]);
            }else{
                $data = [
                    'movie_id' => $movie_id,
                    'room_id' => $room_id,
                    'schedule_date' => $schedule_date,
                    'start_time' => $start_time,
                    'end_time' => $end_time
                ];
                $this->scheduleModel->updateData($id, $data);
                header('Location: ' .__WEB_ROOT__. '/schedule/list');
            }
        }else{           
            return $this->view('admin.schedule.update', [
                'schedule' => $schedule,
                'movies' => $movies,
                'rooms' => $room
            ]);           
        }
    }
    public function delete($id){
        $this->scheduleModel->deleteData($id);
    }
}
?>