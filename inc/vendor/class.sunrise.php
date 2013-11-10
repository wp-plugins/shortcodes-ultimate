<?php

require_once 'class.sunrise-views.php';

if ( !class_exists( 'Sunrise3' ) ) {
	class Sunrise3 {

		static $config = array();

		/**
		 * Constructor
		 */
		function __construct( $args = array() ) {
			add_action( 'admin_menu',   array( __CLASS__, 'register' ) );
			add_action( 'admin_init',   array( __CLASS__, 'assets' ), 10 );
			add_action( 'admin_init',   array( __CLASS__, 'enqueue' ), 20 );
			add_action( 'admin_init',   array( __CLASS__, 'submit' ) );
		}

		public static function setup( $args = array() ) {
			$config = wp_parse_args( $args, array(
					'file'       => '',
					'slug'       => '',
					'prefix'     => '',
					'textdomain' => '',
					'url'        => '',
					'version'    => '3.0',
					'options'    => array(),
					'menus'      => array(),
					'pages'      => array(),
					'slugs'      => array(),
					'css'        => 'assets/css',
					'js'         => 'assets/js'
				) );
			// Check required settings
			if ( !$config['file'] ) wp_die( 'Sunrise: please specify plugin file' );
			if ( !$config['slug'] ) $config['slug'] = sanitize_key( basename( dirname( $config['file'] ) ) );
			if ( !$config['prefix'] ) $config['prefix'] = 'sunrise_' . sanitize_key( $config['slug'] ) . '_';
			if ( !$config['textdomain'] ) $config['textdomain'] = sanitize_key( $config['slug'] );
			// Save config
			self::$config = $config;
		}

		public static function config( $option = false ) {
			return ( $option ) ? self::$config[$option] : self::$config;
		}

		public static function register() {
			$config = self::config();
			if ( isset( $config['menus'] ) && count( $config['menus'] ) )
				foreach ( $config['menus'] as $menu ) {
					add_menu_page( $menu['page_title'], $menu['menu_title'], $menu['capability'], $menu['slug'], array( __CLASS__, 'render' ), $menu['icon_url'], $menu['position'] );
				}
			if ( isset( $config['pages'] ) && count( $config['pages'] ) )
				foreach ( $config['pages'] as $page ) {
					add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['slug'], array( __CLASS__, 'render' ) );
				}
		}

		public static function add_menu( $args ) {
			$args = wp_parse_args( $args, array(
					'page_title'  => __( 'Plugin Settings', self::config( 'textdomain' ) ),
					'menu_title'  => __( 'Plugin Settings', self::config( 'textdomain' ) ),
					'capability'  => 'manage_options',
					'slug'        => self::config( 'slug' ),
					'icon_url'    => admin_url( 'images/wp-logo.png' ),
					'position'    => '81.' . rand( 0, 99 ),
					'url'         => '',
					'options'     => array()
				) );
			// Define page url
			if ( !$args['url'] ) $args['url'] = admin_url( 'admin.php?page=' . $args['slug'] );
			// Save url to global config
			if ( !self::$config['url'] ) self::$config['url'] = $args['url'];
			// Save options to global config
			if ( is_array( $args['options'] ) && count( $args['options'] ) ) foreach ( $args['options'] as $option ) {
					self::$config['options'][] = $option;
				}
			// Save menu slug to the global config
			self::$config['slugs'][] = $args['slug'];
			// Add page to global config
			self::$config['menus'][$args['slug']] = $args;
		}

		public static function add_submenu( $args ) {
			$args = wp_parse_args( $args, array(
					'parent_slug' => 'options-general.php',
					'page_title'  => __( 'Plugin Settings', self::config( 'textdomain' ) ),
					'menu_title'  => __( 'Plugin Settings', self::config( 'textdomain' ) ),
					'capability'  => 'manage_options',
					'slug'        => self::config( 'slug' ),
					'url'         => '',
					'options'     => array()
				) );
			// Define page url
			if ( !$args['url'] ) {
				if ( strpos( $args['parent_slug'], '.php' ) !== false ) $args['url'] = admin_url( $args['parent_slug'] . '?page=' . $args['slug'] );
				else $args['url'] = ( isset( self::$config['menus'][$args['parent_slug']] ) ) ? admin_url( 'admin.php?page=' . $args['slug'] ) : '';
			}
			// Save url to global config
			if ( !self::$config['url'] ) self::$config['url'] = $args['url'];
			// Save options to global config
			if ( is_array( $args['options'] ) && count( $args['options'] ) && !in_array( $args['slug'], array_keys( (array) self::$config['menus'] ) ) ) foreach ( $args['options'] as $option ) {
					self::$config['options'][] = $option;
				}
			// Save page slug to the global config
			self::$config['slugs'][] = $args['slug'];
			// Add page to global config
			self::$config['pages'][$args['slug']] = $args;
		}

		public static function render() {
			do_action( 'sunrise/page/before' );
			echo '<div id="sunrise-settings" class="wrap">';
			echo self::tabs();
			echo self::notifications();
			do_action( 'sunrise/page/notifications' );
			echo '<form action="" method="post" id="sunrise-form">';
			echo self::panes();
			echo '<input type="hidden" name="sunrise_action" value="save" />';
			do_action( 'sunrise/page/form' );
			echo '</form></div>';
			do_action( 'sunrise/page/after' );
		}

		function tabs() {
			$options = self::get_page_options();
			$output = array();
			foreach ( $options as $option ) {
				if ( isset( $option['type'] ) && isset( $option['name'] ) && $option['type'] === 'opentab' ) $output[] = '<span class="nav-tab">' . $option['name'] . '</span>';
			}
			return ( count( $output ) ) ? '<div id="icon-options-general" class="icon32 hide-if-no-js"><br /></div><h2 id="sunrise-tabs" class="nav-tab-wrapper hide-if-no-js">' . implode( '', $output ) . '</h2>' : '';
		}

		public static function panes() {
			$options = self::get_page_options();
			$output = array();
			foreach ( $options as $option ) {
				if ( !isset( $option['type'] ) ) continue;
				elseif ( is_callable( array( 'Sunrise3_Views', $option['type'] ) ) ) $output[] = call_user_func( array( 'Sunrise3_Views', $option['type'] ), $option, self::$config );
				elseif ( isset( $option['callback'] ) && is_callable( $option['callback'] ) ) $output[] = call_user_func( $option['callback'], $option, self::$config );
				else $output[] = Sunrise3_Views::notice( 'Sunrise: ' . sprintf( __( 'option type %s is not callable', self::config( 'textdomain' ) ), '<b>' . $option['type'] . '</b>' ), 'error' );
			}
			return implode( '', $output );
		}

		public static function notifications( $msgs = array() ) {
			$msgs = wp_parse_args( $msgs, apply_filters( 'sunrise/page/notices', array(
						__( 'For full functionality of this page it is reccomended to enable javascript.', self::config( 'textdomain' ) ),
						__( 'Settings saved successfully', self::config( 'textdomain' ) ),
						__( 'Settings reseted successfully', self::config( 'textdomain' ) )
					) ) );
			$output = array();
			$message = ( isset( $_GET['message'] ) && is_numeric( $_GET['message'] ) ) ? intval( sanitize_key( $_GET['message'] ) ) : 0;
			$output[] = Sunrise3_Views::notice( '<a href="http://enable-javascript.com/" target="_blank">' . $msgs[0] . '</a>.', 'error hide-if-js' );
			if ( $message !== 0 ) $output[] = Sunrise3_Views::notice( $msgs[$message], 'updated' );
			return implode( '', $output );
		}

		public static function assets() {
			wp_register_style( 'sunrise', plugins_url( self::config( 'css' ), self::config( 'file' ) ) . '/sunrise.css', false, self::config( 'version' ), 'all' );
			wp_register_script( 'form', plugins_url( self::config( 'js' ), self::config( 'file' ) ) . '/form.js', array( 'jquery' ), self::config( 'version' ), true );
			wp_register_script( 'sunrise', plugins_url( self::config( 'js' ), self::config( 'file' ) ) . '/sunrise.js', array( 'form' ), self::config( 'version' ), true );
			wp_localize_script( 'sunrise', 'sunrise', array(
				'media_title'  => __( 'Choose file', self::$config['textdomain'] ),
				'media_insert' => __( 'Use selected file', self::$config['textdomain'] )
			) );
			do_action( 'sunrise/assets/register' );
		}

		public static function enqueue() {
			if ( !self::is_sunrise() ) return;
			foreach ( array( 'farbtastic', 'sunrise' ) as $style ) wp_enqueue_style( $style );
			foreach ( array( 'jquery', 'farbtastic', 'form', 'sunrise' ) as $script ) wp_enqueue_script( $script );
			do_action( 'sunrise/assets/enqueue' );
		}

		public static function defaults() {
			$config = self::config();
			if ( isset( $config['options'] ) && is_array( $config['options'] ) ) foreach ( $config['options'] as $option ) {
					if ( isset( $option['id'] ) && isset( $option['default'] ) ) update_option( $config['prefix'] . $option['id'], $option['default'] );
					elseif ( isset( $option['id'] ) && isset( $option['options'] ) && is_array( $option['options'] ) ) {
						$grroup = array();
						foreach ( $option['options'] as $item ) if ( isset( $item['id'] ) && isset( $item['default'] ) ) $group[$item['id']] = $item['default'];
							update_option( $config['prefix'] . $option['id'], $group );
					}
				}
		}

		public static function submit() {
			if ( !isset( $_REQUEST['sunrise_action'] ) || !isset( $_REQUEST['page'] ) ) return;
			$action = sanitize_key( $_REQUEST['sunrise_action'] );
			$page = sanitize_key( $_REQUEST['page'] );
			$options = (array) self::get_page_options();
			$request = ( isset( $_REQUEST['sunrise'] ) ) ? (array) $_REQUEST['sunrise'] : array();
			$config = self::config();
			// Run actions
			switch ( $action ) {
			case 'save':
				foreach ( $options as $option ) {
					if ( !isset( $option['id'] ) ) continue;
					$val = ( isset( $request[$option['id']] ) ) ? $request[$option['id']] : '';
					update_option( $config['prefix'] . $option['id'], $val );
				}
				wp_redirect( self::get_page_url() . '&message=1' );
				exit;
				break;
			case 'reset':
				foreach ( $options as $option ) {
					if ( !isset( $option['id'] ) ) continue;
					if ( !isset( $option['default'] ) && isset( $option['options'] ) ) {
						$option['default'] = array();
						foreach ( (array) $option['options'] as $item ) {
							if ( isset( $item['id'] ) && isset( $item['default'] ) ) $option['default'][$item['id']] = $item['default'];
						}
					}
					if ( isset( $option['default'] ) ) update_option( $config['prefix'] . $option['id'], $option['default'] );
				}
				wp_redirect( self::get_page_url() . '&message=2' );
				exit;
				break;
			}
		}

		public static function get_page() {
			$config = self::config();
			$slug = sanitize_key( $_REQUEST['page'] );
			if ( in_array( $slug, array_keys( (array) self::$config['menus'] ) ) ) return self::$config['menus'][$slug];
			else if ( in_array( $slug, array_keys( (array) self::$config['pages'] ) ) ) return self::$config['pages'][$slug];
				return array();
		}

		public static function get_page_options() {
			$page = self::get_page();
			$return = array();
			if ( isset( $page['options'] ) && is_array( $page['options'] ) ) foreach ( $page['options'] as $option ) $return[] = $option;
				return $return;
		}

		public static function get_page_url( $slug = false ) {
			if ( !$slug && isset( $_REQUEST['page'] ) ) $slug = sanitize_key( $_REQUEST['page'] );
			if ( isset( self::$config['menus'][$slug] ) && isset( self::$config['menus'][$slug]['url'] ) ) return self::$config['menus'][$slug]['url'];
			elseif ( isset( self::$config['pages'][$slug] ) && isset( self::$config['pages'][$slug]['url'] ) ) return self::$config['pages'][$slug]['url'];
			return '';
		}

		public static function is_sunrise() {
			return isset( $_GET['page'] ) && in_array( $_GET['page'], self::$config['slugs'] );
		}

	}
}
