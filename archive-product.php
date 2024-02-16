<?php
get_header();

$current_term_id = get_queried_object_id();

$terms = get_terms('product_cat');

if (!empty($terms)) {
    echo '<div class="container my-4">';
    echo '<ul class="nav nav-pills">'; ?>
    <li class="nav-item">
    <a href="#" class="rounded-circle btn btn-dark add-to-cart-button text-white me-5" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" data-product-id="' . esc_attr(get_the_ID()) . '"><i class="bi bi-cart "></i></a>
    </li>
    <?php foreach ($terms as $term) {
            echo '<li class="nav-item">';
            echo '<a class="nav-link';
            echo ($term->term_id === $current_term_id) ? ' active' : '';
            echo '" href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
            echo '</li>';
        
    }
    echo '</ul>';
    echo '</div>';
}

echo '<div class="container py-4">';
echo '<div class="row g-4">'; // Use Bootstrap 5 grid classes

if (have_posts()) {
    while (have_posts()):
        the_post(); ?>

        <div class="col-md-4">
            <div class="card">
                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) ?>" class="card-img-top"
                    alt="' . esc_attr(get_the_title()) . '" loading="lazy">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>" class="text-dark text-decoration-none">
                            <?php echo esc_html(get_the_title()); ?>
                        </a>
                    </h5>
                    <p class="card-text">
                        <?php echo esc_html(get_the_excerpt()); ?>
                    </p>
                    <a href="?add-to-cart=<?php echo esc_attr(get_the_ID()) ?>" class="btn btn-dark add-to-cart-button" data-product-id="<?php echo esc_attr(get_the_ID()); ?>">Add to Cart</a>
                </div>
            </div>
        </div>

    <?php endwhile;
} else {
    echo '<p>No products found</p>';
}

echo '</div>';
echo '</div>';

?>
<div class="offcanvas offcanvas-end py-5" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Shopping Cart</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="cart-offcanvas-body">
        <!-- Cart items will be dynamically added here -->
        <a href="/cart" class="btn btn-primary">View Cart</a>
</div>
</div>

<?php
get_footer();
?>
