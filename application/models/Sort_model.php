<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sort_model extends CI_Model {

    public function get_sort_by_userid(){
        $userid = $_SESSION['user_id'] ;
        $query = $this->db->query("select * from t_type where user_id= $userid ");
        return $query->result();
    }

    public function delete_sort_by_sortid($sortid){
        $tables = array('t_type', 't_article');
        $this->db->where('type_id', $sortid);
        $res = $this->db->delete($tables);
        echo $res;
    }


}
