<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_posts extends CI_Model {
	private $table_name;
	
	// Model Constructor
    public function __construct() {
        parent::__construct();
		$this->table_name = "posts";
    }
    
    public function create($data) {
        $this->load->database();
	    $this->db->insert($this->table_name, $data);
	    return $this->db->insert_id();
    }
    
    public function get($id){
        $this->load->database();
		$query  = $this->db->get_where($this->table_name,array('id'=>$id),1,0);
		$result = $query->result();
		return $result ? $result[0] : NULL;	
	}
        
    public function getById($id){
        $this->load->database();
		$this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result();
	}
        
    public function get_all($status){
        $this->load->database(); 
		$this->db->where('status', $status);
		$query = $this->db->get($this->table_name);
		return $query->result();	
	}

	public function count_all($status){
        $this->load->database(); 
        $this->db->select('COUNT(*) as count');
		$this->db->where('status', $status);
		$query = $this->db->get($this->table_name);
		return $query->result();	

	}
        
    public function update($id,$data) {
        $this->load->database();
		$this->db->where('id', $id);
		$this->db->update($this->table_name, $data); 
		return $this->db->affected_rows();
	}
        
    public function delete($id) {
        $this->load->database();
		$this->db->delete($this->table_name, array('id' => $id));
		return $this->db->affected_rows();		
	}
        
    public function get_all_desc_limit($offside, $limit){
        $this->load->database();
    	$this->db->limit($limit, $offside);
		$this->db->order_by("created_date", "desc"); 
		$query = $this->db->get($this->table_name);
		return $query ? $query->result() : NULL;	
	}

    public function get_by_params($params){
        $query  = $this->db->get_where($this->table_name,$params);
        return $query->result();
    }

	public function get_by_params_limit($params, $limit, $offset){
        $this->db->order_by('id', 'Desc');
		$query  = $this->db->get_where($this->table_name,$params, $limit, $offset);
		return $query->result();
	}
	
    public function count_by_params(){
        $query  = $this->db->get_where($this->table_name,$params);
        return $query->result();
    }


        
}