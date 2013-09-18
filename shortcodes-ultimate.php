<?php
/*
  Plugin Name: Shortcodes Ultimate
  Plugin URI: http://gndev.info/shortcodes-ultimate/
  Version: 4.0.7
  Author: Vladimir Anokhin
  Author URI: http://gndev.info/
  Description: Supercharge your WordPress theme with mega pack of shortcodes
  Text Domain: su
  Domain Path: /languages
  License: GPL
 */

// Define plugin file constant
define( 'SU_PLUGIN_FILE', __FILE__ );

// Includes
require_once 'inc/vendor/class.sunrise-framework.php';
require_once 'inc/vendor/class.image-meta.php';
require_once 'inc/vendor/class.media-upload.php';
require_once 'inc/core/class.shortcodes-ultimate.php';
require_once 'inc/core/class.assets.php';
require_once 'inc/core/class.data.php';
require_once 'inc/core/tools.php';
require_once 'inc/core/shortcodes.php';
require_once 'inc/core/class.generator.php';
require_once 'inc/core/class.widget.php';
require_once 'inc/core/class.vote.php';
