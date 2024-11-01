<?php

/*
Plugin Name: Unique Content
Plugin URI: https://codenpy.com/item/youcontent
Description: Unlimited unique content generator from youtube captions.
Author: Codenpy
Version: 1.2.1
Author URI: https://codenpy.com
*/



function youcontent_admin_script(){

    wp_enqueue_script('youcontent', plugins_url( 'youcontent.js', __FILE__ ) );
    wp_enqueue_style('youcontent', plugins_url( 'youcontent.css', __FILE__ ) );

}
add_action('admin_enqueue_scripts','youcontent_admin_script');


// Move metabox above the default editor
add_action('edit_form_after_title', function() {
    global $post, $wp_meta_boxes;
    do_meta_boxes(get_current_screen(), 'youcontent', $post);
    unset($wp_meta_boxes[get_post_type($post)]['youcontent']);
});



/**
 * Register meta box(es).
 */
function youcontent_register_meta_box() {
    add_meta_box( 'youcontent-metabox', esc_html__( 'YouContent', 'youcontent' ), 'youcontent_display_callback', 'post', 'youcontent', 'high',
        array(
            '__back_compat_meta_box' => true,
        )
    );
}
add_action( 'add_meta_boxes', 'youcontent_register_meta_box' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function youcontent_display_callback( $post ) {
?>

    <form method="GET">

        <input type="text" name="video_id" size="40" value="" id="video_id" placeholder="insert youtube video id, ex: HAnw168huqA" >
        
        <select name="lang" class="lang" id="lang">
        <option value="en">English</option>
            <option value="fr">French</option>
            <option value="de">Germany</option>
            <option value="es">Spanish</option>
            <option value="ru">Russian</option>
            <option value="sv">Swedish</option>
            <option value="uk">Ukrainian</option>
            <option value="pl">Polish</option>
            <option value="ro">Romanian</option>
            <option value="ar">Arabic</option>
            <option value="ja">Japanis</option>
            <option value="bg">Bulgarian</option>
            <option value="nl">Dutch</option>
            <option value="el">Greek</option>
            <option value="bs">Bosnian</option>
            <option value="hr">Croatian</option>
            <option value="pt">Portuguese (Portugal, Brazil)</option>

        </select>

        <?php

        wp_nonce_field( 'video_id_nonce_action', 'video_id' );

        ?>

        <input type="submit" name="run" id="ycrun" class="run-btn gradient-btn" value="<?php echo esc_attr( 'RUN' ); ?>">

        <input type="text" name="words_count" size="22" id="words_count">

        <div class="yc-ins">

            <p><?php _e( 'Please switch your editor to "Text" mode', 'youcontent' ) ?></p>
            
            <p><?php _e( 'Insert Youtube video "id", select language and click RUN - Ex:', 'youcontent' ) ?> <del>https://www.youtube.com/watch?v=</del><span style="color: green">HAnw168huqA</span></p>

            <p><?php _e( 'Make sure, Youtube video has CC, otherwise it won\'t work', 'youcontent' ) ?></p>

            <h3><?php _e( 'In FREE version you will get only 200 words, <a target="_blank" href="https://codenpy.com/item/unique-content-unlimited-unique-content-generator-from-youtube-captions-pro/">buy pro version to get all words for $19</a>', 'youcontent' ) ?></h3>

        </div>

    </form>

    <div id="loader" style="display:none; text-align: center;"><img src="<?= plugins_url( 'ajax-loader.gif', __FILE__ )?>"/></div>

<?php  
}