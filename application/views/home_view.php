<div id="profileleft">

<a href="./profile/<?php echo $username; ?>" title="<?php echo $username; ?>">

<?php if (!empty($avatar)) { ?>

<img src="<?php echo base_url(); ?>/images/profile/avatar/<?php echo $avatar; ?>" width="150" height="150" />

<?php } ?>

</a>

</div>



<div id="profileright">

<?php echo form_open('') ?>

	<textarea name="text" cols="50" rows="3"></textarea><br />



	<input type="submit" name="submit" value="Post" /> 



<?=form_close()?>

<?php if (!empty($friendsposts)) { ?>

<?php foreach ($friendsposts as $fpost) { ?>

<article>

<?php $query = $this->db->query('SELECT * FROM users WHERE id = '.$fpost['user_id'].'');

foreach ($query->result() as $row) { ?>

<a href="./profile/<?php echo $row->slug; ?>" title="<?php echo $row->username; ?>">

<?php if (!empty($row->avatar)) { ?>

<img id="feedimage" src="<?php echo base_url(); ?>/images/profile/avatar/<?php echo $row->avatar; ?>" width="80" height="80" />

<div id="posttitle"><?php echo $row->username; ?></div>

<?php } ?>

</a>

<?php } ?>

<?php echo $fpost['text']; ?>

</article>

<?php } ?>

<?php } ?>

<?php echo $this->pagination->create_links(); ?>

</div>