<?php
/**
 * Plugin Name: Ajax 
 * Author: Rupom
 * Desciption: Plugin description
 * Version: 1.0
 */

function callback_enqueue_scripts(){
    wp_enqueue_style( 'ajax_css', plugin_dir_url( __FILE__ ).'/assets/css/style.css',null);
    wp_enqueue_script( 'ajax_js',plugin_dir_url( __FILE__ ).'/assets/js/main.js', array('jquery'), time(), true );
    $action = 'aj_protected';
    $aj_nonce = wp_create_nonce($action);
    wp_localize_script('ajax_js', 'plugin_data',array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'aj_nonce' => $aj_nonce
    ));
}
add_action( 'admin_enqueue_scripts','callback_enqueue_scripts');

function menu_ajax_callback(){
   ?>
   <button class="action_button" data-task="demo_data"> demo </button>
   <button class="action_button" data-task="more_data"> more  </button>
   <button class="action_button" data-task="ajax_nonce"> nonce  </button>
   <h1 class="mydata"></h1>
   <h1 class="moredata"></h1>
   <h1 class="securedata"></h1>
   <?php
}
add_action( 'admin_menu',function(){
    add_menu_page('ajax_demo', 'Ajax_demo', 'manage_options', 'my_ajax', 'menu_ajax_callback');
});
function action_aj_callback(){
    $data = [
        'name' => 'rupom',
        'url_data' => admin_url(),
    ];
    // $data = $_POST['data'];
    wp_send_json($data['name']);
    die();
}
add_action( 'wp_ajax_aj_simple', 'action_aj_callback');

add_action( 'wp_ajax_ajax_more', function(){
    $more_data = [
        'a_name' => 'mohrajul',
        'home' => 'rangpur'
    ];
    $dt = $_POST['data'];
    wp_send_json($dt);
    die();
});
add_action( 'wp_ajax_aj_protected', function(){
    $secure = [
        'massage' => 'author',
    ];
    $nonce = $_POST['a_nonce'];
    $action = 'aj_protected';
    if(wp_verify_nonce($nonce, $action)){
        wp_send_json($secure);
    }else{
        echo('not author');
    }
    die();
});
?>