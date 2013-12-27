<h1>Login</h1>
   <?php echo validation_errors(); ?>
   <?php echo form_open('verifylogin'); ?>
     <label for="username">Username:</label>
     <input type="text" size="20" id="username" name="username"/>
     <br/>
     <label for="password">Password:</label>
     <input type="password" size="20" id="passowrd" name="password"/>
     <br/>
     <input type="submit" value="Login"/>
   <?=form_close()?> 
   <a href="<?php echo base_url(); ?>create">Don't have an account?  Register!</a>
   <br />
   <a href="<?php echo base_url(); ?>forgot">Forgot your password?</a>

   

