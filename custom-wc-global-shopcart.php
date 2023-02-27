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
        array( 'description' => __( 'Display WooCommerce cart items globally', 'custom_wc_global_shopcart_domain' ), )
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
        echo __( $widgetContent, 'custom_wc_global_shopcart_domain' );
        echo $args['after_widget'];
    }

    // Creating widget Backend
    public function form( $instance ) {
      	$title = isset($instance['title']) ? $instance[ 'title' ] : __( 'New title', 'custom_wc_global_shopcart_domain' );
      	$numberOfItemsLabel = isset($instance['numberOfItemsLabel']) ? $instance[ 'numberOfItemsLabel' ] : __( 'N. of items: ', 'custom_wc_global_shopcart_domain' );
      	$buttonLink = isset($instance['buttonLink']) ? $instance[ 'buttonLink' ] : __( '/cart/', 'custom_wc_global_shopcart_domain' );
      	$buttonText = isset($instance['buttonText']) ? $instance[ 'buttonText' ] : __( 'Go to cart', 'custom_wc_global_shopcart_domain' );
        $fields = array(
            "Title:" => array(
                "id" => "title", 
                "content" => $title
            ),
            "Number of Items label:" => array(
                "id" => "numberOfItemsLabel",
                "content" => $numberOfItemsLabel
            ),
            "Button link" => array(
                "id" => "buttonLink", 
                "content" => $buttonLink
            ),
            "Button text" => array(
                "id" => "buttonText", 
                "content" => $buttonText
            )
        );
        // Widget admin form
        echo "<p>";
        foreach ($fields AS $label => $data) {
            echo "<label for='".$this->get_field_id($data['id'])."'>"._e($label)."</label>";
            echo "<input class='widefat' id='".$this->get_field_id($data['id'])."' name='".$this->get_field_name($data['id'])."' type='text' value='".esc_attr($data['content'])."' />";
        }
        echo "</p>";
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['numberOfItemsLabel'] = ( ! empty( $new_instance['numberOfItemsLabel'] ) ) ? strip_tags( $new_instance['numberOfItemsLabel'] ) : '';
      	$instance['buttonLink'] = ( ! empty( $new_instance['buttonLink'] ) ) ? strip_tags( $new_instance['buttonLink'] ) : '';
      	$instance['buttonText'] = ( ! empty( $new_instance['buttonText'] ) ) ? strip_tags( $new_instance['buttonText'] ) : '';
        return $instance;
    }
// Class custom_wc_global_shopcart ends here
}

function wpb_load_glocal_shopcart_widget() {
    register_widget( 'custom_wc_global_shopcart' );
}
add_action( 'widgets_init', 'wpb_load_glocal_shopcart_widget' );