<?php
/**
* @package Declaration
*/

if(! class_exists('DeclarationActivation')) {
    class DeclarationActivation {
        // Create pages
       static private function create_pages_fly($pageName, $parent = 0, $pageTemplate = '') {
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
                add_option('declaration_page_id', $pageID);
            }
            return $pageID;
        }
        
        static public function activate() {
            if(get_page_by_title( 'Deklaracja dostępności' ) === NULL) {
                $parent = DeclarationActivation::create_pages_fly( 'Deklaracja dostępności', 0, 'declaration.php' );
            } else {
                wp_untrash_post(get_option('declaration_page_id'));
            }
            // Flush rewrite rules
            flush_rewrite_rules();
        }
    }
}