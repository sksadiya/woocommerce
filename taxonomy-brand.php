<?php
get_header();
?>

<div class="container py-5">
    <h1><?php single_term_title(); ?></h1>

    <?php
    // Display child brand navigation
    $current_brand_id = get_queried_object_id();
    $child_brand_terms = get_terms(
        array(
            'taxonomy' => 'brand',
            'parent'   => $current_brand_id,
        )
    );

    if (!empty($child_brand_terms)) :
    ?>
        <ul class="nav nav-pills  mb-4">
            <li class="nav-item"><a class="nav-link bg-dark active" href="<?php echo esc_url(get_term_link($current_brand_id, 'brand')); ?>">Show All</a></li>
            <?php foreach ($child_brand_terms as $child_brand) : ?>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="<?php echo esc_url(get_term_link($child_brand)); ?>">
                        <?php echo esc_html($child_brand->name); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="row" id="car-list">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                $car_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $car_brand_terms = get_the_terms(get_the_ID(), 'brand');
                $car_brand = !empty($car_brand_terms) ? reset($car_brand_terms) : null;
                ?>
                <div class="col-md-4 mb-4 car-item">
                    <div class="card">
                        <img src="<?php echo esc_url($car_image); ?>" class="card-img-top" alt="<?php the_title(); ?>" loading="lazy">
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title(); ?></h5>
                            <p class="card-text"><?php the_excerpt(); ?></p>
                            <p class="card-categories">Brand: <?php echo $car_brand ? esc_html($car_brand->name) : 'N/A'; ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-dark">Read more</a>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;
            wp_reset_postdata(); // Reset post data to restore the main query
        else :
            ?>
            <p>No cars found for the selected brand</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
