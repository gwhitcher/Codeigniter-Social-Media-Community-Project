<?php
class User extends CI_Model {

	public function __construct()
	{
	$this->load->database();
	$this->db->order_by("id", "desc"); 
	}

	public function login($username, $password)
	{
	$this -> db -> select('*');
	$this -> db -> from('users');
	$this -> db -> where('username', $username);
	$this -> db -> where('password', MD5($password));
	$this -> db -> limit(1);

	$query = $this -> db -> get();

	if($query -> num_rows() == 1)
	{
     return $query->result();
	}
	else
	{
     return false;
	}
	}
	
	//
	public function forgot_password($password){
		$data = array(
               'password' => md5($password)
            );
        $this->load->database();
        $this->db->where('email', $this->input->post('email'));
        $this->db->update('users', $data);
    }
	
	//LOAD PROFILE
	public function get_profile($username = FALSE)
	{
	if ($username === FALSE)
	{
	$query = $this->db->get('users');
	return $query->result_array();
	$config['per_page']; $this->uri->segment(3);
	}
	$query = $this->db->get_where('users', array('username' => $username));
	return $query->row_array();
	}

	//CREATE PROFILE
	public function set_profile()
	{
	$this->load->helper('url');
	$session_data = $this->session->userdata('logged_in');
    $data['username'] = $session_data['username'];
	$data['user_id'] = $session_data['id'];
	$data['title'] = $session_data['username'];
	$slug = url_title($data['username'],'dash',TRUE);
	$data = array(
		'username' => $this->input->post('username'),
		'password' => md5($this->input->post('password')),
		'email' => $this->input->post('email'),
		'slug'	=>	$slug
	);
	return $this->db->insert('users', $data);
	}
	
	//EDIT PROFILE
	public function update_profile($id=0)
	{
	$this->load->helper('url');
	$config['upload_path'] = './images/profile/avatar/';
	$config['allowed_types'] = 'gif|jpg|png';
	$config['max_width'] = '150';
	$config['max_height'] = '150';
	$this->upload->initialize($config); 
	$this->upload->do_upload('avatar');
	$this->load->library('upload', $config);
	$image_data = $this->upload->data();
	$avatar = $image_data['file_name'];
	$config2['upload_path'] = './images/profile/cover/';
	$config2['allowed_types'] = 'gif|jpg|png';
	$config2['max_width'] = '715';
	$config2['max_height'] = '150';
	$this->upload->initialize($config2); 
	$this->upload->do_upload('cover');
	$this->load->library('upload', $config2);
	$image_data2 = $this->upload->data();
	$cover = $image_data2['file_name'];
	if (!empty($avatar) AND !empty($cover)) {
	$data = array(
		'email' => $this->input->post('email'),
		'password' => md5($this->input->post('password')),
		'about' => $this->input->post('about'),
		'avatar' => $avatar,
		'cover' => $cover
	);
	} elseif (!empty($avatar)) {
	$data = array(
		'email' => $this->input->post('email'),
		'password' => md5($this->input->post('password')),
		'about' => $this->input->post('about'),
		'avatar' => $avatar
	);
	} elseif (!empty($cover)) {
	$data = array(
		'email' => $this->input->post('email'),
		'password' => md5($this->input->post('password')),
		'about' => $this->input->post('about'),
		'cover' => $cover
	);
	} else {
	$data = array(
		'email' => $this->input->post('email'),
		'password' => md5($this->input->post('password')),
		'about' => $this->input->post('about')
	);	
	}
	$this->db->where('id', $id);
	return $this->db->update('users', $data);
	}
	
	//DELETE PROFILE
	public function delete_profile($id) {
    $this->db->delete('users', array('id' => $id));
	}
	
	
	//LOAD POST
	public function get_post($id = FALSE)
	{
	if ($id === FALSE)
	{
	$query = $this->db->get('posts');
	return $query->result_array();
	$config['per_page']; $this->uri->segment(3);
	}
	$query = $this->db->get_where('posts', array('id' => $id));
	return $query->row_array();
	}

	//CREATE POST
	public function set_post()
	{
	$this->load->helper('url');
	$session_data = $this->session->userdata('logged_in');
	$data = array(
		'user_id' => $session_data['id'],
		'text' => $this->input->post('text')
	);
	return $this->db->insert('posts', $data);
	}
	
	//EDIT POST
	public function update_post($id=0)
	{
	$this->load->helper('url');
	$data = array(
		'user_id' => $this->input->post('user_id'),
		'text' => $this->input->post('text')
	);
	$this->db->where('id', $id);
	return $this->db->update('posts', $data);
	}
	
	//DELETE POST
	public function delete_post($id) {
    $this->db->delete('posts', array('id' => $id));
	}
	
	//LOAD FRIEND
	public function get_friend($id = FALSE)
	{
	if ($id === FALSE)
	{
	$query = $this->db->get('friends');
	return $query->result_array();
	$config['per_page']; $this->uri->segment(3);
	}
	$query = $this->db->get_where('friends', array('id' => $id));
	return $query->row_array();
	}
}
?>