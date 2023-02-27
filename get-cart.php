<?php
global $woocommerce;
foreach ($cartItems AS $itemKey => $cartItem) {
    $numberOfProducts++;

    $productId = $cartItem['product_id'];
    $theProduct = new WC_Product($productId);
    
    $productQuantity = $cartItem['quantity'];
    $productImage = get_the_post_thumbnail_url($cartItem['data']->get_id());
    $productOrgPrice = $theProduct->get_price();
    $productTitle = $theProduct->get_title();

    $itemsOutput .= '<li class="cart-item">';
    if ($instance['showProductImage'] == 'yes') $itemsOutput .= '<img src="'.$productImage.'" alt="">';
    if ($instance['showProductTitle'] == 'yes') $itemsOutput .= '<span class="product-title">'.$productTitle.'</span>';
    $itemsOutput .= '<span class="remove-item" onclick="shopcart_Deleteitem('.$productId.');">x</span>';
    if ($instance['showProductQuantity'] == 'yes') $itemsOutput .= '<span class="quantity">'.$productQuantity.'</span>';
    $itemsOutput .= '<span class="minus" onclick="shopcart_Reducequantity('.$productId.', 1);">-</span>';
    $itemsOutput .= '<span class="plus" onclick="shopcart_Addtocart('.$productId.');">+</span>';
    $itemsOutput .= '</li>';
}
?>