@extends('layouts/frontend/Theme39/main')
@section('content')
<section id="featured-title" class="featured-title row-background row-parallax">
    <div class="strip-bg"></div>
    <div class="container">
        <div class="row">
            <div class="title">
                <h1>About</h1>
                <h3 class='subtitle'>LET'S GET FAMILIAR WITH US & WHAT WE'RE DOING</h3> </div>
        </div>
    </div>
</section>
<div class="breadcrumb-wrapper container">
    <ul class="breadcrumb">
        <li>
            <span><a class="home" href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]"><span>Home</span></a></span>
        </li>
        <li>
            <span><span>About</span></span>
        </li>
    </ul>
</div>
<main id="main" class="main clearfix">
    <div class="container">
        <div class="row">
            <section id="content" class="site-content hfeed site-content col-xs-12 col-sm-12 col-md-12" role="main">
                <article class="page-content post-2 page type-page status-publish hentry clearfix">
                    <div class="entry-content">
                        <div class="fitsc-row ">
                            <?php   
                           $allimages = explode(',', $about->banner_images);
                            $count = count($allimages);
                            $value = rand(1, $count) - 1;
                            ?>
                            <div class="row">
                                <div class="fitsc-column col-md-4 col-sm-4 col-xs-12">
                                    <img src="<?php
                                    if (!empty($allimages[$value]))
                                        echo "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/website/banner-images/" . $allimages[$value];
                                    ?>" alt="about img" width="370" height="240" class="alignleft size-full wp-image-2000" />
                                </div>
                                <div class="fitsc-column col-md-8 col-sm-8 col-xs-12 share-friends_">
                                    <h5 class="fitsc-heading fitsc-heading-default fitsc-font-medium   clearfix"><span>COMPANY INTRODUCTION</span></h5>
                                    <span class="fitsc-dropcap dropcap">A</span><p><?php echo $about->page_content; ?></p>
                                    <h6>SHARE WITH YOUR FRIENDS 
                                        <a href="<?php // echo $this->FACEBOOK->link; ?>"><i class="fitsc-icon fa fa-facebook fitsc-icon-type-box"></i></a>
                                        <a href="<?php //echo $this->TWITTER->link; ?>"><i class="fitsc-icon fa fa-twitter fitsc-icon-type-box"></i></a>
                                        <a href="<?php //echo $this->GOOGLE->link; ?>"><i class="fitsc-icon fa fa-google-plus fitsc-icon-type-box"></i></a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="fitsc-space fitsc-space-about-1"></div>
                        <div class="fitsc-row fitsc-row-about-1 row-fluid">
                            <div class="row"></div>
                        </div>
                    </div>
                </article>
            </section>

        </div>
    </div>
</main>


@endsection()   