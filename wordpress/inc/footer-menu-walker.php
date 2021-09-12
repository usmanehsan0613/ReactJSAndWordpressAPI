<?php
 

// Check if Class Exists.
if ( ! class_exists( 'T5_Nav_Menu_Walker_Simple' ) ) :
	 
 class T5_Nav_Menu_Walker_Simple extends Walker_Nav_Menu
 {
	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
    
    
         /*
          *  <!-- start_el--0  Key Sites -->
          *     <!-- start_lvl--0 -->
          *         <!-- start_el--1  Course Catalog -->
          *         <!-- end_el--1Course Catalog -->
          * 
          *         <!-- start_el--1  Enroll -->
          *         <!-- end_el--1Enroll -->
          * 
          *         <!-- start_el--1  Students Login -->
          *         <!-- end_el--1Students Login -->
          * 
          *         <!-- start_el--1  Employee Login -->
          *         <!-- end_el--1Employee Login -->
          * 
          *         <!-- start_el--1  Blackboard -->
          *         <!-- end_el--1Blackboard -->
          * 
          *     <!-- end_lvl--0 -->
          * <!-- end_el--0Key Sites -->
          * 
          * <!-- start_el--0  Intranet -->
          *     <!-- start_lvl--0 -->
          *         <!-- start_el--1  Policies -->
          *         <!-- end_el--1Policies -->
          * 
          *         <!-- start_el--1  Telephone Directory -->
          *         <!-- end_el--1Telephone Directory -->
          *     <!-- end_lvl--0 -->
          * <!-- end_el--0Intranet -->
          * 
          */
    
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0  )
	{
		  echo '<!-- start_el--'.$depth.'  '.$item->title.' -->';
                 
		$attributes  = '';

                if($depth == 0){
                    
                    ! empty ( $item->attr_title )
			// Avoid redundant titles
			and $item->attr_title !== $item->title
                        
			and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';

                        $attributes  .= trim( $attributes );

                        $title       = apply_filters( 'the_title', $item->title, $item->ID );

                        $item_output = "<div class='footer-block col-lg-6 col-md-6 col-xs-12'>"; 
                         
                        $item_output .= "$args->before<h5 $_classes $attributes>$args->link_before$title</h5>"
                                                          . "$args->link_after$args->after";
                                                                
                          
                        
                        
                }
                
                else if($depth > 0){
                
                    $output     .= '<li '.($item->current ? ' class="list-group-item current"':'class="list-group-item"').'level-'.$depth.'>';
                
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

	/**
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = array())
	{
           echo '<!-- start_lvl--'.$depth.''.$item->title.' -->';
            
            $output .= '<ul class="list-group">';
	}

	/**
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() )
	{
            echo '<!-- end_lvl--'.$depth.''.$item->title.' -->';
            
            $output .= '</ul>';
            
            if($depth == 0)
            {
                $output .= "</div> <!-- wrapper div-->"; 
               
            }
	}

	/**
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
	{
            echo '<!-- end_el--'.$depth.''.$item->title.' -->';
            
            $output .= '</li>';
	}
}

endif;



// Check if Class Exists.
if ( ! class_exists( 'Footer_Bottom_Menu_Walker' ) ) :
	 
 class Footer_Bottom_Menu_Walker extends Walker_Nav_Menu
 {
	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
    
    
          
    
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0  )
	{
		  
                 
		$attributes  = '';

                
                    
                ! empty ( $item->attr_title )
                    // Avoid redundant titles
                    and $item->attr_title !== $item->title

                    and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';

                    $attributes  .= trim( $attributes );

                    $_data_title     = ' data-original-title='.$item->description.'';
                    $_data_placement = ' data-placement="top" ';
                    $_data_toggle = ' data-toggle="tooltip" ';
                    $_href      = ' href="'.$item->url.'" ';
                    
                    $title       = apply_filters( 'the_title', $item->title, $item->ID );

                   $item_output .= "$args->before<a $_href $_classes $attributes $_data_title $_data_placement $_data_toggle>$args->link_before$title</a>"
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

	/**
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = array())
	{
            
	}

	/**
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() )
	{
            
	}

	/**
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
	{
           
	}
}

endif;