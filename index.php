<!-- Change the Login Logo admin -->
function my_custom_login_logo() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo_url = wp_get_attachment_image_src( $custom_logo_id , 'full' )[0];
    echo '<style type="text/css">
        body.login div#login h1 a {
            background-image: url('.$logo_url.') !important;
            background-size: contain;
            height: 100px;
            width: auto;
        } 
    </style>';
}
add_action( 'login_enqueue_scripts', 'my_custom_login_logo' );


<!-- Link payment for order pending -->
$order->get_checkout_payment_url()


<!-- Update fee -->
add_action('woocommerce_checkout_order_review','show_discount_from_point',9);
add_action('wp_ajax_update_fee', 'tgb_update_fee');
add_action('wp_ajax_nopriv_update_fee', 'tgb_update_fee');
function tgb_update_fee() {
    $manual_point = (int)$_POST['manual_point'];
    echo $manual_point;
    WC()->session->set( 'number_point_applied' , $manual_point );
}

add_action( 'woocommerce_cart_calculate_fees','woocommerce_custom_surcharge', 10, 1 );
function woocommerce_custom_surcharge( $cart_object ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    $manual_point = WC()->session->get( 'number_point_applied' );
    $payment_method = WC()->session->get('chosen_payment_method');
    
    if($manual_point > 0 && $payment_method != 'tgbpoint'){
        // $user_id = get_current_user_id();
        // $tgbpoint = new TgbPoint($user_id);
        $point_text = 'Points used ('.$manual_point.' points)';
        $cart_object->add_fee( $point_text, -$manual_point, true, '' );
    }
}

add_action('woocommerce_checkout_order_processed', 'enroll_student', 10, 1);
function enroll_student($order_id){
    WC()->session->set( 'number_point_applied', 0 );
    $order = new WC_Order($order_id);
}
<!-- End update fee -->

<!-- Remove password verify default wordpress -->
function iconic_remove_password_strength() {
    wp_dequeue_script( 'wc-password-strength-meter' );
}
add_action( 'wp_print_scripts', 'iconic_remove_password_strength', 10 );


<!-- Đổ tên và sắp xếp My account -->
function my_custom_my_account_menu_items( $items ) {
    $items = array(
        'orders'            => __( 'Booking details', 'woocommerce' ),
        'dashboard'         => __( 'Point details', 'woocommerce' ),
        'edit-address'    => __( 'Addresses', 'woocommerce' ),
        // 'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
        'edit-account'      => __( 'Account detail', 'woocommerce' ),
        'customer-logout'   => __( 'Logout', 'woocommerce' ),
    );

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'my_custom_my_account_menu_items' );
