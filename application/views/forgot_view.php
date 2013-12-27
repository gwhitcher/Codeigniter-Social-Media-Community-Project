<?php echo validation_errors(); ?>
<?php if (!empty($success)){?>
<?php echo $success; ?>
<?php } ?>
<?php if (!empty($captchaincorrect)){?>
<?php echo $captchaincorrect; ?>
<?php } ?>
<?php echo form_open_multipart('./forgot'); ?>
<label for="email">Email</label><br />
<input type="input" name="email" /><br />
<label for="captcha">Captcha</label><br />
<?php echo $captcha; ?><br />
<input type="text" name="captcha" value="" /><br />
<input name="reset" type="submit" value="Reset">
<?php echo form_close(); ?>