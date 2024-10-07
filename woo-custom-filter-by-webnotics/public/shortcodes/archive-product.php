<?php get_header(); ?>
<style type="text/css">
	.theme-neve .wrapper {
		overflow: unset !important;
	}

	div#fullscreen-wcpfloader {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.7);
		z-index: 9999;
		display: none;
		justify-content: center;
		align-items: center;
	}

	.wcpfloader {
		border: 12px solid #f3f3f3;
		border-top: 12px solid #c7cbce;
		border-radius: 50%;
		width: 80px;
		height: 80px;
		animation: spin 2s linear infinite;
	}

	@keyframes spin {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}

	.site-main>* {
		margin-top: 0;
	}

	.wcpf_main_wrapper {
		margin-top: 35px;
		margin-bottom: 35px;
		width: 100%;
	}

	.wcpf_main_wrapper .row {
		display: flex;
		flex-wrap: wrap;
		margin-left: -15px;
		margin-right: -15px;
	}

	.wcpf_main_wrapper .col-md-3 {
		width: 25%;
		max-width: 25%;
		padding-left: 15px;
		padding-right: 15px;
	}

	.wcpf_main_wrapper .col-md-9 {
		width: 75%;
		max-width: 75%;
		padding-left: 15px;
		padding-right: 15px;
	}

	.wcpf_main_wrapper .col-md-12 {
		width: 100%;
	}

	.wcpf_main_section_filter .chosen-container {
		width: 100% !important;
	}

	.sticky_filter {
		position: absolute;
		left: 0;
		top: 7%;
		z-index: 999;
		border-top-right-radius: 5px;
		border-bottom-right-radius: 5px;
		width: 25%;
	}

	.wcpf_for_mobile {
		position: relative;
	}

	.wcpf_main_section_filter {
		padding: 20px 12px;
		border: 1px solid gainsboro;
		background: #fff;
	}

	.sticky_filter #wcpf_toggleButton {
		display: block;
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
		padding: 10px 16px;
		position: fixed;
		border: none;
		cursor: pointer;
	}

	.sticky_filter.open_filter #wcpf_toggleButton {
		position: absolute;
		right: 0;
		z-index: 9999;
		border: none;

	}

	.sticky_filter #wcpf_toggleDiv {
		display: none;
	}

	img.filter-icon {
		filter: invert(1) brightness(1000%);
		height: 20px;
		position: relative;
		top: 3px;
	}

	.wcpf_main_section_filter .close {
		float: right;
		cursor: pointer;
		display: none;
		padding-top: 5px;
		color: black;
		font-weight: bold;
	}

	@media (max-width: 767px) {
		.wcpf_main_section_filter .close {

			display: block;
		}

		.wcpf_main_wrapper .col-md-3,
		.wcpf_main_wrapper .col-md-9 {
			width: 100%;
			max-width: 100%;
		}

		.wcpf_for_mobile {
			margin: 10px 0px;
			position: relative;
		}

		.wcpf_for_mobile #wcpf_toggleButton {
			background: whitesmoke;
			background-color: whitesmoke;
			border: 1px solid #dbdbdb;
			padding: 5px 13px;
			position: fixed;
			left: 0;
			top: 33%;
			z-index: 999;
		}

		.wcpf_main_section_filter {
			position: fixed;
			bottom: 0;
			z-index: 999999;
			background: #f7f7f7;
			padding: 0px 25px 20px;
			border: 1px solid gainsboro;
			width: 100%;
			height: 100%;
			overflow: auto;
		}

		#wcpf_toggleDiv {
			display: none;
		}

		.wcpf_main_wrapper {
			margin-top: 10px;
			margin-bottom: 10px;
		}

		.sticky_filter.open_filter #wcpf_toggleButton {
			position: static !important;
		}

		.sticky_filter {
			border: none !important;
			width: 35%;
		}

		.sticky_filter.open_filter #wcpf_toggleDiv {
			bottom: 40px;
		}

	}

	@media (min-width: 768px) {
		.wcpf_pagination_show ul {
			display: flex;
		}

		.wcpf_pagination_show ul li:not(.woocommerce-pagination ul li) {
			width: 50%;
			list-style: none;
		}

		#wcpf_toggleButton {
			display: none;
		}

		#wcpf_toggleDiv:not(.sticky_filter #wcpf_toggleDiv) {
			display: block !important;
		}
	}
</style>
<?php
global $wp_query;

$total_products = $wp_query->found_posts;
$products_per_page = get_option('posts_per_page');
$current_page = max(1, get_query_var('paged'));

// Calculate the product range on the current page
$start_product = ($current_page - 1) * $products_per_page + 1;
$end_product = min($current_page * $products_per_page, $total_products);

//do_action( 'woocommerce_before_main_content' );
$sticky_filter = get_option('wpcf_enable_sticky_filter_form');
$dir = WCPFCF_PLUGIN_DIR_URL;
?>
<?php
$buttonStyle = $buttonTextStyle = "";
$options = get_option('wpcf_customize_style_options');


if (isset($options['button_background_color'])) {
	$buttonStyle .= 'background-color: ' . esc_attr($options['button_background_color']) . '; ';
}

if (isset($options['button_font_family'])) {
	$buttonStyle .= 'font-family: ' . esc_attr($options['button_font_family']) . '; ';
}

if (isset($options['button_font_size'])) {
	$buttonStyle .= 'font-size: ' . esc_attr($options['button_font_size']) . 'px; ';
}

if (isset($options['button_text_color'])) {
	$buttonStyle .= 'color: ' . esc_attr($options['button_text_color']) . '; ';
}

if (!empty($buttonStyle)) {
	$buttonStyle = 'style="' . $buttonStyle . '"';
}
if (isset($options['button_text_color'])) {
	$buttonTextStyle = 'style="color: ' . esc_attr($options['button_text_color']) . ';"';
}
?>

<div id="fullscreen-wcpfloader">
	<div class="wcpfloader"></div>

</div>

<div id="wcpf_primary" class="wcpf_main_wrapper">
	<div class="container">
		<div class="row">
		<div class="<?= $sticky_filter ? 'sticky_filter' : 'col-md-3'; ?>">
				<div class="wcpf_for_mobile">
					<button id="wcpf_toggleButton" <?= $buttonStyle; ?>><img class="filter-icon"
							src="<?= $dir; ?>/assets/images/filter.svg" alt="filter-icon">
						Filters</button>
					<div id="wcpf_toggleDiv">
						<?php echo do_shortcode('[WCPF_shop_page_let_sidebar]'); ?>
					</div>
				</div>

			</div>
			<div class="<?php echo $sticky_filter ? 'col-md-12' : 'col-md-9'; ?>">

				<div class="wcpf_main_content">
					<?php
					if (woocommerce_product_loop()) {

						do_action('woocommerce_before_shop_loop');

						woocommerce_product_loop_start();
						// Start the loop
						if (wc_get_loop_prop('total')) {
							while (have_posts()):
								the_post();

								// Include the template for the content
								wc_get_template_part('content', 'product');

							endwhile;
							woocommerce_product_loop_end();
						}



						?>
						<div class="wcpf_pagination_show">
							<ul>
								<li>
									<p>Showing <?php echo $start_product; ?> -<?php echo $end_product ?> of
										<?php echo $total_products ?> results
									</p>
								</li>
								<li>
									<?php do_action('woocommerce_after_shop_loop'); ?>
								</li>
							</ul>
						</div>
						<?php
					} else {
						do_action('woocommerce_no_products_found');
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>


<?php get_footer(); ?>




<script type="text/javascript">
	jQuery(document).ready(function () {
		// Attach a click event handler to the button
		jQuery('#wcpf_toggleButton,.close').on('click', function () {
			// Toggle the visibility of the div
			jQuery.fn.slideToggleLeft = function (duration) {
				var $elem = this;
				if ($elem.css('display') === 'none') {
					$elem.css({
						position: 'relative',
						left: '-100%',
						display: 'block'
					}).animate({
						left: 0
					}, duration);

					jQuery('.sticky_filter').addClass('open_filter');
					jQuery('html, body').animate({ scrollTop: 0 }, 500);
				} else {
					$elem.animate({
						left: '-100%'
					}, duration, function () {
						$elem.css('display', 'none'); jQuery('.sticky_filter').removeClass('open_filter');
					});

				}
			};

			jQuery('#wcpf_toggleDiv').slideToggleLeft(500);


		});
	});
</script>