<?php
global $woocommerce;
foreach ($cartItems AS $itemKey => $cartItem) {
    $numberOfProducts++;

    $productId = $cartItem['product_id'];
    $productQuantity = $cartItem['quantity'];
    $productImage = get_the_post_thumbnail_url($cartItem['data']->get_id());
    $theProduct = new WC_Product($productId);
    $productOrgPrice = $theProduct->get_price();

    $itemsOutput .= '<li class="cart-item">'.
                        '<img src="'.$productImage.'" alt="">'.
                        '<span class="remove-item" onclick="shopcart_Deleteitem('.$productId.');">x</span>'.
                        '<span class="quantity">'.$productQuantity.'</span>'.
                        '<span class="minus" onclick="shopcart_Reducequantity('.$productId.', 1);">-</span>'.
                        '<span class="plus" onclick="shopcart_Addtocart('.$productId.');">+</span>'.
                    '</li>';
}
?>