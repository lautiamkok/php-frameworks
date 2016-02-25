<?php
/**
 * Metabox
 *
 */
include 'demo.php';

// @ref: https://metabox.io/docs/getting-started/
// Basic:
// add_filter( 'rwmb_meta_boxes', 'wp_meta_boxes' );
// function wp_meta_boxes( $meta_boxes ) {
//     $meta_boxes[] = array(
//         'title'      => __( 'Test Meta Box', 'quinn_' ),
//         'post_types' => array( 'post', 'page' ),
//         'fields'     => array(
//             array(
//                 'id'   => 'name',
//                 'name' => __( 'Name', 'textdomain' ),
//                 'type' => 'text',
//             ),
//             array(
//                 'id'      => 'gender',
//                 'name'    => __( 'Gender', 'textdomain' ),
//                 'type'    => 'radio',
//                 'options' => array(
//                     'm' => __( 'Male', 'textdomain' ),
//                     'f' => __( 'Female', 'textdomain' ),
//                 ),
//             ),
//             array(
//                 'id'   => 'email',
//                 'name' => __( 'Email', 'textdomain' ),
//                 'type' => 'email',
//             ),
//             array(
//                 'id'   => 'bio',
//                 'name' => __( 'Biography', 'textdomain' ),
//                 'type' => 'textarea',
//             ),
//         ),
//     );
//     return $meta_boxes;
// }
