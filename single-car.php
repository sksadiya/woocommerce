<?php get_header(); ?>

<div class="bg-dark text-secondary px-4 py-5 text-center">
    <div class="py-5">
        <?php
        while (have_posts()):
            the_post();
            $car_title = get_the_title();
            $car_excerpt = get_the_excerpt();
            ?>
            <h1 class="display-5 fw-bold text-white">
                <?php echo esc_html($car_title); ?>
            </h1>
            <p class="fs-5 mb-4 px-lg-5 mx-lg-5">
                <?php echo esc_html($car_excerpt); ?>
            </p>
        <?php endwhile; ?>
        <div class="col-lg-6 mx-auto">
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="#single-car" class="btn btn-outline-light btn-lg px-4 me-sm-3 fw-bold">View Details</a>
            </div>
        </div>
    </div>
</div>



<?php
while (have_posts()):
    the_post();
    $car_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
    $car_brand_terms = get_the_terms(get_the_ID(), 'brand');
    $car_brand = !empty($car_brand_terms) ? reset($car_brand_terms) : null;
    ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <img src="<?php echo esc_url($car_image); ?>" class="card-img-top" alt="<?php the_title(); ?>"
                        loading="lazy">
                    <div class="card-body" id="single-car">
                        <h1 class="card-title">
                            <?php the_title(); ?>
                        </h1>
                        <p class="card-categories">Brand:
                            <?php echo $car_brand ? esc_html($car_brand->name) : 'N/A'; ?>
                        </p>
                        <div class="row mt-5">
                            <div class="col-md-6 mb-5">
                                <strong class="me-5"><i class="bi bi-airplane-engines me-2"></i>Engine</strong>
                                <?php echo get_field('range'); ?>
                            </div>
                            <div class="col-md-6 mb-5">
                                <strong class="me-5"><i class="bi bi-ev-front me-2"></i>Power</strong>
                                <?php echo get_field('battery_capacity'); ?>
                            </div>
                            <div class="col-md-6 mb-5">
                                <strong class="me-5"><i class="bi bi-arrow-clockwise me-2"></i>Torque</strong>
                                <?php echo get_field('charging_time_ac'); ?>
                            </div>
                            <div class="col-md-6 mb-5">
                                <strong class="me-5"><i class="bi bi-diagram-3 me-2"></i>Seating Capacity</strong>
                                <?php echo get_field('power'); ?>
                            </div>
                            <div class="col-md-6 mb-5">
                                <strong class="me-5"><i class="bi bi-power me-2"></i>Drive Type</strong>
                                <?php echo get_field('charging_time_dc'); ?>
                            </div>
                            <div class="col-md-6 mb-5">
                                <strong class="me-5"><i class="bi bi-badge-cc me-2"></i>Mileage</strong>
                                <?php echo get_field('boot_space'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="flex-shrink-0 p-3 bg-dark card" style="width: 280px;">
                    <a href="/" class="d-flex align-items-center pb-3 mb-3 link-white text-decoration-none border-bottom">
                        <svg class="bi me-2" width="30" height="24">
                            <use xlink:href="#bootstrap"></use>
                        </svg>
                        <span class="fs-5 fw-semibold text-white">Brands</span>
                    </a>
                    <ul class="list-unstyled ps-0">
                        <?php
                        $categories = get_categories(
                            array(
                                'taxonomy' => 'brand',
                                'hide_empty' => false,
                                'parent' => 0,
                            )
                        );

                        foreach ($categories as $category):
                            $child_categories = get_categories(
                                array(
                                    'taxonomy' => 'brand',
                                    'hide_empty' => false,
                                    'parent' => $category->term_id,
                                )
                            );
                            ?>
                            <li class="mb-1">
                                <?php if (!empty($child_categories)): ?>
                                    <button class="btn btn-toggle align-items-center rounded collapsed text-white"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#<?php echo esc_attr($category->slug); ?>-collapse" aria-expanded="false">
                                        <?php echo esc_html($category->name); ?>
                                    </button>
                                    <div class="collapse" id="<?php echo esc_attr($category->slug); ?>-collapse">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                            <?php foreach ($child_categories as $child_category): ?>
                                                <li class="text-white"><a class="text-white text-decoration-none" href="<?php echo esc_url(get_category_link($child_category)); ?>">
                                                        <?php echo esc_html($child_category->name); ?>
                                                    </a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php else: ?>
                                    <a href="<?php echo esc_url(get_category_link($category)); ?>"
                                        class="btn link-light align-items-center rounded">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>


<?php endwhile;

 get_footer(); ?>