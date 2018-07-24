<?php $njba_fb_setting=new njba_fb_setting();?>
;(function($) {
	$(document).ready(function() {
		new NjbaFacebookComments({
			id: '<?php echo $id; ?>',
			sdkUrl: '<?php echo $njba_fb_setting->njba_get_fb_sdk_url(); ?>'
		});
	});
})(jQuery);