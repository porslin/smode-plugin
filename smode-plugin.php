<?php
/**
 * Plugin Name: Smode Plugin
 * Description: Plugin för att kontrollera status på hemsidans olika delar.
 * Plugin URI: http://example.com/smode-plugin
 * Version: 2.3
 * Author: Haashira
 * Author URI: http://haashira.com/
 * Text Domain: smode-plugin
 * 
 * @package SmodePlugin
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2022 Automattic, Inc.
*/

// Add stylesheets
add_action('admin_enqueue_scripts', 'reg_stylesheets');

function reg_stylesheets()
{
    wp_enqueue_style('cover_stylesheet', plugins_url('assets/css/styles.css', __FILE__));
}

// Add js or jQuery files
add_action('admin_enqueue_scripts', 'reg_scripts');

add_action('wp_ajax_save_answer', 'save_answer');
add_action('wp_ajax_nopriv_save_answer', 'save_answer');

function save_answer()
{
    check_ajax_referer('save_answer_nonce', 'security');
    global $wpdb;

    $current_user = wp_get_current_user();

    $question_id = isset($_POST['question_id']) ? intval($_POST['question_id']) : 0;
    $control_value = isset($_POST['control_value']) ? intval($_POST['control_value']) : 0;

    //echo "<pre>";
    //print_r($question_id);
    //echo "</pre>";

    // Check if answer already exists
    $existingAnswer = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}smode_answers WHERE questionId = %d", $question_id));

    if ($existingAnswer) {
        // Update existing answer
        $wpdb->update(
            "{$wpdb->prefix}smode_answers",
            array(
                'control_value' => $control_value,
                'modified_at' => current_time('mysql'),
                'modified_by' => get_current_user()
            ),
            array('id' => $existingAnswer->id),
            array('%d', '%s', '%s'),
            array('%d')
        );

        // echo 'Answer updated successfully';

    } else {
        // Insert new answer
        $wpdb->insert(
            "{$wpdb->prefix}smode_answers",
            array(
                'questionId' => $question_id,
                'control_value' => $control_value,
                'created_at' => current_time('mysql'),
                'created_by' => get_current_user(),
                'modified_at' => current_time('mysql'),
                'modified_by' => get_current_user()
            ),
            array('%d', '%d', '%s', '%s', '%s', '%s')
        );

        // echo 'Answer saved successfully';
        
    }
    wp_send_json($response);

    wp_die(); // Always include
}

function reg_scripts()
{

    wp_enqueue_script('js_file', plugins_url('assets/js/script.js', __FILE__));
    //wp_localize_script('js_file', 'js_file_vars', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_localize_script('js_file', 'js_file_vars', array('ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('save_answer_nonce')));
}

function custom_function4() {

    include_once('plugin_page3.php');
    SMP_insert_data();
}

function custom_function5() {

    include_once('plugin_page4.php');
    // save_answer();

    // enqueue tab scripts and styles
    wp_enqueue_script('jquery');
    wp_enqueue_script('tabs-script', plugins_url('assets/js/tabs.js', __FILE__));
    wp_enqueue_style('tabs-style', plugins_url('assets/css/tabs.css', __FILE__));

}

function custom_function6() {

    include_once('plugin_page5.php');
}

if( !defined('ABSPATH') ) {
    die('You cannot be here');
}

// register hook
register_activation_hook(__FILE__, 'SMP_tb_create');


// Creating DB table for plugin

function SMP_tb_create() {
    
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    $table_one = $wpdb->prefix .'smode_questions';

    $sql = "CREATE TABLE $table_one (
        id int(10) NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        categoryId int(10) NOT NULL,
        controlType varchar(255) NOT NULL,
        PRIMARY KEY (id)
        ) $charset_collate;";      
        dbDelta($sql);

    $checks = array(
        array(
            'title' => 'CSS fungerar',
            'categoryId' => '1',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'JS fungerar',
            'categoryId' => '1',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Typsnitt fungerar',
            'categoryId' => '1',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Responsiviteten fungerar',
            'categoryId' => '1',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Menyn fungerar',
            'categoryId' => '1',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Alla sidor har innehåll',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Korrekta uppgifter i sidfot/sidhuvud',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Alla länkar fungerar och pekar rätt',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Bilder ser bra ut på stor skärm',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Bilder ser bra ut på liten skärm',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Bilder och videoklipp anpassar sig',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Favicon finns och är rätt',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Rätt logotyp samt klickbar',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Texter är fria från felstavningar',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'All "Lorem ipsum"-text är borttagen',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Hemsidans primära delar fungerar även om JS är avaktiverat i webbläsaren',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Sidans tagline är rätt ("Just another Wordpress-site")',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Alla eventuella stock-bilder är köpta och inlagda',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Färger visas enligt kundens profil',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Sidan är testad i riktig mobil',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Sharethis är inlagt med unikt konto',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Sidan kör HTTPS och ALLA externa resources läses in via HTTPS',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Demobilder och Dreamstime-bilder är borttagna',
            'categoryId' => '2',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'CSS & HTML validerar bra',
            'categoryId' => '3',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Sidan laddar inom 2-3 sekunder',
            'categoryId' => '3',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Bilder är optimerade (filstorlek)',
            'categoryId' => '3',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Element i form av bilder som kan bytas ut mot ren CSS finns på sidan',
            'categoryId' => '3',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'All mixed-content är borttaget',
            'categoryId' => '4',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Sidan fungerar med www, utan www, med http:// och med https://',
            'categoryId' => '4',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Alla formulär fungerar (skicka, få bekräftelse, tvingande fält, valbara fält)',
            'categoryId' => '5',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Det är rätt mottagare för formulär',
            'categoryId' => '5',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Alla sökfält fungerar',
            'categoryId' => '5',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Hover-effekter förvandlats till annat på touch-enheter',
            'categoryId' => '5',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Kassan fungerar även i mobilen (om sidan är webbshop)',
            'categoryId' => '5',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'GDPR-plugin är installerat och fungerande',
            'categoryId' => '5',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Övriga basplugins är installerade',
            'categoryId' => '5',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Sidan innehåller rätt sökord och de förekommer naturligt i texten',
            'categoryId' => '6',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Bilderna har försetts med beskrivande text (alt-text)',
            'categoryId' => '6',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Alla kundens domäner pekar rätt',
            'categoryId' => '6',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Alla aktiva plugins används',
            'categoryId' => '7',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'All plugins och teman är up to date',
            'categoryId' => '7',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => '“Discourage search engines from indexing this site” är bortkryssad',
            'categoryId' => '7',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Cookieplugin är installerat',
            'categoryId' => '7',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'En custom 404-sida finns och det är inte en standardtext från en template',
            'categoryId' => '7',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Kunden kan skapa inlogg',
            'categoryId' => '8',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Payment fungerar',
            'categoryId' => '8',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Öppna developer tools i console fliken',
            'categoryId' => '10',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Alla varningar i devtools är åtgärdade',
            'categoryId' => '10',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Stämmer resultat och offert överens?',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Har vi erbjudit kunden några kringtjänster?',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Är 301:or förberedda och klara?',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Har vi inloggningen till domännamnet?',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Testat inloggningen till domännanmnet?',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Mejlat förfrågan om skriftligt godkännande till kund',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Kollat att all SEO på gamla sajten är med! Om detta ska med?',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Är SSL klart?',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'API  för captcha-skydd',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Kolla att START/HEM har meta data (test-dela på FB för att se vilken info FB väljer.)',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Rutinen för "systemtest" är klar',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Testat hemsidan ONLINE?',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Testat adminverktygen ONLINE?',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Kolla att ALL testdata är raderad! (Bilder, texter mm mm)',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Dubbelkolla att robots.txt är uppdaterad med sidans domän. robots.txt ska ha senaste version/format (enligt smode.se på Smode03, som vi använder som "master")  (Se http://smode.se/robots.txt för exempel)',
            'categoryId' => '11',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Har du kollat igenom konfig?',
            'categoryId' => '12',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Peka om hemsidan',
            'categoryId' => '12',
            'controlType' => 'checkbox'
        ),
        array(
            'title' => 'Uppdatera inloggningsuppgifterna i konfigmappen från t ex wp.nysida.se/wp-login till minriktigadomän.se/wp-login',
            'categoryId' => '13',
            'controlType' => 'checkbox'
        )

    );

    foreach ( $checks as $check ) {
        $wpdb->insert( $table_one, $check );
    }


    $table_answers = $wpdb->prefix .'smode_answers';

    $sql = "CREATE TABLE $table_answers (
        id INT NOT NULL AUTO_INCREMENT,
        questionId INT NOT NULL,
        control_value INT NOT NULL,
        created_at DATETIME NOT NULL,
        created_by varchar(255) NOT NULL,
        modified_at DATETIME,
        modified_by varchar(255),
        PRIMARY KEY (id)
        ) $charset_collate;";
        dbDelta($sql);



    $table_categories = $wpdb->prefix .'smode_categories';

    $sql = "CREATE TABLE $table_categories (
        id int(10) NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        PRIMARY KEY (id)
        ) $charset_collate;";
        dbDelta($sql);

    // Insert the fixed category data
    $categories = array(
        array(
            'id' => '1',
            'title' => 'Webbläsare'
        ),
        array(
            'id' => '2',
            'title' => 'Innehåll'
        ),
        array(
            'id' => '3',
            'title' => 'Prestanda'
        ),
        array(
            'id' => '4',
            'title' => 'Säkerhet & Trovärdighet'
        ),
        array(
            'id' => '5',
            'title' => 'Funktionalitet'
        ),
        array(
            'id' => '6',
            'title' => 'SEO'
        ),
        array(
            'id' => '7',
            'title' => 'Wordpress'
        ),
        array(
            'id' => '8',
            'title' => 'Woocommerce'
        ),
        array(
            'id' => '9',
            'title' => 'Projektspecifikt'
        ),
        array(
            'id' => '10',
            'title' => 'Dev-tools'
        ),
        array(
            'id' => '11',
            'title' => 'Inför'
        ),
        array(
            'id' => '12',
            'title' => 'Ompekning'
        ),
        array(
            'id' => '13',
            'title' => 'Uppföljning'
        )
    );

    foreach ( $categories as $category ) {
        $wpdb->insert( $table_categories, $category );
    }

}


add_action( 'admin_menu','custom_function1' ); 

function custom_function1() {
    // first part of function
    add_menu_page( 
    // second part of function
        'Smode Plugin',         // page title 
        'Smode Plugin',         // menu title,
        'manage_options',       // capability,
        'smode_plugin',         // menu slug, 
        'custom_function2',     // callable function,
        '',                     // icon url,
        2                       // position
        );
    add_submenu_page( 

        'smode_plugin', 
        'Hårdkodad Checklista', 
        'Hårdkodade kontroller', 
        'manage_options', 
        'smode_plugin2',
        'custom_function3'
    );
    add_submenu_page( 
        
        'smode_plugin', 
        'Skapa ny kontroll', 
        'Administrera kontroller', 
        'manage_options',
        'smode_plugin3', 
        'custom_function4'
    );
    add_submenu_page( 
        
        'smode_plugin', 
        'Kontroller från DB', 
        'Kör kontroller', 
        'manage_options',
        'smode_plugin4', 
        'custom_function5'
    );
    add_submenu_page( 
        
        'smode_plugin', 
        'Tidigare kontroller', 
        'Tidigare kontroller', 
        'manage_options',
        'smode_plugin5', 
        'custom_function6'
    );
}

function custom_function2() {

    include_once('plugin_page1.php');
    php_design();
}

function custom_function3() {

    include_once('plugin_page2.php');
}


?>

