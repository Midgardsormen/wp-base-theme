
<?php
  $menu_name = 'menu-1';
  $locations = get_nav_menu_locations();
  $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
  $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

?>
<div id="base-component-main-navigation-<?php echo $menu -> slug; ?>" class="base-main-navigation base-main-navigation--horizontal">
    <button 
        class="js-active-menu js-active-overlay base-main-navigation__open-btn" 
        aria-expanded="false" 
        aria-controls="<?php echo $menu -> slug; ?>" 
        data-listtarget="<?php echo  $menu_name ; ?>" 
        aria-label="Ouvrir ou Fermer le <?php echo $menu -> name; ?>"
    >
            <span class="dashicons dashicons-menu menu-icon-open">&nbsp;</span><span class="dashicons dashicons-no menu-icon-close">&nbsp;</span>
    </button>     
    <nav 
        id="<?php echo $menu -> slug; ?>" 
        class="base-main-navigation__menu js-toggle-menu <?php echo  $menu_name ; ?>" 
        aria-label="<?php echo $menu -> name; ?>" 
        role="navigation"
    >
        <ul  >
            <?php loopInMenu($menuitems, $menuitems, true); ?> 
        </ul>
    </nav>
    <?php
        function loopInMenu( $baseArray, $array , $isFirstLevel, $level = 0) {
            $menu_name = 'menu-1';
            $locations = get_nav_menu_locations();
            $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
            $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );
            $baseArray = $menuitems;

            $level++ ;
            
            foreach( $array as $menu_item ) {
                if( $menu_item->menu_item_parent == 0 ) {
                    $parent = $menu_item->ID;
                    }; 
                    $currentId = $menu_item->ID;
                    ${'menu_array' . $level} = array_filter( $baseArray, function($obj) use ($currentId, $isFirstLevel){
                        return $obj->menu_item_parent === strval($currentId);
                    });
                if ((!$menu_item->menu_item_parent && $isFirstLevel) || !$isFirstLevel):?>

                    <li  class="base-main-navigation__item <?php if (count( ${'menu_array' . $level} ) > 0):?> base-main-navigation__item--has-children<?php endif; ?> cat-<?php echo $menu_item->ID; ?> base-main-navigation__item--child-of-<?php echo $menu_item->menu_item_parent; ?>" >
                        <a href="<?php echo  $menu_item->url ; ?>"><?php echo  $menu_item->title ; ?> </a>  
                            <?php if (count( ${'menu_array' . $level} ) > 0):?>
                                <button 
                                    aria-label = "Ouvrir ou fermer le sous-menu <?php echo $menu_item->title; ?>"
                                    aria-expanded="false"
                                    aria-controls = "sub-menu-<?php echo $menu_item->ID; ?>"
                                    class="js-active-menu base-main-navigation__item-toggle-btn" 
                                    data-listtarget="sub-menu-<?php echo $menu_item->ID; ?>"
                                >
                                    <span class="dashicons dashicons-arrow-down-alt2">&nbsp;</span>
                                </button>                            
                                <ul                                 
                                    id="sub-menu-<?php echo $menu_item->ID; ?>"
                                    class="base-main-navigation__sub-menu base-main-navigation__sub-menu--level-<?php echo  $level ; ?> sub-menu-<?php echo $menu_item->ID; ?>"
                                >
                                    <?php loopInMenu( $array, ${'menu_array' . $level}, false, $level )?> 
                                </ul>
                            <?php endif; ?>

                    </li>
                    
                <?php endif; ?>
            
            <?php 
            $count++; 
            }
        } 
    ?>
</div>