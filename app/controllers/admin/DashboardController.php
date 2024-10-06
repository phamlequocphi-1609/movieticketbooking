<?php
class DashboardController extends BaseController{
    public $data = [];

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
       $this->data['content']= 'admin.dashboard';
       return $this->view('admin.layouts.app', $this->data);
    }    
    
}

?>