<?php
/*
Plugin Name: Simple Property Management
Plugin URI: http://kaelsteinert.com/
Description: A simple and easy way to add property listings to your site.
Author: avantegarde
Author URI: http://kaelsteinert.com/
Version: 1.0.0
Text Domain: simple-properties
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * Plugin Activation
 */
function spm_activate() {
	spm_properties_post_type();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'spm_activate' );

/**
 * Plugin Deactivation
 */
function spm_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'spm_deactivate' );

/**
 * Enqueue Styles
 */
function spm_enqueue_custom_scripts(){
	// CSS
	wp_enqueue_style('spm-bootstrap-grid', plugin_dir_url( __FILE__ ) . 'includes/css/bootstrap-grid.min.css');
	wp_enqueue_style('spm-slick', plugin_dir_url( __FILE__ ) . 'includes/css/slick.css');
	wp_enqueue_style('spm-css', plugin_dir_url( __FILE__ ) . 'includes/css/properties.css');
	// JS
	wp_enqueue_script('spm-slick', plugin_dir_url( __FILE__ ) . 'includes/js/slick.min.js', array('jquery'), 1.0, true);
	wp_enqueue_script('spm-fontawesome', 'https://kit.fontawesome.com/400d5ec791.js', array(), 1.0, false);
	wp_enqueue_script('spm-js', plugin_dir_url( __FILE__ ) . 'includes/js/spm.js', array('jquery'), 1.0, true);
}
add_action('wp_enqueue_scripts', 'spm_enqueue_custom_scripts');

/**
 * Define path and URL to the ACF plugin.
 */
define( 'MY_ACF_PATH', plugin_dir_path( __FILE__ ) . 'includes/acf-pro/' );
define( 'MY_ACF_URL', plugin_dir_url( __FILE__ ) . 'includes/acf-pro/' );

/**
 * Include the ACF plugin.
 */
include_once( MY_ACF_PATH . 'acf.php' );

/**
 * Customize the url setting to fix incorrect asset URLs.
 */
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url( $url ) {
    return MY_ACF_URL;
}

/**
 * (Optional) Hide the ACF admin menu item.
 */
add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
function my_acf_settings_show_admin( $show_admin ) {
    return false;
}

/**
 * Register Properties Post Type
 */
function spm_properties_post_type() {
  $labels = array(
      'name'                  => _x( 'Properties', 'Post Type General Name', 'lpm' ),
      'singular_name'         => _x( 'Property', 'Post Type Singular Name', 'lpm' ),
      'menu_name'             => __( 'Properties', 'lpm' ),
      'name_admin_bar'        => __( 'Properties', 'lpm' ),
      'archives'              => __( 'Property Archives', 'lpm' ),
      'attributes'            => __( 'Property Attributes', 'lpm' ),
      'parent_item_colon'     => __( 'Parent Property:', 'lpm' ),
      'all_items'             => __( 'All Properties', 'lpm' ),
      'add_new_item'          => __( 'Add New Property', 'lpm' ),
      'add_new'               => __( 'Add New', 'lpm' ),
      'new_item'              => __( 'New Property', 'lpm' ),
      'edit_item'             => __( 'Edit Property', 'lpm' ),
      'update_item'           => __( 'Update Property', 'lpm' ),
      'view_item'             => __( 'View Property', 'lpm' ),
      'view_items'            => __( 'View Properties', 'lpm' ),
      'search_items'          => __( 'Search Property', 'lpm' ),
      'not_found'             => __( 'Not found', 'lpm' ),
      'not_found_in_trash'    => __( 'Not found in Trash', 'lpm' ),
      'featured_image'        => __( 'Featured Image', 'lpm' ),
      'set_featured_image'    => __( 'Set featured image', 'lpm' ),
      'remove_featured_image' => __( 'Remove featured image', 'lpm' ),
      'use_featured_image'    => __( 'Use as featured image', 'lpm' ),
      'insert_into_item'      => __( 'Insert into item', 'lpm' ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', 'lpm' ),
      'items_list'            => __( 'Properties list', 'lpm' ),
      'items_list_navigation' => __( 'Properties list navigation', 'lpm' ),
      'filter_items_list'     => __( 'Filter Properties list', 'lpm' ),
  );
  $args = array(
      'label'                 => __( 'Property', 'lpm' ),
      'description'           => __( 'Property Listings', 'lpm' ),
      'labels'                => $labels,
      'supports'              => array( 'title', 'thumbnail', ),
      'taxonomies'            => array( 'category', 'post_tag' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'menu_icon'             => 'dashicons-admin-home',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => 'properties',
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
  );
  register_post_type( 'property', $args );
}
add_action( 'init', 'spm_properties_post_type', 0 );

/**
 * ACF Property Listings Fields
 */
if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'group_5e1e39b649655',
		'title' => 'Simple Property Management',
		'fields' => array(
			array(
				'key' => 'field_5e1e39b652316',
				'label' => 'Address',
				'name' => 'spm_prop_address',
				'type' => 'text',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5e1e39b652324',
				'label' => 'City',
				'name' => 'spm_prop_city',
				'type' => 'text',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '33',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5e1e39b65232d',
				'label' => 'State/Province',
				'name' => 'spm_prop_state_prov',
				'type' => 'text',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '33',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5e1e39b652333',
				'label' => 'Postal Code',
				'name' => 'spm_prop_postal_code',
				'type' => 'text',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '33',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5e1e39b65233c',
				'label' => 'Bedrooms (numbers only)',
				'name' => 'spm_prop_bedrooms',
				'type' => 'number',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '33',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array(
				'key' => 'field_5e1e39b652344',
				'label' => 'Bathrooms	(numbers only)',
				'name' => 'spm_prop_bathrooms',
				'type' => 'number',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '33',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array(
				'key' => 'field_5e1e39b65234d',
				'label' => 'Parking',
				'name' => 'spm_prop_parking',
				'type' => 'radio',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '33',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'yes' => 'Yes',
					'no' => 'No',
				),
				'allow_null' => 0,
				'other_choice' => 0,
				'default_value' => 'yes',
				'layout' => 'horizontal',
				'return_format' => 'value',
				'save_other_choice' => 0,
			),
			array(
				'key' => 'field_5e1e39b652355',
				'label' => 'Price (Monthly)',
				'name' => 'spm_prop_price_monthly',
				'type' => 'number',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '33',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array(
				'key' => 'field_5e1e39b65235f',
				'label' => 'Date Available',
				'name' => 'spm_prop_date_available',
				'type' => 'date_picker',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '33',
					'class' => '',
					'id' => '',
				),
				'display_format' => 'F j, Y',
				'return_format' => 'd/m/Y',
				'first_day' => 1,
			),
			array(
				'key' => 'field_5e1e39b652369',
				'label' => 'Availability',
				'name' => 'spm_prop_availability',
				'type' => 'radio',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '33',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'yes' => 'Available',
					'no' => 'Rented',
				),
				'allow_null' => 0,
				'other_choice' => 0,
				'default_value' => 'yes',
				'layout' => 'horizontal',
				'return_format' => 'value',
				'save_other_choice' => 0,
			),
			array(
				'key' => 'field_5e1e39b652371',
				'label' => 'Property Type',
				'name' => 'spm_prop_type',
				'type' => 'radio',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '100',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'singlefam' => 'Single Family',
					'student' => 'Student Rentals',
					'apt' => 'Apartment / Condo',
				),
				'allow_null' => 0,
				'other_choice' => 0,
				'default_value' => 'apt',
				'layout' => 'horizontal',
				'return_format' => 'value',
				'save_other_choice' => 0,
			),
			array(
				'key' => 'field_5e1e39b65237a',
				'label' => 'Amenities',
				'name' => 'spm_prop_amenities',
				'type' => 'repeater',
				'instructions' => 'Click the "Add Item" button below to get started. You may add as many items as you like.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => 'Add Item',
				'sub_fields' => array(
					array(
						'key' => 'field_5e1e39b6718bb',
						'label' => 'Items',
						'name' => 'spm_prop_amenity_item',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
				),
			),
			array(
				'key' => 'field_5e1e39b67802f',
				'label' => 'Gallery',
				'name' => 'spm_prop_gallery',
				'type' => 'gallery',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'preview_size' => 'medium',
				'insert' => 'append',
				'library' => 'all',
				'min' => '',
				'max' => '',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => 'jpg, jpeg, png, gif',
			),
			array(
				'key' => 'field_5e1e39b67a61f',
				'label' => 'Description',
				'name' => 'spm_prop_description',
				'type' => 'wysiwyg',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 1,
				'delay' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'property',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'the_content',
			1 => 'excerpt',
			2 => 'discussion',
			3 => 'comments',
		),
		'active' => true,
		'description' => '',
	));
	
endif;

/**
 * Properties Archive Template
 */
/*add_filter('archive_template', 'spm_prop_template_archive');

function spm_prop_template_archive($archive) {

    global $post;

    if ( $post->post_type == 'property' ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . 'templates/archive-property.php' ) ) {
            return plugin_dir_path( __FILE__ ) . 'templates/archive-property.php';
        }
    }

    return $archive;

}*/

/**
 * Properties Single Template
 */
/*add_filter('single_template', 'spm_prop_template_single');

function spm_prop_template_single($single) {

    global $post;

    if ( $post->post_type == 'property' ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . 'templates/single-property.php' ) ) {
            return plugin_dir_path( __FILE__ ) . 'templates/single-property.php';
        }
    }

    return $single;

}*/

function wikicon_include_templates( $template_path ) {
	if ( 'property' === get_post_type() || 'property' === get_query_var('post_type') ) {
			if ( is_singular() ) {
					$template_path = plugin_dir_path( __FILE__ ) . 'templates/single-property.php';
			}
			elseif ( is_search() ) {
					$template_path = plugin_dir_path( __FILE__ ) . 'templates/search-property.php';
			}
			elseif ( is_archive() || is_404() ) {
					$template_path = plugin_dir_path( __FILE__ ) . 'templates/archive-property.php';
			}
	}

	return $template_path;
}
add_filter( 'template_include', 'wikicon_include_templates', 999, 1 );

/**
 * Property Listings Shortcode
 */
function spm_prop_listings_shortcode($atts, $content = null) {
  ob_start();
  // Attributes
  extract(shortcode_atts(
          array(
              'posts' => '6',
              'category' => '',
              'order' => 'DESC',
              'availability' => 'yes',
              'slideset' => 'false',
          ), $atts)
  );
  $slideset_class = '';
  if($slideset === 'yes'){
      $slideset_class = 'prop-slideset';
  }

  // Code
  $listing_args = array(
      'post_type' => 'property',
      'product_cat' => $category,
      'posts_per_page' => $posts,
      'meta_key'     => 'spm_prop_availability',
      'meta_value'   => $availability,
      'order' => $order
  );
  $listing_query = new WP_Query($listing_args);
  if ($listing_query->have_posts()) : ?>
      <?php
      $postCount = $listing_args['posts_per_page'];
      $columnWidth = 'col-sm-6 col-md-3';
      if ($postCount === '1') {
          $columnWidth = 'col-md-12';
      } else if ($postCount === '2') {
          $columnWidth = 'col-sm-12 col-md-6';
      } else if ($postCount === '3' || $postCount === '6') {
          $columnWidth = 'col-sm-6 col-md-4';
      }
      ?>
      <div class="property-list <?php echo $slideset_class; ?>">
          <?php while ( $listing_query->have_posts() ) : $listing_query->the_post(); ?>
              <?php
              /**
               * Property Fields
               */
              $prop_address = get_field( "spm_prop_address" );
              $prop_city = get_field( "spm_prop_city" );
              $prop_province = get_field( "spm_prop_province" );
              $prop_postal_code = get_field( "spm_prop_postal_code" );
              $prop_bedrooms = get_field( "spm_prop_bedrooms" );
              $prop_bathrooms = get_field( "spm_prop_bathrooms" );
              $prop_price_monthly = get_field( "spm_prop_price_monthly" );
              // Property Image
              $feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
              $image = $feat_image[0] ? $feat_image[0] : get_template_directory_uri() . '/inc/images/hero.jpg';
              // parking
              $prop_parking = get_field_object('spm_prop_parking');
              $parking_value = $prop_parking['value'];
              $parking_label = $prop_parking['choices'][ $parking_value ];
              if ($parking_value == 'yes') {
                  $parking_string = 'Parking Included';
              } else {
                  $parking_string = 'Parking Not Included';
              }
              // Availability
              $prop_availability = get_field_object('spm_prop_availability');
              $availability_value = $prop_availability['value'];
              $availability_label = $prop_availability['choices'][ $availability_value ];
              if ($availability_value == 'yes') {
                  $availability = '<span class="available">Available</span>';
                  $availability_class = 'available';
              } else {
                  $availability = '<span class="rented">Rented</span>';
                  $availability_class = 'rented';
              }
              // Date Available
              $prop_date_available = get_field( "spm_prop_date_available", false, false);
              $prop_date = new DateTime($prop_date_available);
              $prop_av_end_date = $prop_date->format('Ymd');
              if ( $prop_av_end_date <= date('Ymd') && $availability_value != 'yes' ) {
                  $availability_string = 'Rented';
              } else if ( $prop_av_end_date <= date('Ymd') && $availability_value === 'yes' ) {
                  $availability_string = 'Available Now';
              } else {
                  $availability_string = 'Available ' . $prop_date->format('F j, Y');
              }
              ?>
              <div class="listing-item <?php echo $columnWidth; ?>">
                  <article id="listing-<?php echo $post->ID; ?>" class="listing-<?php echo $post->ID; ?> listing-card <?php echo $availability_class; ?>">
                      <header class="listing-header panel" style="background-image:url(<?php echo $image; ?>);">
                          <a href="<?php the_permalink(); ?>">
                              <?php echo $availability; ?>
                              <div class="details">
                                  <h1 class="listing-title"><?php the_title(); ?></h1>
                                  <p class="listing-address"><?php echo $prop_city . ', ' . $prop_province; ?></p>
                                  <p class="price"><?php echo '$' . $prop_price_monthly . '/month'; ?></p>
                              </div>
                          </a>
                      </header><!-- .entry-header -->

                      <div class="listing-content panel">
                          <ul class="arrows listing-info">
                              <li><i class="fa fa-bed" aria-hidden="true"></i> <?php echo $prop_bedrooms; ?> Bedroom</li>
                              <li><i class="fa fa-bath" aria-hidden="true"></i> <?php echo $prop_bathrooms; ?> Bathroom</li>
                              <li><i class="fa fa-car" aria-hidden="true"></i> <?php echo $parking_string; ?></li>
                              <li><i class="fa fa-home" aria-hidden="true"></i> <strong><?php echo $availability_string; ?></strong></li>
                          </ul>
                      </div><!-- .entry-content -->
                      <div class="listing-footer">
                          <a href="<?php the_permalink(); ?>" class="arrow" data-button="black">View Listing</a>
                      </div>
                  </article>
              </div>
          <?php endwhile; ?>
      </div><!-- .slideset-listings -->
  <?php else : ?>
      <p class="center">Sorry! Looks like there are no listings found within your criteria. Try broadening your search and try again.</p>
  <?php endif;
  $output = ob_get_clean();
  return $output;
}

add_shortcode('property-list', 'spm_prop_listings_shortcode');

/**
 * Property Search Form
 */
function spm_get_property_search() {
  $search_form = '<form role="search" method="get" class="spm-search-filter" action="' . site_url("properties/") . '">' .
              //'<a href="/properties/locations/" class="button locations">Locations</a>' .
              '<input type="hidden" name="s" value=""/>' .
              '<input type="hidden" name="search-type" value="property-search"/>' .
              '<input type="number" name="price" min="100" step="100" placeholder="Search by $" class="search_price" />' .
              '<input type="number" name="bdrms" min="1" step="1" placeholder="Search # of Bedrooms" class="search_bedrooms" />' .
              '<select name="ltype" class="search_ltype">' .
              '   <option value="">All</option>' .
              '   <option value="apt">Apartment / Condo</option>' .
              '   <option value="singlefam">Single Family</option>' .
              '   <option value="student">Student Rentals</option>' .
              '</select>' .
              //'<input type="blog-search" class="form-control search_text" name="s" action="" aria-label="..." placeholder="Search...">' .
              '<button class="button do_search">Go</button>' .
          '</form>';
  return $search_form;
}
