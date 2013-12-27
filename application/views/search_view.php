<h2>Search</h2>
<form method="post">
Username: <input name="username" type="text">
<input name="submit" type="submit" value="Search">
</form>
<?php
if (!empty($_POST['submit'])) {
$username = mysql_real_escape_string($_POST['username']);
$selectusername = $this->db->query('SELECT * FROM users WHERE username LIKE \'%' . $username . '%\'');
foreach ($selectusername->result() as $row) { 
	echo '<li><a href="'.base_url().'profile/'.$row->slug.'">'.$row->username.'</a></li>';
}
}
?>