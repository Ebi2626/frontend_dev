<!DOCTYPE html>
<html <?php language_attributes(); ?>>

    <head>

        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width" />
        <?php wp_head(); ?>

    </head>

    <body <?php body_class(); ?>>

        <?php wp_body_open(); ?>

        <div id="wrapper">
            <header class="container" id="header">
                <nav class="navbar navbar-expand-md">
                    <div class="container-fluid px-0">
                       <a 
                        class="navbar-brand" 
                        id="logo"
                        href="<?php esc_url( home_url( "/" ) ); ?>" 
                        title="<?php esc_attr( get_bloginfo( "name" ) ); ?>" 
                        rel="home" 
                        itemprop="url">
                            <?php 
                                if(function_exists('the_custom_logo')){ // getting sure if wordpress version supports logo
                                    $custom_logo_id = get_theme_mod('custom_logo');
                                    $logo = wp_get_attachment_image_src($custom_logo_id)[0]; // getting url and dimensions
                            ?>
                                <img width="100" height="100" class="logo" src="<?php echo $logo; ?>" alt="Edwin Harmata - logo złożone z inicjałów i operatorów logicznych" />
                            <?php } ?>
                        </a>
                        <button class="navbar-toggler text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Rozwiń menu">
                            <i class="fas fa-bars" aria-hidden="true"></i>
                        </button>   
                        <?php wp_nav_menu( 
                            array( 
                                'theme_location' => 'main-menu',
                                'container_class' => 'collapse navbar-collapse',
                                'container_id' => 'navbarNav',
                                'menu' => 'main-menu',
                                'menu_class' => 'navbar-nav ms-auto mb-2 mb-lg-0'
                                ) 
                            ); ?>
                    </div>
                </nav>

                <!-- <nav id="menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                    
                    <div id="search"><?php //get_search_form(); ?></div>

                </nav> -->

            </header>

            <div id="container" class="container main-content">