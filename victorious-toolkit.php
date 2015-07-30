<?php

/*
  Plugin Name: Victorious Toolkit
  Description: A specific plugin use in Victorious Theme to help you register post types and widgets.
  Version: 1.0.0
  Author: Kopatheme
  Author URI: http://kopatheme.com
  License: GNU General Public License v3 or later
  License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

define( 'VICTOR_PREFIX', 'victor_' );
define( 'VICTOR_DIR', plugin_dir_url( __FILE__ ) );
define( 'VICTOR_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'plugins_loaded', array( 'Victorious_Toolkit', 'victor_plugins_loaded' ) );
add_action( 'after_setup_theme', array( 'Victorious_Toolkit', 'victor_after_setup_themes' ), 20 );

class Victorious_Toolkit {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'victor_admin_enqueue_scripts' ) );
		#FILTER HOOK
		add_filter( 'kopa_admin_meta_box_wrap_start', array( $this, 'victor_meta_box_wrap_start' ), 10, 3 );
		add_filter( 'kopa_admin_meta_box_wrap_end', array( $this, 'victor_meta_box_wrap_end' ), 10, 3 );

		#PAGE BUILDER
		require_once(VICTOR_PATH . 'includes/page-builder.php');

		#METABOX
		require_once(VICTOR_PATH . 'includes/fields/metabox/gallery.php');
		require_once(VICTOR_PATH . 'includes/fields/metabox/icon.php');
		require_once(VICTOR_PATH . 'includes/fields/metabox/datetime.php');
		require_once(VICTOR_PATH . 'includes/fields/widget/icon.php');
		require_once(VICTOR_PATH . 'includes/fields/widget/link-icon.php');

		#AJAX
		require_once(VICTOR_PATH . 'includes/ajax.php');

		#SHORTCODE
		require_once(VICTOR_PATH . 'includes/shortcode.php');
		require_once(VICTOR_PATH . 'includes/shortcodes/missions.php');
		require_once(VICTOR_PATH . 'includes/shortcodes/blockquote.php');
		require_once(VICTOR_PATH . 'includes/shortcodes/dropcap.php');
		require_once(VICTOR_PATH . 'includes/shortcodes/rows.php');
		require_once(VICTOR_PATH . 'includes/shortcodes/tabs.php');
		require_once(VICTOR_PATH . 'includes/shortcodes/accordions.php');
		require_once(VICTOR_PATH . 'includes/shortcodes/toggles.php');
		require_once(VICTOR_PATH . 'includes/shortcodes/buttons.php');
		require_once(VICTOR_PATH . 'includes/shortcodes/pricing-table.php');
		
		#POST TYPES
		require_once(VICTOR_PATH . 'includes/post-types/services.php');
		require_once(VICTOR_PATH . 'includes/post-types/testimonials.php');
		require_once(VICTOR_PATH . 'includes/post-types/staff.php');
		require_once(VICTOR_PATH . 'includes/post-types/portfolio.php');

		#WIDGETS
		require_once(VICTOR_PATH . 'includes/widgets/victor-languages.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-about.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-text.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-intro.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-tab-container.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-entry-list.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-social.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-feedburner.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-mailchimp.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-basic-contact-info.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-portfolio.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-service.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-service-stat.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-staff.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-testimonial.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-contact-form.php');
		require_once(VICTOR_PATH . 'includes/widgets/victor-contact-info.php');
	}

	public static function victor_plugins_loaded() {
		load_plugin_textdomain( 'victor-toolkit-111', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	public static function victor_after_setup_themes() {
		if ( !class_exists( 'Kopa_Framework' ) ) {
			return;
		} else {
			new Victorious_Toolkit();
		}
	}

	function victor_meta_box_wrap_start( $wrap, $value, $loop_index ) {
		if ( 0 == $loop_index ) {
			$wrap = '<div class="victor-metabox-wrap victor-metabox-wrap-first victor-row">';
		} else {
			$wrap = '<div class="victor-metabox-wrap victor-row">';
		}

		if ( $value['title'] ) {
			$wrap .= '<div class="victor-col-3">';
			$wrap .= esc_html( $value['title'] );
			$wrap .= '</div>';
			$wrap .= '<div class="victor-col-9">';
		} else {
			$wrap .= '<div class="victor-col-12">';
		}

		return $wrap;
	}

	function victor_meta_box_wrap_end( $wrap, $value, $loop_index ) {
		$wrap = '';

		if ( $value['desc'] ) {
			$wrap .= '<p class="victor-help">' . $value['desc'] . '</p>';
		}

		$wrap .= '</div>';
		$wrap .= '</div>';

		return $wrap;
	}

	function victor_admin_enqueue_scripts() {
		global $pagenow;

		if ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'widgets.php' ) ) ) {
			//CSS
			wp_enqueue_style( VICTOR_PREFIX . 'jquery-datetimepicker', VICTOR_DIR . "assets/css/jquery.datetimepicker.css", NULL, NULL );
			wp_enqueue_style( VICTOR_PREFIX . 'flaticon', VICTOR_DIR . "assets/css/flaticon.css", array(), NULL );
			wp_enqueue_style( VICTOR_PREFIX . 'metabox', VICTOR_DIR . "assets/css/metabox.css", NULL, NULL );
			wp_enqueue_style( VICTOR_PREFIX . 'jquery-ui', VICTOR_DIR . "assets/css/jquery-ui/jquery-ui.css", array(), NULL );
			wp_enqueue_style( VICTOR_PREFIX . 'jquery-ui-structure', VICTOR_DIR . "assets/css/jquery-ui/jquery-ui.structure.css", array(), NULL );
			wp_enqueue_style( VICTOR_PREFIX . 'jquery-ui-theme', VICTOR_DIR . "assets/css/jquery-ui/jquery-ui.theme.css", array(), NULL );

			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-dialog' );
			wp_enqueue_script( 'jquery-ui-position' );
			wp_enqueue_script( 'jquery-ui-droppable' );
			wp_enqueue_script( 'jquery-ui-draggable' );

			//JS
			wp_enqueue_script( VICTOR_PREFIX . 'jquery-datetimepicker', VICTOR_DIR . "assets/js/jquery.datetimepicker.js", array( 'jquery' ), NULL, TRUE );
			wp_enqueue_script( VICTOR_PREFIX . 'icon-picker', VICTOR_DIR . "assets/js/icon_picker.js", array( 'jquery' ), NULL, TRUE );
			wp_enqueue_script( VICTOR_PREFIX . 'metabox', VICTOR_DIR . "assets/js/metabox.js", array( 'jquery' ), NULL, TRUE );

			wp_localize_script( VICTOR_PREFIX . 'icon-picker', 'victor_toolkit', array(
				'ajax' => array(
					'url' => array(
						'get_lighbox_icons' => wp_nonce_url( admin_url( 'admin-ajax.php' ), '$P$By.WhgC.styMXTVXajsHThQZgrlsVm1', 'security' )
					)
				),
				'i18n' => array(
					'icon_picker' => __( 'Icon Picker', 'victor-toolkit' ),
					'shortcodes' => __( 'Shortcodes', 'victor-toolkit' ),
					'caption' => __( 'Caption', 'victor-toolkit' ),
					'grid' => __( 'Grid', 'victor-toolkit' ),
					'container' => __( 'Container', 'victor-toolkit' ),
					'tabs' => __( 'Tabs', 'victor-toolkit' ),
					'tabs_large' => __( 'Tabs (large)', 'victor-toolkit' ),
					'tabs_vertical' => __( 'Tabs (vertical)', 'victor-toolkit' ),
					'accordion' => __( 'Accordion', 'victor-toolkit' ),
					'toggle' => __( 'Toggle', 'victor-toolkit' ),
					'dropcap' => __( 'Dropcap', 'victor-toolkit' ),
					'color' => __( 'Color', 'victor-toolkit' ),
					'gray' => __( 'Gray', 'victor-toolkit' ),
					'transparent' => __( 'Transparent', 'victor-toolkit' ),
					'alert' => __( 'Alert box', 'victor-toolkit' ),
					'info' => __( 'Info', 'victor-toolkit' ),
					'success' => __( 'Success', 'victor-toolkit' ),
					'warning' => __( 'Warning', 'victor-toolkit' ),
					'danger' => __( 'Danger', 'victor-toolkit' ),
					'button' => __( 'Button', 'victor-toolkit' ),
					'fill' => __( 'Fill', 'victor-toolkit' ),
					'solid' => __( 'Solid', 'victor-toolkit' ),
					'small' => __( 'Small', 'victor-toolkit' ),
					'medium' => __( 'Medium', 'victor-toolkit' ),
					'large' => __( 'Large', 'victor-toolkit' ),
					'blockquote' => __( 'Blockquote', 'victor-toolkit' ),
					'default' => __( 'Default', 'victor-toolkit' ),
					'without_border' => __( 'Without border', 'victor-toolkit' ),
					'pricing_table' => __( 'Pricing Table', 'victor-toolkit' ),
					'special' => __( 'Special', 'victor-toolkit' )
				)
			) );
		}
	}

}
