<?php
class BlogController extends BaseController{
    private $blogModel, $data = [];

    public function __construct()
    {
        $this->model('admin.blog');
        $this->blogModel = new BlogModel();
    }

    public function index(){
        $blogs = $this->blogModel->getAll();
        $this->data['sub_content']['blogs'] = $blogs;
        $this->data['content'] = 'admin.blog.list';
        return $this->view('admin.layouts.app', $this->data);
    }
    
    public function add(){
        return $this->view('admin.blog.add');
    }
    public function create(){    
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $headingArr = isset($_POST['heading']) ? explode(',', trim($_POST['heading'], " ")) : [] ;
            $contentArr = isset($_POST['content']) ? explode(';', trim($_POST['content'], " ")) : [];
            $image = isset($_FILES['image']) ? $_FILES['image'] : '';
            $validation = [];
            if(empty($title)){
                $validation[] = 'The title is required';
            }
            if(empty($headingArr[0])){
                $validation[] = 'The heading is required';
            }
            if(empty($contentArr[0])){
                $validation[] = 'The content is required';
            }
            if(!empty($image['name'][0])){
                $fileTypes = ['png', 'jpg', 'jpeg'];
                foreach ($image['name'] as $key => $filename) {
                    if ($image['error'][$key] > 0) {
                       $validation[] = 'File upload is errored';
                    }else if($image['size'][$key] > 2*1024 * 1024){
                        $validation[] = "File " . $filename . " is no larger than 2MB";                      
                    }else{
                        $pathInfo = pathinfo($filename);             
                        $extension = strtolower($pathInfo['extension']);             
                        if (!in_array($extension, $fileTypes)) {
                            $validation[] = "File " . $filename . " must have one of the following extensions: png, jpg, jpeg";
                        }else{
                            $uploadDir = __DIR_ROOT__ . '/public/upload/admin/blog/'.$filename;
                            move_uploaded_file($image['tmp_name'][$key], $uploadDir);
                        }
                    }      
                }
            }else{
                $validation[] = "The file upload is required";
            }
            if(!empty($validation)){
                return $this->view('admin.blog.add', ['validation' => $validation]);
            }else{
                $data = [
                    'title' => $title,
                    'heading' => json_encode($headingArr, JSON_UNESCAPED_UNICODE),
                    'content' => json_encode($contentArr , JSON_UNESCAPED_UNICODE),
                    'image' => json_encode($image['name'], JSON_UNESCAPED_UNICODE)
                ];
                $this->blogModel->store($data);
                header('Location: ' .__WEB_ROOT__ . '/blog/list');
            }
        }
    }   

    public function update($id){
        $blog = $this->blogModel->findById($id);
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $title = isset($_POST['title']) ? $_POST['title'] : $blog['title'];
            $heading = isset($_POST['heading']) ? explode(",", $_POST['heading']) : json_decode($blog['heading'], true);
            $content = isset($_POST['content']) ? explode(";", $_POST['content']) : json_decode($blog['content'], true);
            $validation = [];
            $images = json_decode($blog['image'], true);
            if(isset($_POST["deleteImg"])){
                $imgCheckbox = $_POST['deleteImg'];
                foreach($imgCheckbox as $imgRemove){
                    if(in_array($imgRemove, $images)){
                        $key = array_search($imgRemove, $images);
                        unset($images[$key]);
                    }
                }
            }
            if(empty($title)){
                $validation[] = "Title is required";
            }
            if(empty($heading[0])){
                $validation[] = "Blog heading is required";
            }
            if(empty($content[0])){
                $validation[] = "Blog content is required";
            }   
            if(!empty($_FILES["image"]['name'][0])){
                $fileTypes = ['png', 'jpg', 'jpeg'];
                foreach($_FILES["image"]['name'] as $key => $value){
                    if($_FILES["image"]['error'][$key] > 0 ){
                        $validation[] = "File upload is errored";
                    }else if($_FILES["image"]['size'][$key] > 2*1024*1024){
                        $validation[] = "File" . $value . " is no larger than 2MB";
                    }else{
                        $pathInfo = pathinfo($value);
                        $extension = strtolower($pathInfo["extension"]);
                        if(!in_array($extension, $fileTypes)){
                            $validation[] = "File " . $value . " must have one of the following extensions: png, jpg, jpeg";
                        }else{
                            
                            $uploadDir = __DIR_ROOT__ . '/public/upload/admin/blog/'.$value;
                            move_uploaded_file($_FILES["image"]['tmp_name'][$key], $uploadDir);
                        }
                        $images[] = $value;
                    }
                }
            }
            $images = array_values($images);
            if(count($images) > 6){
                $validation[] = "The total number of images to be uploaded must be less than 6 images";
            }
            if(!empty($validation)){
                return $this->view('admin.blog.update', [
                    'validation' => $validation,
                    'blog' => $blog
                ]);
            }else{
                $data = [
                        'title' => $title,
                        'heading' => json_encode($heading, JSON_UNESCAPED_UNICODE),
                        'content' => json_encode($content , JSON_UNESCAPED_UNICODE),
                        'image' => !empty($_FILES['image']['name'][0]) ? json_encode($images, JSON_UNESCAPED_UNICODE) : $blog['image']
                ];
                $this->blogModel->updateData($id, $data);
                header('Location:' .__WEB_ROOT__ . '/blog/list');
            }
        }else{
            return $this->view('admin.blog.update', ['blog' => $blog]);
        }
    }
    
    public function delete($id){
        $this->blogModel->deleteData($id);
    }

}
?>