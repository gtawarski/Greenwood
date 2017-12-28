<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h1>You've been Invited to Greenwood Group's Interchange</h1>
<p>Dear <?php echo $firstname; ?></p>
<p>
	You have been invited to join Greenwood Group's Interchange system.  You can activate your account by going to: <a href="http://test.greenwood.ourinterchange.com/system/activate">http://greenwood.ourinterchange.com/system/activate</a>.  Once there, you will enter the email address you received this message at and the code: <?php echo $password; ?>.
</p>
<p>We look forward to you joining us!</p>
<p><em>The Greenwood Group</em></p>
<?php
/* End of file userInvitation.php */
/* Location: ./application/views/employees/userInvitation.php */