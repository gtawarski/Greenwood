<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h1>A Password Reset for Greenwood Group's Exchange was Received</h1>
<p>Dear <?php echo $firstname; ?></p>
<p>
	A password reset was requested on this email account.  You can reset your password by going to: <a href="http://test.greenwood.ourinterchange.com/system">http://greenwood.ourinterchange.com/system</a>, and entering your email address and a new password: <?php echo $password; ?>.
</p>
<p>Make sure you update your password after you log in!</p>
<p><em>The Greenwood Group</em></p>
<?php
/* End of file userInvitation.php */
/* Location: ./application/views/employees/passwordReset.php */