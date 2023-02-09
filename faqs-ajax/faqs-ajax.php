<?php

/**
 * Plugin Name:       Faqs System by Ajax
 * Plugin URI:        https://mharif.com/plugins
 * Description:       qr code for blog post plugins
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            mh Arif
 * Author URI:        https://mharif.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       faqs-ajax
 * Domain Path:       /languages/
 */
function faqs_load_textdomain()
{
    load_plugin_textdomain('faqs-ajax', false, dirname(__FILE__) . "/languages");
}
add_action('plugins_loaded', 'faqs_load_textdomain');


add_action('wp_ajax_nopriv_filter_types_action', 'filter_ajax_cat_types');
add_action('wp_ajax_filter_types_action', 'filter_ajax_cat_types');

function filter_ajax_cat_types()
{

    $typesId = $_REQUEST['category'];
    $term = get_term($typesId); ?>
    <div class="faqs--area-header" style="display: block; opacity: 1;">
        <h3><img class="img-icon" src="https://cdn01.alison-static.net/public/html/site/img/faqs/refer-a-friend-programme.png"><span><?php echo $term->name; ?></span></h3>
    </div>
    <?php

    $termArgs = array(
        'hierarchical' => 1,
        'show_option_none' => '',
        'hide_empty' => 0,
        'parent' => $typesId,
        'taxonomy' => 'types'
    );
    $allTerms = get_categories($termArgs);

    echo '<ul class="faq_questions">';
    foreach ($allTerms as $subTerms) :
    ?>
        <li><i class="fa fa-angle-right"></i>
            <a data-subcat="<?php echo $subTerms->term_id; ?>" href="<?php //echo $subTerms->slug; 
                                                                        ?>">
                <h3><?php echo $subTerms->name; ?></h3>

                <span><?php
                        if ($subTerms->description) {
                            echo $subTerms->description;
                        } else {
                            echo 'How do I become Certified in my Course or Learning Path? FAQs and Answers to common queries about Getting Started on Alisons Free Learning Platform.';
                        }
                        ?></span>
            </a>
        </li>
    <?php
    endforeach;
    echo '</ul>';
    wp_die();
}

add_action('wp_ajax_nopriv_filter_subcat_action', 'filter_ajax_subcat_types');
add_action('wp_ajax_filter_subcat_action', 'filter_ajax_subcat_types');

function filter_ajax_subcat_types()
{
    $subcatId = $_REQUEST['subcat_id'];
    //echo $subcatId;
    $myFaqs = get_posts(
        array(
            'showposts' => -1,
            'post_type' => 'faqs',
            'tax_query' => array(
                array(
                    'taxonomy' => 'types',
                    'field' => 'term_id',
                    'terms' => $subcatId
                )
            )
        )
    );
    echo '<ul class="faq_answers">';
    foreach ($myFaqs as $myfaq) {
        echo '<li><i class="fa fa-angle-right"></i>';
        echo '<a data-conid="' . $myfaq->ID . '">' . $myfaq->post_title . '</a>';
        echo '</li>';
    }
    echo '</ul>';
    wp_die();
}


add_action('wp_ajax_nopriv_filter_conid_action', 'filter_ajax_conid_types');
add_action('wp_ajax_filter_conid_action', 'filter_ajax_conid_types');

function filter_ajax_conid_types()
{
    $contentId = $_REQUEST['conid_id'];
    //echo $contentId;
    $myContents = get_posts(
        array(
            'post_type' => 'faqs',
            'post_in'  => $contentId
        )
    );
    echo '<ul class="faq_content">';
    //var_dump($myContents);
    foreach ($myContents as $myContent) {
        echo $myContent->post_content;
    }
    echo '</ul>';
    wp_die();
}

add_action('wp_ajax_nopriv_filter_search_action', 'filter_ajax_search_types');
add_action('wp_ajax_filter_search_action', 'filter_ajax_search_types');
function filter_ajax_search_types()
{
    $the_query = new WP_Query(array('posts_per_page' => 5, 's' => esc_attr($_POST['keyword']), 'post_type' => 'faqs'));
    if ($the_query->have_posts()) : ?>
        <ul class="faq_answers">
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <li>
                    <a data-conid="178" href="<?php echo esc_url(post_permalink()); ?>"><?php the_title(); ?></a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php wp_reset_postdata();
    else :
        echo '<h3>No Results Found</h3>';
    endif;
    wp_die();
}


function my_scripts_method()
{ ?>
    <script>
        ;
        (function($) {
            let category = '';

            //var ajax_request_made = false;
            $(document).ready(function() {
                //its for click a category link 
                $(document).on('click', '.faqs_category_list li a', function(e) {
                    $(this).prop('disabled', true);
                    e.preventDefault();
                    // if ($(this).prop('disabled', true)) {
                    //     e.preventDefault();
                    // }

                    category = $(this).data('category');

                    var activeClass = $(this).parent("li");
                    $.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        type: 'get',
                        data: {
                            action: 'filter_types_action',
                            category: category
                        },
                        success: function(result) {
                            //alert('hello ajax ');
                            $('.faqs--area-inner').html(result);

                            $('.faqs--onclicked').css('display', 'block');
                            $('.faqs--default-area').css('display', 'none');

                            $('.faqs--area-inner').css('z-index', '1');
                            $('.faqs--area-inner2').css('z-index', '0');
                            $('.faqs--area-inner3').css('z-index', '0');


                            $('.faqs_category_list li').removeClass('active');
                            activeClass.addClass('active');
                        },
                        error: function(result) {
                            console.warn(result);
                        }
                    });



                });

            });

        })(jQuery);

        (function($) {

            let subcat = '';
            $(document).ready(function() {
                // its for click a subcat link
                $(document).on('click', '.faq_questions li a', function(ea) {
                    ea.preventDefault();

                    subcat = $(this).attr('data-subcat');
                    $.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        type: 'get',
                        data: {
                            action: 'filter_subcat_action',
                            subcat_id: subcat
                        },
                        success: function(result) {
                            $('.faqs--area-inner2').html(result);
                            $('.faqs--area-inner2').css('z-index', '1');
                            $('.faqs--area-inner').css('z-index', '0');
                            $('.faqs--area-inner3').css('z-index', '0');
                        },
                        error: function(result) {
                            console.warn(result);
                        }
                    });
                });
            });

        })(jQuery);

        (function($) {

            let conid = '';
            $(document).ready(function() {
                // its for click a subcat link
                $(document).on('click', '.faq_answers li a', function(eb) {
                    eb.preventDefault();

                    conid = $(this).attr('data-conid');
                    $.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        type: 'get',
                        data: {
                            action: 'filter_conid_action',
                            conid_id: conid
                        },
                        success: function(result) {
                            $('.faqs--area-inner3').html(result);
                            $('.faqs--area-inner3').css('z-index', '1');
                            $('.faqs--area-inner').css('z-index', '0');
                            $('.faqs--area-inner2').css('z-index', '0');
                        },
                        error: function(result) {
                            console.warn(result);
                        }
                    });
                });
            });

        })(jQuery);

        function fetchResults(e) {
            //e.preventDefault();
            var keyword = jQuery('#searchInput').val();
            if (keyword == "") {
                jQuery('.faqs--default-area').html("");
            } else {
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'post',
                    data: {
                        action: 'filter_search_action',
                        keyword: keyword
                    },
                    success: function(data) {
                        jQuery('.faqs--default-area').html(data);
                        jQuery('.faqs--default-area').css('z-index', '999');

                    }
                });
            }

        }


        let count = 0;
        jQuery('.back').click(function(ed) {
            ed.preventDefault();

            count++;

            if (count == 1) {
                jQuery('.faqs--area-inner3').css('z-index', '0');
                jQuery('.faqs--area-inner2').css('z-index', '1');
                jQuery('.faqs--area-inner').css('z-index', '0');
            } else if (count == 2) {
                jQuery('.faqs--area-inner2').css('z-index', '0');
                jQuery('.faqs--area-inner').css('z-index', '1');
                jQuery('.faqs--area-inner3').css('z-index', '0');
            } else {
                jQuery('.faqs--onclicked').css('display', 'none');
                jQuery('.faqs--default-area').css('display', 'block');
            }


            if (count === 3) {
                count = 0;
            }

        });
    </script>

<?php }

add_action('wp_footer', 'my_scripts_method');

// Register custom post type FAQS 
function register_Faqs_post_type()
{
    $labels = array(
        'name' => 'Faqs',
        'singular_name' => 'Book',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Book',
        'edit_item' => 'Edit Book',
        'new_item' => 'New Book',
        'view_item' => 'View Book',
        'search_items' => 'Search Faqs',
        'not_found' => 'No Faqs found',
        'not_found_in_trash' => 'No Faqs found in trash',
        'parent_item_colon' => 'Parent Book:',
        'menu_name' => 'Faqs',
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-book',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );

    register_post_type('faqs', $args);
}
add_action('init', 'register_Faqs_post_type');

// Register custom taxonomy for FAQS
function register_Types_taxonomy()
{
    $labels = array(
        'name' => 'Types',
        'singular_name' => 'Genre',
        'search_items' => 'Search Types',
        'all_items' => 'All Types',
        'parent_item' => 'Parent Genre',
        'parent_item_colon' => 'Parent Genre:',
        'edit_item' => 'Edit Genre',
        'update_item' => 'Update Genre',
        'add_new_item' => 'Add New Genre',
        'new_item_name' => 'New Genre Name',
        'menu_name' => 'Types',
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );

    register_taxonomy('types', array('faqs'), $args);
}
add_action('init', 'register_Types_taxonomy');
