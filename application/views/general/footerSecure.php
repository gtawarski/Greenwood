<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
		</div>
		<script src="/scripts/mainApp.js" type="text/javascript"></script>
		<?php if (isset($methodScript) && ($methodScript != NULL)): ?>
			<script type='text/javascript' src='/scripts/<?php echo $methodScript; ?>/controller.js'></script>
		<?php else: ?>
			<script type='text/javascript' src='/scripts/general/controller.js'></script>
		<?php endif; ?>

		<?php if (isset($methodScript) && ($methodScript != NULL)): ?>
			<script type='text/javascript' src='/scripts/<?php echo $methodScript; ?>/service.js'></script>
		<?php else: ?>
			<script type='text/javascript' src='/scripts/general/service.js'></script>
		<?php endif; ?>
		<script type='text/javascript' src='/scripts/profileController.js'></script>
		<script type='text/javascript' src='/scripts/profileService.js'></script>
	</body>
</html>

<?php
/* End of file footer_secure.php */
/* Location: ./application/views/general/footer_secure.php */
