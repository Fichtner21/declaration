<?php
/**
* @package Declaration
*/

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Delete all data from database
$declaration_page_id = get_option('declaration_page_id');

global $wpdb;

$wpdb->query("DELETE FROM wp_posts WHERE post_title = 'Deklaracja dostępności'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id = $declaration_page_id");
$wpdb->query("DELETE FROM wp_postmeta WHERE meta_value = 'declaration.php'");
$wpdb->query("DELETE FROM wp_postmeta WHERE meta_value = 'deklaracja-dostepnosci'");

delete_option('declaration_page_id');

// Delete files from theme
$filename = ABSPATH . 'wp-content/themes/' . get_option('stylesheet') . '/declaration.php';
// Remove page template craeted by plugin
if(file_exists( $filename )) {
    unlink($filename);
}
