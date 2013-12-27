<?php echo validation_errors(); ?>

<div id="profileleft">

<a href="./<?php echo $profile_item['slug']; ?>" title="<?php echo $profile_item['username']; ?>">

<?php if (!empty($profile_item['avatar'])) { ?>

<img src="<?php echo base_url(); ?>images/profile/avatar/<?php echo $profile_item['avatar']; ?>" width="150" height="150" />

<?php } ?>

</a>

<?php echo form_open('friend');?>

<input name="user_id" type="hidden" value="<?php echo $user_id; ?>" />

<input name="friend_id" type="hidden" value="<?php echo $profile_item['id']; ?>" />

<input name="submit" type="submit" value="Add Friend" />

</form>

About:

<p><?php if(!empty($profile_item['about'])) { echo $profile_item['about']; } ?></p>

<div id="profile-friends">

Friends: <br />

<?php foreach ($friends as $friend) { ?>

<?php

$query = $this->db->query('SELECT * FROM users WHERE id = '.$friend['friend_id'].'');

foreach ($query->result() as $row) { ?>

<a href="<?php echo base_url(); ?>profile/<?php echo $row->slug; ?>" title="<?php echo $row->username; ?>">

<?php if (!empty($row->avatar)) { ?>

<img src="<?php echo base_url(); ?>images/profile/avatar/<?php echo $row->avatar; ?>" width="80" height="80" />

<?php } ?>

</a>

<?php }} ?>

</div>

</div>

<div id="profileright">

<?php if (!empty($profile_item['cover'])) { ?>

<img src="<?php echo base_url(); ?>images/profile/cover/<?php echo $profile_item['cover']; ?>" width="715" height="150" />

<?php } ?>

<?php echo form_open('./profile/'.$profile_item['slug'].'') ?>

	<textarea name="text" cols="50" rows="3"></textarea><br />



	<input type="submit" name="submit" value="Post" /> 



<?=form_close()?> 

<?php foreach ($posts as $post) { ?>

<article>

<?php $query = $this->db->query('SELECT * FROM users WHERE id = '.$post['user_id'].'');

foreach ($query->result() as $row) { ?>

<a href="<?php echo base_url(); ?>profile/<?php echo $row->slug; ?>" title="<?php echo $row->username; ?>">

<?php if (!empty($row->avatar)) { ?>

<img id="feedimage" src="<?php echo base_url(); ?>/images/profile/avatar/<?php echo $row->avatar; ?>" width="80" height="80" />

<div id="posttitle"><?php echo $row->username; ?></div>

<?php } ?>

</a>

<?php } ?>

<?php echo $post['text']; ?>

</article>

<?php } ?>

<?php echo $this->pagination->create_links(); ?>

</div>