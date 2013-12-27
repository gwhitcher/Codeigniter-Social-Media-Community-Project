<h2>Create a profile</h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('./create') ?>

	<label for="username">Username</label><br />
	<input type="input" name="username" /><br />
    
    <label for="email">Email</label><br />
	<input type="input" name="email" /><br />

	<label for="password">Password</label><br />
	<input type="password" name="password" /><br />

	<input type="submit" name="submit" value="Create profile" /> 

<?=form_close()?>