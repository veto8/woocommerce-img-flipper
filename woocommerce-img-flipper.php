<?php
/*
Plugin Name: Woocommerce IMG Flipper
Plugin URI: https://woocommerce-img-flipper.myridia.com
Version:1.0
Description: When you mouse over or touch with mobile a Woocomerce Product List Image, it will flipp and then slide to all your gallery images of this product 
Author: Myridia.com Co., LTD.
Author URI: https://myridia.com
Text Domain:  Woocommerce-IMG-Flipper
Domain Path: /languages/

	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Check if WooCommerce is active
 **/
//function is_plugin_active( $plugin ) {
//    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || is_plugin_active_for_network( $plugin );
//}




    $plugin_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';
//if ( in_array( $plugin_path, wp_get_active_and_valid_plugins() )):
if(1==1):
	/**
	 * Localisation (with WPML support)
	 **/
	add_action( 'init', 'plugin_init' );
	function plugin_init()
    {
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );        
		load_plugin_textdomain( 'woocommerce-img-flipper', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}


	/**
	 * Main Class get initated.
	 **/
if ( ! class_exists( 'WC_flip' ) ):

		class WC_flip {
			public function __construct() {
              add_action( 'woocommerce_before_shop_loop_item_title', array($this,'custom_loop_product_thumbnail'), 10 );
		      add_action( 'wp_enqueue_scripts', array( $this, 'image_flip' ) );														// Enqueue the styles
                //				add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woocommerce_template_loop_second_product_thumbnail' ), 11 );
                //				add_filter( 'post_class', array( $this, 'product_has_gallery' ) );
			}
            
	        /*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/
            function custom_loop_product_thumbnail() {
              global $product;
              global $product;
              $data = $this->get_gallery_imgs();
              $image_size = apply_filters( 'single_product_archive_thumbnail_size',800 );
              $p = $product ? $product->get_image( $image_size, ['data-galleryimg'=>json_encode($data)] ) : '';
              echo $p;
            }


            
			function image_flip() {
				if ( apply_filters( 'woocommerce_product_image_flipper_styles', true ) ) {
					wp_enqueue_style( 'pif-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
				}
				wp_enqueue_script( 'flip-script', plugins_url( '/assets/js/script.js', __FILE__ ), array( 'jquery' ) );
			}

			// Add flip-image-gallery class to products that have a gallery
			function get_gallery_imgs(  ) {
                $image_links = [];
				global $product;
				$post_type = get_post_type( get_the_ID() );

				if ( ! is_admin() ):
					if ( $post_type == 'product' ):
                      $ids = $product->get_gallery_image_ids();
                      $img_id = $product->get_image_id();
                      //                      echo wp_get_attachment_image_srcset($img_id);
                      //exit;
                      if(count($ids)):
                      
                      foreach( $ids as $i ):
                          $url =  wp_get_attachment_url( $i );
                      //echo $url;
                          if ($this->does_url_exists($url)) :
                            $image_links[] = ['src'=>$url,'srcset'=> wp_get_attachment_image_srcset($i)];
                          break;
                          endif;
                       endforeach;
                       if(count($image_links)):
                         $image_links[] = ['src'=>wp_get_attachment_url( $img_id ),'srcset'=> wp_get_attachment_image_srcset($img_id)];
                       endif;
                      endif;
				  endif;
				endif;

				return $image_links;
			}



    function does_url_exists($url) {
        $status = true;
/*
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
*/
    return $status;
}

		}


		$WC_flip = new WC_flip();
endif;
endif;
