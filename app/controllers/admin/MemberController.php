<?php
class MemberController extends BaseController{

    private $userModel, $genderModel, $countryModel, $data = [];

    public function __construct()
    {
        $this->middleware('auth');
        $this->model('user');
        $this->userModel = new UserModel();
        $this->model('admin.gender');
        $this->genderModel = new GenderModel();
        $this->model('admin.country');
        $this->countryModel = new CountryModel();
    }

    public function index(){
        $value = [
            'level' => '0'
        ];
        $member = $this->userModel->findbycondition($value);
        $genders = $this->genderModel->getAll();
        $countries = $this->countryModel->getAll();
        $this->data['sub_content']['members'] = $member;
        $this->data['sub_content']['genders'] = $genders;
        $this->data['sub_content']['countries'] = $countries;
        $this->data['content'] = 'admin.member.list';
        $this->view('admin.layouts.app', $this->data);
    }

    public function delete($id){
        $this->userModel->deleteData($id);
    }

}
?>