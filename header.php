<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-5">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo site_url() ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="" width="80"
                        height="44">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_front_page() ? 'active' : ''; ?>" aria-current="page"
                                href="<?php echo site_url() ?>">Home</a>
                        </li>

                        <?php
                        $brand_terms = get_terms('brand', array('parent' => 0)); // Get only parent brands
                        
                        foreach ($brand_terms as $brand):
                            $brand_slug = esc_attr($brand->slug);
                            $brand_link = get_term_link($brand); // Get the link for the brand archive page
                            $child_brand_terms = get_terms('brand', array('parent' => $brand->term_id));

                            if (empty($child_brand_terms)):
                                // If no child brands, display a regular nav item
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo is_tax('brand', $brand->slug) ? 'active' : ''; ?>"
                                        href="<?php echo esc_url($brand_link); ?>">
                                        <?php echo esc_html($brand->name); ?>
                                    </a>
                                </li>
                            <?php else: ?>
                                <!-- If there are child brands, display a dropdown menu -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle <?php echo is_tax('brand', $brand->slug) ? 'active' : ''; ?>"
                                        href="<?php echo esc_url($brand_link); ?>" role="button" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <?php echo esc_html($brand->name); ?>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown<?php echo $brand->term_id; ?>">
                                        <a class="dropdown-item" href="<?php echo esc_url($brand_link); ?>">All</a>

                                        <?php foreach ($child_brand_terms as $child_brand): ?>
                                            <a class="dropdown-item <?php echo is_tax('brand', $child_brand->slug) ? 'active' : ''; ?>"
                                                href="<?php echo esc_url(get_term_link($child_brand)); ?>">
                                                <?php echo esc_html($child_brand->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                                <?php
                            endif;
                        endforeach;
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo is_shop() ? 'active' : ''; ?>" aria-current="page"
                                href="<?php echo site_url('/shop'); ?>">Shop</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

    </header>