<?php
/**
* Plugin Name: Declaration
* Description: Wtyczka tworzy stronę z deklaracją dostępności.
* Author: Przemysław Drożniak & Ernest Fichtner
* Text Domain: declaration
* Version: 2.1
*/

if(defined('WP_DEBUG') && WP_DEBUG) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'debugger.php';
}

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

// Create theme templates
if(!function_exists('declaration_theme_files')) {
    function declaration_theme_files() {
        // Template with form to add post
        $filename = ABSPATH . 'wp-content/themes/' . get_option('stylesheet') . '/declaration.php';
        $content = __DIR__ . DIRECTORY_SEPARATOR . 'declaration-page-template.php';
        // Get content from declaration-content & create file in active theme folder
        $declaration_template = file_get_contents($content);
        file_put_contents($filename, $declaration_template);
    }

    add_action('admin_init', 'declaration_theme_files');
}

// Create pages
if(!function_exists('create_pages_fly')) {
    function create_pages_fly($pageName, $parent = 0, $pageTemplate = '') {
        $createPage = array(
            'post_title'    => $pageName,
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'post_name'     => $pageName,
            'post_parent' => $parent,
            'page_template' => $pageTemplate
        );
        // Insert the post into the database
        $pageID = wp_insert_post( $createPage );
        if ( $pageID && ! is_wp_error( $pageID ) ){
            update_post_meta( $pageID, '_wp_page_template', $pageTemplate );
        }
        return $pageID;
    }
}
if(!function_exists('declaration_pages')) {
    function declaration_pages() {
        if(get_page_by_title( 'Deklaracja dostępności' ) === NULL) {
            $parent = create_pages_fly( 'Deklaracja dostępności', 0, 'declaration.php' );
        }
    }
    register_activation_hook(__FILE__, 'declaration_pages');
}
// Delete page
if(!function_exists('deactivate_declaration')){
    function deactivate_declaration(){
        $declaration_page = get_page_by_path('deklaracja-dostepnosci');
        wp_delete_post($declaration_page->ID, true);
    }
    register_deactivation_hook(__FILE__, 'deactivate_declaration');
}

// Hide editor
if(!function_exists('hide_editor')) {
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
    add_action( 'admin_init', 'hide_editor' );
}

// Add Metaboxes
if(!function_exists('add_custom_fields_boxes')) {
    function add_custom_fields_boxes() {
        global $post;

        if(!empty($post)) {
            $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

            if($pageTemplate == 'declaration.php' ) {
                add_meta_box(
                    'declaration_meta', // $id
                    'Pola dla deklaracji', // $title
                    'display_custom_meta_boxes', // $callback
                    'page', // $page
                    'normal', // $context
                    'high' // $priority
                );
            }
        }
    }

    add_action('add_meta_boxes', 'add_custom_fields_boxes');
}

// Add meta content with link
if(!function_exists('add_meta_declaration_link')) {
    function add_meta_declaration_link() {
        global $post;

        $page_link = $post->guid;

        echo '<meta name="deklaracja-dostępności" content="'. $page_link .'"/>';
    }

    add_action('wp_head', 'add_meta_declaration_link');
}

// Dusokay custom meta boxes
if(!function_exists('display_custom_meta_boxes')) {
function display_custom_meta_boxes() { ?>

<?php
    global $post;

    $custom = get_post_custom($post->ID);

    $fullname = isset($custom["fullname"][0]) ? $custom["fullname"] : " ";
    $publish_date = isset($custom["publish-date"][0]) ? $custom["publish-date"] : " ";
    $address_email = isset($custom["address-email"][0]) ? $custom["address-email"] : " ";
    $phone_number = isset($custom["phone-number"][0]) ? $custom["phone-number"] : " ";
    
    $accessibility_1 = isset($custom["accessibility-1"][0]) ? $custom["accessibility-1"] : " ";    
    $accessibility_2 = isset($custom["accessibility-2"][0]) ? $custom["accessibility-2"] : " ";
    $accessibility_3 = isset($custom["accessibility-3"][0]) ? $custom["accessibility-3"] : " ";
    $accessibility_4 = isset($custom["accessibility-4"][0]) ? $custom["accessibility-4"] : " ";
    $accessibility_5 = isset($custom["accessibility-5"][0]) ? $custom["accessibility-5"] : " ";
    $accessibility_6 = isset($custom["accessibility-6"][0]) ? $custom["accessibility-6"] : " ";

    $mobile_app_android = isset($custom["mobile-app-android"][0]) ? $custom["mobile-app-android"] : " ";
    $mobile_app_ios = isset($custom["mobile-app-ios"][0]) ? $custom["mobile-app-ios"] : " ";    
    
?>

    <div class="declaration-meta-form">        
        <div class="declaration-meta-form__row">
            <label for="fullname" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-admin-users"></span> Imię i nazwisko osoby odpowiedzialnej za kontakt w sprawie niedostępności</h3></label>
            <input type="text" id="fullname" name="fullname" class="declaration-meta-form__input" value="<?= $fullname[0]; ?>">
        </div>

        <div class="declaration-meta-form__row">
            <label for="publish-date" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-calendar-alt"></span> Data publikacji strony internetowej (Format: RRRR-MM-DD):</h3></label>
            <input type="text" id="publish-date" name="publish-date" class="declaration-meta-form__input" value="<?= $publish_date[0]; ?>">
        </div>

        <div class="declaration-meta-form__row">
            <label for="address-email" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-email-alt"></span> Adres poczty elektronicznej osoby kontaktowej</h3></label>
            <input type="email" id="address-email" name="address-email" class="declaration-meta-form__input" value="<?= $address_email[0]; ?>">
        </div>

        <div class="declaration-meta-form__row">
            <label for="phone-number" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-phone"></span> Numer telefonu do osoby kontaktowej</h3></label>
            <?= wp_editor($phone_number[0], "phone-number", array('editor_height' => 100, 'media_buttons' => false )); ?>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-1" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Opis dostępności wejścia do budynku i przechodzenia przez obszary kontrolii</h3></label>
            <?= wp_editor($accessibility_1[0], "accessibility-1", array('editor_height' => 200)); ?>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-2" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Opis dostępności korytarzy, schodów i wind</h3></label>
            <?= wp_editor($accessibility_2[0], "accessibility-2", array('editor_height' => 200)); ?>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-3" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Opis dostosowań, na przykład pochylni, platform, informacji głosowych, pętlach indukcyjnych</h3></label>
            <?= wp_editor($accessibility_3[0], "accessibility-3", array('editor_height' => 200)); ?>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-4" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-building"></span> Informacje o miejscu i sposobie korzystania z miejsc parkingowych wyznaczonych dla osób niepełnosprawnych</h3></label>
            <?= wp_editor($accessibility_4[0], "accessibility-4", array('editor_height' => 200)); ?>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-5" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-buddicons-activity"></span> Informacja o prawie wstępu z psem asystującym i ewentualnych uzasadnionych ograniczeniach</h3></label>
            <?= wp_editor($accessibility_5[0], "accessibility-5", array('editor_height' => 200)); ?>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-6" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-universal-access"></span> Informacje o możliwości skorzystania z tłumacza języka migowego na miejscu lub online. W przypadku braku takiej możliwości, taką informację także należy zawrzeć</h3></label>
            <?= wp_editor($accessibility_6[0], "accessibility-6", array('editor_height' => 200)); ?>
        </div>

        <div class="declaration-meta-form__row">
            <label for="mobile-app-android" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-smartphone"></span> (Android) Wymienić aplikacje oraz informację skąd można je pobrać</h3></label>
            <?= wp_editor($mobile_app_android[0], "mobile-app-android", array('editor_height' => 100)); ?>
        </div>        

        <div class="declaration-meta-form__row">
            <label for="mobile-app-ios" class="declaration-meta-form__label"><h3><span class="dashicons dashicons-smartphone"></span> (iOS) Wymienić aplikacje oraz informację skąd można je pobrać</h3></label>
            <?= wp_editor($mobile_app_ios[0], "mobile-app-ios", array('editor_height' => 100)); ?>
        </div>
        
    </div>

<?php } }

//Declaration
if(! function_exists('declaration_styles')) {
    function declaration_styles() {
        $styles_path = plugins_url('declaration') . '/assets/css/style.css';

        wp_enqueue_style('declaration', $styles_path);
    }

    add_action('wp_head', 'declaration_styles');
    add_action('admin_enqueue_scripts', 'declaration_styles');
}

// Save custom meta data when post publish
if(! function_exists('save_details')) {
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
                if(isset($_POST['address-email'])) {
                    update_post_meta($post->ID, "address-email", strip_tags( $_POST["address-email"] ));
                }
                if(isset($_POST['phone-number'])) {
                    update_post_meta($post->ID, "phone-number", strip_tags( $_POST["phone-number"] ));
                }
                if(isset($_POST['accessibility-1'])) {
                    update_post_meta($post->ID, "accessibility-1", strip_tags( $_POST["accessibility-1"] ));
                }
                if(isset($_POST['accessibility-2'])) {
                    update_post_meta($post->ID, "accessibility-2", strip_tags( $_POST["accessibility-2"] ));
                }
                if(isset($_POST['accessibility-3'])) {
                    update_post_meta($post->ID, "accessibility-3", strip_tags( $_POST["accessibility-3"] ));
                }
                if(isset($_POST['accessibility-4'])) {
                    update_post_meta($post->ID, "accessibility-4", strip_tags( $_POST["accessibility-4"] ));
                }
                if(isset($_POST['accessibility-5'])) {
                    update_post_meta($post->ID, "accessibility-5", strip_tags( $_POST["accessibility-5"] ));
                }
                if(isset($_POST['accessibility-6'])) {
                    update_post_meta($post->ID, "accessibility-6", strip_tags( $_POST["accessibility-6"] ));
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
    add_action('save_post', 'save_details', 100);
}