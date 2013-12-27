<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
   $this->load->helper(array('form', 'url'));
 }

 function index()
 {
	if($this->session->userdata('logged_in'))
   {
	$data['title'] = '';
	$session_data = $this->session->userdata('logged_in');
	$data['username'] = $session_data['username'];
	$data['user_id'] = $session_data['id'];
	$data['avatar'] = $session_data['avatar'];
	$data['email'] = $session_data['email'];
	$data['slug'] = $session_data['slug'];
	$this->load->helper('form');
	$this->load->library('form_validation');
	$this->load->library('pagination');			
	$config['base_url'] = ''.base_url().'home/index/';
	$config['total_rows'] = $this->db->get_where('posts', array('user_id' => $data['user_id']))->num_rows();
	$config['per_page'] = 10;
	$config['num_links'] = 5;
	$config['uri_segment'] = '3';
	$config['full_tag_open'] = '<div id="pagination">';
	$config['full_tag_close'] = '</div>';
	$this->pagination->initialize($config);
	//LOAD FRIENDS
	$this->db->select('*');
    $this->db->where('user_id',$data['user_id']);
    $this->db->order_by("id","desc");
    $friendsquery=$this->db->get('friends');
	$data["friends"] = $friendsquery->result_array();
	foreach ($data["friends"] as $friend) {
	//LOAD FRIENDS POSTS
	$this->db->select('*');
   // $this->db->where('user_id',$friend['friend_id']);
	$this->db->where('(`user_id` = '.$friend['friend_id'].' OR `user_id` = '.$data['user_id'].')', NULL, FALSE);
    $this->db->order_by("id","desc");
    $friendsquery=$this->db->get('posts', $config['per_page'], $this->uri->segment($config['uri_segment']));
	$data["friendsposts"] = $friendsquery->result_array();
	}
	$this->form_validation->set_rules('text', 'text', 'required');
	if (!$this->form_validation->run() === FALSE) {
	$this->user->set_post();
	redirect('', 'refresh');
	}
	$this->load->view('template/header', $data);
	$this->load->view('home_view', $data);
	$this->load->view('template/footer', $data);
   } else {
	$data['title'] = 'Login';
	$this->load->helper(array('form'));
	$this->load->view('template/header', $data);
	$this->load->view('login_view');
	$this->load->view('template/footer', $data);
   }
 }

}

?>
