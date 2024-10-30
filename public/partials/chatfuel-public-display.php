<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       taicv.com
 * @since      1.0.0
 *
 * @package    Chatfuel
 * @subpackage Chatfuel/public/partials
 */
/**
 * Grab latest post title by an author!
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest,? * or null if none.
 */
function chatfuel_get_post_by_category($data) {
    $category_name  =   $data['category_name'];
    if($data['category_name']=="0") $category_name=   '';
    $posts = get_posts( array(
        'category_name' => $category_name,
        'posts_per_page'=> 6,
        'offset'        => $data['offset'],

    ) );

    return  chatfuel_format_JSON_API($posts,$data,'post','category',$data['category_name']);

}
function chatfuel_get_post_by_keyword($data) {
    $data['keyword']    =   urldecode($data['keyword']);
    $posts = get_posts( array(
        'posts_per_page'=> 6,
        'offset'        => $data['offset'],
        's'         => $data['keyword']
    ) );

    return  chatfuel_format_JSON_API($posts,$data,'post','keyword',$data['keyword']);
}
function chatfuel_get_product_by_category($data) {
    $cat_query  =   array();
    if($data['category_name']!=="0")
        $cat_query  =    array(
            array(
                'taxonomy'      => 'product_cat',
                'field'         => 'slug',
                'terms'         => $data['category_name']
            )
        );

    $posts = get_posts( array(
        'posts_per_page'=> 6,
        'offset'        => $data['offset'],
        'post_type'     =>  'product',
        'tax_query'             => $cat_query

    ) );

    return  chatfuel_format_JSON_API($posts,$data,'product','category',$data['category_name']);
}
function chatfuel_get_product_by_keyword($data) {
    $data['keyword']    =   urldecode($data['keyword']);
    $posts = get_posts( array(
        'posts_per_page'=> 6,
        'offset'        => $data['offset'],
        'post_type'     =>  'product',
        's'         => $data['keyword']
    ) );

    return  chatfuel_format_JSON_API($posts,$data,'product','keyword',$data['keyword']);
}

function chatfuel_format_JSON_API($posts,$data,$post_type,$filter,$condition)
{
    $return_data    =   array();
    $post_number=0;
    if ( empty( $posts ) ) {

        $return_data['messages']  = array();
        $return_data['messages'][0]['text'] =   "Nothing to show at this moment";
        return new WP_REST_Response(  $return_data );
    }
    else{
        foreach ($posts as &$post) {
            if($post_number==5)
            {
                $data['offset'] =   $data['offset']+5;
                $return_posts[$post_number]['title'] = 'More items';
                $return_posts[$post_number]['buttons'][0]['type'] = 'json_plugin_url';
                $return_posts[$post_number]['buttons'][0]['url'] = get_home_url().'/wp-json/chatfuel/'.$post_type.'/'.$filter.'/'.$condition.'/'.$data['offset'];
                $return_posts[$post_number]['buttons'][0]['title'] = 'More items';
                break;
            }
            $return_posts[$post_number]['title'] = $post->post_title;
            $return_posts[$post_number]['image_url'] = get_the_post_thumbnail_url( $post->ID,'large');
            $return_posts[$post_number]['subtitle'] = strip_tags($post->post_excerpt);
            $return_posts[$post_number]['buttons'][0]['type'] = 'web_url';
            $return_posts[$post_number]['buttons'][0]['url'] = get_permalink($post->ID);
            $return_posts[$post_number]['buttons'][0]['title'] = 'More detail';
            $post_number++;
        }
        $return_data    =   array();
        $return_data['messages']  = array();
        $return_data['messages'][0]['attachment']['type']    =   'template';
        $return_data['messages'][0]['attachment']['payload']['template_type']    =   'generic';
        $return_data['messages'][0]['attachment']['payload']['elements']         =   $return_posts;


        return new WP_REST_Response(  $return_data );
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'chatfuel', '/post/category/(?P<category_name>[a-zA-Z0-9-]+)/(?P<offset>\d+)', array(
        'methods' => 'GET',
        'callback' => 'chatfuel_get_post_by_category',
    ) );
    register_rest_route( 'chatfuel', '/post/keyword/(?P<keyword>.+)/(?P<offset>\d+)', array(
        'methods' => 'GET',
        'callback' => 'chatfuel_get_post_by_keyword',
    ) );
    register_rest_route( 'chatfuel', '/product/category/(?P<category_name>[a-zA-Z0-9-]+)/(?P<offset>\d+)', array(
        'methods' => 'GET',
        'callback' => 'chatfuel_get_product_by_category',
    ) );
    register_rest_route( 'chatfuel', '/product/keyword/(?P<keyword>.+)/(?P<offset>\d+)', array(
        'methods' => 'GET',
        'callback' => 'chatfuel_get_product_by_keyword',
    ) );

} );

