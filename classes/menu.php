<?php

/**
 * Class CF_GA_Menu
 *
 * Add the admin
 *
 * @package CF-GA
 * @author    Josh Pollock <Josh@CalderaForms.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2007 CalderaWP LLC
 */
class CF_GA_Menu {

	/**
	 * Menu slug
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	protected $menu_slug;

	/**
	 * CF_GA_Menu constructor.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_page' ) );
		$this->menu_slug = Caldera_Forms::PLUGIN_SLUG . '-cf-ga';
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * Add menu page
	 *
	 * @since 0.0.1
	 *
	 * @uses "admin_menu"
	 */
	public function add_page(){
		add_submenu_page(
			Caldera_Forms::PLUGIN_SLUG,
			__( 'Google Analytics', 'cf-ga' ),
			__( 'Google Analytics', 'cf-ga' ),
			Caldera_Forms::get_manage_cap(),
			$this->menu_slug,
			array( $this, 'render_admin' ) );
	}

	/**
	 * Load scripts for admin page
	 *
	 * @since 0.0.1
	 *
	 * @uses "admin_enqueue_scripts"
	 *
	 * @param $hook
	 */
	public function scripts( $hook ){
		if ( isset( $_GET[ 'page' ] ) && 'caldera-forms-cf-ga' == $_GET[ 'page' ] ) {
			// CF 1.5.0+
			if( class_exists( 'Caldera_Forms_Admin_Assets' ) ){
				Caldera_Forms_Admin_Assets::enqueue_style( 'admin' );
				Caldera_Forms_Render_Assets::enqueue_script( 'vue' );
			}else{
				wp_enqueue_style( Caldera_Forms::PLUGIN_SLUG . '-admin-styles', CFCORE_URL . 'assets/css/admin.css', array(), Caldera_Forms::VERSION );
				wp_enqueue_script( 'cf-ga-vue', CF_GA_URL . '/assets/vue.min.js', array( 'jquery' ), CF_GA_VER, true );

			}

			wp_enqueue_script( 'cf-ga', CF_GA_URL . '/assets/admin.js', array( 'jquery' ), CF_GA_VER, true );
			wp_localize_script( 'cf-ga', 'CF_GA', array(
				'api' => esc_url_raw( Caldera_Forms_API_Util::url( 'add-ons/cf-ga/settings' ) ),
				'nonce' => wp_create_nonce( 'wp_rest' )
			));

		}
	}

	/**
	 * Render plugin admin page
	 *
	 * @since 0.0.1
	 *
	 * @todo move to partial and/or load via AJAX
	 */
	public function render_admin(){

		?>
<div class="caldera-editor-header">
	<ul class="caldera-editor-header-nav">
		<li class="caldera-editor-logo">
			<span class="caldera-forms-name">
				<?php esc_html_e( 'Google Analytics For Caldera Forms - Settings', 'cf-ga' ); ?>
			</span>
		</li>
	</ul>
</div>
<div id="cf-ga" style="margin-top: 64px;">
	<cf-ga></cf-ga>
</div>
<script type="text/html" id="cf-ga-tmpl">
	<form  v-on:submit.prevent="onSubmit" v-cloak>
		<div class="caldera-config-group">
			<label for="cf-ga-ua">
				<?php esc_html_e( 'UA Code', 'cf-ga' ); ?>
			</label>
			<input v-model="ua" id="cf-ga-ua"/>
		</div>
		<div class="caldera-config-group">
			<label for="cf-ga-domain">
				<?php esc_html_e( 'Domain', 'cf-ga' ); ?>
			</label>
			<input v-model="domain" id="cf-ga-domain"/>
		</div>
		<?php submit_button( esc_html__( 'Save') ); ?>
	</form>
</script>

<?php
	}

}
