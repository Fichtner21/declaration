<?php
/**
* @package Declaration
*/

if(! class_exists('DeclarationDeactivation')) {
    class DeclarationDeactivation {
        static public function deactivate() {
            // Delete page on deactivation
            $declaration_page = get_page_by_path('deklaracja-dostepnosci');
            
            wp_delete_post($declaration_page->ID, false);
            
            // // Flush rewrite rules
            flush_rewrite_rules();
        }
    }
}