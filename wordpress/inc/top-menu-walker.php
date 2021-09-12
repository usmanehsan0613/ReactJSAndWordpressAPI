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
if ( ! class_exists( 'top_walkernav' ) ) :
	/**
	 * WP_Bootstrap_Navwalker class.
	 */
	class top_walkernav extends Walker_Nav_Menu
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
        // echo "<!-- start_lvl - ".$depth." -->";
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        // echo "<!-- end_lvl - ".$depth." -->";
    }

    public function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0){
        
       // echo "<!-- end_el ".$depth. $item->title ." -->";
        
      
    }
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
          //echo "<!-- start_el ".$depth. $item->title ." -->";
          
        ! empty ( $item->attr_title )
                     // Avoid redundant titles
                     and $item->attr_title !== $item->title

                     and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';

                     $attributes  .= trim( $attributes );

                     $title       = apply_filters( 'the_title', $item->title, $item->ID );

                    
                     
                    $class_names = implode(' ', ($item->classes));
                    $class_names = ' class=" btn '.esc_attr($class_names).'"';
                     
                     $item_output .= "$args->before<a $class_names $attributes>$args->link_before$title</a>"
                                                       . "$args->link_after$args->after";
        
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

