<?php
/**
 * Plugin Name: WP Truncate Content
 * Plugin URI: http://crea8xion.com/features/truncate-content/
 * Version: 1.0
 * Author: crea8xion
 * Author URI: http://crea8xion.com/
 * Description: A plugin that truncate and hide longer content but retains its html for search engine optimization. Good for longer content post and pages that wanted only to show partially visible content but does hide all the content for SEO. Extending <a href="http://jedfoster.com/Readmore.js/" target="_blank">Jed Foster</a> jQuery toggle content for wordpress content. See docs on how to use this plugin @ <a href="http://crea8xion.com/features/wp-hide-content/">crea8xion</a>.
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

global $truncate_content;

require_once( 'class/wp-truncate-class.php' );
require_once( 'class/shortcode-gen.php' );

$attr_content = array();
$truncate_content = new Hide_Content( __FILE__ );
?>