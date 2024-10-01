<?php // Reset Settings

if (!defined('ABSPATH')) exit;

function g7g_cfg_admin_notice() {
	
	$screen_id = g7g_cfg_get_current_screen_id();
	
	if (!$screen_id) return;
	
	if ($screen_id === 'settings_page_g7g-cfg') {
		
		if (isset($_GET['reset-options'])) {
			
			if ($_GET['reset-options'] === 'true') : ?>
			
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e('Default options restored.', 'custom-fields-gutenberg'); ?></strong></p>
			</div>
			
			<?php else : ?>
			
			<div class="notice notice-info is-dismissible">
				<p><strong><?php esc_html_e('No changes made to options.', 'custom-fields-gutenberg'); ?></strong></p>
			</div>
			
			<?php endif;
			
		}
		
		if (!g7g_cfg_check_date_expired() && !g7g_cfg_dismiss_notice_check()) {
			
			?>
			
			<div class="notice notice-success notice-custom">
				<p>
					<strong><?php esc_html_e('Super Plugin Sale!', 'custom-fields-gutenberg'); ?></strong> 
					<?php esc_html_e('Buy one get one FREE with code', 'custom-fields-gutenberg'); ?> <code>BOGO24</code>, 
					<?php esc_html_e('or take 30% off with code', 'custom-fields-gutenberg'); ?> <code>SUPER24</code> 
					⭐ <a class="notice-link" target="_blank" rel="noopener noreferrer" href="https://plugin-planet.com/super-summer-sale/"><?php esc_html_e('Get&nbsp;plugins&nbsp;&raquo;', 'custom-fields-gutenberg'); ?></a> 
					<?php echo g7g_cfg_dismiss_notice_link(); ?>
				</p>
			</div>
			
			<?php
			
		}
		
	}
	
}

//

function g7g_cfg_dismiss_notice_activate() {
	
	delete_option('g7g-cfg-dismiss-notice');
	
}

function g7g_cfg_dismiss_notice_version() {
	
	$version_current = G7G_CFG_VERSION;
	
	$version_previous = get_option('g7g-cfg-dismiss-notice');
	
	$version_previous = ($version_previous) ? $version_previous : $version_current;
	
	if (version_compare($version_current, $version_previous, '>')) {
		
		delete_option('g7g-cfg-dismiss-notice');
		
	}
	
}

function g7g_cfg_dismiss_notice_check() {
	
	$check = get_option('g7g-cfg-dismiss-notice');
	
	return ($check) ? true : false;
	
}

function g7g_cfg_dismiss_notice_save() {
	
	if (isset($_GET['dismiss-notice-verify']) && wp_verify_nonce($_GET['dismiss-notice-verify'], 'g7g_cfg_dismiss_notice')) {
		
		if (!current_user_can('manage_options')) exit;
		
		$result = update_option('g7g-cfg-dismiss-notice', G7G_CFG_VERSION, false);
		
		$result = $result ? 'true' : 'false';
		
		$location = admin_url('options-general.php?page=g7g-cfg&dismiss-notice='. $result);
		
		wp_redirect($location);
		
		exit;
		
	}
	
}

function g7g_cfg_dismiss_notice_link() {
	
	$nonce = wp_create_nonce('g7g_cfg_dismiss_notice');
	
	$href  = add_query_arg(array('dismiss-notice-verify' => $nonce), admin_url('options-general.php?page=g7g-cfg'));
	
	$label = esc_html__('Dismiss', 'custom-fields-gutenberg');
	
	return '<a class="g7g-cfg-dismiss-notice" href="'. esc_url($href) .'">'. esc_html($label) .'</a>';
	
}

function g7g_cfg_check_date_expired() {
	
	$expires = apply_filters('g7g_cfg_check_date_expired', '2024-09-22');
	
	return (new DateTime() > new DateTime($expires)) ? true : false;
	
}

//

function g7g_cfg_reset_options() {
	
	if (isset($_GET['reset-options-verify']) && wp_verify_nonce($_GET['reset-options-verify'], 'g7g_cfg_reset_options')) {
		
		if (!current_user_can('manage_options')) exit;
		
		$options_delete = delete_option('g7g_cfg_options');
		
		$result = 'false';
		
		if ($options_delete) $result = 'true';
		
		$location = admin_url('options-general.php?page=g7g-cfg&reset-options='. $result);
		
		wp_redirect($location);
		
		exit;
		
	}
	
}