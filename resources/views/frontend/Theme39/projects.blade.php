@extends('layouts/frontend/Theme39/main')
@section('content')
<section id="featured-title" class="featured-title row-background row-parallax">
    <div class="strip-bg"></div>
    <div class="container">
        <div class="row">
            <div class="title"><h1>Projects</h1><h3 class='subtitle'>Let's take a look at our best & big projects</h3></div>
        </div>
    </div>
</section>
<div class="breadcrumb-wrapper container">
    <ul class="breadcrumb">
        <li>
            <span><a class="home" href="<?php //echo Yii::app()->getBaseUrl(true);  ?>"><span itemprop="title">Home</span></a></span>
        </li>
        <li>
            <span><span>Projects</span></span>
        </li>
    </ul>
</div>
<main id="main" class="main clearfix" >
    <div class="container">
        <div class="row">
            <section id="content" class="site-content hfeed site-content col-xs-12 col-sm-12 col-md-12">
                <article class="page-content post-1898 page type-page status-publish hentry clearfix">

                    <div class="entry-content">
                        <div class="fitsc-portfolio portfolio-no-gutter columns-4 show-filter">
                            <div class="portfolio-filter"><a href="#" data-group="all">All Projects</a>
                                <a href="#" data-group="Current">Current Pojects</a>
                                <a href="#" data-group="Future">Future Pojects</a>
                                <a href="#" data-group="Completed">Completed Pojects</a>
                            </div>
                            <div class="projects" data-gutter="0">
                                <?php
                                if (isset($current)) {
                                    foreach ($current as $projects) {
                                        $image_url = "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/" . $projects['project_logo'];
                                        ?>

                                        <figure class="project" data-groups="[&quot;Current&quot;]">
                                            <div class="figure-image"><img width="384" height="276" src="<?php echo $image_url; ?>" class="attachment-portfolio-thumbnail" alt="Building-Trades" />
                                            </div>
                                            <figcaption>
                                                <h3><strong><?php echo ucwords(substr($projects['project_name'], 0, 15) . '...'); ?></strong></h3>
                                                <a href="<?php echo "project-details/" . $projects['id']; ?>" class="view-project">View Project</a>
                                            </figcaption>
                                        </figure>
                                    <?php }
                                } ?> 			


                                <?php
                                if (isset($upcoming)) {
                                    foreach ($upcoming as $projects) {
                                        $image_url = "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/" . $projects['project_logo'];
                                        ?>

                                        <figure class="project" data-groups="[&quot;Future&quot;]">
                                            <div class="figure-image"><img width="384" height="276" src="<?php echo $image_url; ?>" class="attachment-portfolio-thumbnail" alt="Building-Trades" />
                                            </div>
                                            <figcaption>
                                                <h3><strong><?php echo ucwords(substr($projects['project_name'], 0, 15) . '...'); ?></strong></h3>
                                                <a href="<?php echo "project-details/" . $projects['id']; ?>" class="view-project">View Project</a>
                                            </figcaption>
                                        </figure>
                                    <?php }
                                } ?> 
                                <?php
                                if (isset($completed)) {
                                    foreach ($completed as $projects) {
                                        $image_url = "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/" . $projects['project_logo'];
                                        ?>

                                        <figure class="project" data-groups="[&quot;Completed&quot;]">
                                            <div class="figure-image"><img width="384" height="276" src="<?php echo $image_url; ?>" class="attachment-portfolio-thumbnail" alt="Building-Trades" />
                                            </div>
                                            <figcaption>
                                                <h3><strong><?php echo ucwords(substr($projects['project_name'], 0, 15) . '...'); ?></strong></h3>
                                                <a href="<?php echo "project-details/" . $projects['id']; ?>" class="view-project">View Project</a>
                                            </figcaption>
                                        </figure>	
    <?php }
} ?> 			
                            </div>
                        </div>
                        <br>
                    </div>
                    </div>
                </article>
            </section>
        </div>
    </div>
</main>
@endsection()