<?php
/** Contains the InkblotAdmin class.
 * 
 * @package Inkblot
 */

/** Handle general administrative tasks.
 * 
 * @package Inkblot
 */
class InkblotAdmin extends Inkblot {
	/** Register hooks and istantiate the administrative classes.
	 * 
	 * @uses Inkblot::$dir
	 * @uses Inkblot::__construct()
	 * @uses InkblotAdmin::after_switch_theme()
	 * @uses InkblotMedia
	 * @uses InkbotPages
	 */
	public function __construct() {
		parent::__construct();
		
		add_action( 'after_switch_theme', array( $this, 'after_switch_theme' ) );
		
		require_once self::$dir . '-/php/media.php'; new InkblotMedia;
		require_once self::$dir . '-/php/pages.php'; new InkblotPages;
	}
	
	/** Activation hook.
	 * 
	 * @hook after_switch_theme
	 */
	public function after_switch_theme() {
		if ( get_theme_mod( 'uninstall', false ) ) {
			remove_theme_mods();
		}
	}
	
	/** Render custom header preview styles.
	 */
	public static function admin_head() { ?>
		<style>
			#headimg {
				font: 130%/1.5 sans-serif;
			}
			
			#headimg div {
				padding: 1rem;
			}
			
			#headimg a {
				color: #333;
				text-decoration: none;
			}
			
			#headimg a:focus,
			#headimg a:hover {
				opacity: .75;
			}
			
			#headimg a:active {
				opacity: .25;
			}
			
			#headimg h1 {
				line-height: 1;
				margin: 0;
			}
			
			#headimg h2 {
				font-size: 100%;
				font-weight: normal;
				line-height: 2;
				margin: 0;
			}
			<?php
				if ( $header_textcolor = get_header_textcolor() ) {
					if ( 'blank' === $header_textcolor ) {
						echo '#headimg div { display: none; }';
					} else {
						printf( '#headimg div, #headimg a { color: #%s; }', $header_textcolor );
					}
				}
			?>
		</style>
		<?php
	}
	
	/** Render custom header preview HTML.
	 */
	public static function admin_preview() { ?>
		<div id="headimg">
			<div>
				<h1><a id="name" href="<?php echo esc_url( home_url() ); ?>" rel="home" onclick="return false;"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 id="desc"><?php bloginfo( 'description' ); ?></h2>
			</div>
			<?php if ( $header = get_custom_header() and $header->url ) : ?>
				<a href="<?php echo esc_url( home_url() ); ?>" rel="home" onclick="return false;"><img src="<?php header_image(); ?>" width="<?php echo $header->width; ?>" height="<?php echo $header->height; ?>" alt=""></a>
			<?php endif; ?>
		</div>
		<?php
	}
}