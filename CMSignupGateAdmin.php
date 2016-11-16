<?php

class CMSignupGateAdmin {
	private $options;
	
	public function __construct($name) {
		$plugin = plugin_basename($name);

		add_action('admin_init', array($this, 'admin_init'));
		add_action('admin_menu', array($this, 'admin_menu'));
		
		add_filter("plugin_action_links_$plugin", array($this, 'settings_link'));
	}
	
	public function settings_link($links) {
		$settings_link = '<a href="options-general.php?page=cm_signup_gate_settings">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	public function admin_init() {
		register_setting('cm_signup_gate', 'cm_signup_gate_settings');

        add_settings_section('cm_signup_gate_section', 'Settings', array($this, 'section_header'), 
            'cm_signup_gate_settings');  

        add_settings_field('selectors', 'Link Selectors', array($this, 'selectors_field'),
            'cm_signup_gate_settings', 'cm_signup_gate_section');      

        add_settings_field('form_code',  'CampaignMonitor Form Code',  array($this, 'form_code_field'), 
            'cm_signup_gate_settings', 'cm_signup_gate_section');
		
        add_settings_field('page_field',  'Page/Post Title Field', array($this, 'page_field_field'), 
            'cm_signup_gate_settings', 'cm_signup_gate_section');
		
		add_settings_field('show_thank_you', '', array($this, 'show_thank_you_field'),
			'cm_signup_gate_settings', 'cm_signup_gate_section');
				
		add_settings_field('thank_you_text', 'Text of Thank You box', array($this, 'thank_you_text_field'),
			'cm_signup_gate_settings', 'cm_signup_gate_section');
		
		add_settings_field('custom_css', 'Custom CSS', array($this, 'custom_css_field'),
			'cm_signup_gate_settings', 'cm_signup_gate_section');
	}

	public function admin_menu() {
		add_options_page('CampaignMonitor Signup Gate', 'CampaignMonitor Signup Gate', 
			'manage_options',  'cm_signup_gate_settings',  array($this, 'settings_page'));
	}
	
	public function settings_page() {
		 // Set class property
        $this->options = get_option('cm_signup_gate_settings');
        ?>
        <div class="wrap">
            <h1>CampaignMonitor Signup Gate</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields('cm_signup_gate');
                do_settings_sections( 'cm_signup_gate_settings' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
	}
	
	public function section_header() {

	} 
	
	private function textarea_field($name) {
?>
<textarea name="cm_signup_gate_settings[<?php echo $name; ?>]" rows="5" style="width:100%;"><?php echo isset($this->options[$name]) ? esc_attr($this->options[$name]) : ''; ?></textarea>
<?php
	}
	
	public function selectors_field() {
		$this->textarea_field('selectors');
?>
<br /><em>jQuery selectors for the links you wish to gate with signup forms, one per line
<br />eg. <code>a.button</code> to match all links with CSS class "button"
<br /><code>a[href$=".pdf"]</code> to match all links to PDF files (href ends with ".pdf")</em>
<?php
	}
	
	public function form_code_field() {
		$this->textarea_field('form_code');
?>
<br /><em>Paste your CampaignMonitor form code here. You can get this code from your CampaignMonitor account under <code>Lists &amp; Subscribers</code> -> <code>Signup forms</code> -> <code>Copy/paste a form to your site</code></em>
<?php
	}
	
	public function page_field_field() {
?>
<input type="text" name="cm_signup_gate_settings[page_field]" value="<?php echo isset($this->options['page_field']) ? esc_attr($this->options['page_field']) : ''; ?>" /><br />
<em>Optional - CampaignMonitor field ID to store title of page/post when the user submits the form. This should match the ID of a field in the above form code. The field will automatically be hidden and pre-filled with the page/post title when the signup form is displayed</code></em>
<?php
	}
	
	public function show_thank_you_field() {
?>
<input type="checkbox" id="show_thank_you" name="cm_signup_gate_settings[show_thank_you]" value="show" <?php echo isset($this->options['show_thank_you']) && $this->options['show_thank_you'] == 'show' ? 'checked' : ''; ?> /><label for="show_thank_you"> Show Thank You box for empty links (href="#")</label>
<?php
	}
	
	public function thank_you_text_field() {
		$this->textarea_field('thank_you_text');
?>
<br /><em>Optional - text content to be displayed in the Thank You box, if shown</em>
<?php
	}
	
	public function custom_css_field() {
		$this->textarea_field('custom_css');
?>
<br /><em>Optional - enter any custom CSS for your signup form popup</em>
<?php
	}
	
}

?>