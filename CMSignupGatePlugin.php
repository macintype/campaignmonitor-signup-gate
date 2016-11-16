<?php

class CMSignupGatePlugin {

	public function __construct($name) {
		add_action('wp_footer', array($this, 'wp_footer'));
		
		if (is_admin()) {
			require('CMSignupGateAdmin.php');
			new CMSignupGateAdmin($name);
		}
	}
	
	function wp_footer() {
		if (is_admin()) return;
		
		global $post;
		
		$options = get_option('cm_signup_gate_settings');
		wp_enqueue_style('cm-signup-gate', plugins_url('cm-signup-gate.css', __FILE__));
		wp_enqueue_script('cm-signup-gate', plugins_url('cm-signup-gate.js', __FILE__), array('jquery'), false, true);
		$lines = $options['selectors'];
		$arr = preg_split("/\\r\\n|\\r|\\n/", $lines);
		$selectors = implode(',', $arr);

		$page_field = $options['page_field'];
		if ($page_field) {
			$title = '';
			if (isset($post) && is_object($post)) {
				$title = $post->post_title;
				if ($post->post_type == 'page') {
					$cur_post = $post;
					while($cur_post->post_parent) {
						$cur_post = get_post($cur_post->post_parent);
						if (is_object($cur_post)) {
							$title = "$cur_post->post_title : $title";
						}
					}
				}
			}
?>
<style type="text/css">
label[for="<?php echo $page_field; ?>"] { display:none;	}
</style>
<script type="text/javascript">
jQuery(document).ready(function($) {
	cmSignupGateHidePageField('<?php echo $page_field; ?>', '<?php echo $title; ?>');
});
</script>
<?php
		}
		
		if ($options['custom_css']) {
?>
<style type="text/css">
<?php echo $options['custom_css']; ?>
</style>
<?php
		}
		
?>						  
<script type="text/javascript">
jQuery(document).ready(function($) { 
	$('<?php echo $selectors; ?>').click(function() {
		var url = $(this).attr('href');
		return cmSignupGate(url, <?php echo $options['show_thank_you'] ? 'true' : 'false'; ?>);
	});
});
</script>
<div id="cm-signup-gate" class="cm-signup-gate-modal" data-url="">
	<div>
		<a href="#" class="cm-signup-gate-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
		<h1>Sign up</h1>
		<p>Please sign up with us to access this download and receive further information about the product via email.</p>
		<p class="cm-signup-gate-err"></p>
		<?php echo $options['form_code']; ?>
	</div>
</div>
<div id="cm-signup-gate-thanks" class="cm-signup-gate-modal">
	<div>
		<a href="#" class="cm-signup-gate-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
		<h1>Thank you</h1>
		<p>Thank you for your submission, we will get back to you as soon as possible.</p>
	</div>
</div>
<?php
	}
		
}

?>