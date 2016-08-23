<?php
/**
 * Uninstall procedure for the plugin.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* Set the text domain */
define( 'ITSTUDY_DOMAIN', 'itstudy' );

/* Make sure we're actually uninstalling the plugin. */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	wp_die( sprintf( __( '%s should only be called when uninstalling the plugin.', ITSTUDY_DOMAIN ), '<code>' . __FILE__ . '</code>' ) );

/* === Remove croles by the plugin. === */

remove_role( 'mentor' );
remove_role( 'student' );

?>

