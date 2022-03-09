<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://tplugins.com/shop
 * @since      1.0.0
 *
 * @package    Tp_Product_Description_In_Loop_For_Woocommerce
 * @subpackage Tp_Product_Description_In_Loop_For_Woocommerce/admin/partials
 */

add_action('admin_menu', 'tppdil_plugin_create_menu');

function tppdil_plugin_create_menu() {
 
	//create new top-level menu
	add_menu_page(TPPDIL_PLUGIN_MENU_NAME, TPPDIL_PLUGIN_MENU_NAME, 'manage_options', 'tppdil_plugin_settings_page', 'tppdil_plugin_settings_page' , plugins_url('/images/tp.png', __FILE__) );
    // add_submenu_page( 'tppdil_plugin_settings_page', 'Settings', 'Settings', 'manage_options', 'tppdil_plugin_settings_page', 'tppdil_plugin_settings_page');
    // add_submenu_page( 'tppdil_plugin_settings_page', 'Statistics', 'Statistics', 'manage_options', 'tppdil-statistics-page', 'tppdil_statistics_page');   

	//call register settings function
	add_action( 'admin_init', 'register_tppdil_plugin_settings' );
    
}

function register_tppdil_plugin_settings() {

    //register our settings
    register_setting('tppdil-plugin-settings-group','tppdil_disable_description_in_loop');
    register_setting('tppdil-plugin-settings-group','tppdil_disable_description_in_mobile');
    register_setting('tppdil-plugin-settings-group','tppdil_description_priority');
    register_setting('tppdil-plugin-settings-group','tppdil_description_position');
    register_setting('tppdil-plugin-settings-group','tppdil_limit_description');
    register_setting('tppdil-plugin-settings-group','tppdil_limit_description_len');
    register_setting('tppdil-plugin-settings-group','tppdil_exclude_description_from_categories');
    register_setting('tppdil-plugin-settings-group','tppdil_exclude_description_from_tags');
    register_setting('tppdil-plugin-settings-group','tppdil_exclude_description_from_related');
    register_setting('tppdil-plugin-settings-group','tppdil_exclude_description_from_up_sells');
    register_setting('tppdil-plugin-settings-group','tppdil_exclude_description_from_shop');
    register_setting('tppdil-plugin-settings-group','tppdil_show_product_description');
    register_setting('tppdil-plugin-settings-group','tppdil_show_product_short_description');

    register_setting('tppdil-plugin-settings-group','tppdil_description_background');
    register_setting('tppdil-plugin-settings-group','tppdil_description_color');
    register_setting('tppdil-plugin-settings-group','tppdil_description_font_size');
    register_setting('tppdil-plugin-settings-group','tppdil_description_text_align');
    register_setting('tppdil-plugin-settings-group','tppdil_description_font_weight');
    register_setting('tppdil-plugin-settings-group','tppdil_tooltip_background');
    register_setting('tppdil-plugin-settings-group','tppdil_tooltip_color');
    register_setting('tppdil-plugin-settings-group','tppdil_tooltip_position');

}

function tppdil_plugin_settings_page() {

    //Settings
    $disable_description_in_loop = get_option('tppdil_disable_description_in_loop');
    $disable_description_in_mobile = get_option('tppdil_disable_description_in_mobile');
    $description_priority = get_option('tppdil_description_priority');
    $description_position = get_option('tppdil_description_position');
    $show_product_description = get_option('tppdil_show_product_description');
    $show_product_short_description = get_option('tppdil_show_product_short_description');
    $exclude_description_from_related  = get_option('tppdil_exclude_description_from_related');
    $exclude_description_from_up_sells = get_option('tppdil_exclude_description_from_up_sells');
    $exclude_description_from_shop     = get_option('tppdil_exclude_description_from_shop');

    $limit_description     = get_option('tppdil_limit_description');
    $limit_description_len = get_option('tppdil_limit_description_len');

    //Style
    $description_background  = get_option('tppdil_description_background');
    $description_color       = get_option('tppdil_description_color');
    $description_font_size   = get_option('tppdil_description_font_size');
    $description_text_align  = get_option('tppdil_description_text_align');
    $description_font_weight = get_option('tppdil_description_font_weight');
    $tooltip_background      = get_option('tppdil_tooltip_background');
    $tooltip_color           = get_option('tppdil_tooltip_color');
    $tooltip_position        = get_option('tppdil_tooltip_position');

    $custom_css = get_option('tppdil_custom_css');
    
    $disable_description_in_loop_check = ($disable_description_in_loop) ? 'checked="checked"' : '';
    $disable_description_in_mobile_check = ($disable_description_in_mobile) ? 'checked="checked"' : '';
    $exclude_description_from_related_check  = ($exclude_description_from_related) ? 'checked="checked"' : '';
    $exclude_description_from_up_sells_check = ($exclude_description_from_up_sells) ? 'checked="checked"' : '';
    $exclude_description_from_shop_check     = ($exclude_description_from_shop) ? 'checked="checked"' : '';

    $show_product_description_check       = ($show_product_description) ? 'checked="checked"' : '';
    $show_product_short_description_check = ($show_product_short_description) ? 'checked="checked"' : '';
    $limit_description_check              = ($limit_description) ? 'checked="checked"' : '';

    ?>
    
    <div class="wrap tppdil-wrap">

        <h1><?php echo TPPDIL_PLUGIN_NAME; ?></h1>
        
        <form method="post" action="options.php">
            <?php settings_fields( 'tppdil-plugin-settings-group' ); ?>
            <?php do_settings_sections( 'tppdil-plugin-settings-group' ); ?>

            <div id="tppdil-tabs" class="tpglobal-tabs">
                <ul>
                    <li><a href="#tabs-1">Settings</a></li>
                    <li><a href="#tabs-2">Style</a></li>
                    <li><a href="#tabs-3">Custom css</a></li>
                    <li><a href="#tabs-7">License</a></li>
                    <!-- <li><a href="#tabs-8">Logs</a></li> -->
                </ul>

                <div id="tabs-1" class="tpglobal-tabs-content">

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Disable description in loop
                                <input type="checkbox" name="tppdil_disable_description_in_loop" <?php echo esc_html($disable_description_in_loop_check); ?> value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Disable description in mobile
                                <input type="checkbox" name="tppdil_disable_description_in_mobile" <?php echo esc_html($disable_description_in_mobile_check); ?> value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                    <div class="tpglobal-tabs-row">
                        <label>Description position</label>
                        <?php echo tppdil_select_description_position(); ?>
                    </div>

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Show product full description
                                <input type="checkbox" name="tppdil_show_product_description" id="tppdil_show_product_description" <?php echo esc_html($show_product_description_check); ?> value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Show product short description
                                <input type="checkbox" name="tppdil_show_product_short_description" id="tppdil_show_product_short_description" <?php echo esc_html($show_product_short_description_check); ?> value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <span class="tppdil_admin_settings_desc">If checked, all product description / short description will display in loop.</span>
                        <span class="tppdil_admin_settings_desc">Custom description <strong>(PRO Option)</strong> will override this option.</span>
                    </div><!-- tpglobal-tabs-row -->

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Limit description
                                <input type="checkbox" name="tppdil_limit_description" <?php echo esc_html($limit_description_check); ?> value="1" disabled>
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Limit description length</label>
                            <input type="number" name="tppdil_limit_description_len" value="<?php echo esc_html($limit_description_len); ?>" disabled>
                        </div>
                        <div class="tpglobal_triangle_topright_box"><div class="tpglobal_triangle_topright"><span>PRO</span></div></div>
                    </div><!-- tpglobal-tabs-row -->

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label>Exclude Description from Categories</label>
                            <div style="position: relative;float: left;width: 100%;">
                                <?php echo tppdil_exclude_description_from_categories(); ?>
                            </div>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Exclude Description from Tags</label>
                            <div style="position: relative;float: left;width: 100%;">
                                <?php echo tppdil_exclude_description_from_tags(); ?>
                            </div>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Exclude Description from Shop Loop
                                <input type="checkbox" name="tppdil_exclude_description_from_shop" <?php echo esc_html($exclude_description_from_shop_check); ?> value="1" disabled>
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Exclude Description from Related Products Loop
                                <input type="checkbox" name="tppdil_exclude_description_from_related" <?php echo esc_html($exclude_description_from_related_check); ?> value="1" disabled>
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label class="tpglobal-container">Exclude Description from Up Sells Products Loop
                                <input type="checkbox" name="tppdil_exclude_description_from_up_sells" <?php echo esc_html($exclude_description_from_up_sells_check); ?> value="1" disabled>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="tpglobal_triangle_topright_box"><div class="tpglobal_triangle_topright"><span>PRO</span></div></div>
                    </div>
                
                </div><!-- tpglobal-tabs-content -->

                <div id="tabs-2" class="tpglobal-tabs-content">

                    <div class="tpglobal-tabs-row">

                        <div class="tpglobal-tabs-row-ins">
                            <label>Background</label>
                            <input type="text" class="tp_colorpiker" name="tppdil_description_background" value="<?php echo esc_html($description_background); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Color</label>
                            <input type="text" class="tp_colorpiker" name="tppdil_description_color" value="<?php echo esc_html($description_color); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Font size (in px)</label>
                            <input type="range" class="tp_range" id="tppdil_description_font_size" name="tppdil_description_font_size" value="<?php echo esc_html($description_font_size); ?>" ><span id="tppdil_description_font_size_range_show" class="tp_range_show"></span>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Font weight</label>
                            <?php
                                $description_font_weight_options = array('normal','bold','400','700','inherit');
                                echo tppdil_select_options('tppdil_description_font_weight',$description_font_weight_options,$description_font_weight);
                            ?>
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Text align</label>
                            <?php
                                $description_text_align_options = array('left','right','center','inherit');
                                echo tppdil_select_options('tppdil_description_text_align',$description_text_align_options,$description_text_align);
                            ?>
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                    <div class="tpglobal-tabs-row">
                        <h3>Tooltip Style</h3>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Background</label>
                            <input type="text" class="tp_colorpiker" name="tppdil_tooltip_background" value="<?php echo esc_html($tooltip_background); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Color</label>
                            <input type="text" class="tp_colorpiker" name="tppdil_tooltip_color" value="<?php echo esc_html($tooltip_color); ?>" >
                        </div>

                        <div class="tpglobal-tabs-row-ins">
                            <label>Position</label>
                            <?php
                                $tooltip_position_options = array('top','right','bottom','left');
                                echo tppdil_select_options('tppdil_tooltip_position',$tooltip_position_options,$tooltip_position);
                            ?>
                        </div>

                    </div><!-- tpglobal-tabs-row -->

                </div>

                <div id="tabs-3" class="tpglobal-tabs-content">
                    <div class="tpglobal-tabs-row">
                        <p>This option is for developers only! If you do not know CSS it is not recommended to change it.</p>
                        <textarea id="tppdil_custom_css" class="tppdil_custom_css" name="tppdil_custom_css" disabled></textarea>
                        <div class="tpglobal_triangle_topright_box"><div class="tpglobal_triangle_topright"><span>PRO</span></div></div>
                    </div>
                </div>

                <div id="tabs-7" class="tpglobal-tabs-content">
                    <div class="tppdil_admin_settings_left">
                        <h2>Free Version</h2>
                        <a href="<?php echo esc_url(TPPDIL_PLUGIN_HOME.'product/'.TPPDIL_PLUGIN_SLUG); ?>" target="_blank">Upgrade to PRO</a>
                    </div>

                    <div class="tppdil_admin_settings_right">
                    </div><!-- tppdil_admin_settings_right -->
                </div><!-- tab7 -->

            </div><!-- tpglobal-tabs -->

            <?php submit_button(); ?>
        </form>

    </div><!-- tppdil-wrap -->
    <?php

}

function tppdil_select_options($name,$options,$selected = false) {
    $select = '';
    $select .= '<select name="'.$name.'">';
    foreach ($options as $option) {
        if($selected && $selected == $option){
            $select .= '<option value="'.esc_attr($option).'" selected>'.esc_html($option).'</option>';
        }
        else{
            $select .= '<option value="'.esc_attr($option).'">'.esc_html($option).'</option>';
        }
    }
    $select .= '</select>';
    return $select;
}

function tppdil_select_asso_options($name,$options,$selected = false) {
    $select = '';
    $select .= '<select name="'.$name.'">';
    foreach ($options as $option => $value) {
        if($selected && $selected == $option){
            $select .= '<option value="'.esc_attr($option).'" selected>'.esc_html($value).'</option>';
        }
        else{
            $select .= '<option value="'.esc_attr($option).'">'.esc_html($value).'</option>';
        }
    }
    $select .= '</select>';
    return $select;
}

function tppdil_select_description_position() {
    $select = '';
    $description_position = get_option('tppdil_description_position');
    $description_priority = get_option('tppdil_description_priority');

    $data = array(
        array(
            'name'     => 'Befor Title',
            'position' => 'woocommerce_shop_loop_item_title',
            'priority' => 5
        ),
        array(
            'name'     => 'After Title',
            'position' => 'woocommerce_after_shop_loop_item_title',
            'priority' => 10
        ),
        array(
            'name'     => 'After Price',
            'position' => 'woocommerce_after_shop_loop_item_title',
            'priority' => 20
        ),
        array(
            'name'     => 'After "Add to cart" Button',
            'position' => 'woocommerce_after_shop_loop_item',
            'priority' => 15
        )
    );

    $select .= '<select name="tppdil_description_position" id="tppdil_description_position">';
        foreach ($data as $ddd) {
            $name     = $ddd['name'];
            $position = $ddd['position'];
            $priority = $ddd['priority'];

            if($description_position == $position && $description_priority == $priority){
                $select .= '<option value="'.esc_attr($position).'" data-priority="'.esc_attr($priority).'" selected>'.esc_html($name).'</option>';
            }
            else{
                $select .= '<option value="'.esc_attr($position).'" data-priority="'.esc_attr($priority).'">'.esc_html($name).'</option>';
            }

        }
    $select .= '</select>';

    $select .= '<input type="hidden" name="tppdil_description_priority" id="tppdil_description_priority" value="'.esc_html($description_priority).'" >';

    return $select;

}

function tppdil_exclude_description_from_categories() {
    $exclude_description_from_categories = get_option('tppdil_exclude_description_from_categories');
    //wp_dbug($exclude_description_from_categories);
    $select = '';
    $orderby    = 'name';
    $order      = 'asc';
    $hide_empty = false ;
    $cat_args = array(
        'orderby'    => $orderby,
        'order'      => $order,
        'hide_empty' => $hide_empty,
    );
 
    $product_categories = get_terms( 'product_cat', $cat_args );

    //wp_dbug($product_categories);

    if($product_categories){
        $select .= '<select name="tppdil_exclude_description_from_categories[]" id="tppdil_exclude_description_from_categories" multiple="multiple">';
            //$select .= '<option value="0">None</option>';
            foreach ($product_categories as $product_cat) {
                if($exclude_description_from_categories && in_array($product_cat->term_id, $exclude_description_from_categories)) {
                    $select .= '<option value="'.esc_attr($product_cat->term_id).'" selected>'.esc_html($product_cat->name).'</option>';
                }
                else{
                    $select .= '<option value="'.esc_attr($product_cat->term_id).'">'.esc_html($product_cat->name).'</option>';
                }
            }
        $select .= '</select>';
    }

    return $select;
}

function tppdil_exclude_description_from_tags() {
    $exclude_description_from_tags = get_option('tppdil_exclude_description_from_tags');
    $select = '';
    $orderby    = 'name';
    $order      = 'asc';
    $hide_empty = false ;
    $tag_args = array(
        'orderby'    => $orderby,
        'order'      => $order,
        'hide_empty' => $hide_empty,
    );
 
    $product_tags = get_terms( 'product_tag', $tag_args );

    //wp_dbug($product_tags);

    if($product_tags){
        $select .= '<select name="tppdil_exclude_description_from_tags[]" id="tppdil_exclude_description_from_tags" multiple="multiple">';
            //$select .= '<option value="0">None</option>';
            foreach ($product_tags as $product_tag) {
                if($exclude_description_from_tags && in_array($product_tag->term_id, $exclude_description_from_tags)) {
                    $select .= '<option value="'.esc_attr($product_tag->term_id).'" selected>'.esc_html($product_tag->name).'</option>';
                }
                else{
                    $select .= '<option value="'.esc_attr($product_tag->term_id).'">'.esc_html($product_tag->name).'</option>';
                }
            }
        $select .= '</select>';
    }

    return $select;
}