WOOCOMMERCE EXTRA FEES

LESSON 1 
------------------------------------------------------------------------------------------
<?php
/**
 * Plugin Name: Change Currencies in WooCommerce
 * Plugin URI: https://omukiguy.com
 * Author: TechiePress
 * Author URI: https://omukiguy.com
 * Description: Change Currencies in WooCommerce
 * Version: 0.1.0
 * License: GPL2
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: ocotw
*/

/**
 * Change an exisiting currency
 *
 * Go to https://github.com/woocommerce/woocommerce/blob/master/includes/wc-core-functions.php
 * In the get_woocommerce_currencies() to find your currency code.
 */
add_filter( 'woocommerce_currency_symbol', 'techiepress_change_woocommerce_currency_symbol', 10, 2 );

function techiepress_change_woocommerce_currency_symbol( $currency_symbol, $currency ) {
    
    switch( $currency ) {
		    
	// Insert currency code from the get_woocommerce_currencies().
        case 'AED' : $currency_symbol = 'AED';
        break;
		    
    }
    
    return $currency_symbol;
    
}

LESSON 2 
------------------------------------------------------------------------------------------
<?php
/**
 * WooCommerce: Add custom fee to cart automatically
 * Can be used to add a surcharge if so desired.
 */
function woo_add_cart_fee() {
 
  global $woocommerce;
	
  $woocommerce->cart->add_fee( __('Custom', 'woocommerce'), 5 );
	
}
add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );



LESSON 3
------------------------------------------------------------------------------------------
<?php
/*
Plugin name: Package Cost Extra fee
Description: Package Cost Extra fee information for Web designer.
Author: Laurence Bahiirwa
Plugin URI: https://omukiguy.com
Author URI: https://omukiguy.com
text-domain: om-service-widget
*/

function lab_pacakge_cost() {
    global $woocommerce;
    
    $flat_rate = 5;
    $taxable = $flat_rate + ( $woocommerce->cart->cart_contents_total * 0.18 );

    $woocommerce->cart->add_fee( __( 'VAT', 'om-service-widget' ), $taxable );
}

add_action( 'woocommerce_cart_calculate_fees', 'lab_pacakge_cost');

LESSON 4
------------------------------------------------------------------------------------------
<?php
/**
 * Plugin name: Package Cost Extra fee with Custom Settings Tab
 * Description: Package Cost Extra fee information for Web designer.
 * Author: Laurence Bahiirwa
 * Plugin URI: https://omukiguy.com
 * Author URI: https://omukiguy.com
 * text-domain: om-service-widget
 */

function lab_pacakge_cost() {
    
    $flat_fee    = get_option( 'techiepress_vat_pricing_flat_fee' );
    $dynamic_fee = get_option( 'techiepress_vat_pricing_dynamic_fee' );
    
    global $woocommerce;
   
    $taxable = $flat_rate + ( $woocommerce->cart->cart_contents_total * $dynamic_fee );

    $woocommerce->cart->add_fee( __( 'VAT', 'om-service-widget' ), $taxable );
    
}

add_action( 'woocommerce_cart_calculate_fees', 'lab_pacakge_cost');


add_filter( 'woocommerce_settings_tabs_array', 'techiepress_add_vat_pricing', 50 );

function techiepress_add_vat_pricing( $settings_tab ) {
    
    $settings_tab['techiepress_vat_pricing'] = __( 'VAT Pricing', 'om-service-widget' );
    
    return $settings_tab;
}


add_action( 'woocommerce_settings_tabs_techiepress_vat_pricing', 'techiepress_add_vat_pricing_settings' );

function techiepress_add_vat_pricing_settings() {
    woocommerce_admin_fields( get_techiepress_vat_pricing_settings() );
}

add_action( 'woocommerce_update_options_techiepress_vat_pricing', 'techiepress_update_options_vat_pricing_settings' );

function techiepress_update_options_vat_pricing_settings() {
    woocommerce_update_options( get_techiepress_vat_pricing_settings() );
}

function get_techiepress_vat_pricing_settings() {
    
    $settings = array(
        
        'section_title' => array(
            'id'   => 'techiepress_vat_pricing_settings_title',
            'desc' => 'Section for handlign VAT information',
            'type' => 'title',
            'name' => 'VAT Pricing Information',
        ),
        
        'vat_pricing_flat_fee' => array(
            'id'   => 'techiepress_vat_pricing_flat_fee',
            'desc' => 'Flat Fee number',
            'type' => 'text',
            'name' => 'Flat Fee',
        ),
        
        'vat_pricing_dynamic_fee' => array(
            'id'   => 'techiepress_vat_pricing_dynamic_fee',
            'desc' => 'Percentage of Tax',
            'type' => 'text',
            'name' => 'Dynamic Fee',
        ),
        
        'section_end' => array(
            'id'   => 'techiepress_vat_pricing_sectionend',
            'type' => 'sectionend',
        ),
    );
    
    return apply_filters( 'filter_techiepress_vat_pricing_settings', $settings );
}
LESSON 5
------------------------------------------------------------------------------------------
<?php
/**
 * Plugin name: Extra fee for the particualar payment gateways.
 * Description: Package Cost Extra fee for the particualar payment gateways.
 * Author: Techiepress
 * Plugin URI: https://omukiguy.com
 * Author URI: https://omukiguy.com
 * text-domain: package-cost-extra
 */

 add_action( 'woocommerce_cart_calculate_fees', 'techiepress_cart_fees_gateway' );

 function techiepress_cart_fees_gateway( $cart ) {

    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    // cod, cheque, paypal, bacs, payleo
    $preferred_payment_gateway_id = WC()->session->get( 'chosen_payment_method' );
    
    if ( empty( $preferred_payment_gateway_id ) ) {
        return;
    }

    $chosen_methods_ids = array(
        'cod'    => 3,
        'cheque' => 1,
        'paypal' => 4,
        'bacs'   => 2,
        'payleo' => 6
    );

    foreach( $chosen_methods_ids as $chosen_methods_id => $amount ) {
        if ( $preferred_payment_gateway_id === $chosen_methods_id ) {
            $cart->add_fee( 'Handling', $amount, true );
        }
    }

 }

 // Ajax update on gateway change
 add_action( 'wp_footer', 'techiepress_ajax_runner' );

 function techiepress_ajax_runner() {
     if ( is_checkout() && ! is_wc_endpoint_url() ) {
        ?>
            <script>
                jQuery( function($){
                    $('form.checkout').on('change', 'input[name="payment_method"]', function(){
                        $(document.body).trigger('update_checkout');
                    });
                });
            </script>
        <?php
     }
 }
 LESSON 6
------------------------------------------------------------------------------------------
<?php
/**
 * Plugin name: Package Cost Extra fee
 * Description: Package Cost Extra fee information for Web designer.
 * Author: Laurence Bahiirwa
 * Plugin URI: https://omukiguy.com
 * Author URI: https://omukiguy.com
 * text-domain: om-service-widget
 */

add_action( 'woocommerce_after_checkout_billing_form', 'techiepress_add_vat_cancel_button' );

function techiepress_add_vat_cancel_button( $checkout ) {
    echo '<div id="vat-cancel">'; 
    
    woocommerce_form_field(
        'techiepress_vat_cancel',
        array(
            'label'  => 'I am VAT exempt',
            'class'  => array( 'vat-cancel-button' ),
            'type'   => 'checkbox'
        ),
        $checkout->get_value( 'techiepress_vat_cancel' )
    );
    
    echo '</div>';    
}

add_action( 'wp_footer', 'techiepress_vat_cancel_ajax' );

function techiepress_vat_cancel_ajax() {
    
    if ( is_checkout() ) {
        ?>
        <script type="text/javascript">
            jQuery( document ).ready(
                function($) {
                    $('#techiepress_vat_cancel').click(
                        function() {
                            jQuery('body').trigger('update_checkout');
                        }    
                    );
                }
            );
        </script>
        <?php
    }
}

function lab_pacakge_cost() {
    
    global $woocommerce;
    
    $flat_fee    = get_option( 'techiepress_vat_pricing_flat_fee' );
    $dynamic_fee = get_option( 'techiepress_vat_pricing_dynamic_fee' );
    
    if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
        return;
    }
    
    if ( isset( $_POST['post_data'] ) ) {
        parse_str( $_POST['post_data'], $post_data );
    } else {
        $post_data = $_POST;
    }
    
    if ( isset( $post_data['techiepress_vat_cancel'] ) ) {
        return;
    }
    
    $taxable = $flat_rate + ( $woocommerce->cart->cart_contents_total * $dynamic_fee );

    $woocommerce->cart->add_fee( __( 'VAT', 'om-service-widget' ), $taxable );
    
}

add_action( 'woocommerce_cart_calculate_fees', 'lab_pacakge_cost');


add_filter( 'woocommerce_settings_tabs_array', 'techiepress_add_vat_pricing', 50 );

function techiepress_add_vat_pricing( $settings_tab ) {
    
    $settings_tab['techiepress_vat_pricing'] = __( 'VAT Pricing', 'om-service-widget' );
    
    return $settings_tab;
}


add_action( 'woocommerce_settings_tabs_techiepress_vat_pricing', 'techiepress_add_vat_pricing_settings' );

function techiepress_add_vat_pricing_settings() {
    woocommerce_admin_fields( get_techiepress_vat_pricing_settings() );
}

add_action( 'woocommerce_update_options_techiepress_vat_pricing', 'techiepress_update_options_vat_pricing_settings' );

function techiepress_update_options_vat_pricing_settings() {
    woocommerce_update_options( get_techiepress_vat_pricing_settings() );
}

function get_techiepress_vat_pricing_settings() {
    
    $settings = array(
        
        'section_title' => array(
            'id'   => 'techiepress_vat_pricing_settings_title',
            'desc' => 'Section for handlign VAT information',
            'type' => 'title',
            'name' => 'VAT Pricing Information',
        ),
        
        'vat_pricing_flat_fee' => array(
            'id'   => 'techiepress_vat_pricing_flat_fee',
            'desc' => 'Flat Fee number',
            'type' => 'text',
            'name' => 'Flat Fee',
        ),
        
        'vat_pricing_dynamic_fee' => array(
            'id'   => 'techiepress_vat_pricing_dynamic_fee',
            'desc' => 'Percentage of Tax',
            'type' => 'text',
            'name' => 'Dynamic Fee',
        ),
        
        'section_end' => array(
            'id'   => 'techiepress_vat_pricing_sectionend',
            'type' => 'sectionend',
        ),
    );
    
    return apply_filters( 'filter_techiepress_vat_pricing_settings', $settings );
}