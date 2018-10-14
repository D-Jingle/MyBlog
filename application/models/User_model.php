<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function save($mes){
        $data = array(
            'username'=>$mes['username'],
            'password'=>$mes['password'],
            'email'=>$mes['email'],
            'sex'=>$mes['sex'],
//            'birthday'=>$mes['birthday'],
            'mood'=>$mes['mood']
        );
        $this->db->insert('t_user',$data);
        return $this->db->affected_rows();
    }


    public function get_userinfo_by_username($username){
        $query = $this->db->get_where('t_user',array(
            'username'=>$username,
        ));
        foreach ($query->result_array() as $userinfo)
        {
            echo $userinfo['user_id'];
            echo $userinfo['username'];
            echo $userinfo['email'];
        }
        $this->session->set_userdata($userinfo);
        $this->session->set_userdata('logged_in',TRUE);
        echo $userinfo['username'];
        return $query->row();
    }

    public function get_by_name_pwd($username,$password){
        $query = $this->db->get_where('t_user',array(
            'username'=>$username,
            'password'=>$password
        ));
//        $query = $this->db->query("select * from t_article where username= $username ");
//        return json_encode(array('query'=>$query,'row'=>$query->row()));
        return $query->row(); // $query->query(); 多条
        // 查到返回一条记录，查不到返回null
        // 查到返回一个数组
    }

    public function update_userinfo($userinfo){
        $this->db->where('user_id', $_SESSION['user_id']);
        $query = $this->db->update('t_user',$userinfo);
        return $query;
    }

}
