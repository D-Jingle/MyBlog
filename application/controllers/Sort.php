<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sort extends CI_Controller {

    public function get_sort_by_userid(){
        $this->load->model('Sort_model');
        $query = $this->Sort_model->get_sort_by_userid();
        $data['code'] = 0;
        $data['data'] = $query;
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function delete_sort_by_sortid(){
        $sortid = $this->input->get('sortid');
        $this->load->model('Sort_model');
        $res = $this->Sort_model->delete_sort_by_sortid($sortid);
//        echo json_encode($res);
        if($res == null){
            $data['code'] = 0;
            $data['mes'] = '删除成功';
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        } else {
            $data['code'] = 1;
            $data['mes'] = '删除失败';
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }

}