<?php
/**
 * General plugin settings as well as Fedora, Solr and Ezid settings.
 *
 * @package HumCORE
 * @subpackage Deposits
 */

/**
 * Add the HumCORE settings page to the admin menu.
 */
function humcore_deposits_admin_menu() {
	add_options_page( 'HumCORE', 'HumCORE', 'manage_options', 'humcore-deposits', 'humcore_deposits_settings_page' );
}
add_action( 'admin_menu', 'humcore_deposits_admin_menu' );

/**
 * Define the HumCORE settings page.
 */
function humcore_deposits_settings_page() {
	?>
	<div class="wrap">
		<h2>Humanities CORE Settings</h2>
		<form action="options.php" method="POST">
			<?php settings_fields( 'humcore-deposits' ); ?>
			<?php do_settings_sections( 'humcore-deposits' ); ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * The HumCORE settings main function.
 */
function humcore_deposits_admin_settings() {

	add_settings_section(
		'humcore-deposits',
		__( 'Deposits Settings',  'humcore_domain' ),
		'humcore_deposits_setting_callback_section',
		'humcore-deposits'
	);

	add_settings_field(
		'humcore-deposits-humcore-settings',
		__( 'HumCORE Settings', 'humcore_domain' ),
		'humcore_deposits_humcore_settings_callback',
		'humcore-deposits',
		'humcore-deposits'
	);

	register_setting(
		'humcore-deposits',
		'humcore-deposits-humcore-settings',
		'humcore_deposits_humcore_settings_validation'
	);

	add_settings_field(
		'humcore-deposits-fedora-settings',
		__( 'Fedora Settings', 'humcore_domain' ),
		'humcore_deposits_fedora_settings_callback',
		'humcore-deposits',
		'humcore-deposits'
	);

	register_setting(
		'humcore-deposits',
		'humcore-deposits-fedora-settings',
		'humcore_deposits_fedora_settings_validation'
	);

	add_settings_field(
		'humcore-deposits-solr-settings',
		__( 'Solr Settings', 'humcore_domain' ),
		'humcore_deposits_solr_settings_callback',
		'humcore-deposits',
		'humcore-deposits'
	);

	register_setting(
		'humcore-deposits',
		'humcore-deposits-solr-settings',
		'humcore_deposits_solr_settings_validation'
	);

	add_settings_field(
		'humcore-deposits-ezid-settings',
		__( 'EZID Settings', 'humcore_domain' ),
		'humcore_deposits_ezid_settings_callback',
		'humcore-deposits',
		'humcore-deposits'
	);

	register_setting(
		'humcore-deposits',
		'humcore-deposits-ezid-settings',
		'humcore_deposits_ezid_settings_validation'
	);
}
add_action( 'admin_init', 'humcore_deposits_admin_settings' );

/**
 * Display the general plugin form elements.
 */
function humcore_deposits_humcore_settings_callback() {

	$humcore_deposits_humcore_settings = (array) get_option( 'humcore-deposits-humcore-settings' );
	?>
	<table>
	<tr><td>
		<label for="humcore-deposits-humcore-settings[servername]"><?php _e( 'Server Name', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-humcore-settings[servername]" name="humcore-deposits-humcore-settings[servername]" type="text" value="<?php echo esc_attr( $humcore_deposits_humcore_settings['servername'] ); ?>" />
		<p class="description"><?php _e( 'If set, must match SERVER_NAME in the $_SERVER global variable.', 'humcore_domain' ); ?></p>
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-humcore-settings[service_status]"><?php _e( 'Service Status', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-humcore-settings[service_status]" name="humcore-deposits-humcore-settings[service_status]" type="text" value="<?php echo esc_attr( $humcore_deposits_humcore_settings['service_status'] ); ?>" />
		<p class="description"><?php _e( "Valid values are 'up' and 'down', defaults to 'up'.", 'humcore_domain' ); ?></p>
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-humcore-settings[namespace]"><?php _e( 'Namespace', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-humcore-settings[namespace]" name="humcore-deposits-humcore-settings[namespace]" type="text" value="<?php echo esc_attr( $humcore_deposits_humcore_settings['namespace'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-humcore-settings[tempdir]"><?php _e( 'Temp Dir', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-humcore-settings[tempdir]" name="humcore-deposits-humcore-settings[tempdir]" type="text" value="<?php echo esc_attr( $humcore_deposits_humcore_settings['tempdir'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-humcore-settings[collectionpid]"><?php _e( 'Collection PID', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-humcore-settings[collectionpid]" name="humcore-deposits-humcore-settings[collectionpid]" type="text" value="<?php echo esc_attr( $humcore_deposits_humcore_settings['collectionpid'] ); ?>" />
	</td></tr>
   </table>
	<?php
}

/**
 * Validate the plugin general settings.
 */
function humcore_deposits_humcore_settings_validation( $input ) {

	$input['tempdir'] = rtrim( $input['tempdir'], '/' );
	$input['service_status'] = strtolower( $input['service_status'] );
	$input['servername_hash'] = md5( $input['servername'] );
	return $input;

}


/**
 * Display the section description.
 */
function humcore_deposits_setting_callback_section() {
	?>
	<p class="description"><?php _e( 'Enter the Fedora, Solr and EZID host connection parameters', 'humcore_domain' );?></p>
	<?php
}

/**
 * Display the Fedora form elements.
 */
function humcore_deposits_fedora_settings_callback() {

	$humcore_deposits_fedora_settings = get_option( 'humcore-deposits-fedora-settings' );
	?>
	<table>
	<tr><td>
		<label for="humcore-deposits-fedora-settings[protocol]"><?php _e( 'Protocol', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-fedora-settings[protocol]" name="humcore-deposits-fedora-settings[protocol]" type="text" value="<?php echo esc_attr( $humcore_deposits_fedora_settings['protocol'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-fedora-settings[host]"><?php _e( 'Host', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-fedora-settings[host]" name="humcore-deposits-fedora-settings[host]" type="text" value="<?php echo esc_attr( $humcore_deposits_fedora_settings['host'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-fedora-settings[port]"><?php _e( 'Port', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-fedora-settings[port]" name="humcore-deposits-fedora-settings[port]" type="text" value="<?php echo esc_attr( $humcore_deposits_fedora_settings['port'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-fedora-settings[path]"><?php _e( 'Path', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-fedora-settings[path]" name="humcore-deposits-fedora-settings[path]" type="text" value="<?php echo esc_attr( $humcore_deposits_fedora_settings['path'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-fedora-settings[login]"><?php _e( 'Login', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-fedora-settings[login]" name="humcore-deposits-fedora-settings[login]" type="text" value="<?php echo esc_attr( $humcore_deposits_fedora_settings['login'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-fedora-settings[password]"><?php _e( 'Password', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-fedora-settings[password]" name="humcore-deposits-fedora-settings[password]" type="text" value="<?php echo esc_attr( $humcore_deposits_fedora_settings['password'] ); ?>" />
	</td></tr>
   </table>
	<?php
}

/**
 * Validate the Fedora settings.
 */
function humcore_deposits_fedora_settings_validation( $input ) {

	$input['path'] = rtrim( $input['path'], '/' );
	return $input;

}

/**
 * Display the Solr form elements.
 */
function humcore_deposits_solr_settings_callback() {
	$humcore_deposits_solr_settings = (array) get_option( 'humcore-deposits-solr-settings' );
	?>
	<table>
	<tr><td>
		<label for="humcore-deposits-solr-settings[protocol]"><?php _e( 'Protocol', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-solr-settings[protocol]" name="humcore-deposits-solr-settings[protocol]" type="text" value="<?php echo esc_attr( $humcore_deposits_solr_settings['protocol'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-solr-settings[host]"><?php _e( 'Host', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-solr-settings[host]" name="humcore-deposits-solr-settings[host]" type="text" value="<?php echo esc_attr( $humcore_deposits_solr_settings['host'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-solr-settings[port]"><?php _e( 'Port', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-solr-settings[port]" name="humcore-deposits-solr-settings[port]" type="text" value="<?php echo esc_attr( $humcore_deposits_solr_settings['port'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-solr-settings[path]"><?php _e( 'Path', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-solr-settings[path]" name="humcore-deposits-solr-settings[path]" type="text" value="<?php echo esc_attr( $humcore_deposits_solr_settings['path'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-solr-settings[core]"><?php _e( 'Core', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-solr-settings[core]" name="humcore-deposits-solr-settings[core]" type="text" value="<?php echo esc_attr( $humcore_deposits_solr_settings['core'] ); ?>" />
		<p class="description"><?php _e( 'Enter the name of the Core in which documents will be stored for this Solr instance.', 'humcore_domain' ); ?></p>
	</td></tr>
   </table>
	<?php
}

/**
 * Validate the Solr settings.
 */
function humcore_deposits_solr_settings_validation( $input ) {

	$input['path'] = rtrim( $input['path'], '/' );
	$input['core'] = rtrim( $input['core'], '/' );
	return $input;

}

/**
 * Display the EZID form elements.
 */
function humcore_deposits_ezid_settings_callback() {

	$humcore_deposits_ezid_settings = get_option( 'humcore-deposits-ezid-settings' );
	?>
	<table>
	<tr><td>
		<label for="humcore-deposits-ezid-settings[protocol]"><?php _e( 'Protocol', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-ezid-settings[protocol]" name="humcore-deposits-ezid-settings[protocol]" type="text" value="<?php echo esc_attr( $humcore_deposits_ezid_settings['protocol'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-ezid-settings[host]"><?php _e( 'Host', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-ezid-settings[host]" name="humcore-deposits-ezid-settings[host]" type="text" value="<?php echo esc_attr( $humcore_deposits_ezid_settings['host'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-ezid-settings[port]"><?php _e( 'Port', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-ezid-settings[port]" name="humcore-deposits-ezid-settings[port]" type="text" value="<?php echo esc_attr( $humcore_deposits_ezid_settings['port'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-ezid-settings[path]"><?php _e( 'Path', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-ezid-settings[path]" name="humcore-deposits-ezid-settings[path]" type="text" value="<?php echo esc_attr( $humcore_deposits_ezid_settings['path'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-ezid-settings[mintpath]"><?php _e( 'Mint Path', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-ezid-settings[mintpath]" name="humcore-deposits-ezid-settings[mintpath]" type="text" value="<?php echo esc_attr( $humcore_deposits_ezid_settings['mintpath'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-ezid-settings[login]"><?php _e( 'Login', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-ezid-settings[login]" name="humcore-deposits-ezid-settings[login]" type="text" value="<?php echo esc_attr( $humcore_deposits_ezid_settings['login'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-ezid-settings[password]"><?php _e( 'Password', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-ezid-settings[password]" name="humcore-deposits-ezid-settings[password]" type="text" value="<?php echo esc_attr( $humcore_deposits_ezid_settings['password'] ); ?>" />
	</td></tr>
	<tr><td>
		<label for="humcore-deposits-ezid-settings[prefix]"><?php _e( 'Prefix', 'humcore_domain' ); ?></label>
	</td><td>
		<input id="humcore-deposits-ezid-settings[prefix]" name="humcore-deposits-ezid-settings[prefix]" type="text" value="<?php echo esc_attr( $humcore_deposits_ezid_settings['prefix'] ); ?>" />
	</td></tr>
   </table>
	<?php
}

/**
 * Validate the EZID settings.
 */
function humcore_deposits_ezid_settings_validation( $input ) {

	$input['path'] = rtrim( $input['path'], '/' );
	$input['mintpath'] = rtrim( $input['mintpath'], '/' );
	return $input;

}

