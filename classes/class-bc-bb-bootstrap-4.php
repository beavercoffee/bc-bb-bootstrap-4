<?php

if(!class_exists('BC_BB_Bootstrap_4')){
    final class BC_BB_Bootstrap_4 {

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    	//
    	// private static
    	//
    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private static $instance = null;

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    	//
    	// public static
    	//
    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    	public static function get_instance($file = ''){
            if(null === self::$instance){
                if(@is_file($file)){
                    self::$instance = new self($file);
                } else {
                    wp_die(__('File doesn&#8217;t exist?'));
                }
            }
            return self::$instance;
    	}

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    	//
    	// private
    	//
    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        private $file = '';

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    	private function __clone(){}

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    	private function __construct($file = ''){
            $this->file = $file;
            add_action('after_setup_theme', [$this, 'maybe_reboot_default_styles']);
            add_action('customize_controls_print_footer_scripts', [$this, 'add_theme_colors']);
            add_action('wp_enqueue_scripts', [$this, 'overwrite'], 1000);
            add_filter('fl_builder_color_presets', [$this, 'add_plugin_colors']);
            add_filter('fl_theme_compile_less_paths', [$this, 'remove_default_styles']);
            remove_filter('fl_theme_framework_enqueue', 'FLLayout::fl_theme_framework_enqueue');
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    	//
    	// public
    	//
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public function add_plugin_colors($colors){
            $colors = array_map(function($color){
        		return '#' . ltrim($color, '#');
        	}, $colors);
            $colors = array_merge(['#007bff', '#6c757d', '#28a745', '#17a2b8', '#ffc107', '#dc3545', '#f8f9fa', '#343a40'], $colors);
            $colors = array_unique($colors);
            $colors = array_values($colors);
            return $colors;
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public function add_theme_colors(){ ?>
            <script>
                jQuery(function($){
                    $('.wp-picker-container').iris({
                        controls: {
                            horiz: 'h', // square horizontal displays hue
                            strip: 'l', // slider displays lightness
                            vert: 's', // square vertical displays saturdation
                        },
                        mode: 'hsl',
                        palettes: ['#007bff', '#6c757d', '#28a745', '#17a2b8', '#ffc107', '#dc3545', '#f8f9fa', '#343a40'],
                    });
                });
            </script><?php
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public function check_default_styles(){
            $defaults = $this->default_styles();
        	$defaults = array_map('strval', $defaults);
        	$mods = get_theme_mods();
        	$mods = array_map('strval', $mods);
        	$intersection = array_intersect_assoc($defaults, $mods);
        	$difference = array_diff_assoc($defaults, $intersection);
        	return empty($difference);
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public function default_styles(){
            return [
        		'fl-body-font-size_medium' => 14,
        		'fl-body-font-size_mobile' => 14,
        		'fl-button-font-size_medium' => 16,
        		'fl-button-font-size_mobile' => 16,
        		'fl-button-line-height_medium' => 1.2,
        		'fl-button-line-height_mobile' => 1.2,
        		'fl-body-line-height_medium' => 1.45,
        		'fl-body-line-height_mobile' => 1.45,
        		'fl-h1-font-size_medium' => 36,
        		'fl-h1-font-size_mobile' => 36,
        		'fl-h1-line-height_medium' => 1.4,
        		'fl-h1-line-height_mobile' => 1.4,
        		'fl-h1-letter-spacing_medium' => 0,
        		'fl-h1-letter-spacing_mobile' => 0,
        		'fl-h2-font-size_medium' => 30,
        		'fl-h2-font-size_mobile' => 30,
        		'fl-h2-line-height_medium' => 1.4,
        		'fl-h2-line-height_mobile' => 1.4,
        		'fl-h2-letter-spacing_medium' => 0,
        		'fl-h2-letter-spacing_mobile' => 0,
        		'fl-h3-font-size_medium' => 24,
        		'fl-h3-font-size_mobile' => 24,
        		'fl-h3-line-height_medium' => 1.4,
        		'fl-h3-line-height_mobile' => 1.4,
        		'fl-h3-letter-spacing_medium' => 0,
        		'fl-h3-letter-spacing_mobile' => 0,
        		'fl-h4-font-size_medium' => 18,
        		'fl-h4-font-size_mobile' => 18,
        		'fl-h4-line-height_medium' => 1.4,
        		'fl-h4-line-height_mobile' => 1.4,
        		'fl-h4-letter-spacing_medium' => 0,
        		'fl-h4-letter-spacing_mobile' => 0,
        		'fl-h5-font-size_medium' => 14,
        		'fl-h5-font-size_mobile' => 14,
        		'fl-h5-line-height_medium' => 1.4,
        		'fl-h5-line-height_mobile' => 1.4,
        		'fl-h5-letter-spacing_medium' => 0,
        		'fl-h5-letter-spacing_mobile' => 0,
        		'fl-h6-font-size_medium' => 12,
        		'fl-h6-font-size_mobile' => 12,
        		'fl-h6-line-height_medium' => 1.4,
        		'fl-h6-line-height_mobile' => 1.4,
        		'fl-h6-letter-spacing_medium' => 0,
        		'fl-h6-letter-spacing_mobile' => 0,
        		'fl-hamburger-icon-top-position_medium' => 24,
        		'fl-hamburger-icon-top-position_mobile' => 24,
        		'fl-topbar-bg-color' => '#ffffff',
        		'fl-topbar-text-color' => '#000000',
        		'fl-topbar-link-color' => '#428bca',
        		'fl-topbar-hover-color' => '#428bca',
        		'fl-header-bg-color' => '#ffffff',
        		'fl-header-text-color' => '#000000',
        		'fl-header-link-color' => '#428bca',
        		'fl-header-hover-color' => '#428bca',
        		'fl-nav-bg-color' => '#ffffff',
        		'fl-nav-text-color' => '#000000',
        		'fl-nav-link-color' => '#428bca',
        		'fl-nav-hover-color' => '#428bca',
        		'fl-footer-widgets-bg-color' => '#ffffff',
        		'fl-footer-widgets-text-color' => '#000000',
        		'fl-footer-widgets-link-color' => '#428bca',
        		'fl-footer-widgets-hover-color' => '#428bca',
        		'fl-footer-bg-color' => '#ffffff',
        		'fl-footer-text-color' => '#000000',
        		'fl-footer-link-color' => '#428bca',
        		'fl-footer-hover-color' => '#428bca',
        		'fl-nav-font-family' => 'Helvetica',
        		'fl-nav-font-weight' => 400,
        		'fl-nav-font-format' => 'none',
        		'fl-nav-font-size' => 14,
        	];
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public function maybe_reboot_default_styles(){
            if($this->check_default_styles()){
            	$this->reboot_default_styles();
            }
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public function overwrite(){
            if(wp_script_is('bootstrap-4') and wp_style_is('bootstrap-4')){
                $this->overwrite_script('bootstrap-4', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js', [], '4.6.0', true);
                $this->overwrite_style('bootstrap-4', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css', [], '4.6.0');
            }
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public function overwrite_script($handle = '', $src = '', $deps = [], $ver = false, $in_footer = false){
            if(wp_script_is($handle)){
                wp_dequeue_script($handle);
            }
            if(wp_script_is($handle, 'registered')){
                wp_deregister_script($handle);
            }
            wp_register_script($handle, $src, $deps, $ver, $in_footer);
            wp_enqueue_script($handle);
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public function overwrite_style($handle = '', $src = '', $deps = [], $ver = false){
            if(wp_style_is($handle)){
                wp_dequeue_style($handle);
            }
            if(wp_style_is($handle, 'registered')){
                wp_deregister_style($handle);
            }
            wp_register_style($handle, $src, $deps, $ver);
            wp_enqueue_style($handle);
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public function reboot_default_styles(){
            $mods = get_theme_mods();
        	$mods['fl-scroll-to-top'] = 'enable';
            $mods['fl-framework'] = 'bootstrap-4';
            $mods['fl-awesome'] = 'fa5';
            $mods['fl-body-bg-color'] = '#ffffff';
            $mods['fl-accent'] = '#007bff';
            $mods['fl-accent-hover'] = '#0056b3';
            $mods['fl-heading-text-color'] = '#343a40';
            $mods['fl-heading-font-family'] = 'Montserrat';
            $mods['fl-heading-font-weight'] = 700;
            $mods['fl-h1-font-size'] = 40;
            $mods['fl-h1-font-size_medium'] = 33;
            $mods['fl-h1-font-size_mobile'] = 28;
            $mods['fl-h1-line-height'] = 1.2;
            $mods['fl-h1-line-height_medium'] = 1.2;
            $mods['fl-h1-line-height_mobile'] = 1.2;
            $mods['fl-h2-font-size'] = 32;
            $mods['fl-h2-font-size_medium'] = 28;
            $mods['fl-h2-font-size_mobile'] = 24;
            $mods['fl-h2-line-height'] = 1.2;
            $mods['fl-h2-line-height_medium'] = 1.2;
            $mods['fl-h2-line-height_mobile'] = 1.2;
            $mods['fl-h3-font-size'] = 28;
            $mods['fl-h3-font-size_medium'] = 25;
            $mods['fl-h3-font-size_mobile'] = 22;
            $mods['fl-h3-line-height'] = 1.2;
            $mods['fl-h3-line-height_medium'] = 1.2;
            $mods['fl-h3-line-height_mobile'] = 1.2;
            $mods['fl-h4-font-size'] = 24;
            $mods['fl-h4-font-size_medium'] = 22;
            $mods['fl-h4-font-size_mobile'] = 20;
            $mods['fl-h4-line-height'] = 1.2;
            $mods['fl-h4-line-height_medium'] = 1.2;
            $mods['fl-h4-line-height_mobile'] = 1.2;
            $mods['fl-h5-font-size'] = 20;
            $mods['fl-h5-font-size_medium'] = 19;
            $mods['fl-h5-font-size_mobile'] = 16;
            $mods['fl-h5-line-height'] = 1.2;
            $mods['fl-h5-line-height_medium'] = 1.2;
            $mods['fl-h5-line-height_mobile'] = 1.2;
            $mods['fl-h6-font-size'] = 16;
            $mods['fl-h6-font-size_medium'] = 16;
            $mods['fl-h6-font-size_mobile'] = 16;
            $mods['fl-h6-line-height'] = 1.2;
            $mods['fl-h6-line-height_medium'] = 1.2;
            $mods['fl-h6-line-height_mobile'] = 1.2;
            $mods['fl-body-text-color'] = '#6c757d';
            $mods['fl-body-font-family'] = 'Open Sans';
            $mods['fl-body-font-size'] = 16;
            $mods['fl-body-font-size_medium'] = 16;
            $mods['fl-body-font-size_mobile'] = 16;
            $mods['fl-body-line-height'] = 1.5;
            $mods['fl-body-line-height_medium'] = 1.5;
            $mods['fl-body-line-height_mobile'] = 1.5;
            $mods['fl-header-layout'] = 'none';
            $mods['fl-fixed-header'] = 'hidden';
            $mods['fl-footer-widgets-display'] = 'disabled';
            $mods['fl-footer-layout'] = 'none';
            return update_option('theme_mods_' . get_stylesheet(), $mods);
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public function remove_default_styles($paths){
            foreach($paths as $index => $path){
                if(FL_THEME_DIR . '/less/theme.less' === $path){
                    $paths[$index] = plugin_dir_path($this->file) . 'assets/theme-1.7.9.less';
                    break;
                }
            }
            return $paths;
        }

    	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}
