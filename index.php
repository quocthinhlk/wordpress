<!-- Change the Login Logo admin -->
function my_custom_login_logo() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo_url = wp_get_attachment_image_src( $custom_logo_id , 'full' )[0];
    echo '<style type="text/css">
        body.login div#login h1 a {
            background-image: url('.$logo_url.');
            background-size: contain;
            height: 100px;
            width: auto;
        } 
    </style>';
}
add_action( 'login_enqueue_scripts', 'my_custom_login_logo' );
