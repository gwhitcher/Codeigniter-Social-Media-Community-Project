<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start(); //we need to call PHP's session object to access it through CI

class Pages extends CI_Controller {



 function __construct()

 {

   parent::__construct();

   $this->load->model('user','',TRUE);

   $this->load->helper(array('form', 'url'));

 }

 

//PROFILE

 function profile($username)

 {

	$data['profile_item'] = $this->user->get_profile($username);

	if (empty($data['profile_item']))

	{

	redirect('', 'refresh');

	}

   if($this->session->userdata('logged_in'))

   {

    $session_data = $this->session->userdata('logged_in');

    $data['username'] = $session_data['username'];

	$data['user_id'] = $session_data['id'];

	$data['slug'] = $session_data['slug'];

	$data['title'] = $session_data['username'];

	$this->load->helper('form');

	$this->load->library('form_validation');

	$this->load->library('pagination');			

	$config['base_url'] = ''.base_url().'profile/'.$username.'/';

	$config['total_rows'] = $this->db->get_where('posts', array('user_id' => $data['profile_item']['id']))->num_rows();

	$config['per_page'] = 10;

	$config['num_links'] = 5;

	$config['full_tag_open'] = '<div id="pagination">';

	$config['full_tag_close'] = '</div>';

	$this->pagination->initialize($config);

	//LOAD POSTS

	$this->db->select('*');

    $this->db->where('user_id',$data['profile_item']['id']);

    $this->db->order_by("id","desc");

    $postsquery=$this->db->get('posts', $config['per_page'], $this->uri->segment(3));

	$data["posts"] = $postsquery->result_array();

	//LOAD FRIENDS

	$this->db->select('*');

    $this->db->where('user_id',$data['profile_item']['id']);

    $this->db->order_by("id","desc");

    $friendsquery=$this->db->get('friends', 10);

	$data["friends"] = $friendsquery->result_array();

	//LOAD FRIENDS

	$this->db->select('*');

    $this->db->where('user_id',$data['profile_item']['id']);

    $this->db->order_by("id","desc");

    $friendsquery=$this->db->get('friends');

	$data["friends"] = $friendsquery->result_array();

	$this->form_validation->set_rules('text', 'text', 'required');

	if (!$this->form_validation->run() === FALSE) {

	$this->user->set_post();

	redirect('profile/'.$id.'', 'refresh');

	}

	$this->load->view('template/header', $data);

    $this->load->view('profile_view', $data);

	$this->load->view('template/footer', $data);

   }

   else

   {

     //If no session, redirect to login page

     redirect('login', 'refresh');

   }

 }

 

//PROFILE CREATE

	public function create()

	{

	$data['title'] = 'Create a profile';

	$session_data = $this->session->userdata('logged_in');

    $data['username'] = $session_data['username'];

	$data['user_id'] = $session_data['id'];

	$data['slug'] = $session_data['slug'];

	$this->load->helper('form');

	$this->load->library('form_validation');

	$this->form_validation->set_rules('username', 'username', 'required');

	$this->form_validation->set_rules('password', 'password', 'required');

	if (! $this->upload->do_upload() && $this->form_validation->run() === FALSE)

	{

	$this->load->view('template/header', $data);

	$this->load->view('create_view', $data);

	$this->load->view('template/footer');

	}

	else

	{

	$this->user->set_profile();

	$this->upload->do_upload();

	$image_data = array('upload_data' => $this->upload->data());

	$this->load->view('template/header', $data);

	$this->load->view('success_view', $image_data);

	$this->load->view('template/footer');

	}	

	}



//PROFILE UPDATE

	public function edit($username)

	{

	if($this->session->userdata('logged_in'))

	{

	$session_data = $this->session->userdata('logged_in');

    $data['username'] = $session_data['username'];

	$data['user_id'] = $session_data['id'];

	$data['slug'] = $session_data['slug'];

	//LOAD PROFILE

	$data['profile_item'] = $this->user->get_profile($username);

	if(empty($data['profile_item']) OR $data['profile_item']['id'] != $data['user_id'])

	{
	show_404(); // IF EMTPY SHOW 404

	}

	$data['success'] = '';

	$data['title'] = 'Edit profile';

	$this->load->helper('form');

	$this->load->library('form_validation');

	$this->form_validation->set_rules('about','about','required');

	if (!$this->form_validation->run() === FALSE)

	{

	$this->user->update_profile($data['profile_item']['id']);

	redirect('edit/'.$data['profile_item']['slug'].'', 'refresh');

	$data['success'] = 'Profile updated!';

	}

	$this->load->view('template/header', $data);

	$this->load->view('edit_view', $data);

	$this->load->view('template/footer');

   } else

   {

     //If no session, redirect to login page

     redirect('login', 'refresh');

   }

	}



//PROFILE DELETE

	public function delete($id) {

	if($this->session->userdata('logged_in'))

   {

	$data['title'] = 'Item deleted!';

	$session_data = $this->session->userdata('logged_in');

    $data['username'] = $session_data['username'];

	$data['user_id'] = $session_data['id'];

	$data['slug'] = $session_data['slug'];

	$this->user->delete_profile($id);

	$this->load->view('template/header', $data);

	$this->load->view('delete_view', $data);

	$this->load->view('template/footer');

   } else {

	 //If no session, redirect to login page

     redirect('login', 'refresh');

   }

	}

	

//ADD FRIEND

	function friend()

	{

	 $data['title'] = 'Add Friend';

     $session_data = $this->session->userdata('logged_in');

     $data['username'] = $session_data['username'];

	 $data['user_id'] = $session_data['id'];

	 $data['slug'] = $session_data['slug'];

	 $this->load->view('template/header', $data);

     $this->load->view('friend_view', $data);

	 $this->load->view('template/footer', $data);	

	}

//SEARCH 

	function search()

	{

	 $data['title'] = 'Search';

	 $session_data = $this->session->userdata('logged_in');
 
	 $data['username'] = $session_data['username'];

	 $data['user_id'] = $session_data['id'];

	 $data['slug'] = $session_data['slug'];

	 $this->load->view('template/header', $data);

	 $this->load->view('search_view', $data);

	 $this->load->view('template/footer', $data);

   }

 

//ABOUT (not secure)

	function about()

	{

	 $data['title'] = 'About';

     $session_data = $this->session->userdata('logged_in');

     $data['username'] = $session_data['username'];

	 $data['user_id'] = $session_data['id'];

	 $data['slug'] = $session_data['slug'];

	 $this->load->view('template/header', $data);

     $this->load->view('about_view', $data);

	 $this->load->view('template/footer', $data);

   }

   

//LEGAL (not secure)

	function legal()

	{

	 $data['title'] = 'Legal';

     $session_data = $this->session->userdata('logged_in');

     $data['username'] = $session_data['username'];

	 $data['user_id'] = $session_data['id'];

	 $data['slug'] = $session_data['slug'];

	 $this->load->view('template/header', $data);

     $this->load->view('legal_view', $data);

	 $this->load->view('template/footer', $data);

   }

 

//CONTACT (not secure)

	function contact()

	{

	 $data['title'] = 'Contact';

	 $this->load->helper('captcha');

	 $this->load->library('form_validation');

	 $this->form_validation->set_rules('email','email','required');

	 $this->form_validation->set_rules('name','name','required');

	 $this->form_validation->set_rules('subject','subject','required');

	 $this->form_validation->set_rules('message','message','required');

	 $vals = array(

	 //'word'	 => 'test',

     'img_path'	 => './captcha/',

     'img_url'	 => './captcha/'

     );

	 $cap = create_captcha($vals);

	 $data = array(

	 'captcha_time'	=> $cap['time'],

	 'ip_address'	=> $this->input->ip_address(),

	 'word'	 => $cap['word']

	 );

	 $query = $this->db->insert_string('captcha', $data);

	 $this->db->query($query);

	 $data['captcha'] = $cap['image'];

	 if ($this->form_validation->run() === TRUE && !empty($_POST['submit'])) {

	 // First, delete old captchas

	 $expiration = time()-7200; // Two hour limit

	 $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	

	 // Then see if a captcha exists:

	 $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";

	 $binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);

	 $query = $this->db->query($sql, $binds);

	 $row = $query->row();

	 if ($row->count == 0)

	 {

     $data['captchaincorrect'] = "You must submit the word that appears in the image";

	 }

	 else {

	 $this->load->library('email');

	 $config['protocol'] = 'sendmail';

	 $config['mailpath'] = '/usr/sbin/sendmail';

	 $config['charset'] = 'iso-8859-1';

	 $config['wordwrap'] = TRUE;

	 $this->email->initialize($config);

	 $this->email->from($this->input->post('email'), $this->input->post('name'));

	 $this->email->to($this->config->item('adminemail'));  

	 $this->email->subject($this->input->post('subject'));

	 $this->email->message($this->input->post('message'));	

	 $this->email->send();

	 $data['success'] = 'Email successfully submitted.  You will be contacted as soon as possible.  Thank you!';

	 }}

	 $session_data = $this->session->userdata('logged_in');

     $data['username'] = $session_data['username'];

	 $data['user_id'] = $session_data['id'];

	 $data['slug'] = $session_data['slug'];

	 $this->load->view('template/header', $data);

     $this->load->view('contact_view', $data);

	 $this->load->view('template/footer', $data);

   }

  

//FORGOT PASSWORD

 function forgot()

 {

   	$data['success'] = '';

	$data['title'] = 'Forgot Password';

	//RANDOM PASSWORD

	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";

    $password = substr( str_shuffle( $chars ), 0, 8);

	$this->load->helper('captcha');

	$this->load->library('form_validation');

	$this->form_validation->set_rules('email','email','required');

	$vals = array(

	'word'	 => 'test',

    'img_path'	 => './captcha/',

    'img_url'	 => './captcha/'

    );

	$cap = create_captcha($vals);

	$data = array(

	'captcha_time'	=> $cap['time'],

	'ip_address'	=> $this->input->ip_address(),

	'word'	 => $cap['word']

	);

	$query = $this->db->insert_string('captcha', $data);

	$this->db->query($query);

	$data['captcha'] = $cap['image'];

	if ($this->form_validation->run() === TRUE) {

	$expiration = time()-7200; // Two hour limit

	$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	

	// Then see if a captcha exists:

	$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";

	$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);

	$query = $this->db->query($sql, $binds);

	$row = $query->row();

	if ($row->count == 0)

	{

    $data['captchaincorrect'] = "You must submit the word that appears in the image";

	}

	else {

	$email = $this->input->post('email');

	$this->load->library('email');

	$config['protocol'] = 'sendmail';

	$config['mailpath'] = '/usr/sbin/sendmail';

	$config['charset'] = 'iso-8859-1';

	$config['wordwrap'] = TRUE;

	$this->email->initialize($config);

	$this->email->from($email, 'Password Reset');

	$this->email->to($email);  

	$this->email->subject('Password Reset');

	$this->email->message('Your new password is '.$password.'');	

	$this->email->send();

	$this->user->forgot_password($password);

	$data['success'] = 'Password successfully reset.  Please check your email!';

	}}

	$session_data = $this->session->userdata('logged_in');

    $data['username'] = $session_data['username'];

	$data['user_id'] = $session_data['id'];

	$data['slug'] = $session_data['slug'];

	$this->load->view('template/header', $data);

    $this->load->view('forgot_view', $data);

	$this->load->view('template/footer', $data);

 }

 

//LOGOUT

 function logout()

 {

   $this->session->unset_userdata('logged_in');

   session_destroy();

   $this->load->view('template/header');

   redirect('', 'refresh');

   $this->load->view('template/footer');

 }

 



}

?>