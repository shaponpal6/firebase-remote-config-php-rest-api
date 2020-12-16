<?php

require_once 'firebase-remote-config.php';

add_action( 'wp_ajax_cwv_tracking', 'cwv_tracking' );
function cwv_tracking2() {
    if(class_exists('CWVRemoteConfig')){
    $date = (new \DateTime('UTC'))->format('Y-m-d\TH:i:s\Z');
    $config = new CWVRemoteConfig();
    $config->setTemplate('one1223333333', 'one value', 'one Duration');
    // print_r($config->getTemplate() );
	global $wpdb;
	$whatever = intval( $_POST['whatever'] );
	$whatever += 10;
        //echo $whatever;
        $return = array(
            'message'  => $whatever,
            'ID'       => 1
        );
         
        wp_send_json($return);
    }
	wp_die();
}

function cwv_tracking($request) {
    if(class_exists('CWVRemoteConfig')){
        $date = (new \DateTime('UTC'))->format('Y-m-d\TH:i:s\Z');
        $data = array(
            'ID'       => 1,
            'lastUpdated'  => $date,
            'type'       => 'fatch_visitors',
        );
        $config = new CWVRemoteConfig();
        $config->setTemplate('cwv_tracking', json_encode($data), 'Description here');
        
        wp_send_json($data);
    }
	wp_die();
}

add_action('rest_api_init', function () {
    register_rest_route( 'cwvchat/v1', 'tracking/',array(
        'methods'  => 'POST',
        'callback' => 'cwv_tracking',
    ));
    register_rest_route( 'cwvchat/v1', 'tracking/',array(
        'methods'  => 'GET',
        'callback' => 'cwv_tracking',
    ));
  });


// echo admin_url( 'admin-ajax.php' );

add_action( 'wp_footer', 'cwv_script' );
function cwv_script() {
    echo '<h1 id="cwvTracking" style="position: fixed;top: 200px;"><button>Tracking Click</button></h1>';
	?>
    <script>
    const btn = document.getElementById('cwvTracking');
    if(btn){
        btn.addEventListener('click', function(e){
            console.log('e', e)
            jQuery.post(
                'http://localhost/wordpress/wp-admin/admin-ajax.php', 
                {
                    'action': 'cwv_tracking',
                    'whatever':   123
                }, 
                function(response) {
                    console.log('The server responded: ', response);
                }
            );
        })
    }
    console.log('object :>> ', 'here................');
    </script>
    <?php
}


function add_cors_http_header(){
    header("Access-Control-Allow-Origin: *");
}
add_action('init','add_cors_http_header');