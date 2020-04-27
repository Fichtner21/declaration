<?php
/**
* @package Declaration
*/

/*
Plugin Name: Declaration
Description: Wtyczka tworzy stronę z deklaracją dostępności.
Author: Przemysław Drożniak & Ernest Fichtner
Text Domain: declaration
Version: 1.0.2
*/

defined( 'ABSPATH' ) or die('Sorry, you cant access to this site!');

if(defined('WP_DEBUG') && WP_DEBUG) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'debugger.php';
}

if(! class_exists('Declaration')) {
    class Declaration {
        public $plugin_name;

        function __construct() {
            $this->plugin_name = dirname(plugin_basename( __FILE__ ));
        }

        function update() {
            // Update Checker
            require dirname(__FILE__) . '/plugin-update-checker/plugin-update-checker.php';

            $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
                'https://github.com/Fichtner21/declaration/',
                __FILE__, //Full path to the main plugin file or functions.php.
                'declaration'
            );

            //Optional: If you're using a private repository, specify the access token like this:
            $myUpdateChecker->setAuthentication('2c9375641f1b85448fd18e4500de6210019a3157');

            //Optional: Set the branch that contains the stable release.
            $myUpdateChecker->setBranch('master');

            //Enable realese assets
            $myUpdateChecker->getVcsApi()->enableReleaseAssets();
        }

        function activate() {
            require_once plugin_dir_path( __FILE__ ) . 'inc/declaration-activation.php';
            DeclarationActivation::activate();
        }

        function deactivate() {
            require_once plugin_dir_path( __FILE__ ) . 'inc/declaration-deactivation.php';
            DeclarationDeactivation::deactivate();
        }

        function register() {
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_assets' ) );
        }

        function enqueue_admin_assets() {
            // enqueue all our styles
            wp_enqueue_style( $this->plugin_name . '_admin_styles', plugins_url( '/admin/css/style.css', __FILE__ ) );
            wp_enqueue_script( $this->plugin_name . '_admin_scripts', plugins_url( '/admin/js/main.js', __FILE__ ) );
        }

        function enqueue_public_assets() {
            // enqueue all our styles
            wp_enqueue_style( $this->plugin_name . '_admin_styles', plugins_url( '/public/css/style.css', __FILE__ ) );
            wp_enqueue_script( $this->plugin_name . '_admin_scripts', plugins_url( '/public/js/main.js', __FILE__ ) );
        }

        function page_options() {
            add_action( 'admin_init', array( $this, 'theme_files' ) );
            add_action( 'admin_init', array( $this, 'hide_editor' ) );
            add_action( 'add_meta_boxes', array( $this, 'add_custom_fields_boxes' ) );
            add_action( 'wp_head', array( $this, 'add_meta_link' ) );
            add_action( 'save_post', array( $this, 'save_details' ), 100 );
        }

        function theme_files() {
            // Template with form to add post
            $filename = ABSPATH . 'wp-content/themes/' . get_option('stylesheet') . '/declaration.php';
            $content = __DIR__ . DIRECTORY_SEPARATOR . 'declaration-page-template.php';
            // Get content from declaration-content & create file in active theme folder
            $declaration_template = file_get_contents($content);
            file_put_contents($filename, $declaration_template);
        }

        // Hide editor
        function hide_editor() {
            if(isset($_GET['post']) || isset($_POST['post_ID'])) {
                $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
            }
            if( !isset( $post_id ) ) return;

            $template_file = get_post_meta($post_id, '_wp_page_template', true);

            if($template_file == 'declaration.php'){ // edit the template name
                remove_post_type_support('page', 'thumbnail');
                remove_post_type_support('page', 'editor');
                remove_post_type_support('page', 'excerpt');
                remove_post_type_support('page', 'author');
                remove_post_type_support('page', 'comments');
                remove_post_type_support('page', 'postcustom');
                remove_meta_box( 'postcustom' , 'page' , 'normal' );
                remove_meta_box( 'slugdiv' , 'page' , 'normal' );
            }


        }
        // Add Metaboxes
        function add_custom_fields_boxes() {
            global $post;

            if(!empty($post)) {
                $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

                if($pageTemplate == 'declaration.php' ) {
                    add_meta_box(
                        'declaration_meta', // $id
                        'Pola dla deklaracji', // $title
                        array($this, 'display_custom_meta_boxes'), // $callback
                        'page', // $page
                        'normal', // $context
                        'high' // $priority
                    );
                }
            }
        }
        // Add meta content with link
        function add_meta_link() {
            global $post;

            $page_link = $post->guid;

            echo '<meta name="deklaracja-dostępności" content="'. $page_link .'"/>';
        }
        function display_custom_meta_boxes() {
            global $post;
        
            $custom = get_post_custom($post->ID);
        
            $fullname = isset($custom["fullname"][0]) ? $custom["fullname"] : " ";
            $publish_date = isset($custom["publish-date"][0]) ? $custom["publish-date"] : " ";
            $address_email = isset($custom["address-email"][0]) ? $custom["address-email"] : " ";
            $page_date = isset($custom["page-date"][0]) ? $custom["page-date"] : " ";
            $attention_optional = isset($custom["attention-optional"][0]) ? $custom["attention-optional"] : " ";
            $phone_number = isset($custom["phone-number"][0]) ? $custom["phone-number"] : " ";
            
            $accessibility_1 = isset($custom["accessibility-1"][0]) ? $custom["accessibility-1"] : " ";    
            $accessibility_2 = isset($custom["accessibility-2"][0]) ? $custom["accessibility-2"] : " ";
            $accessibility_3 = isset($custom["accessibility-3"][0]) ? $custom["accessibility-3"] : " ";
            $accessibility_4 = isset($custom["accessibility-4"][0]) ? $custom["accessibility-4"] : " ";
            $accessibility_5 = isset($custom["accessibility-5"][0]) ? $custom["accessibility-5"] : " ";
            $accessibility_6 = isset($custom["accessibility-6"][0]) ? $custom["accessibility-6"] : " ";
        
            $mobile_app_android = isset($custom["mobile-app-android"][0]) ? $custom["mobile-app-android"] : " ";
            $mobile_app_ios = isset($custom["mobile-app-ios"][0]) ? $custom["mobile-app-ios"] : " "; 
            
            require_once dirname(__FILE__) . '/declaration-admin-template.php' ;
        }
        // Save custom meta data when post publish
        function save_details() {
            global $post;

            if(!empty($post)) {
                $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

                if($pageTemplate == 'declaration.php' ) {
                    if(isset($_POST['dec_test'])){
                        update_post_meta($post->ID, "dec_test", $_POST["dec_test"]);
                    }
                    if(isset($_POST['fullname'])) {
                        update_post_meta($post->ID, "fullname", strip_tags( $_POST["fullname"] ));
                    }
                    if(isset($_POST['publish-date'])) {
                        update_post_meta($post->ID, "publish-date", strip_tags( $_POST["publish-date"] ));
                    }
                    if(isset($_POST['page-date'])) {
                        update_post_meta($post->ID, "page-date", strip_tags( $_POST["page-date"] ));
                    }
                    if(isset($_POST['attention-optional'])) {
                        update_post_meta($post->ID, "attention-optional", $_POST["attention-optional"] );
                    }
                    if(isset($_POST['address-email'])) {
                        update_post_meta($post->ID, "address-email", strip_tags( $_POST["address-email"] ));
                    }
                    if(isset($_POST['phone-number'])) {
                        update_post_meta($post->ID, "phone-number", strip_tags( $_POST["phone-number"] ));
                    }
                    if(isset($_POST['accessibility-1'])) {
                        update_post_meta($post->ID, "accessibility-1", $_POST["accessibility-1"] );
                    }
                    if(isset($_POST['accessibility-2'])) {
                        update_post_meta($post->ID, "accessibility-2", $_POST["accessibility-2"] );
                    }
                    if(isset($_POST['accessibility-3'])) {
                        update_post_meta($post->ID, "accessibility-3", $_POST["accessibility-3"] );
                    }
                    if(isset($_POST['accessibility-4'])) {
                        update_post_meta($post->ID, "accessibility-4", $_POST["accessibility-4"] );
                    }
                    if(isset($_POST['accessibility-5'])) {
                        update_post_meta($post->ID, "accessibility-5", $_POST["accessibility-5"] );
                    }
                    if(isset($_POST['accessibility-6'])) {
                        update_post_meta($post->ID, "accessibility-6", $_POST["accessibility-6"] );
                    }
                    if(isset($_POST['mobile-app-android'])) {
                        update_post_meta($post->ID, "mobile-app-android", $_POST["mobile-app-android"] );
                    }
                    if(isset($_POST['mobile-app-ios'])) {
                        update_post_meta($post->ID, "mobile-app-ios",  $_POST["mobile-app-ios"] );
                    }
                }
            }
        }
        // Restore page from trash
        function restore_page() {
            if(get_page_by_title( 'Deklaracja dostępności' )) {
                $declaration_page_id = get_option('declaration_page_id');
                
                wp_untrash_post($declaration_page_id);
            }
        }
    }

    $declaration = new Declaration();
    $declaration->register();
    $declaration->update();
    $declaration->page_options();

    // activation
    register_activation_hook( __FILE__, array( $declaration, 'activate' ) );

    // deactivation
    register_deactivation_hook( __FILE__, array( $declaration, 'deactivate' ) );
}