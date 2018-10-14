<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artical_model extends CI_Model {

    public function get_artical_by_userid(){
        $userid = $_SESSION['user_id'] ;
        $query = $this->db->query("select * from t_article where user_id= $userid order by article_id desc");
        return $query->result();
    }
    public function get_Article_by_sortid_userid($sortid){
        $userid = $_SESSION['user_id'] ;
        $query = $this->db->query("select * from t_article where user_id= $userid and type_id= $sortid order by article_id desc");

//        $query = $this->db->get_where('t_article',array(
//            'type_id'=>$sortid,
//            'user_id'=>$userid
//        ));
        return $query->result();
    }
    public function get_Article_by_articalId($articalId){
        $query = $this->db->get_where('t_article',array(
            'article_id'=>$articalId
        ));
        return $query->row();
    }

    public function issue_artial($sortId,$content,$title){
        $data = array(
            'article_id' => null,
            'title' => $title ,
            'content' => $content ,
            'user_id' => $_SESSION['user_id'] ,
            'type_id' => $sortId);
        $query = $this->db->insert('t_article', $data);
        // $query是布尔型变量
        return $query;

    }

    public function delete_artical_by_id($articalId){
        $query = $this->db->delete('t_article', array('article_id' => $articalId));
        // $query是布尔型变量
        return $query;
    }

    public function edit_artical_by_id($data,$articalId){
        $this->db->where('article_id', $articalId);
        $query = $this->db->update('t_article', $data);
        return $query;
    }

}