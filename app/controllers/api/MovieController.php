<?php
class MovieController extends BaseController{

    private $movieModel , $commentMovieModel, $rateMovieModel, $scheduleModel;    
    
    public function __construct()
    {
        $this->model('admin.movie');
        $this->movieModel = new MovieModel();
        $this->model('admin.commentMovie');
        $this->commentMovieModel = new CommentMovieModel();
        $this->model('admin.rateMovie');
        $this->rateMovieModel = new RateMovieModel();
        $this->model('admin.schedule');
        $this->scheduleModel = new ScheduleModel();
    }

    public function index(){
        $selectColums = [
            'movies.id as id',
            'movies.name',
            'movies.description',
            'movies.trailer',
            'movies.genre',
            'movies.release_date',
            'movies.duration',
            'movies.format',
            'movies.poster_image',
            'movies.age_rating',
            'movies.content_rating',
            'movies.create_at as movies_created_at',
            'movies.update_at as movies_updated_at',
            'comments_movie.id as idMovie',
            'comments_movie.movie_id',
            'comments_movie.user_id',
            'comments_movie.user_name',
            'comments_movie.avatar_user',
            'comments_movie.comment',
            'comments_movie.id_comment',
            'comments_movie.created_at as comment_created_at',
            'comments_movie.updated_at as comment_updated_at'
            
        ];
        $tableJoin = ['comments_movie'];
        $condition = ['comments_movie.movie_id' => 'movies.id'];
        $movielist = $this->movieModel->joinData($tableJoin, $condition, $selectColums);

        $movieComment = [];
        foreach($movielist as $value){
            if(!isset($movieComment[$value['id']])){
                $movieComment[$value['id']] = [
                    'id'            => $value['id'],
                    'name'          => $value['name'],
                    'description'   => $value['description'],
                    'trailer'       => $value['trailer'],
                    'genre'         => $value['genre'],
                    'release_date'  => $value['release_date'],
                    'duration'      => $value['duration'],
                    'format'        => $value['format'],
                    'poster_image'  => $value['poster_image'],
                    'age_rating'    => $value['age_rating'],
                    'content_rating'=> $value['content_rating'],
                    'created_at'    => $value['movies_created_at'],
                    'updated_at'    => $value['movies_updated_at'],
                    'comments'      => []
                ];
            }
            if(!empty($value['comment'])){
                $movieComment[$value['id']]['comments'][] = [
                    'id'            => $value['idMovie'],
                    'movie_id'      => $value['movie_id'],
                    'user_id'       => $value['user_id'],
                    'user_name'     => $value['user_name'],
                    'avatar_user'   => $value['avatar_user'],
                    'comment'       => $value['comment'],
                    'id_comment'    => $value['id_comment'],
                    'created_at'    => $value['comment_created_at'],
                    'updated_at'    => $value['comment_updated_at']
                ];
            }
        }
        if($movieComment){
            $response = json_encode([
                'status' => 200,
                'data' => array_values($movieComment)
            ]); 
            echo $response;
        }else{
            $response = json_encode([
                'status' => 404,
                'data' => 'Not found'
            ]); 
            echo $response;
        }
    }

    public function playing(){
        $selectColums = [
            'movies.id as id',
            'movies.name',
            'movies.description',
            'movies.trailer',
            'movies.genre',
            'movies.release_date',
            'movies.duration',
            'movies.format',
            'movies.poster_image',
            'movies.age_rating',
            'movies.content_rating',
            'cinemas.name as cinema_name',
            'movies.create_at as movies_created_at',
            'movies.update_at as movies_updated_at',
            'comments_movie.id as idMovie',
            'comments_movie.movie_id',
            'comments_movie.user_id',
            'comments_movie.user_name',
            'comments_movie.avatar_user',
            'comments_movie.comment',
            'comments_movie.id_comment',
            'comments_movie.created_at as comment_created_at',
            'comments_movie.updated_at as comment_updated_at'
        ];
        $tableJoin = ['schedule', 'room', 'cinemas', 'comments_movie'];
        $condition = [
            'movies.id'                 => 'schedule.movie_id',
            'room.id'                   => 'schedule.room_id',
            'room.cinema_id'            => 'cinemas.id',
            'comments_movie.movie_id'   => 'movies.id'
        ];

        $where = [
            'movies.release_date'       => '<= NOW()',
            'schedule.schedule_date'    => '<= NOW()',
            'schedule.end_time'         => '>= NOW()'
        ];
        $moviePlaying = $this->movieModel->joinData($tableJoin, $condition, $selectColums, $where);
        
        $moviePlayingComment = [];
        foreach($moviePlaying as $value){
            if(!isset($moviePlayingComment[$value['id']])){
                $moviePlayingComment[$value['id']] = [
                    'id'                => $value['id'],
                    'name'              => $value['name'],
                    'description'       => $value['description'],
                    'trailer'           => $value['trailer'],
                    'genre'             => $value['genre'],
                    'release_date'      => $value['release_date'],
                    'duration'          => $value['duration'],
                    'format'            => $value['format'],
                    'poster_image'      => $value['poster_image'],
                    'age_rating'        => $value['age_rating'],
                    'content_rating'    => $value['content_rating'],
                    'cinema_name'       => $value['cinema_name'],
                    'created_at'        => $value['movies_created_at'],
                    'updated_at'        => $value['movies_updated_at'],
                    'comment'           => []
                ];
            }
            if(!empty($value['comment'])){
                $moviePlayingComment[$value['id']]['comment'][] = [
                    'id'                => $value['idMovie'],
                    'movie_id'          => $value['movie_id'],
                    'user_id'           => $value['user_id'],
                    'user_name'         => $value['user_name'],
                    'avatar_user'       => $value['avatar_user'],
                    'comment'           => $value['comment'],
                    'id_comment'        => $value['id_comment'],
                    'created_at'        => $value['comment_created_at'],
                    'updated_at'        => $value['comment_updated_at']
                ];
            }
        }
        if($moviePlayingComment){
            $response = json_encode([
                'status' => 200,
                'data' => array_values($moviePlayingComment)
            ]);
            echo $response;
        }else{
            $response = json_encode([
                'status' => 404,
                'message' => 'Not found'
            ]);
            echo $response;
        }    
    }

    public function upcoming(){
        $selectColums = [
            'movies.id as id',
            'movies.name',
            'movies.description',
            'movies.trailer',
            'movies.genre',
            'movies.release_date',
            'movies.duration',
            'movies.format',
            'movies.poster_image',
            'movies.age_rating',
            'movies.content_rating',
            'cinemas.name as cinema_name',
            'movies.create_at as movies_created_at',
            'movies.update_at as movies_updated_at',
            'comments_movie.id as idMovie',
            'comments_movie.movie_id',
            'comments_movie.user_id',
            'comments_movie.user_name',
            'comments_movie.avatar_user',
            'comments_movie.comment',
            'comments_movie.id_comment',
            'comments_movie.created_at as comment_created_at',
            'comments_movie.updated_at as comment_updated_at'
        ];
        $tableJoin = ['schedule', 'room', 'cinemas', 'comments_movie'];
        $condition = [
            'movies.id'                 => 'schedule.movie_id',
            'room.id'                   => 'schedule.room_id',
            'room.cinema_id'            => 'cinemas.id',
            'comments_movie.movie_id'   => 'movies.id'
        ];

        $where = [
            'movies.release_date' => ' > NOW()',
        ];

        $movieUpcoming = $this->movieModel->joinData($tableJoin, $condition, $selectColums, $where);
        $movieUpcomingComment = [];
        foreach($movieUpcoming as $value){
            if(!isset($movieUpcomingComment[$value['id']])){
                $movieUpcomingComment[$value['id']] = [
                    'id'                => $value['id'],
                    'name'              => $value['name'],
                    'description'       => $value['description'],
                    'trailer'           => $value['trailer'],
                    'genre'             => $value['genre'],
                    'release_date'      => $value['release_date'],
                    'duration'          => $value['duration'],
                    'format'            => $value['format'],
                    'poster_image'      => $value['poster_image'],
                    'age_rating'        => $value['age_rating'],
                    'content_rating'    => $value['content_rating'],
                    'cinema_name'       => $value['cinema_name'],
                    'created_at'        => $value['movies_created_at'],
                    'updated_at'        => $value['movies_updated_at'],
                    'comment'           => []
                ];
            }
            if(!empty($value['comment'])){
                $movieUpcomingComment[$value['id']]['comment'][] = [
                    'id'                => $value['idMovie'],
                    'movie_id'          => $value['movie_id'],
                    'user_id'           => $value['user_id'],
                    'user_name'         => $value['user_name'],
                    'avatar_user'       => $value['avatar_user'],
                    'comment'           => $value['comment'],
                    'id_comment'        => $value['id_comment'],
                    'created_at'        => $value['comment_created_at'],
                    'updated_at'        => $value['comment_updated_at']
                ];
            }
        }
        if($movieUpcomingComment){
            $response = json_encode([
                'status'    => 200,
                'data'      => array_values($movieUpcomingComment)
            ]);
            echo $response;
        }else{
            $response = json_encode([
                'status'    => 400,
                'message'   => 'Not found'
            ]);
            echo $response;
        }
    }
    
    public function detail($id){
        $movie = $this->movieModel->findById($id);
        $find = [
            'movie_id' => $id
        ];
        $comment = $this->commentMovieModel->findbycondition($find);
        if($movie){
            if($comment){
                $response = json_encode([
                    'status'    => 200,
                    'data'      => [
                            'data'      => $movie,
                            'comments'  => $comment
                    ]
                ]);
                echo $response;
            }else{
                $response = json_encode([
                    'status'    => 200,
                    'data'      => [
                                'data'      => $movie,
                                'comments'  => []
                    ]
                ]);
                echo $response;
            }
        }else{
            $response = json_encode([
                'status'    => 404,
                'message'   => 'Not Found'
            ]);
            echo $response;
        }
    }

    public function comment(){
        $this->checkToken();
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $movie_id = isset($_POST['movie_id']) ? $_POST['movie_id'] : '';
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
            $user_avatar = isset($_POST['user_avatar']) ? $_POST['user_avatar'] : '';
            $id_comment = isset($_POST['id_comment']) ? $_POST['id_comment'] : '';
            $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
            $validation = [];
            if(empty($movie_id)){
                $validation[] = 'Movie id is required';
            }
            if(empty($user_id)){
                $validation[] = 'User id is required';
            }
            if(empty($user_name)){
                $validation[] = 'User name is required';
            }
            if(empty($user_avatar)){
                $validation[] = 'User avatar is required';
            }
            if(empty($comment)){
                $validation[] = 'Comment is required';
            }
            if(!isset($id_comment)){
                $validation[] = 'Comment id is required';
            }
            if(!empty($validation)){
                $response = json_encode([
                    'status'    => 'error',
                    'message'   => $validation
                ]);
                echo $response;
            }else{
                $data = [
                    'movie_id'      => $movie_id,
                    'user_id'       => $user_id,
                    'user_name'     => $user_name,
                    'avatar_user'   => $user_avatar,
                    'id_comment'    => $id_comment,
                    'comment'       => $comment
                ];
                $setCommentMovie = $this->commentMovieModel->store($data);
                if($setCommentMovie == true){
                    $response = json_encode([
                        'status'    => 200,
                        'data'      => $data,
                        'message'   => 'You have successfully commented on this movie'
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

        }
    }

    public function rate(){
        $this->checkToken();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $movie_id = isset($_POST['movie_id']) ? $_POST['movie_id'] : '';
            $user_id  = isset($_POST['user_id']) ? $_POST['user_id'] : '';
            $rate     = isset($_POST['rate']) ? $_POST['rate'] : '';
            $validation = [];
            if(empty($movie_id)){
                $validation[] = 'Movie id is required';
            }
            if(empty($user_id)){
                $validation[] = 'User id is required';
            }
            if(empty($rate)){
                $validation[] = 'Movie rate is required';
            }
            if(!empty($validation)){
                $response = json_encode([
                    'status' => 'error',
                    'message' => $validation
                ]);
                echo $response;
            }else{
                $data = [
                    'movie_id' => $movie_id,
                    'user_id'  => $user_id,
                    'rate'     => $rate
                ];
                $rate = $this->rateMovieModel->store($data);
                if($rate == true){
                    $response = json_encode([
                        'status'    => 200,
                        'message'   => 'You have successfully rate on this movie'
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
        }
    }
    
    public function getRate($id){
        $rate = $this->rateMovieModel->findById($id);
        if($rate){
            $response = json_encode([
                'status' => 200,
                'data'   => $rate
            ]);
            echo $response;
        }else{
            $response = json_encode([
                'status' => 404,
                'data'   => 'Not found'
            ]);
            echo $response;
        }
    }

    public function search($name = '', $description = '', $genre = '', $format = '', $age_rating = '', $content_rating = '', $duration = ''){     
        $name = $_GET['name'];
        $description = $_GET['description'];
        $genre = $_GET['genre'];
        $format = $_GET['format'];
        $age_rating = $_GET['age_rating'];
        $content_rating = $_GET['content_rating'];
        $duration = $_GET['duration'];
        $selectColums = ['name', 'description', 'genre', 'format', 'age_rating', 'content_rating', 'duration'];
        $like = [
            'name'              => $name,
            'description'       => $description,
            'genre'             => $genre,
            'format'            => $format,
            'age_rating'        => $age_rating,
            'content_rating'    => $content_rating,
            'duration'          => $duration 
        ];     
        $data = $this->movieModel->findByLike( $selectColums,$like);
        if($data){
            $response = json_encode([
                'status' => 200,
                'data'   => $data
            ]);
            echo $response;
        }else{
            $response = json_encode([
                'status' => 404,
                'message' => 'Not Found'
            ]);
        }     
    }

    public function showdate(){
        $select = ['schedule_date'];
        $order = [
            'column' => 'schedule_date',
            'order'  => 'asc'
        ];
        $showdate = $this->scheduleModel->orderData($select, $order);
        $showdateweek = [];
        foreach($showdate as $value){
            if(!isset($showdateweak[$value['schedule_date']])){
                $showdateweek[$value['schedule_date']] = [
                    'schedule_date' => $value['schedule_date'],
                    'dayoftheweek'     => date('l', strtotime($value['schedule_date'])),
                    'month'            => date('m' , strtotime($value['schedule_date']))
                ];
            }
        }    
        if($showdateweek){
            $response = json_encode([
                'status' => 200,
                'data'   => array_values($showdateweek)
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

    public function showtime($date = ''){
        $date = $_GET['date'];
        $selectColums = [
           'movies.id as id',
           'movies.name',
           'movies.description',
           'movies.trailer',
           'movies.genre',
           'movies.release_date',
           'movies.duration',
           'movies.format',
           'movies.poster_image',
           'movies.age_rating',
           'movies.content_rating',
           'schedule.schedule_date',
           'schedule.start_time',
           'schedule.end_time',
           'room.name as room_name',
           'cinemas.name as cinema_name',
           'cinemas.address as cinema_address',
           'movies.create_at as created_at',
           'movies.update_at as updated_at',
        ];
        $tableJoin = ['movies', 'room', 'cinemas'];
        $condition = [
            'movies.id'                 => 'schedule.movie_id',
            'room.id'                   => 'schedule.room_id',
            'room.cinema_id'            => 'cinemas.id',
        ];
        $where = [
            'schedule.schedule_date' => "=" . "'$date'"
        ];    
        $data  = $this->scheduleModel->joinData($tableJoin, $condition, $selectColums, $where);
        if($data){
            $response = json_encode([
                'status' => 200,
                'data'   => $data
            ]);
            echo $response;
        }else{
            $response = json_encode([
                'status'    => 500,
                'message'   => 'Internal Server Error'  
            ]);
        }        
    }
}
?>