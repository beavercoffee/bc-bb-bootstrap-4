<?php
/*
Author: Beaver Coffee
Author URI: https://beaver.coffee
Description: Add Bootstrap 4 to Beaver Builder default styles.
Domain Path:
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Network: true
Plugin Name: BC BB Bootstrap 4
Plugin URI: https://github.com/beavercoffee/bc-bb-bootstrap-4
Requires at least: 5.7
Requires PHP: 5.6
Text Domain: bc-bb-bootstrap-4
Version: 1.7.9
*/

if(defined('ABSPATH')){
    require_once(plugin_dir_path(__FILE__) . 'classes/class-bc-bb-bootstrap-4.php');
    BC_BB_Bootstrap_4::get_instance(__FILE__);
}
