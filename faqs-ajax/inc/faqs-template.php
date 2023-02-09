<?php

/**
 * Template Name: FAQ Custom page 
 */
get_header(); ?>
<style>
    .faqs {
        background-color: #f2f6f7;
        color: #2d3942;
    }

    .faqs .container-fluid {
        padding: 40px 80px;
        width: 100%;
    }

    .faq_title {
        color: #2d3942;
        font-size: 45px;
        font-weight: 400;
        margin-top: -10px;
        margin-bottom: 35px;
    }

    .faqs .faqs--menu {
        background-color: #fff;
        box-shadow: 0 1px 5px 0 rgba(50, 50, 50, .3);
        margin-top: 10px;
        overflow: hidden;
        padding: 20px 0;
    }

    .faqs .faqs--menu li.active,
    .faqs .faqs--menu li:hover {
        background-color: #e9eef2;
    }

    .faqs .faqs--menu li.active {
        cursor: default;
    }

    .faqs .faqs--menu li {
        cursor: pointer;
        margin: 4px 0;
        padding: 5px 20px;
        position: relative;
        transition: all .3s ease-in;
        height: 100px;
    }

    .faqs .faqs--menu li .faqs--menu-icon {
        width: 85px;
    }

    .faqs .faqs--menu li a>div {
        float: left;
    }

    .faqs .faqs--menu li .faqs--menu-title {
        width: calc(100% - 100px);
    }

    .faqs .faqs--menu li a>div {
        float: left;
    }

    .faqs .faqs--menu li.active .arrow,
    .faqs .faqs--menu li:hover .arrow {
        opacity: 1;
    }

    .faqs .faqs--menu li .arrow,
    .faqs .faqs--menu li .arrow:after {
        position: absolute;
        transition: all .5s cubic-bezier(.785, .135, .15, .86);
    }

    .faqs .faqs--menu li:hover {
        background: #e9eef2;
    }

    .faqs .faqs--menu li .arrow {
        background: 0 0;
        height: 100%;
        opacity: 0;
        overflow: hidden;
        right: -50px;
        top: 0;
        width: 50px;
    }

    .faqs .faqs--menu li a h3 {
        font-size: 22px;
        margin-bottom: 6px;
        padding-top: 3px;
        margin-top: 0px;
    }

    .faqs .faqs--menu li a p {
        color: #536476;
        font-size: 17px;
        margin-bottom: 0;
    }

    .faqs .faqs--area .back {
        background: #fff;
        border-radius: 100%;
        box-shadow: 0 1px 5px 0 rgba(50, 50, 50, .3);
        cursor: pointer;
        display: none;
        height: 40px;
        left: -50px;
        position: absolute;
        text-indent: 0;
        top: 20px;
        width: 40px;
    }

    .faqs .faqs--area .back img {
        border-radius: 50%;
        margin-left: 4px;
        margin-top: 3px;
    }

    .faqs .faqs--area .faqs--onclicked,
    .faqs .faqs--area .faqs--default-area {
        background: #fff;
        box-shadow: 0 1px 5px 0 rgba(50, 50, 50, .3);
        /* overflow: hidden; */
        height: 100%;
    }

    .faqs .faqs--area .faqs--onclicked {
        display: none;
    }

    .faqs--area-inner {
        padding: 25px 0;
    }

    .faq_questions li {
        border-bottom: 1px solid #efefef;
        color: #536476;
        cursor: pointer;
        padding: 20px 20px 20px 50px;
        position: relative;
        transform: translate(-10px);
        transition: all .3s ease-in;
        transform: translate(0);
    }

    .faq_questions li:hover {
        background: #e9eef2;
    }

    .faq_questions li i,
    .faq_answers li i {
        left: 20px;
        position: absolute;
        top: 19px;
        transition: all .3s ease-in;
        font-size: 26px;
    }

    .faq_answers li a {
        color: #2d3942;
    }

    .faq_questions li:hover:before {
        left: 25px;
    }

    .faq_questions li a h3 {
        color: #2d3942;
        font-size: 16px;
        font-weight: 400;
        margin-bottom: 15px;
        margin-top: -2px;
        text-align: left;
    }

    .faq_questions li a span {
        color: #536476;
        line-height: 23px;
    }

    .faqs--area-overflow {
        position: relative;
        height: 700px;
        overflow: hidden;
        padding: 20px;
    }

    .faqs--area-inner {
        background-color: #fff;
        height: 700px;
        width: 95%;
        position: absolute;
        /* z-index: 1; */
    }

    .faqs--area-inner2 {
        background-color: #fff;
        height: 700px;
        width: 95%;
        position: absolute;
        /* z-index: 0; */
    }

    .faqs--area-inner3 {
        background-color: #fff;
        height: 680px;
        width: 95%;
        position: absolute;
        overflow-x: hidden;
        /* z-index: 0; */
    }

    .faq_answers li {
        border-bottom: 1px solid #efefef;
        color: #536476;
        cursor: pointer;
        padding: 20px 20px 20px 50px;
        position: relative;
        transform: translate(0);
        transition: all .3s ease-in;
    }

    .faq_answers li:hover {
        background: #e9eef2;
    }

    .global-search form {
        display: flex;
    }

    #faqs-search {
        background: 0 0;
        border: 1px solid #908e92;
        border-right: 0 solid;
        width: calc(100% - 150px);
        height: 50px;
        font-size: 1.1875em;
    }

    .global-search form button {
        background-color: #0094c9;
        border: 1px solid #908e92;
        border-bottom-left-radius: 0;
        border-left: 0 solid;
        border-top-left-radius: 0;
        width: 200px;
        max-width: 145px;
        height: 50px;
        padding: 12px 0;
        margin-top: 0px;
        margin-left: -5px;
    }

    .global-search form button:hover {
        background-color: #fff;
        border: 1px solid #908e92 !important;
    }

    .faqs--area-header {
        transition: all .3s ease-in;
    }

    .faqs--area-header h3 {
        font-size: 22px;
        margin-bottom: 26px;
    }
</style>
<section class="faqs">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 left_column">
                <h2 class="faq_title">Hi. How can we help?</h2>
            </div>
            <div class="col-md-6 col-md-offset-1 right-column faqs--area">
                <div class="global-search">
                    <form method="POST" action="#" accept-charset="UTF-8">
                        <input id="faqs-search" class="form-control typeahead" id="searchInput" name="s" type="text" onkeypress="fetchResults()" placeholder="<?php esc_attr_e('Search For &hellip;', 'txt'); ?>" value="<?php the_search_query(); ?>">
                        <button class="btn btn-warning btn-flat" type="submit"><i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 left_column">
                <div class="faqs--menu">
                    <ul class="faqs_category_list">
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'types',
                            'parent' => 0,
                            'hide_empty' => false,
                        ));

                        foreach ($categories as $cat) : ?>
                            <li class="learning"><a data-category="<?php echo $cat->term_id; ?>" title="Learning">
                                    <div class="faqs--menu-icon"><img src="https://cdn01.alison-static.net/public/html/site/img/faqs/learning.png" title="Learning"></div>
                                    <div class="faqs--menu-title">
                                        <h3><?php echo $cat->name; ?></h3>
                                        <p>Helpful articles to get you started on Alison and solve technical issues</p>
                                    </div>
                                </a>
                                <div class="arrow"></div>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-1 right-column faqs--area">
                <div class="faqs--default-area">
                    <div style="padding-top: 20px;padding-bottom:20px;text-align:center;">
                        <p>Welcome to Alison's Help Center; where all your most commonly asked questions are answered.</p>
                        <p>Before contacting us, use the search (above) or browse through our categories (left) to try and find your answer.</p>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/faq-people.webp" alt="">
                    </div>
                </div>
                <div class="faqs--onclicked">
                    <div class="back" title="back" style="display: block;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/back.png"></div>
                    <div class="faqs--area-overflow">
                        <div class="faqs--area-inner">
                        </div>
                        <div class="faqs--area-inner2">
                        </div>
                        <div class="faqs--area-inner3">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>



<?php
get_footer();
