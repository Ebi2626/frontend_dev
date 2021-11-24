<?php
// Theme supports
add_action( 'after_setup_theme', 'frontenddev_setup' );
function frontenddev_setup() {
    load_theme_textdomain( 'frontenddev', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'search-form' ) );

    global $content_width;
    if ( !isset( $content_width ) ) { 
        $content_width = 1920; 
    }

    register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'frontenddev' ) ) );
}

// Enaqueue styles and scripts
add_action( 'wp_enqueue_scripts', 'frontenddev_enqueue' );
function frontenddev_enqueue() {
    wp_enqueue_style( 'frontenddev-style', get_stylesheet_uri() );
    wp_enqueue_script( 'jquery' );
}

// Device detection in footer
add_action( 'wp_footer', 'frontenddev_footer' );
function frontenddev_footer() {
?>

<script>
jQuery(document).ready(function($) {
var deviceAgent = navigator.userAgent.toLowerCase();
if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
$("html").addClass("ios");
}
if (navigator.userAgent.search("MSIE") >= 0) {
$("html").addClass("ie");
}
else if (navigator.userAgent.search("Chrome") >= 0) {
$("html").addClass("chrome");
}
else if (navigator.userAgent.search("Firefox") >= 0) {
$("html").addClass("firefox");
}
else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
$("html").addClass("safari");
}
else if (navigator.userAgent.search("Opera") >= 0) {
$("html").addClass("opera");
}
});
</script>

<?php
}



add_filter( 'document_title_separator', 'frontenddev_document_title_separator' );
function frontenddev_document_title_separator( $sep ) {
    $sep = '|';
    return $sep;
}

add_filter( 'the_title', 'frontenddev_title' );
function frontenddev_title( $title ) {
    if ( $title == '' ) {
        return '...';
    } else {
        return $title;
    }
}

add_filter( 'nav_menu_link_attributes', 'frontenddev_schema_url', 10 );
function frontenddev_schema_url( $atts ) {
    $atts['itemprop'] = 'url';
    return $atts;
}

if ( !function_exists( 'frontenddev_wp_body_open' ) ) {
    function frontenddev_wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

// Add skiplink
add_action( 'wp_body_open', 'frontenddev_skip_link', 5 );
function frontenddev_skip_link() {
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'frontenddev' ) . '</a>';
}

add_filter( 'the_content_more_link', 'frontenddev_read_more_link' );
function frontenddev_read_more_link() {
    if ( !is_admin() ) {
        return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'frontenddev' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
    }
}

add_filter( 'excerpt_more', 'frontenddev_excerpt_read_more_link' );
function frontenddev_excerpt_read_more_link( $more ) {
    if ( !is_admin() ) {
        global $post;
        return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'frontenddev' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
    }
}

add_filter( 'big_image_size_threshold', '__return_false' );

// Overriding images sizing
add_filter( 'intermediate_image_sizes_advanced', 'frontenddev_image_insert_override' );
function frontenddev_image_insert_override( $sizes ) {
    unset( $sizes['medium_large'] );
    unset( $sizes['1536x1536'] );
    unset( $sizes['2048x2048'] );
    return $sizes;
}

// Register sidebar widget area
add_action( 'widgets_init', 'frontenddev_widgets_init' );
function frontenddev_widgets_init() {
    register_sidebar( array(
        'name' => esc_html__( 'Sidebar Widget Area', 'frontenddev' ),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
        ) 
    );
}

add_action( 'wp_head', 'frontenddev_pingback_header' );
function frontenddev_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}

// Support for comments threading
add_action( 'comment_form_before', 'frontenddev_enqueue_comment_reply_script' );
function frontenddev_enqueue_comment_reply_script() {
    if ( get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function frontenddev_custom_pings( $comment ) {
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
<?php
}

add_filter( 'get_comments_number', 'frontenddev_comment_count', 0 );
function frontenddev_comment_count( $count ) {
    if ( !is_admin() ) {
        global $id;
        $get_comments = get_comments( 'status=approve&post_id=' . $id );
        $comments_by_type = separate_comments( $get_comments );
        return count( $comments_by_type['comment'] );
    } else {
        return $count;
    }
}