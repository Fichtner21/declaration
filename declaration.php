<?php
/**
* Plugin Name: Declaration
* Description: Wtyczka tworzy stronę z deklaracją dostępności.
* Author: Przemysław Drożniak & Ernest Fichtner
* Text Domain: declaration
* Version: 1.1
*/

if(defined('WP_DEBUG') && WP_DEBUG) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'debugger.php';
}

define( 'DECLARATION_VERSION', '1.1' );

add_filter('plugins_api', 'declaration_plugin_info', 20, 3);
/*
 * $res empty at this step
 * $action 'plugin_information'
*/
function declaration_plugin_info( $res, $action, $args ) {
	// do nothing if this is not about getting plugin information
	if( 'plugin_information' !== $action ) {
		return false;
	}

	$plugin_slug = 'declaration'; // we are going to use it in many places in this function

	// do nothing if it is not our plugin
	if( $plugin_slug !== $args->slug ) {
		return false;
	}

	// trying to get from cache first
	if( false == $remote = get_transient( 'declaration_update_' . $plugin_slug ) ) {
		// info.json is the file with the actual plugin information on your server
		$remote = wp_remote_get( 'http://wptest.nowoczesnyurzad.pl/info.json', array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);

		if ( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
			set_transient( 'declaration_update_' . $plugin_slug, $remote, 43200 ); // 12 hours cache
		}
	}

	if( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
        $remote = json_decode( $remote['body'] );

        $res = new stdClass();

        $res->name = 'Declaration';
		$res->slug = $plugin_slug;
		$res->version = $remote->version;
		$res->tested = $remote->tested;
		$res->requires = $remote->requires;
		$res->author = 'Przemysław Drożniak & Ernest Fichtner';
		$res->download_link = $remote->download_url;
		$res->trunk = $remote->download_url;
		$res->requires_php = $remote->requires_php;
		$res->last_updated = $remote->last_updated;
		$res->sections = array(
			'description' => $remote->sections->description,
			'installation' => $remote->sections->installation
        );

        $res->banners = array(
			'low' => 'https://source.unsplash.com/random/772x250',
			'high' => 'https://source.unsplash.com/random/1544x500'
        );

		return $res;
	}

	return false;
}

add_filter('site_transient_update_plugins', 'declaration_push_update' );

function declaration_push_update( $transient ) {
	if ( empty($transient->checked ) ) {
        return $transient;
    }

	// trying to get from cache first, to disable cache comment 10,20,21,22,24
	if( false == $remote = get_transient( 'declaration_upgrade_declaration' ) ) {
		// info.json is the file with the actual plugin information on your server
		$remote = wp_remote_get( 'http://wptest.nowoczesnyurzad.pl/info.json', array(
			'timeout' => 10,
			'headers' => array(
				'Accept' => 'application/json'
			) )
		);

		if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
			set_transient( 'declaration_upgrade_declaration', $remote, 43200 ); // 12 hours cache
		}
	}

	if( $remote ) {
        $remote = json_decode( $remote['body'] );
		// your installed plugin version should be on the line below! You can obtain it dynamically of course
		if( $remote && version_compare(DECLARATION_VERSION, $remote->version, '<') ) {
			$res = new stdClass();
			$res->slug = 'declaration';
			$res->plugin = 'declaration/declaration.php'; // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
			$res->new_version = $remote->version;
			$res->tested = $remote->tested;
			$res->package = $remote->download_url;
           		$transient->response[$res->plugin] = $res;
                //$transient->checked[$res->plugin] = $remote->version;
        }
    }

    return $transient;
}

add_action( 'upgrader_process_complete', 'declaration_after_update', 10, 2 );

function declaration_after_update( $upgrader_object, $options ) {
	if ( $options['action'] == 'update' && $options['type'] == 'plugin' )  {
        // just clean the cache when new plugin version is installed
        delete_transient( 'declaration_upgrade_declaration' );
	}
}

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
            <label for="fullname" class="declaration-meta-form__label">imię i nazwisko osoby odpowiedzialnej za kontakt w sprawie niedostępności</label>
            <input type="text" id="fullname" name="fullname" class="declaration-meta-form__input" value="<?= $fullname[0]; ?>">
        </div>

        <div class="declaration-meta-form__row">
            <label for="publish-date" class="declaration-meta-form__label">Data publikacji strony internetowej (Format: RRRR-MM-DD):</label>
            <input type="text" id="publish-date" name="publish-date" class="declaration-meta-form__input" value="<?= $publish_date[0]; ?>">
        </div>

        <div class="declaration-meta-form__row">
            <label for="address-email" class="declaration-meta-form__label">Adres poczty elektronicznej osoby kontaktowej</label>
            <input type="email" id="address-email" name="address-email" class="declaration-meta-form__input" value="<?= $address_email[0]; ?>">
        </div>

        <div class="declaration-meta-form__row">
            <label for="phone-number" class="declaration-meta-form__label">Numer telefonu do osoby kontaktowej</label>
            <input type="text" id="phone-number" name="phone-number" class="declaration-meta-form__input" value="<?= $phone_number[0]; ?>">
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-1" class="declaration-meta-form__label">Opis dostępności wejścia do budynku i przechodzenia przez obszary kontrolii</label>
            <textarea name="accessibility-1" id="accessibility-1" cols="30" rows="10" class="declaration-meta-form__textarea"><?= $accessibility_1[0]; ?></textarea>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-2" class="declaration-meta-form__label">Opis dostępności korytarzy, schodów i wind</label>
            <textarea name="accessibility-2" id="accessibility-2" cols="30" rows="10" class="declaration-meta-form__textarea"><?= $accessibility_2[0]; ?></textarea>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-3" class="declaration-meta-form__label">Opis dostosowań, na przykład pochylni, platform, informacji głosowych, pętlach indukcyjnych</label>
            <textarea name="accessibility-3" id="accessibility-3" cols="30" rows="10" class="declaration-meta-form__textarea"><?= $accessibility_3[0]; ?></textarea>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-4" class="declaration-meta-form__label">Informacje o miejscu i sposobie korzystania z miejsc parkingowych wyznaczonych dla osób niepełnosprawnych</label>
            <textarea name="accessibility-4" id="accessibility-4" cols="30" rows="10" class="declaration-meta-form__textarea"><?= $accessibility_4[0]; ?></textarea>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-5" class="declaration-meta-form__label">Informacja o prawie wstępu z psem asystującym i ewentualnych uzasadnionych ograniczeniach</label>
            <textarea name="accessibility-5" id="accessibility-5" cols="30" rows="10" class="declaration-meta-form__textarea"><?= $accessibility_5[0]; ?></textarea>
        </div>

        <div class="declaration-meta-form__row">
            <label for="accessibility-6" class="declaration-meta-form__label">Informacje o możliwości skorzystania z tłumacza języka migowego na miejscu lub online. W przypadku braku takiej możliwości, taką informację także należy zawrzeć</label>
            <textarea name="accessibility-6" id="accessibility-6" cols="30" rows="10" class="declaration-meta-form__textarea"><?= $accessibility_6[0]; ?></textarea>
        </div>

        <div class="declaration-meta-form__row">
            <label for="mobile-app-android" class="declaration-meta-form__label">(Android) Wymienić aplikacje oraz informację skąd można je pobrać</label>
            <input type="text" id="mobile-app-android" name="mobile-app-android" class="declaration-meta-form__input" value="<?= $mobile_app_android[0]; ?>">
        </div>

        <div class="declaration-meta-form__row">
            <label for="mobile-app-ios" class="declaration-meta-form__label">(iOS) Wymienić aplikacje oraz informację skąd można je pobrać</label>
            <input type="text" id="mobile-app-ios" name="mobile-app-ios" class="declaration-meta-form__input" value="<?= $mobile_app_ios[0]; ?>">
        </div>
    </div>
<?php } }

// Declaration admin styles
if(! function_exists('declaration_styles')) {
	function declaration_styles() {
		$styles_path = plugins_url('declaration') . '/assets/css/style.css';

		wp_enqueue_style('declaration', $styles_path);
	}

	add_action('wp_head', 'declaration_styles');
	add_action('admin_enqueue_scripts', 'declaration_styles');
}
// Declaration front styles

// Save custom meta data when post publish
if(! function_exists('save_details')) {
	function save_details() {
		global $post;

        if(!empty($post)) {
            $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

            if($pageTemplate == 'declaration.php' ) {
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
                    update_post_meta($post->ID, "mobile-app-android", strip_tags( $_POST["mobile-app-android"] ));
                }
                if(isset($_POST['mobile-app-ios'])) {
                    update_post_meta($post->ID, "mobile-app-ios", strip_tags( $_POST["mobile-app-ios"] ));
                }
            }
        }
    }
    add_action('save_post', 'save_details', 100);
}

// Delete transient
delete_transient( 'declaration_upgrade_declaration' );
