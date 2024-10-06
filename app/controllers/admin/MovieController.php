<?php
class MovieController extends BaseController{
    private $movieModel, $data = []; 
    public function __construct(){
        $this->model('admin.movie');
        $this->movieModel = new MovieModel();
        $this->middleware('auth');
    }  
    public function index(){
        $movies = $this->movieModel->getAll();
        $this->data['sub_content']['movies'] = $movies;
        $this->data['content'] = 'admin.movie.list';
        return $this->view('admin.layouts.app', $this->data);
    }
    public function add(){
        return $this->view('admin.movie.add');
    }
    public function create(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';           
            $trailer = isset($_FILES['trailer']) ? $_FILES['trailer'] : '';
            $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
            $release_date = isset($_POST['release_date']) ? $_POST['release_date'] : '';
            $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
            $format = isset($_POST['format']) ? $_POST['format'] : '';
            $poster_image = isset($_FILES['poster_image']) ? $_FILES['poster_image'] : '';
            $age_rating = isset($_POST['age_rating']) ? $_POST['age_rating'] : '';
            $content_rating = isset($_POST['content_rating']) ? $_POST['content_rating'] : '';
            $validation = [];
            if(empty($name)){
                $validation[] = 'The name is required';
            }
            if(empty($description)){
                $validation[] = 'The description is required';
            }
            if(empty($genre)){
                $validation[] = 'The genre is required';
            }
            if(empty($release_date)){
                $validation[] = 'The release date is required';
            }
            if(empty($duration)){
                $validation[] = 'The duration is required';
            }
            if(empty($format)){
                $validation[] = 'The format is required';
            }
            if(empty($age_rating)){
                $validation[] = 'The age rating is required';
            }
            if(empty($content_rating)){
                $validation[] = 'The content rating is required';
            }
            if(!empty($poster_image['name'])){
                if($poster_image['error'] > 0){
                    $validation[] = 'File upload is errored';
                }else if($poster_image['size'] > 1024*1024){
                    $validation[] = 'The image is required to be no longer than 1MB';
                }else{
                    $fileType = ['png', 'jpg', 'jpeg'];
                    $filename = explode('.', $poster_image['name']);
                    $filecheck = strtolower(end($filename));
                    if(!in_array($filecheck, $fileType)){
                        $validation[] = 'The image must have the extension png, jpg, jpeg';
                    }else{
                        $uploadDir = __DIR_ROOT__ . '/public/upload/admin/movie/poster/'.$poster_image['name'];
                        move_uploaded_file($poster_image['tmp_name'], $uploadDir);
                    }
                }
            }else{
                $validation[] = 'The poster is required';
            }
            if(!empty($trailer['name'])){
                if($trailer['error'] > 0){
                    $validation[] = 'File upload is errored';
                }else{
                    $fileType = ['mp4', 'avi','mov', 'mkv'];
                    $filename = explode('.', $trailer['name']);
                    $filecheck = strtolower(end($filename));
                    if(!in_array($filecheck, $fileType)){
                        $validation[] = 'The trailer must have the extension mp4, avi, mov, mkv';
                    }else{
                        $uploadDir = __DIR_ROOT__ . '/public/upload/admin/movie/trailer/'.$trailer['name'];
                        move_uploaded_file($trailer['tmp_name'], $uploadDir);
                    }
                }
            }else{
                $validation[] = 'The trailer is required';
            }
            if(!empty($validation)){
                return $this->view('admin.movie.add', ['validation' => $validation]);
            }else{
                $data = [
                    'name' => $name,
                    'description' => $description,
                    'trailer' => $trailer['name'],
                    'genre' => $genre,
                    'release_date' => $release_date,
                    'duration' => $duration,
                    'format' => $format,
                    'poster_image' => $poster_image['name'],
                    'age_rating' => $age_rating,
                    'content_rating' => $content_rating
                ];
                $this->movieModel->store($data);
                header('Location: ' .__WEB_ROOT__ . '/movie/list');
            }
        }
    }
    public function delete($id){
        $this->movieModel->deleteData($id);
    }
    public function update($id){
        $movie = $this->movieModel->findById($id);
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $name = isset($_POST['name']) ? $_POST['name'] : $movie['name'];
            $description = isset($_POST['description']) ? $_POST['description'] : $movie['description'];           
            $trailer = isset($_FILES['trailer']) ? $_FILES['trailer'] : '';
            $genre = isset($_POST['genre']) ? $_POST['genre'] : $movie['genre'];
            $release_date = isset($_POST['release_date']) ? $_POST['release_date'] : $movie['release_date'];
            $duration = isset($_POST['duration']) ? $_POST['duration'] : $movie['duration'];
            $format = isset($_POST['format']) ? $_POST['format'] : $movie['formate'];
            $poster_image = isset($_FILES['poster_image']) ? $_FILES['poster_image'] : '';
            $age_rating = isset($_POST['age_rating']) ? $_POST['age_rating'] : $movie['age_rating'];
            $content_rating = isset($_POST['content_rating']) ? $_POST['content_rating'] : $movie['content_rating'];
            $validation = [];
            if(empty($name)){
                $validation[] = 'The name is required';
            }
            if(empty($description)){
                $validation[] = 'The description is required';
            }
            if(empty($genre)){
                $validation[] = 'The genre is required';
            }
            if(empty($release_date)){
                $validation[] = 'The release date is required';
            }
            if(empty($duration)){
                $validation[] = 'The duration is required';
            }
            if(empty($format)){
                $validation[] = 'The format is required';
            }
            if(empty($age_rating)){
                $validation[] = 'The age rating is required';
            }
            if(empty($content_rating)){
                $validation[] = 'The content rating is required';
            }
            if(!empty($trailer['name'])){
                if($trailer['error'] > 0){
                    $validation[] = 'File upload is errored';
                }else{
                    $fileType = ['mp4', 'avi','mov', 'mkv'];
                    $filename = explode('.', $trailer['name']);
                    $filecheck = strtolower(end($filename));
                    if(!in_array($filecheck, $fileType)){
                        $validation[] = 'The trailer must have the extension mp4, avi, mov, mkv';
                    }else{
                        $uploadDir = __DIR_ROOT__ . '/public/upload/admin/movie/trailer/'.$trailer['name'];
                        move_uploaded_file($trailer['tmp_name'], $uploadDir);
                    }
                }
            }
            if(!empty($poster_image['name'])){
                if($poster_image['error'] > 0){
                    $validation[] = 'File upload is errored';
                }else if($poster_image['size'] > 1024*1024){
                    $validation[] = 'The image is required to be no longer than 1MB';
                }else{
                    $fileType = ['png', 'jpg', 'jpeg'];
                    $filename = explode('.', $poster_image['name']);
                    $filecheck = strtolower(end($filename));
                    if(!in_array($filecheck, $fileType)){
                        $validation[] = 'The image must have the extension png, jpg, jpeg';
                    }else{
                        $uploadDir = __DIR_ROOT__ . '/public/upload/admin/movie/poster/'.$poster_image['name'];
                        move_uploaded_file($poster_image['tmp_name'], $uploadDir);
                    }
                }
            }
            if(!empty($validation)){
                return $this->view('admin.movie.update',
                    [
                        'validation' => $validation,
                        'movie' => $movie
                    ]
                );
            }else{
                $data = [
                    'name' => $name,
                    'description' => $description,
                    'trailer' => !empty($_FILES['trailer']['name']) ? $_FILES['trailer']['name'] : $movie['trailer'],
                    'genre' => $genre,
                    'release_date' => $release_date,
                    'duration' => $duration,
                    'format' => $format,
                    'poster_image' => !empty($_FILES['poster_image']['name']) ? $_FILES['poster_image']['name'] : $movie['poster_image'] ,
                    'age_rating' => $age_rating,
                    'content_rating' => $content_rating
                ];
                $this->movieModel->updateData($id, $data);
                header('Location: ' .__WEB_ROOT__ . '/movie/list');
            }
        }else{
            return $this->view('admin.movie.update', ['movie' => $movie]);
        }
    }
    
}
?>