<?php 

/* rest route */
add_action('rest_api_init', 'register_zu_routes');

// http://localhost/zupress/wp-json/post_info/post?id=122
// http://localhost/zupress/wp-json/wp/v2/posts

function register_zu_routes(){
    register_rest_route( 'post_info', 'post',array(
            'methods'  => 'GET',
            'callback' => 'get_post_details'
        ));
}

function get_post_details( $params ){
    return $params['id'];
}  


// -- more detailed API 
// https://www.sitepoint.com/creating-custom-endpoints-for-the-wordpress-rest-api/

// http://localhost/zupress/open-data/wp-json/zutheme/v1/latest-posts/<CATEGORY_ID>

// http://localhost/zupress/open-data/wp-json/zutheme/v1/latest-posts/1

// http://localhost/zupress/open-data/wp-json/wp/v2/open_data

// https://allt-uae.zu.ac.ae/www-zu/open-data/wp-json/zutheme/v1/latest-posts/3

/*
add_action('rest_api_init', function () {
  register_rest_route( 'zutheme/v1', 'latest-posts/(?P<category_id>\d+)',array(
                'methods'  => 'GET',
                'callback' => 'get_latest_posts_by_category',
                'permission_callback' => function() {
                    return current_user_can('edit_posts');
                }
      ));
});


function get_latest_posts_by_category($request) {

    $args = array(
            'category' => $request['category_id']
    );
    
   //$args = array(
   //         'sanitize_callback' => function($value, $request, $param) {
   //             if($value < 6){
   //                 return 6;
   //         };
   // });
    

    $posts = get_posts($args);
    if (empty($posts)) {
    return new WP_Error( 'empty_category', 'there is no post in this category', array('status' => 404) );

    }

    $response = new WP_REST_Response($posts);
    $response->set_status(200);

    return $response;
}
*/


class Latest_Posts_Controller extends WP_REST_Controller 
{
    
    public $post_type_category = 'open-data-category';
            
    public $post_type          = 'open_data';
 
    public static $_namepsace = 'zutheme/v1';
    
  public function register_routes() {
      
    $namespace      = 'zutheme/v1';
    
    $path           = 'latest-posts/(?P<category_id>\d+)';
    
    $path_year      = 'latest-posts/year/(?P<year>\d+)/category/(?P<category>\d+)';
    
    $path_search     = 'latest-posts/year/(?P<year>\d+)/category/(?P<category>\d+)/keyword/(?P<keyword>[^/]+)';
    
    $path_post_meta = 'update-posts-meta/';
    
   
    register_rest_route( $namespace, '/' . $path, [
            array(
                  'methods'             => 'GET', 
                  'callback'            => array( $this, 'get_items' ),
                  'permission_callback' => array( $this, 'get_items_permissions_check' )
              ),
        ]); 
    
    // by year
    register_rest_route( $namespace, '/' . $path_year, [
            array(
                  'methods'             => 'GET', 
                  'callback'            => array( $this, 'get_items_year' ),
                  'permission_callback' => array( $this, 'get_items_permissions_check' )
              ),
        ]); 
    
    // by general search
    register_rest_route( $namespace, '/' . $path_search, [
            array(
                  'methods'             => 'GET', 
                  'callback'            => array( $this, 'get_items_search' ),
                  'permission_callback' => array( $this, 'get_items_permissions_check' )
              ),
        ]); 
    
    
        register_rest_route( $namespace, '/' . $path_post_meta, [
            array(
                  'methods'             => 'POST', 
                  'callback'            => array( $this, 'update_item' ),
                  'permission_callback' => array( $this, 'update_item_permissions_check' )
              ),
        ]);   
    
    }
    
    
    public function get_items_permissions_check( $request ) {
        return 'true';
    }
    
    
    // get all the items count, such as total files, / posts
    // all categories and count of posts in each categories 
    public function get_items(  $request) {
       
        /*
          $args = array(
            'post_type' => $this->post_type,
            'tax_query' => array(
                array(
                'taxonomy' => $this->post_type_category,
                'terms'     => $request['category_id'] 
              
                )
            )
        );
         * 
         * //  $posts =  (get_posts( $args ));
       
        */

        $reponse = array();
          $category = array();
          
            
            $_posts = array();

            $_subposts = array();
            
            $_total_posts = 0;
            
        if( isset($request['category_id']) && (int) $request['category_id'] > 0 )
        {
            $catID = (int) $request['category_id']; 
            
            //all categories still needed to load dropdown values.
            
            $args = array(
               'taxonomy' => $this->post_type_category,
               'orderby' => 'name',
               'order'   => 'ASC',
               'post_type' => $this->post_type,
               'type' => 'post'
            );
            
            
            $cats = get_categories($args);
            
            $args = array(
                'post_type' => $this->post_type,
                'tax_query' => array(
                    array(
                        'taxonomy' => $this->post_type_category,
                        'terms'     => $catID 
                    )
                )
            );

           //  print_r($args);
            
            $_post = get_posts( $args );
  
            foreach( $_post as $pos ):
                
                $_subposts[$pos->ID] = get_post_meta( $pos->ID );
                
                if( $_subposts[$pos->ID]['type'] != '' ){
                    $_subposts[$pos->ID]['type'] =   unserialize($_subposts[$pos->ID]['type'][0]);
                }
            
                if( $pos->post_date != ''){
                    $_subposts[$pos->ID]['format_post_date'] = date("F j, Y", strtotime($pos->post_date));
                }
                
                if( $_subposts[$pos->ID]['download_csv'] != '' ){
                    $_subposts[$pos->ID]['download_csv'] = get_the_guid($_subposts[$pos->ID]['download_csv'][0]);
                    $_subposts[$pos->ID]['download_pdf'] = get_the_guid($_subposts[$pos->ID]['download_pdf'][0]);
                    $_subposts[$pos->ID]['download_xml'] = get_the_guid($_subposts[$pos->ID]['download_xml'][0]);
                    $_subposts[$pos->ID]['download_xls'] = get_the_guid($_subposts[$pos->ID]['download_xls'][0]);
                }
                
            endforeach; 

            $_posts[$catID]['posts'] =  $_post;       
            
            $response['category']       = $cats;
            $response['posts']          = $_posts;
            $response['posts_meta']     = $_subposts;

            // because each post will have the downloads
            $_total_posts = count($_post);
            $response['total_downloads'] = $_total_posts;
             
        }
        else
        {
             
            $args = array(
               'taxonomy' => $this->post_type_category,
               'orderby' => 'name',
               'order'   => 'ASC',
               'post_type' => $this->post_type,
               'type' => 'post'
            );
            
            
            $cats = get_categories($args);
        
            if( !empty($cats) ):

                 foreach( $cats as $cat ):

                    $category[] = $cat;

                    if( $cat->category_count > 0):
                        $_total_posts += $cat->category_count;
                    endif;

                    $args = array(
                        'post_type' => $this->post_type,
                        'tax_query' => array(
                            array(
                                'taxonomy' => $this->post_type_category,
                                'terms'     => $cat->term_id 
                            )
                        )
                    );

                    $_post = get_posts( $args );

                    foreach( $_post as $pos ):
                        
                        $_subposts[$pos->ID] = get_post_meta( $pos->ID );
                    
                        if( $_subposts[$pos->ID]['type'] != '' ){
                            $_subposts[$pos->ID]['type'] =   unserialize($_subposts[$pos->ID]['type'][0]);
                        }
                        
                        if( $pos->post_date != ''){
                            $_subposts[$pos->ID]['format_post_date'] = date("F j, Y", strtotime($pos->post_date));
                        }
                
                        if( $_subposts[$pos->ID]['download_csv'] != '' ){
                            $_subposts[$pos->ID]['download_csv'] = get_the_guid($_subposts[$pos->ID]['download_csv'][0]);
                            $_subposts[$pos->ID]['download_pdf'] = get_the_guid($_subposts[$pos->ID]['download_pdf'][0]);
                            $_subposts[$pos->ID]['download_xml'] = get_the_guid($_subposts[$pos->ID]['download_xml'][0]);
                            $_subposts[$pos->ID]['download_xls'] = get_the_guid($_subposts[$pos->ID]['download_xls'][0]);
                        }
                        
                    endforeach; 

                    $_posts[$cat->term_id]['posts'] =  $_post;       //$_post[0]->ID;
                    //$_posts[$cat->term_id]['meta'] =  $_subposts;


                endforeach;

                // echo '<pre>'; print_r($_subposts); echo '</pre>';

                $response['category']       = $category;
                $response['posts']          = $_posts;
                $response['posts_meta']     = $_subposts;

                // because each post will have the downloads
                $response['total_downloads'] = $_total_posts;

            endif;  
            
        }
        
        if (empty($_total_posts)) {

            return new WP_Error( $request['category_id'].' empty_category '.$request['tax_id'], 'there is no post in this category', array( 'status' => 404 ) );
        }
    
        $send = new WP_REST_Response( $response );
    
        $send->set_status(200);

        return $send;
        
    }
    
    public function get_items_year( $request ){
        
        $_year = (int) $request['year'];
        
        $_catID = (int) $request['category'];

        if( 
                (!isset($_year) || $_year < 0  || $_year < 2010) 
          ){
            return new WP_Error( ' Invalid Year ', 'there are no post in this year', array( 'status' => 404 ) );
        }
            
        $reponse = array();
               
        $category = array();
            
        $_posts = array();

        $_subposts = array();
            
        $_total_posts = 0;
            
        $args = array(
               'taxonomy' => $this->post_type_category,
               'orderby' => 'name',
               'order'   => 'ASC',
               'post_type' => $this->post_type,
               'type' => 'post'
          );
            
            
        $cats = get_categories($args);
        
        if($_catID > 0 && $_catID != NULL)
        {
            $args = array(
                    'date_query' => array(
                        array('year' => $_year),
                    ),
                    'posts_per_page' => -1,
                    'post_type' => $this->post_type,
                    'post_status' => 'publish',
                    'order' => 'ASC',
                    'tax_query' => array(
                            array(
                                'taxonomy' => $this->post_type_category,
                                'terms'     => $_catID 
                            )
                        )
                );
        }
        else
        {
            $args = array(
                'date_query' => array(
                    array('year' => $_year),
                ),
                'posts_per_page' => -1,
                'post_type' => $this->post_type,
                'post_status' => 'publish',
                'order' => 'ASC'
            );

        }
        
        $query = new WP_Query( $args );
        
        // echo '<pre>'; print_r($query);
        $_posts = $query->posts;
        $_total_posts = count($_posts);
        
        foreach( $_posts as $pos ):
            $_subposts[$pos->ID] = get_post_meta( $pos->ID );
        endforeach; 
                    
        $response['category']       = $cats;
        $response['posts']          = $_posts;
        $response['posts_meta']     = $_subposts;

        // because each post will have the downloads
        $response['total_downloads'] = $_total_posts;
        
        $send = new WP_REST_Response( $response );
    
        $send->set_status(200);

        return $send;

    }
    
    
    public function get_items_search( $request ){
        
        $_year = (int) $request['year'];
        
        $_catID = (int) $request['category'];
        
        $_keyword = (string) sanitize_text_field($request['keyword']);

        if(  (!isset($_keyword) || $_keyword == ""  || $_keyword == NULL ) ){
            return new WP_Error( ' Invalid keyword ', 'there are no keyword in this list', array( 'status' => 404 ) );
        }
        
        if(  (!isset($_year) || $_year < 0  || $_year < 2010) ){
            //return new WP_Error( ' Invalid Year ', 'there are no post in this year', array( 'status' => 404 ) );
            $_year = NULL;
        }
        
        if(  ($_catID < 0 || $_catID == NULL ) ) {
            //return new WP_Error( ' Invalid Year ', 'there are no post in this year', array( 'status' => 404 ) );
            $_catID = NULL;
        }
            
        $reponse = array();
               
        $category = array();
            
        $_posts = array();

        $_subposts = array();
            
        $_total_posts = 0;
            
        $args = array(
               'taxonomy' => $this->post_type_category,
               'orderby' => 'name',
               'order'   => 'ASC',
               'post_type' => $this->post_type,
               'type' => 'post'
          );
            
            
        $cats = get_categories($args);
        
        $_searchArgs = array();
        
        $_searchArgs = array(
            'posts_per_page' => -1,
            'post_type' => $this->post_type,
            'post_status' => 'publish',
            'order' => 'ASC',
             's' => $_keyword
        );
         
        
        if( $_catID > 0 && $_catID != NULL )
        {
            
            $_searchArgs['tax_query'] = array(
                            array(
                                'taxonomy' => $this->post_type_category,
                                'terms'     => $_catID 
                            )
                 );
        }
          
        if($_year !== NULL){
            
            $_searchArgs['date_query'] = array(
                        array('year' => $_year),
                    );
        }
            
        $query = new WP_Query( $_searchArgs );
        
        // -- echo '<pre>'; print_r($_searchArgs);
        
        $_posts = $query->posts;
        $_total_posts = count($_posts);
        
        foreach( $_posts as $pos ):
            $_subposts[$pos->ID] = get_post_meta( $pos->ID );
        endforeach; 
                    
        $response['category']       = $cats;
        $response['posts']          = $_posts;
        $response['posts_meta']     = $_subposts;

        // because each post will have the downloads
        $response['total_downloads'] = $_total_posts;
        
        $send = new WP_REST_Response( $response );
    
        $send->set_status(200);

        return $send;

    }
    
    public function create_item($request){
        
    }
    
    public function update_item_permissions_check( $request ) {
      
        // -- to check user persmissions in this method.
        // -- if its true than it means permissions are done, 
        // -- false will return below error.
        /*
         * {
                "code": "rest_forbidden",
                "message": "Sorry, you are not allowed to do that.",
                "data": {
                    "status": 403
                }
            }
         * 
         */
        return current_user_can('edit_posts');
        
        //return true;
    }
    
    public function update_item( $request ){
        
        // -- below is culprit :) 
        
        header( "Access-Control-Allow-Origin: *");
        header( "Access-Control-Allow-Methods: GET,HEAD,PUT,POST,OPTIONS" );
        header( "Access-Control-Allow-Credentials: true" );
        header( "Access-Control-Allow-Headers: *" );
        
        $response = array();
        
        $post['id']            = (int)    $_POST['postID'];   //'45454';
        $post['meta_key']      = (string) $_POST['meta_key'];
        $post['meta_value']    = (string) $_POST['meta_value'];
        

        if( update_post_meta( $post['id'], $post['meta_key'], sanitize_text_field( $post['meta_value'] )) )
        {
            $_newdata = get_post_meta( $post['id'], 'likes' );
            $response['message'] = 'OK';
            $response['code'] = 200;
            $response['new_data'] = $_newdata;
            return wp_send_json_success($response, 200, 1);
            // return new WP_Error( 'valid object', 'there is item to update'.$post['id'].$post['meta_key'], array( 'status' => 404 ) );
        }
        else
        {
            return new WP_Error( 'invalid_object', 'there is no item to update'.$post['id'].$post['meta_key'], array( 'status' => 404 ) );
        }

    }
    
    public function delete_item($request){
        
    }
    
    public function get_item($request){
        
    }
    
     
}


add_action('rest_api_init', function () {           
     
    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
     
    add_filter( 'rest_pre_serve_request',  'iniCors' , 12 );
    //header( "Access-Control-Allow-Origin: *" );
    
    $latest_posts_controller = new Latest_Posts_Controller();
     
    $latest_posts_controller->register_routes();
     
});

 function wprc_add_acf_posts_endpoint( $allowed_endpoints ) 
 {
    // print_r( $allowed_endpoints );
    if ( ! isset( $allowed_endpoints[ 'zutheme/v1' ] ) || ! in_array( 'latest-posts', $allowed_endpoints[ 'zutheme/v1' ] ) ) {
        $allowed_endpoints[ 'zutheme/v1' ][] = 'latest-posts';
    }
    
   // print_r( $allowed_endpoints );
    return $allowed_endpoints;
 }
  
// add_filter( 'wp_rest_cache/allowed_endpoints', 'wprc_add_acf_posts_endpoint', 10, 1);
add_filter( 'rest_allow_anonymous_comments', '__return_true' );
       
function iniCors( $value )
{
     $origin_url = 'http://localhost:3333';
     // Check if production environment or not
     header( "Access-Control-Allow-Origin: *");
     header( "Access-Control-Allow-Methods: GET,HEAD,PUT,POST,OPTIONS" );
     header( "Access-Control-Allow-Credentials: true" );
     header( "Access-Control-Allow-Headers: * " );
     return $value;
}

?>    


