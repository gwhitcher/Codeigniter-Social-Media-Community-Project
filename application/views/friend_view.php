<?php

$profile_item['id'] =  mysql_real_escape_string($_POST['friend_id']);

$existingfriend = $this->db->query('SELECT * FROM friends WHERE user_id = '.$user_id.' AND friend_id = '.$profile_item['id']);

$friendcall = $existingfriend->result();

if (!empty($friendcall)) {

	echo 'This person is already a friend!';

} elseif (!empty($user_id) && !empty($profile_item['id'])) {

	$this->db->query('INSERT INTO friends (user_id, friend_id) VALUES ('.$user_id.', '.$profile_item['id'].')');

	echo 'Friend Added!';

} else {

	echo 'Error';	

}

?>