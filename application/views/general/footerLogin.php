<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
				</div>
			</div>
		</div>
		<div class="footer hidden-xs">
			<div class="container text-center">
				<small>INTERCHANGE, Copyright &copy; 2014 - <?php echo date('Y'); ?> <a href="http://www.rareearth.us" target="_blank">Rare Earth Interactive, Inc</a>.</small>
			</div>
		</div>

		<script src="/scripts/mainApp.js" type="text/javascript"></script>
		<?php if (isset($methodScript) && ($methodScript != NULL)): ?><script type='text/javascript' src='/scripts/<?php echo $methodScript; ?>/controller.js'></script><?php endif; ?>
		<?php if (isset($methodScript) && ($methodScript != NULL)): ?><script type='text/javascript' src='/scripts/<?php echo $methodScript; ?>/service.js'></script><?php endif; ?>
	</body>
</html>


<?php
/* End of file footer_login.php */
/* Location: ./application/views/general/footer_login.php */
