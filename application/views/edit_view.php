<h2>Edit profile</h2>
<?php echo validation_errors(); ?>
<?php if (!empty($success)){?>
<?php echo $success; ?>
<?php } ?>
<?php echo form_open_multipart('./edit/'.$profile_item['slug']) ?>
	<label for="email">Email</label><br />
    <input name="email" type="text" value="<?php if(!empty($profile_item['email'])) { echo $profile_item['email']; } ?>" readonly="readonly" /><br />
    <label for="password">Password</label><br />
    <input name="password" type="password" value="<?php if(!empty($profile_item['password'])) { echo $profile_item['password']; } ?>" /><br />
<label for="avatar">Avatar</label><br />
    <input type="file" name="avatar" title="avatar" value="<?php echo $profile_item['avatar'];?>" /><br />
    <?php if(!empty($profile_item['avatar'])) { echo '<img src="'.base_url().'/images/profile/avatar/'.$profile_item['avatar'].'">'; echo '<br />'; } ?>
    <label for="cover">Cover</label><br />
    <input type="file" name="cover" title="cover" value="<?php echo $profile_item['cover'];?>" /><br />
    <?php if(!empty($profile_item['cover'])) { echo '<img src="'.base_url().'/images/profile/cover/'.$profile_item['cover'].'">'; echo '<br />'; } ?>
	<label for="about">About</label><br />
    <textarea name="about" cols="50" rows="10"><?php if(!empty($profile_item['about'])) { echo $profile_item['about'];} ?></textarea><br />
<input type="submit" name="submit" value="Update profile" />
<?=form_close()?>