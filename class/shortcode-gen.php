<?php
/**
 * Add shortcode button to the editor 
 * Refined plugin based on http://www.paulund.co.uk/add-button-tinymce-shortcodes add shortcode buttons to tinyMCE
 * 
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

new HideContent_Tinymce();
class HideContent_Tinymce
{
    public function __construct()
    {
        add_action('admin_init', array($this, 'hc_shortcode_button'));

    }

    /**
     * Create a shortcode button for tinymce
     *
     * @return [type] [description]
     */
    public function hc_shortcode_button()
    {
        global $pagenow;

		if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) == 'true' && ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'page-new.php', 'page.php' ) ) ) )  {

            add_filter( 'mce_external_plugins', array($this, 'hc_add_buttons' ));
            add_filter( 'mce_buttons', array($this, 'hc_register_buttons' ));
        }
    }

    /**
     * Add new Javascript to the plugin scrippt array
     *
     * @param  Array $plugin_array - Array of scripts
     *
     * @return Array
     */
    public function hc_add_buttons( $plugin_array )
    {
        $plugin_array['hcshortcodes'] = plugins_url('/assets/js/shortcode-gen.js', __DIR__);

        return $plugin_array;
    }

    /**
     * Add new button to tinymce
     *
     * @param  Array $buttons - Array of buttons
     *
     * @return Array
     */
    public function hc_register_buttons( $buttons )
    {
        array_push( $buttons, '|', 'hcshortcodes' );
        return $buttons;
    }

}
?>