<?php
/*
Template Name: Front Page
*/

get_header();
?>

<div class="container py-5">
    <div class="brand-navigation mb-3">
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link bg-dark active" href="<?php echo home_url(); ?>">Show All</a></li>
            <?php
            $brand_terms = get_terms('brand');

            foreach ($brand_terms as $brand):
                $brand_slug = esc_attr($brand->slug);
                $brand_link = get_term_link($brand); // Get the link for the brand archive page
            
                // Check if the term has any parent terms
                $parent_terms = get_ancestors($brand->term_id, 'brand');
                if (empty($parent_terms)):
                    ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="<?php echo esc_url($brand_link); ?>">
                            <?php echo esc_html($brand->name); ?>
                        </a>
                    </li>
                    <?php
                endif;
            endforeach;
            ?>
        </ul>
    </div>

    <div class="row" id="car-list">
        <?php
        $selected_brand = isset($_GET['brand']) ? sanitize_text_field($_GET['brand']) : 'all';

        $car_query_args = array(
            'post_type' => 'car',
            'posts_per_page' => -1,
        );

        if ($selected_brand !== 'all') {
            $car_query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'brand',
                    'field' => 'slug',
                    'terms' => $selected_brand,
                ),
            );
        }

        $car_query = new WP_Query($car_query_args);

        if ($car_query->have_posts()):
            while ($car_query->have_posts()):
                $car_query->the_post();
                $car_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $car_brand_terms = get_the_terms(get_the_ID(), 'brand');
                $car_brand = !empty($car_brand_terms) ? reset($car_brand_terms) : null;

                if ($car_brand && is_object($car_brand)) {
                    $brand_slug = esc_attr($car_brand->slug);
                } else {
                    $brand_slug = 'unknown';
                }

                ?>
                <div class="col-md-4 mb-4 car-item" data-brand="<?php echo $brand_slug; ?>">
                    <div class="card">
                        <img src="<?php echo esc_url($car_image); ?>" class="card-img-top" alt="<?php the_title(); ?>"
                            loading="lazy">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php the_title(); ?>
                            </h5>

                            <a class="btn btn-dark" data-bs-toggle="collapse" href="#collapse-<?php echo $brand_slug; ?>"
                                role="button" aria-expanded="false" aria-controls="collapseExample">
                                Toggle Description
                            </a>

                            <div class="collapse" id="collapse-<?php echo $brand_slug; ?>">
                                <p class="card-text">
                                    <?php the_excerpt(); ?>
                                </p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-dark">Read more</a>
                            </div>


                            <!-- Link to single post page -->
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata(); // Reset post data to restore the main query
        else:
            ?>
            <p>No cars found</p>
        <?php endif; ?>
    </div>
</div>



<?php get_footer(); ?>