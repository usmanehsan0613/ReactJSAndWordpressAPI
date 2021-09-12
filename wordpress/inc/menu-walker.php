<?php
/**
 * WP Bootstrap Navwalker
 *
 * @package WP-Bootstrap-Navwalker
 *
 * @wordpress-plugin
 * Plugin Name: WP Bootstrap Navwalker
 * Plugin URI:  https://github.com/wp-bootstrap/wp-bootstrap-navwalker
 * Description: A custom WordPress nav walker class to implement the Bootstrap 4 navigation style in a custom theme using the WordPress built in menu manager.
 * Author: Edward McIntyre - @twittem, WP Bootstrap, William Patton - @pattonwebz
 * Version: 4.3.0
 * Author URI: https://github.com/wp-bootstrap
 * GitHub Plugin URI: https://github.com/wp-bootstrap/wp-bootstrap-navwalker
 * GitHub Branch: master
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

// Check if Class Exists.
if ( ! class_exists( 'walkernav' ) ) :
	/**
	 * WP_Bootstrap_Navwalker class.
	 */
	class walkernav extends Walker_Nav_Menu
{

    public $megaMenuID;

    public $count;

    public function __construct()
    {
        $this->megaMenuID = 0;

        $this->count = 0;
        
        $this->iteration = 0;
        
        $this->ItemsInOneLi = 0;
        
        $this->columnBreak = 0;
        
        $this->hasImage = false;
        
        $this->Image = NULL;
    }

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        echo "<!-- start_lvl - ".$depth." -->";
        
        
       $output .= '<ul class="dropdown-menu col-lg-12 col-md-12 col-xs-12 col-sm-12">';
        
       $output     .= '<li class="col-lg-3 col-md-3 col-xs-4 col-sm-4" level-'.$depth.'>';
        
        $output     .=  '<div class="menu-search">';
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        echo "<!-- end_lvl - ".$depth." -->";
         
        
        // before closing the level, first see if any of the posts does have featured-image 
        // if yes than display it and show it 
        if( $this->hasImage == true && $this->Image != NULL ){
        
             $output .= "</div>";

             $output .= "</li>";

             $output     .= '<li class="col-lg-3 col-md-3 col-xs-4 col-sm-4" level-'.$depth.'>';

             $output     .=  '<div class="menu-search">';
                        
             $output .= "<div class='menu-img-container'>".$this->Image."</div>";
             
             $this->Image = NULL;
             
             $this->hasImage = false;
        }
       
        
        
            $output .= "</div>";
            
            $output .= "</li>";
        
        $output .= '</ul>';
        
        $this->iteration = 0;
            
    }

    public function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0){
        
        echo "<!-- end_el ".$depth. $item->title ." -->";
        
        if($depth == 0)
            $output .= '</li>';
    }
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
          echo "<!-- start_el ".$depth. $item->title ." -->";
          
          $attributes  = '';

          if($depth == 0)
          {
              // echo '<pre>'; print_r($item);
                    
                    ! empty ( $item->attr_title )
			// Avoid redundant titles
			and $item->attr_title !== $item->title
                        
			and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';

                        $attributes  .= trim( $attributes );

                        $title       = apply_filters( 'the_title', $item->title, $item->ID );

                        $_classes = 'class="menuitem"';
                                
                        $item_output = "<li class='".$item->classes[0]." dropdown'>"; 
                         
                        $item_output .= "$args->before<a $_classes $attributes>$args->link_before$title</a>"
                                                          . "$args->link_after$args->after";
                }
                
                else if($depth > 0)
                {
                
                   $this->ItemsInOneLi++;
                
                   
                    // once it has displayed 12 links in one li , close the li and re-open it.
                    // 
                     if($this->ItemsInOneLi%13 == 0){

                        $this->columnBreak++;
                        
                        $output .= "</div>";

                        $output .= "</li>";

                        $output     .= '<li class="col-lg-3 col-md-3 col-xs-4 col-sm-4" level-'.$depth.'>';

                        $output     .=  '<div class="menu-search">';

                     }
                     
                    if( $item->description != ''){
                    
                        $output .= '<h5 class="submenu-heading" '.$this->ItemsInOneLi.'>'.$item->description.'</h5>';
                        
                        $this->iteration +=1; 
                    }
                   
                   
                    ! empty ( $item->attr_title )
                            // Avoid redundant titles
                            and $item->attr_title !== $item->title

                            and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';

                    ! empty ( $item->url )
                            and $attributes .= ' href="' . esc_attr( $item->url ) .'"';

                    $attributes  = trim( $attributes );

                    $title       = apply_filters( 'the_title', $item->title, $item->ID );

                    $item_output = "$args->before<a $attributes>$args->link_before$title</a>"
                                                    . "$args->link_after$args->after";

                    
                     // check if any of post has featured-images class and it has image
                    // Check if item has featured image
                    
                    $has_featured_image = array_search('featured-image', $item->classes);
                    
                    if ( $has_featured_image !== false ) {
                        
                        $this->hasImage = true;
                        
                        $postID = url_to_postid( $item->url );
                        
                        $this->Image .= "<img class='img-responsive' alt=\"" . esc_attr($item->attr_title) . "\" src=\"" . get_the_post_thumbnail_url( $postID ) . "\"/>";
                    
                    }
                    
                    
                    
                    
                    
                }
                
		// Since $output is called by reference we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
			,   $item_output
			,   $item
			,   $depth
			,   $args
		);
           
    }

   
}

endif;


require_once 'top-menu-walker.php';

