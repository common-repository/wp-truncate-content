<?php
/**
 * WP Scrolling Carousel Class 
*/
  
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

if(!class_exists('Hide_Content')) {
    
    class Hide_Content{
            private $dir;
        	private $assets_dir;
        	private $assets_url;
        	private $token;
        	public  $version;
        	public  $taxonomy_category;
            public  $settings_class;
            
            /**
        	 * Constructor function.
        	 *
        	 * @access public
        	 * @since 1.0.0
        	 * @return void
        	 */    
            public function __construct() {
                $this->version = '1.0';
        		$this->dir = dirname( __FILE__ );
        		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
        		$this->assets_url = esc_url( trailingslashit( plugins_url( '/wp-truncate-content/assets/', __FILE__ ) ) );
        		$this->token = 'hide_content';

        		add_shortcode( 'truncate_content', array( $this, 'the_shortcode' ) );
                
                if ( !is_admin() ){
                    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_wp_styles' ), 10 );         
                    add_action( 'wp_footer', array( $this, 'enqueue_footer_script' ), 80 );              
                }else{
                    add_action( 'admin_enqueue_scripts', array( $this, 'admin_wp_styles' ), 10 );
                }                
            }         
            
            public function admin_wp_styles(){
               wp_register_style( 'admin-hide-content-css', plugins_url() . '/wp-truncate-content/assets/css/admin.css' , array('dashicons') );
        	   wp_enqueue_style  ( 'admin-hide-content-css' ); 
            }   
            
        	/**
        	 * Enqueue frontend js and css.
        	 *
        	 * @access public
        	 * @since   1.0.0
        	 * @return   void
        	 */
        	public function enqueue_wp_styles () {
                wp_register_script( 'wp-truncate-content-js', plugins_url() . '/wp-truncate-content/assets/js/readmore.min.js' , array('jquery'), false, true );
        		wp_enqueue_script  ( 'wp-truncate-content-js' );
                
        	} // End enqueue_admin_styles()          
            
            /**
             * Shortcode to toggle hide content 
             * @access public
        	 * @since 1.0.0
        	 * @return shortcode   
            */
            public function the_shortcode( $atts, $content = null ){
                
                global $attr_content;
            
                $a = shortcode_atts( array(
            		'speed' => 100,
                    'maxheight' => 200,
                    'morelink'  => 'Read More',
                    'lesslink'  => 'Close',
                    'embedcss'  => '',
            	), $atts );
                
                $attr_content = $a;
                
                $hide_content = "<div id=\"hide_content\" style=\"{$a['embedcss']}\">{$content}</div>"; 
                       
                return $hide_content;
            }
            
            /**
             * Footer script for scrolling 
             * 
             */
             
             public function enqueue_footer_script(){
                
                global $attr_content;
                $a = $attr_content;
                
             ?>
                <script type="text/javascript">
                	jQuery(document).ready(function($){
                       $('#hide_content').readmore({
                        speed: <?php echo $a["speed"] ?>,
                        maxHeight: <?php echo $a["maxheight"] ?>,
                        heightMargin: 16,
                        moreLink: '<a href="#"><?php echo $a["morelink"] ?></a>',
                        lessLink: '<a href="#"><?php echo $a["lesslink"] ?></a>',
                        afterToggle: function(trigger, element, expanded) {
                          if(! expanded) { // The "Close" link was clicked
                            $('html, body').animate( { scrollTop: element.offset().top }, {duration: <?php echo $a["speed"] ?> } );
                          }
                        }
                      }); 
                    });   
                </script>
             <?php   
             }
             
             /**
        	 * Run on activation.
        	 * @access public
        	 * @since 1.0.0
        	 * @return void
        	 */
        	public function activation () {

        	} // End activation()
        
        	/**
        	 * Register the plugin's version.
        	 * @access public
        	 * @since 1.0.0
        	 * @return void
        	 */
        	private function register_plugin_version () {
        		if ( $this->version != '' ) {
        			update_option( 'wp-truncate-content' . '-version', $this->version );
        		}
        	} // End register_plugin_version()
        
        	/**
        	 * Flush the rewrite rules
        	 * @access public
        	 * @since 1.0.0
        	 * @return void
        	 */
        	private function flush_rewrite_rules () {

        	} // End flush_rewrite_rules()
            
            /**
        	 * Register image sizes.
        	 * @since  1.0.0
        	 * @return void
        	 */
        	public function register_image_sizes () {

        	} // End register_image_sizes()
        
        	/**
        	 * Ensure that "post-thumbnails" support is available for those themes that don't register it.
        	 * @since  1.0.0
        	 * @return  void
        	 */
        	public function ensure_post_thumbnails_support () {

        	} // End ensure_post_thumbnails_support()
            
    }//End of Class...
    
}//end of if...
?>