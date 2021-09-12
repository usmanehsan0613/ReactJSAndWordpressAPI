<?php

// -----------------------------------------------------
// Custom Image/SVG Clickable Icon 
// to show on slider , footer external links
// important Links
// Any clickable item
// Regsiter as shortcode as well
// Also to be able to use as widgets.
// -----------------------------------------------------


// enum all display types.

$labels = array(
        "name" => "ZU ImageLink",
        "singular_name" => "ZU ImageLink",
        "menu_name" => "ZU ImageLink",
        "all_items" => "All ZU ImageLink",
        "add_new" => "Add ZU ImageLink",
        "add_new_item" => "Add New ZU ImageLink",
        "edit" => "Edit",
        "edit_item" => "Edit ZU ImageLink",
        "new_item" => "New ZU ImageLink",
        "view" => "View",
        "view_item" => "View ZU ImageLink",
        "search_items" => "Search ZU ImageLink",
        "not_found" => "No ZU ImageLinks Found",
        "not_found_in_trash" => "No ZU ImageLink Found in Trash",
        "parent" => "Parent ZU ImageLink",
);

$supports = array(
                'title',
                'editor',
                'thumbnail',
                'custom-fields',
                'revisions',
);

$args = array(
        "labels" => $labels,
        'supports'        => $supports,
        "description" => "",
        "public" => true,
        "show_ui" => true,
        "has_archive" => true,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => true,
        "rewrite" => array( "slug" => "general-items", "with_front" => true ),
        "query_var" => true,
         'menu_position'   => 30,
	 'menu_icon'       => 'dashicons-id',
    );

register_post_type( "zu_image_links", $args );


                    $labels = array(
			'name'                       => __( 'ZU ImageLinks Categories', 'zu_image_links' ),
			'singular_name'              => __( 'ZU ImageLinks Category', 'zu_image_links' ),
			'menu_name'                  => __( 'ZU ImageLinks Categories', 'zu_image_links' ),
			'edit_item'                  => __( 'Edit ZU ImageLinks Category', 'zu_image_links' ),
			'update_item'                => __( 'Update ZU ImageLinks Category', 'zu_image_links' ),
			'add_new_item'               => __( 'Add New ZU ImageLinks Category', 'zu_image_links' ),
			'new_item_name'              => __( 'New ZU ImageLinks Category Name', 'zu_image_links' ),
			'parent_item'                => __( 'Parent ZU ImageLinks Category', 'zu_image_links' ),
			'parent_item_colon'          => __( 'Parent ZU ImageLinks Category:', 'zu_image_links' ),
			'all_items'                  => __( 'All ZU ImageLinks Categories', 'zu_image_links' ),
			'search_items'               => __( 'Search ZU ImageLinks Categories', 'zu_image_links' ),
			'popular_items'              => __( 'Popular ZU ImageLinks Categories', 'zu_image_links' ),
			'separate_items_with_commas' => __( 'Separate ZU ImageLinks categories with commas', 'zu_image_links' ),
			'add_or_remove_items'        => __( 'Add or remove ZU ImageLinks categories', 'zu_image_links' ),
			'choose_from_most_used'      => __( 'Choose from the most used ZU ImageLinks categories', 'zu_image_links' ),
			'not_found'                  => __( 'No ZU ImageLinks categories found.', 'zu_image_links' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'team-category' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'zu_image_links_category_args', $args );

		register_taxonomy( 'zu-image-links-category', 'zu_image_links', $args );

                
// ----------------------------------------------------------------
/*
 * 
 * Custom ost type - Opend data that will show the tabel list on front end.
 * Title, desc, upload types (pdf,xls, csv, w, all in zip format), year, category, keyword,
 * to track form user 
 * number of donwloads 
 * total files per category
 * comment against each item
 * likes against each item
 * 
 */                
// ----------------------------------------------------------------      
$labels = array(
        "name"                  => esc_html__("Open Data", 'twentytwentyone'),
        "singular_name"         => esc_html__("Open Data",'twentytwentyone'),
        "menu_name"             => esc_html__("Open Data",'twentytwentyone'),
        "all_items"             => esc_html__("All Open Data",'twentytwentyone'),
        "add_new"               => esc_html__("Add Open Data",'twentytwentyone'),
        "add_new_item"          => esc_html__("Add New Open Data",'twentytwentyone'),
        "edit"                  => esc_html__("Edit",'twentytwentyone'),
        "edit_item"              => esc_html__("Edit Open Data",'twentytwentyone'),
        "new_item"              => esc_html__("New Open Data",'twentytwentyone'),
        "view"                  => esc_html__("View",'twentytwentyone'),
        "view_item"             => esc_html__("View Open Data",'twentytwentyone'),
        "search_items"          => esc_html__("Search Open Data",'twentytwentyone'),
        "not_found"             => esc_html__("No Open Data",'twentytwentyone'),
        "not_found_in_trash"    => esc_html__("No Open Data",'twentytwentyone'),
        "parent"                => esc_html__("Parent Open Data",'twentytwentyone'),
        'menu_name'             => esc_html__('Open Data', 'twentytwentyone')
);

$supports = array(
            'title',
            'editor',
            'thumbnail',
            'custom-fields',
            'revisions',
            'comments'
);

$args = array(
        "labels"            => $labels,
        'supports'          => $supports,
        "description"       => "",
     
        "public"            => true,
        'publicly_queryable' => true,
        "show_ui"            => true,
        "has_archive"        => true,
        "show_in_menu"       => true,
        "exclude_from_search" => false,
        "capability_type"   => "post",
        "map_meta_cap"      => true,
        "hierarchical"      => true,
        "rewrite"           => array( "slug" => "open-data", "with_front" => true ),
        "query_var"         => true,
         'menu_position'    => 31,
	 'menu_icon'        => 'dashicons-lightbulb',
        'show_in_rest'          => true,
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'rest_base'             => 'open_data',
    );

register_post_type( "open_data", $args );

$labels = array(
        'name'                       => __( 'OpenData Categories', 'open_data' ),
        'singular_name'              => __( 'OpenData Category', 'open_data' ),
        'menu_name'                  => __( 'OpenData Categories', 'open_data' ),
        'edit_item'                  => __( 'Edit OpenData Category', 'open_data' ),
        'update_item'                => __( 'Update OpenData Category', 'open_data' ),
        'add_new_item'               => __( 'Add New OpenData Category', 'open_data' ),
        'new_item_name'              => __( 'New OpenData Category Name', 'open_data' ),
        'parent_item'                => __( 'Parent OpenData Category', 'open_data' ),
        'parent_item_colon'          => __( 'Parent OpenData Category:', 'open_data' ),
        'all_items'                  => __( 'All OpenData Categories', 'open_data' ),
        'search_items'               => __( 'Search OpenData Categories', 'open_data' ),
        'popular_items'              => __( 'Popular OpenData Categories', 'open_data' ),
        'separate_items_with_commas' => __( 'Separate OpenData categories with commas', 'open_data' ),
        'add_or_remove_items'        => __( 'Add or remove OpenData categories', 'open_data' ),
        'choose_from_most_used'      => __( 'Choose from the most used OpenData categories', 'open_data' ),
        'not_found'                  => __( 'No OpenData categories found.', 'open_data' ),
);

$args = array(
        'labels'            => $labels,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'show_tagcloud'     => true,
        'hierarchical'      => true,
        'rewrite'           => array( 'slug' => 'odata-category' ),
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'          => true,
        'rest_controller_class' => 'WP_REST_Terms_Controller',
        'rest_base'             => 'open_data_category',
);

$args = apply_filters( 'open_data_category_args', $args );

register_taxonomy('open-data-category', 'open_data', $args );     

// for tags
$labels = array(
        'name'                       => __( 'Tags', 'open_data' ),
        'singular_name'              => __( 'Tag', 'open_data' )
);

$args = array(
        'labels'            => $labels,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'show_tagcloud'     => true,
        'hierarchical'      => true,
        'rewrite'           => array( 'slug' => 'odata-tags' ),
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'          => true,
        'rest_controller_class' => 'WP_REST_Terms_Controller',
        'rest_base'             => 'open_data_tags',
);

register_taxonomy('tags', 'open_data', $args );     

// ----------------------------------------- end custom post type , now use ACF for adding meta informatin -----------------

 


/// -- register shortcodes for all my custom posts types -----------------------

// open_data
// zu_image_links

/* @param Array $atts
 *
 * @return string
 */
function shorcode_zu_image_links( $atts ) {
    
    global $wp_query,
        $post;

    $atts = shortcode_atts( array(
        'limit' => '',
        'category' => '',
        'display'   => ''
    ), $atts );
 
     $args = array(
        'post_type' => 'zu_image_links',
        'tax_query' => array(
            array(
            'taxonomy' => 'zu-image-links-category',
            'terms' => array($atts['category']),
            'field' => 'slug'
            )
        )
    );

    $cat_query = new WP_Query($args);
       
   
    if ($cat_query->have_posts()) 
    {
        
        if($atts['display'] == 'footer')
        {
           while ($cat_query->have_posts()) 
            {
                $cat_query->the_post();
                $_postID = get_the_ID();
                //$meta = get_post_meta($_postID);

                //$svg_icon_name = get_post_meta($_postID, 'svg_icon_name');
                //$_url = get_post_meta($_postID, 'url');
                $_all_meta = get_post_meta($_postID);
                // echo '<pre>';  print_r($_all_meta);
                
                $_classes   = ($_all_meta['is_external'][0] == 'yes') ? " class='imgcontainer pull-left external' target='_blank' " : " class='imgcontainer pull-left ' ";
                $_href      = ($_all_meta['url'][0] != '') ? $_all_meta['url'][0] : 'javascript:void(0);';
                $_alt       = get_the_title();
                $_img       = wp_get_attachment_url($_all_meta['Image'][0]);
                $_imgHover  = wp_get_attachment_url($_all_meta['image_hover'][0]);
               
                
              
                $_html .= '<div class="col-lg-2 col-md-2 pull-left">
                                <a '.$_classes.' href='.$_href.' alt='.$_alt.'>
                                    <img alt='.$_alt.' src="'.$_img.'" />
                                    <img alt='.$_alt.' src="'.$_imgHover.'" />
                                </a>
                            </div>';
            }
    
            echo $_html;
        }
        
       
    
    }
}

function shorcode_open_data(){
return false;
    
}

function register_shortcodes() {
    add_shortcode( 'zu_image_links', 'shorcode_zu_image_links' );
    add_shortcode( 'open_data', 'shorcode_open_data' );
}

add_action( 'init', 'register_shortcodes' );


/// --------------------- Register REST API ---------------------------
////////////////////////// OpenData ///////////////////////////////////
function odata_register_rest_fields(){

    register_rest_field('open_data', 'meta_data', array(
                                                            'get_callback'      => 'odata_fetch_meta',
                                                            'update_callback'   => 'odata_update_meta',
                                                            'schema'            => null,
                                                             'show_in_rest'     => true
                                                        )
            );
    
    
    register_rest_field('open_data', 'likes', array(
                                                            'get_callback'      => 'odata_fetch_meta_likes',
                                                            'update_callback'   => 'odata_update_meta_likes',
                                                            'schema'            => null,
                                                             'show_in_rest'     => true
                                                        )
            );
    
    
    // register rest route to update meta data
    
    
}

function odata_update_meta_likes( $object, $meta_value){
    // return update_post_meta($object['id'],'likes',$meta_value);
    //return update_post_meta($object->ID,'likes',$meta_value);
    // return 'odata_update_meta_likes';
}
function odata_fetch_meta_likes($object, $field_name, $request){
    // $object param is $post , will return id, date, guid,slug, status, type,link, content etc
    return get_post_meta( $object['id'], 'likes' );
}

function odata_update_meta( $object, $meta_value){
    // return update_post_meta($object['id'],'likes',$meta_value);
    return 'odata_update_meta';
}
function odata_fetch_meta($object, $field_name, $request){
    // $object param is $post , will return id, date, guid,slug, status, type,link, content etc
    return get_post_meta($object['id']);
    // return 'odata_fetch_meta';
}

add_action('rest_api_init','odata_register_rest_fields');


function my_disable_gutenberg_completely( $current_status, $post_type ) {
    return false;
}
add_filter( 'use_block_editor_for_post_type', 'my_disable_gutenberg_completely', 10, 2 );