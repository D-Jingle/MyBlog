<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artical extends CI_Controller {

    public function issue_artial(){
        $sortId = $this->input->post('sortId');
        $content = $this->input->post('content');
        $title = $this->input->post('title');
        $this->load->model('Artical_model');
        $query = $this->Artical_model->issue_artial($sortId,$content,$title);
        if($query){
            $data['code'] = 0;
            $data['data'] = $query;
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode($data,JSON_UNESCAPED_UNICODE);

        }
    }

    public function get_artical_by_userid(){
        $this->load->model('Artical_model');
        $query = $this->Artical_model->get_artical_by_userid();
        $data['code'] = 0;
        $data['data'] = $query;
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function get_Artical_by_sortid_userid(){
        $sortId = $this->input->post('sortId');
        $this->load->model('Artical_model');
        $query = $this->Artical_model->get_Article_by_sortid_userid($sortId);
        $data['code'] = 0;
        $data['data'] = $query;
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function delete_artical_by_id(){
        $articalId = $this->input->get('artical_id');
        $this->load->model('Artical_model');
        $query = $this->Artical_model->delete_artical_by_id($articalId);
//        echo json_encode($query);
        if($query){
            $data['code'] = 0;
            $data['mes'] = '删除成功';
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        } else {
            $data['code'] = 1;
            $data['mes'] = '删除失败';
        }
    }

    public function get_artical_by_id(){
        $articalId = $this->input->get('articalId');
        $this->load->model('Artical_model');
        $row = $this->Artical_model->get_Article_by_articalId($articalId);
        $data['code'] = 0;
        $data['data'] = $row;
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function edit_artical_by_id(){
        $sortId = $this->input->post('sortId');
        $content = $this->input->post('content');
        $title = $this->input->post('title');
        $articalId = $this->input->post('id');

        $data = array(
            'title' => $title,
            'content'  => $content,
            'type_id' => $sortId
        );

        $this->load->model('Artical_model');
        $query = $this->Artical_model->edit_artical_by_id($data,$articalId);
        if($query){
            $data['code'] = 0;
            $data['mes'] = '删除成功';
        } else {
            $data['code'] = 1;
            $data['mes'] = '删除失败';
        }

        echo json_encode($data);

    }

    public function artical_item(){
        $this->load->view('articalitem');
    }

    public function edit_artical(){
        $this->load->view('edit_artical');
    }

}
