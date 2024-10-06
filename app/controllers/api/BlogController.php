<?php
class BlogController extends BaseController{
    
    private $blogModel, $commentModel;

    public function __construct(){
       $this->model('admin.blog');
       $this->blogModel = new BlogModel();
       $this->model('admin.comment');
       $this->commentModel = new CommentModel();
    }

    public function index(){
        $selectColums = [
            'blog.id as id',
            'blog.title',
            'blog.heading',
            'blog.content',
            'blog.image',
            'blog.create_at as blog_created_at',
            'blog.update_at as blog_updated_at',
            'comments.id as idComment',
            'comments.blog_id as blog_id',
            'comments.user_id as user_id',
            'comments.user_name as user_name',
            'comments.user_avatar as user_avatar',
            'comments.comment as comment',
            'comments.id_comment as id_comment',
            'comments.created_at as comment_created_at',
            'comments.updated_at as comment_updated_at',
        ];
        $tableJoin = ['comments'];
        $condition = ['comments.blog_id' => 'blog.id'];
        $bloglist = $this->blogModel->joinData($tableJoin, $condition, $selectColums);

        $blogcomment = [];
        foreach($bloglist as $value){
            if(!isset($blogcomment[$value['id']])){
               $blogcomment[$value['id']] = [
                    'id'      => $value['id'],
                    'title'   => $value['title'],
                    'heading' => $value['heading'],
                    'content' => $value['content'],
                    'image'   => $value['image'],
                    'created_at' => $value['blog_created_at'],
                    'updated_at' => $value['blog_updated_at'],
                    'comments' => []
               ];
            }        
            if(!empty($value['comment'])){
                $blogcomment[$value['id']]['comments'][] = [
                    'id' => $value['blog_id'],
                    'user_id' => $value['user_id'],
                    'user_name' => $value['user_name'],
                    'user_avatar' => $value['user_avatar'],
                    'comment' => $value['comment'],
                    'id_comment' => $value['id_comment'],
                    'created_at' => $value['comment_created_at'],
                    'updated_at' => $value['comment_updated_at']
                ];
            }
        }
        if($blogcomment){
            $response  = json_encode([
                'status' => 200,
                'data' => array_values($blogcomment)
            ]);
            echo $response;
        }else{
            $response = json_encode([
                'status' => 404,
                'message' => 'Not Found'
            ]);
            echo $response;
        }
    }
    
    public function newBlog(){
        $orderby = [
            'column' => 'id',
            'order' => 'desc'
        ];
        $limit = 6;
        $select = ['*'];
        $data = $this->blogModel->orderData($select,$orderby, $limit);
        if($data){
            $response = json_encode([
                'status' => 200,
                'data' => $data
            ]);
            echo $response;
        }else{
            $response = json_encode([
                'status' => 404,
                'meassage' => 'Not found' 
            ]);
            echo $response;
        }    
    }

    public function detail($id){
        $blog = $this->blogModel->findById($id);
        $find = [
            'blog_id' => $id 
        ];
        $comment = $this->commentModel->findbycondition($find);
        if($blog){
            if($comment){
                $response = json_encode([
                    'status' => 200, 
                    'data' => [
                        'data' => $blog,
                        'comments' => $comment
                    ]
                ]);
            }else{
                $response = json_encode([
                    'status' => 200, 
                    'data' => [
                        'data' => $blog,
                        'comments' =>[]
                    ]
                ]);
            }
            echo $response;
        }else{
            $response = json_encode([
                'status' => 404, 
                'meassage' => 'Not found'
            ]);
            echo $response;
        }
    }
    
    public function pagination($id){
        $blog = $this->blogModel->findById($id);
        $select = ['id'];
        $condition = [
            'id' => $id
        ];
        $orderNext = [
            'column' => 'id',
            'order' => 'ASC'
        ];
        $limit = 1;
        $orderPrevious = [
            'column' => 'id',
            'order' => 'DESC'
        ];    
        $next = $this->blogModel->getNextBlogId($select,$condition, $orderNext, $limit);
        $previous = $this->blogModel->previousBlogId($select, $condition, $orderPrevious, $limit);
        
        $response = json_encode([
            'status' => 200,
            'data' => $blog,
            'previous' => $previous,
            'next' => $next
        ]);
        echo $response;
        
    }

    public function comment(){
        $this->checkToken();
        $userid = $this->userId;
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $blog_id = isset($_POST['blog_id']) ? $_POST['blog_id'] : '';
            $user_id =  isset($_POST['user_id']) ? $_POST['user_id'] : '';
            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
            $user_avatar = isset($_POST['user_avatar']) ? $_POST['user_avatar'] : '';
            $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
            $id_comment = isset($_POST['id_comment']) ? $_POST['id_comment'] : '';
            $validation = [];
            if(empty($blog_id)){
                $validation[] = 'Blog id is required';
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
                    'status' => 'error',
                    'message' => $validation
                ]);
                echo $response;
            }else{
                $data = [
                    'blog_id' => $blog_id,
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'user_avatar' => $user_avatar,
                    'comment' => $comment,
                    'id_comment' => $id_comment
                ]; 
                $setComment = $this->commentModel->store($data);
                if($setComment == true){
                    $response = json_encode([
                        'status' => 200,
                        'data' => $data,
                        'message' => 'You have successfully commented on this blog'
                    ]);
                    echo $response;
                }else{
                    $response = json_encode([
                        'status' => 500,
                        'message' => 'Internal Server Error'
                    ]);
                    echo $response;
                }
             
            }
        }      
    }
    
    
}
?>