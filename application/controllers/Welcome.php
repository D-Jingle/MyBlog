<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
//	    if(isset($_SESSION['username'])){
            $this->load->view('index');
//        } else {
//            redirect('welcome/login');
//        }
	}
	public function login()
    {
        $this->load->view('login');
    }
    public function issue_artical()
    {
        $this->load->view('issue_artical');
    }
    public function regist()
    {
        $this->load->view('regist');
    }
    public function to_index()
    {
        $this->load->view('index');
    }
    public function sort_management()
    {
        $this->load->view('sort_management');
    }
    public function user_info()
    {
        $this->load->view('user_info');
    }
    public function artical_management(){
        $this->load->view('artical_management');
    }
    public function save(){

	    // 1. 接收数据
        $mes = array();
        $mes['username'] = $this->input->post('username');
        $mes['password'] = $this->input->post('password');
        $mes['repassword'] = $this->input->post('repassword');
        $mes['email'] = $this->input->post('email');
        $mes['sex'] = $this->input->post('sex');
        $mes['mood'] = $this->input->post('mood');

        // 2. 验证
        $flag = TRUE;
        $data = array();
        if($mes['username']=='') {
            $data['err_name'] = '请输入用户名';
            $flag = FALSE;
        }
        if($mes['password']!=$mes['repassword']){
            $data['err_pwd'] = '两次密码不一致';
            $flag = FALSE;
        }
        if($mes['sex']==''){
            $data['err_sex'] = '请选择性别';
            $flag = FALSE;
        }

        // 3. 连接数据库
        if($flag){
            $this->load->model('User_model');
            $rows = $this->User_model->save($mes);
            if($rows > 0){
                $newdata = array(
                    'username'  => $mes['username'],
                    'password'  => $mes['password'],
                    'email'     => $mes['email'],
                    'sex'       => $mes['sex'],
                    'mood'      => $mes['mood'],
                    'logged_in' => TRUE,
                );
//                $this->session->set_userdata($newdata);
                $this->load->helper('url');
                $url = base_url();
                echo '<script type="text/javascript">alert("保存成功，请使用此用户名和密码登陆");</script>';
//                $this->load->view('login');
//                redirect('welcome/login');
                $this->login();

            } else {
                echo 'save fail';
            }
        }else{
        // 4. 加载view
            $this->load->view('regist',$data); // 跳转
//            redirect('welcome/regist'); //重定向
        }



    }

    public function check_login(){
	    $username = $this->input->post('username');
	    $password = $this->input->post('password');

	    $this->load->model('User_model');
        $rows = $this->User_model->get_by_name_pwd($username,$password);

        if($rows){
            $this->load->model('User_model');
            $row = $this->User_model->get_userinfo_by_username($username);
            if($row){
                redirect('welcome/index');
            }
        }else{
            $data['err'] = '用户名或密码输入错误';
            $this->load->view('login',$data);
        }
    }

    public function logout(){
	    $data = array();
        $array_items = array(
            'user_id'   ,
            'username'  ,
            'password'  ,
            'email'     ,
            'sex'       ,
            'address'   ,
            'logged_in' ,
            'birthday'  ,
            'mood'      ,
            'tel'       ,
            'qq'        ,
        );
        $this->session->unset_userdata($array_items);
        $this->session->set_userdata('logged_in',FALSE);

        if(!isset($_SESSION['user_id'])){
            $data['code'] = 0;
            $data['status'] = true;
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        } else {
            $data['code'] = 1;
            $data['mes'] = '删除失败！';
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }

    public function get_userinfo(){
        $data['code'] = 0;
        $data['info'] = $_SESSION;
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function update_userinfo(){
	    $data = array();
        $userinfo = array(
//            'user_id' => $_SESSION['user_id'],
            'username'=>$this->input->post('username')  ,
            'password'=>$this->input->post('password')  ,
            'email'=>$this->input->post('email')     ,
            'sex'=>$this->input->post('sex')       ,
            'address'=>$this->input->post('address')   ,
            'birthday'=>$this->input->post('birthday')  ,
            'mood'=>$this->input->post('mood')      ,
            'tel' =>$this->input->post('tel')      ,
            'qq'=>$this->input->post('qq')        ,
        );

        $this->load->model('User_model');
        $rows = $this->User_model->update_userinfo($userinfo);

        if($rows){
            $user_id = $_SESSION['user_id'];
            $this->session->set_userdata($userinfo);
            $this->session->set_userdata('user_id',$user_id);

            $data['code'] = 0;
            $data['mes'] = 'success';
            echo json_encode($data);
        } else {
            $data['code'] = 1;
            $data['mes'] = '修改失败';
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }

    }
}
