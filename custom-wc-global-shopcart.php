<?php
/**
* Plugin Name: Custom WC global shopping cart
* Description: Display WooCommerce cart items globally
* Version: 1.0
* Author: J. S. / DVW
*
*
*/

// Creating the widget
class custom_wc_global_shopcart extends WP_Widget {
    // The construct part
    function __construct() {
        parent::__construct( 
            // Base ID of your widget
            'custom_wc_global_shopcart', 
            
            // Widget name will appear in UI
            __('Custom WC global shopcart', 'custom_wc_global_shopcart_domain'), 
            
            // Widget description
            array(
                'description' => __( 'Display WooCommerce cart items globally', 'custom_wc_global_shopcart_domain' )
            )
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
      	$numberOfItemsLabel = $instance['numberOfItemsLabel'];
      	$buttonLink = $instance['buttonLink'];
      	$buttonText = $instance['buttonText'];
        $priceTag = get_woocommerce_currency_symbol();
         
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        // Grap products in shopping cart
        global $woocommerce;
        $cartItems = $woocommerce->cart->get_cart();
        $itemsOutput = "";
        $numberOfProducts = 0;
        $totalPrice = 0;

        require_once "get-cart.php";
        $products = "<ul class='cart-items'>".$itemsOutput."</ul>";
        $widgetID = "custom_wc_global_shopcart-3";

        // This is where you run the code and display the output
        $widgetContent = "<div id='custom-wc-global-shopcart-widgett'>";
            $widgetContent .= "<div id='cart-info'>";
                if (!empty($title)) : $widgetContent .= $args['before_title'] . $title . $args['after_title']; endif;
                $widgetContent .= "<span class='number-of-items'>".$numberOfItemsLabel."<span>".$numberOfProducts."</span></span>";
                $widgetContent .= "<span class='total-price'><span>".($totalPrice)."</span> ".$priceTag."</span>";
            $widgetContent .= "</div>";
            $widgetContent .= "<a href='".$buttonLink."' class='cart-button'>".$buttonText."</a>";
            $widgetContent .= $products;
        $widgetContent .= "</div>";

        echo $widgetContent;
        echo $args['after_widget'];
    }

    // Creating widget Backend
    public function form( $instance ) {
        $title = isset($instance['title']) ? $instance[ 'title' ] : __( 'New title', 'custom_wc_global_shopcart_domain' );
      	$numberOfItemsLabel = isset($instance['numberOfItemsLabel']) ? $instance[ 'numberOfItemsLabel' ] : __( 'N. of items: ', 'custom_wc_global_shopcart_domain' );
      	$buttonLink = isset($instance['buttonLink']) ? $instance[ 'buttonLink' ] : __( '/cart/', 'custom_wc_global_shopcart_domain' );
      	$buttonText = isset($instance['buttonText']) ? $instance[ 'buttonText' ] : __( 'Go to cart', 'custom_wc_global_shopcart_domain' );
        $showProductImage = isset($instance['showProductImage']) ? $instance[ 'showProductImage' ] : 'no';
        $showProductTitle = isset($instance['showProductTitle']) ? $instance[ 'showProductTitle' ] : 'no';
        $showProductQuantity = isset($instance['showProductQuantity']) ? $instance[ 'showProductQuantity' ] : 'no';

        $inputFields = array(
            __( 'Title', 'custom_wc_global_shopcart_domain' ) => array(
                "id" => "title", 
                "content" => $title
            ),
            __( 'Number of Items label:', 'custom_wc_global_shopcart_domain' ) => array(
                "id" => "numberOfItemsLabel",
                "content" => $numberOfItemsLabel
            ),
            __( 'Button link:', 'custom_wc_global_shopcart_domain' ) => array(
                "id" => "buttonLink", 
                "content" => $buttonLink
            ),
            __( 'Button text:', 'custom_wc_global_shopcart_domain' ) => array(
                "id" => "buttonText", 
                "content" => $buttonText
            )
        );

        $radioFields = array(
            __( 'Show Product Image:', 'custom_wc_global_shopcart_domain' ) => array(
                "id" => "showProductImage",
                "content" => $showProductImage
            ),
            __( 'Show Product Title:', 'custom_wc_global_shopcart_domain' ) => array(
                "id" => "showProductTitle",
                "content" => $showProductTitle
            ),
            __( 'Show Product Quantity:', 'custom_wc_global_shopcart_domain' ) => array(
                "id" => "showProductQuantity",
                "content" => $showProductQuantity
            )
        );
        // Widget admin form
        echo "<div>";
            // Input text fields
            foreach ($inputFields AS $label => $data) {
                echo "<label for='".$this->get_field_id($data['id'])."'>".$label."</label>";
                echo "<input class='widefat' id='".$this->get_field_id($data['id'])."' name='".$this->get_field_name($data['id'])."' type='text' value='".esc_attr($data['content'])."' />";
            }

            // Radio fields
            foreach ($radioFields AS $label => $data) {
                echo "<p>";
                    echo "<label class='widefat' style='display: inline-block;' for='".$this->get_field_id($data['id'])."'>".$label."</label>";
                    echo _e('Yes')." <input class='".$this->get_field_id($data['id'])."' name='".$this->get_field_name($data['id'])."' type='radio' value='yes' ".($data['content'] == 'yes' ? "checked" : "")." />";
                    echo _e('No')." <input class='".$this->get_field_id($data['id'])."' name='".$this->get_field_name($data['id'])."' type='radio' value='no' ".($data['content'] == 'no' ? "checked" : "")." />";
                echo "</p>";
            }
        echo "</div>";
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instances = array("title", "numberOfItemsLabel", "buttonLink", "buttonText", "showProductImage", "showProductTitle", "showProductQuantity");
        foreach ($instances AS $theInstance) {
            $instance[$theInstance] = (!empty($new_instance[$theInstance])) ? strip_tags($new_instance[$theInstance]) : '';
        }
        return $instance;
    }
// Class custom_wc_global_shopcart ends here
}

function wpb_load_glocal_shopcart_widget() {
    register_widget( 'custom_wc_global_shopcart' );
}
add_action( 'widgets_init', 'wpb_load_glocal_shopcart_widget' );