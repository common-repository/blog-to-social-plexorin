<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function bts_plexorin_admin_menu() {
    add_menu_page(
        'Plexorin Blog to Post', // Page title
        'Plexorin', // Menu title
        'manage_options', // Capability
        'bts-plexorin-settings', // Menu slug
        'bts_plexorin_settings_page', // Callback function
        'dashicons-admin-generic', // Icon URL
        25 // Position
    );
}
add_action('admin_menu', 'bts_plexorin_admin_menu');

add_action('admin_enqueue_scripts', 'bts_plexorin_enqueue_admin_scripts');
function bts_plexorin_enqueue_admin_scripts($hook) {
    if ($hook != 'toplevel_page_bts-plexorin-settings') {
        return;
    }
    
    // JS dosyasını ekleyin
    wp_enqueue_script('plugin-custom-js', plugin_dir_url(__FILE__) . '../js/main.js', array('jquery'), '1.0', true);

    // CSS dosyasını ekleyin
    wp_enqueue_style('plugin-custom-css', plugin_dir_url(__FILE__) . '../css/style.css', array(), '1.0');
}

function bts_plexorin_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Plexorin Social Media Auto Sharing Tool Settings', 'bts_plexorin'); ?></h1>
        <div class="settings-container">
            <div class="settings-form">
                <form method="post" action="options.php">
                    <?php
                    settings_fields('bts_plexorin_settings_group');
                    do_settings_sections('bts-plexorin-settings');
                    submit_button('Kaydet', 'primary', 'save_changes');
                    ?>
                </form>
            </div>
            <div class="preview-section">
                <div class="preview">
                    <h2><?php esc_html_e('Twitter Preview', 'bts_plexorin'); ?></h2>
                    <p style="font-size:12px; color: red"><?php esc_html_e('There is a 300 character limit for Twitter, only the first 300 characters of the content will be shared!', 'bts_plexorin'); ?></p>
                    <hr>
                    <div id="twitter-preview-content">
                        <p class="content-title"><?php esc_html_e('(Post Title) Share Your Content Automatically on Social Media with Plexorin!', 'bts_plexorin'); ?></p>
                        <p class="content-link"><?php esc_html_e('(Post URL) https://plexorin.com/tr/', 'bts_plexorin'); ?></p>
                        <p class="content-hashtag"><?php esc_html_e('(Hashtags) #plexorin #socialmediascheduler #socialmedia', 'bts_plexorin'); ?></p>
                        <img class="content-url" src="<?php echo esc_url(plugins_url('../img/default.webp', __FILE__)); ?>" style="width: 100%">
                    </div>
                </div>
                <div class="preview">
                    <h2>Facebook Önizleme</h2>
                    <hr>
                    <div id="facebook-preview-content">
                        <p class="content-title"><?php esc_html_e('(Post Title) Share Your Content Automatically on Social Media with Plexorin!', 'bts_plexorin'); ?></p>
                        <p class="content-description"><?php esc_html_e('(News Description) Connect your social media accounts to Plexorin, then add the API key created for you from the plugin settings page. Shares will be made automatically on the accounts you choose in your Plexorin account.', 'bts_plexorin'); ?></p>
                        <p class="content-link"><?php esc_html_e('(Post URL) https://plexorin.com/tr/', 'bts_plexorin'); ?></p>
                        <p class="content-hashtag"><?php esc_html_e('(Hashtags) #plexorin #socialmediascheduler #socialmedia', 'bts_plexorin'); ?></p>
                        <img class="content-url" src="<?php echo esc_url(plugins_url('../img/default.webp', __FILE__)); ?>" style="width: 100%">
                    </div>
                </div>
                <div class="preview">
                    <h2>Instagram Önizleme</h2>
                    <hr>
                    <div id="instagram-preview-content">
                        <p class="content-title"><?php esc_html_e('(Post Title) Share Your Content Automatically on Social Media with Plexorin!', 'bts_plexorin'); ?></p>
                        <p class="content-description"><?php esc_html_e('(News Description) Connect your social media accounts to Plexorin, then add the API key created for you from the plugin settings page. Shares will be made automatically on the accounts you choose in your Plexorin account.', 'bts_plexorin'); ?></p>
                        <p class="content-link"><?php esc_html_e('(Post URL) https://plexorin.com/tr/', 'bts_plexorin'); ?></p>
                        <p class="content-hashtag"><?php esc_html_e('(Hashtags) #plexorin #socialmediascheduler #socialmedia', 'bts_plexorin'); ?></p>
                        <img class="content-url" src="<?php echo esc_url(plugins_url('../img/default.webp', __FILE__)); ?>" style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function bts_plexorin_register_settings() {
    register_setting('bts_plexorin_settings_group', 'bts_plexorin_settings', 'bts_plexorin_sanitize_settings');

    add_settings_section('bts_plexorin_main_section', '', null, 'bts-plexorin-settings');

    add_settings_field('bts_plexorin_api_key', 'API Key', 'bts_plexorin_api_key_callback', 'bts-plexorin-settings', 'bts_plexorin_main_section');
    add_settings_field('bts_plexorin_users', 'Choose Users', 'bts_plexorin_users_callback', 'bts-plexorin-settings', 'bts_plexorin_main_section');
    add_settings_field('bts_plexorin_categories', 'Choose Category', 'bts_plexorin_categories_callback', 'bts-plexorin-settings', 'bts_plexorin_main_section');
    add_settings_field('bts_plexorin_default_title', 'Default Title Format', 'bts_plexorin_default_title_callback', 'bts-plexorin-settings', 'bts_plexorin_main_section');
    add_settings_field('bts_plexorin_default_description', 'Default Description Format', 'bts_plexorin_default_description_callback', 'bts-plexorin-settings', 'bts_plexorin_main_section');
    add_settings_field('bts_plexorin_default_hashtags', 'Default Hashtag Format', 'bts_plexorin_default_hashtags_callback', 'bts-plexorin-settings', 'bts_plexorin_main_section');
    add_settings_field('bts_plexorin_default_image', 'Default Cover Image', 'bts_plexorin_default_image_callback', 'bts-plexorin-settings', 'bts_plexorin_main_section');
}
add_action('admin_init', 'bts_plexorin_register_settings');

function bts_plexorin_api_key_callback() {
    $options = get_option('bts_plexorin_settings');
    echo '<input type="text" id="bts_plexorin_api_key" name="bts_plexorin_settings[api_key]" value="' . esc_attr($options['api_key']) . '" placeholder="API Anahtarınızı Giriniz">';
}

function bts_plexorin_users_callback() {
    $options = get_option('bts_plexorin_settings');
    $selected_users = $options['users'] ?? array();
    $users = get_users();
    ?>
    <div class="api-dependent">
        <p><?php esc_html_e('Select users to share with:', 'bts_plexorin'); ?></p>
        <?php foreach ($users as $user) : ?>
            <label>
                <input type="checkbox" name="bts_plexorin_settings[users][]" value="<?php echo esc_attr($user->ID); ?>" <?php checked(in_array($user->ID, $selected_users)); ?>>
                <?php echo esc_html($user->display_name); ?>
            </label><br>
        <?php endforeach; ?>
    </div>
    <?php
}

function bts_plexorin_categories_callback() {
    $options = get_option('bts_plexorin_settings');
    $selected_categories = $options['categories'] ?? array();
    $categories = get_categories(array('hide_empty' => false));
    ?>
    <div class="api-dependent">
        <p><?php esc_html_e('Select categories to share:', 'bts_plexorin'); ?></p>
        <?php foreach ($categories as $category) : ?>
            <label>
                <input type="checkbox" name="bts_plexorin_settings[categories][]" value="<?php echo esc_attr($category->term_id); ?>" <?php checked(in_array($category->term_id, $selected_categories)); ?>>
                <?php echo esc_html($category->name); ?>
            </label><br>
        <?php endforeach; ?>
    </div>
    <?php
}

function bts_plexorin_default_title_callback() {
    $options = get_option('bts_plexorin_settings');
    ?>
    <div class="api-dependent">
        <p><?php esc_html_e('Add the default header format. Valid variable: {post_title}', 'bts_plexorin'); ?></p>
        <br>
        <input id="title-input" style="width: 100%" type="text" name="bts_plexorin_settings[default_title]" value="<?php echo !empty($options['default_title']) ? esc_attr($options['default_title']) : esc_attr('{post_title}'); ?>" placeholder="<?php esc_attr_e('Örnek: {post_title} - Tamamını Oku!', 'bts_plexorin'); ?>">
    </div>
    <?php
}

function bts_plexorin_default_description_callback() {
    $options = get_option('bts_plexorin_settings');
    ?>
    <div class="api-dependent">
        <p><?php esc_html_e('Add the default description format. Valid variables: {post_title}, {post_description}, {post_link}, {hashtags}', 'bts_plexorin'); ?></p>
        <br>
        <textarea id="description-textarea" style="width: 100%" name="bts_plexorin_settings[default_description]" rows="7" placeholder="<?php esc_attr_e('Example: This post is about {post_title}. Click on the link to read more: {post_link}', 'bts_plexorin'); ?>"><?php echo !empty($options['default_description']) ? esc_textarea($options['default_description']) : esc_textarea('{post_description}
        
{post-link}
        
{hashtags}'); ?></textarea>
    </div>
    <?php
}

function bts_plexorin_default_hashtags_callback() {
    $options = get_option('bts_plexorin_settings');
    ?>
    <div class="api-dependent">
        <p><?php esc_html_e('Add default hashtags. You must use the {hashtags} variable in the description for it to be used.', 'bts_plexorin'); ?></p>
        <br>
        <input id="hashtag-input" style="width: 100%" type="text" name="bts_plexorin_settings[default_hashtags]" value="<?php echo esc_attr($options['default_hashtags'] ?? ''); ?>" placeholder="<?php esc_attr_e('Example: #plexorin #socialmediascheduler #socialmedia', 'bts_plexorin'); ?>">
    </div>
    <?php
}

function bts_plexorin_default_image_callback() {
    $options = get_option('bts_plexorin_settings');
    $image_id = $options['default_image'];
    $image_url = $image_id ? wp_get_attachment_url($image_id) : plugins_url('../img/default.webp', __FILE__);
    ?>
    <div class="api-dependent">
        <p><?php esc_html_e('If a post does not have a featured image, enter a link to the default featured image to use or select an image from the media library.', 'bts_plexorin'); ?></p>
        <input type="hidden" id="bts_plexorin_default_image" name="bts_plexorin_settings[default_image]" value="<?php echo esc_attr($image_id); ?>">
        <img id="bts_plexorin_default_image_preview" src="<?php echo esc_url($image_url); ?>" style="max-width: 300px; display: <?php echo $image_url ? 'block' : 'none'; ?>;" />
        <br>
        <button type="button" class="button" id="bts_plexorin_default_image_button"><?php esc_html_e('Choose Image', 'bts_plexorin'); ?></button>
        <button type="button" class="button" id="bts_plexorin_default_image_remove" style="display: <?php echo $image_url ? 'inline-block' : 'none'; ?>;"><?php esc_html_e('Delete Image', 'bts_plexorin'); ?></button>
    </div>
    <?php
}


function bts_plexorin_sanitize_settings($settings) {
    $settings['api_key'] = sanitize_text_field($settings['api_key']);
    $settings['default_title'] = sanitize_text_field($settings['default_title']);
    $settings['default_description'] = sanitize_textarea_field($settings['default_description']);
    $settings['default_image'] = absint($settings['default_image']);
    if (isset($settings['users'])) {
        $settings['users'] = array_map('absint', $settings['users']);
    }
    if (isset($settings['categories'])) {
        $settings['categories'] = array_map('absint', $settings['categories']);
    }
    return $settings;
}