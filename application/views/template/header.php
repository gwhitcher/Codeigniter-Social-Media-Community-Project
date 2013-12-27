<html>
<head>
<title><?php echo $this->config->item('title'); ?><?php if (!empty($title)) { echo ' - '.$title; } ?></title>
<link href="<?php echo base_url(); ?>css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container">
<header>
<h1><a href="<?php echo base_url(); ?>" title="<?php echo $this->config->item('title'); ?>"><?php echo $this->config->item('title'); ?></a></h1>
</header>
<?php if (!empty($user_id)) { ?>
<nav>
<ul>
<li><a href="<?php echo base_url(); ?>" title="<?php echo $this->config->item('title'); ?>">Home</a></li>
<li><a href="<?php echo base_url(); ?>profile/<?php echo $slug; ?>">Profile</a></li>
<li><a href="<?php echo base_url(); ?>edit/<?php echo $slug; ?>">Settings</a></li>
<li><a href="<?php echo base_url(); ?>search">Search</a></li>
<li><a href="<?php echo base_url(); ?>about">About</a></li>
<li><a href="<?php echo base_url(); ?>legal">Legal</a></li>
<li><a href="<?php echo base_url(); ?>contact">Contact</a></li>
</ul>
</nav>
<?php } ?>
<section>