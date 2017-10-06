@extends('layouts/frontend/theme31/main')
@section('content') 
<div class="content-area">

    <!-- PAGE -->
    <section id="offers" class="page-section">
        <div class="container">
            <h2 class="section-title wow fadeInUp" data-wow-offset="70" data-wow-delay="100ms">
                <small>What a Kind of home You Want</small>
                <span>Great Offers for You</span>
            </h2>
            <div class="tabs wow fadeInUp" data-wow-offset="70" data-wow-delay="300ms">
                <ul id="tabs" class="nav">
                    <?php if (!empty($current)) { ?>
                        <li class="active"><a href="#tab-1" data-toggle="tab">Current Projects</a></li>
                        <?php if (!empty($upcoming)) { ?>
                            <li ><a href="#tab-2" data-toggle="tab">Future Projects</a></li>
                        <?php } ?>
                        <?php if (!empty($completed)) { ?>  
                            <li ><a href="#tab-3" data-toggle="tab">Completed Projects</a></li>
                        <?php } ?>
                    <?php } else if (!empty($upcoming)) {
                        ?>
                        <li class="<?php if (empty($current)) echo 'active'; ?>"><a href="#tab-2" data-toggle="tab">Future Projects</a></li>                
                        <?php if (!empty($completed)) { ?>
                            <li><a href="#tab-3" data-toggle="tab">Completed Projects</a></li>
                        <?php } ?>
                    <?php } else if (!empty($completed)) { ?>
                        <li class="<?php if (empty($current) && empty($upcoming)) echo 'active'; ?>"> <a href="#tab-3" data-toggle="tab">Completed Projects</a></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="tab-content wow fadeInUp" data-wow-offset="70" data-wow-delay="500ms" style="height:815px;">
                <div class="tab-pane fade active in" id="tab-1">
                    <?php
                    if (!empty($current)) {
                        ?>
                        <div class="swiper swiper--offers-popular">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php
                                    foreach ($current as $projects) {

//                                            
                                        ?>    
                                        <div class="swiper-slide">
                                            <div class="thumbnail no-border no-padding thumbnail-car-card" align="center">
                                                <?php if (!empty($projects['project_logo'])) { ?>
                                                    <a class="btn btn-theme ripple-effect"  href="<?php //echo $this->getProjectsUrl($projects->id, $projects->seo_url, 'ongoing');   ?>">
                                                        <div class="media" align="center">
                                                            <?php $path = $projects['project_logo'];
                                                            ?>
                                                            <img src="<?php echo "[[config('global.s3Path')]]project/project_logo/" . $path; ?>" alt=""/>
                                                        </div>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                                <div class="caption text-center">
                                                    <h4 class="caption-title"><a href="#"><?php
                                                            echo ucwords(substr($projects['project_name'], 0, 20));
                                                            if (strlen($projects['project_name']) > 20) {
                                                                echo '...';
                                                            }
                                                            ?></a></h4>
                                                    <div class="caption-text"><?php echo $projects['project_status']; ?></div>
                                                    <div class="buttons">
                                                        <a class="btn btn-theme ripple-effect"  href="<?php echo "project-details/" . $projects['id']; ?>">More Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>           
                                </div>
                            </div>
                            <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
                            <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
                        </div>
                    <?php } ?>
                </div>
                <div class="tab-pane fade active <?php if (empty($current)) echo 'in'; ?> " id="tab-2">
                    <?php
                    if (!empty($upcoming)) {
                        ?>
                        <div class="swiper swiper--offers-economic">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php
                                    foreach ($upcoming as $projects) {
                                        ?>
                                        <div class="swiper-slide">
                                            <div class="thumbnail no-border no-padding thumbnail-car-card" align="center">
                                                <?php if (!empty($projects['project_logo'])) { ?>
                                                    <a class="btn btn-theme ripple-effect"  href="<?php //echo $this->getProjectsUrl($projects->id, $projects->seo_url, 'ongoing');   ?>">
                                                        <div class="media" align="center">
                                                            <?php $path = $projects['project_logo'];
                                                            ?>
                                                            <img src="<?php echo "[[config('global.s3Path')]]project/project_logo/" . $path; ?>" alt=""/>
                                                        </div>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                                <div class="caption text-center">
                                                    <h4 class="caption-title"><a href="#"><?php
                                                            echo ucwords(substr($projects['project_name'], 0, 20));
                                                            if (strlen($projects['project_name']) > 20) {
                                                                echo '...';
                                                            }
                                                            ?></a></h4>
                                                    <div class="caption-text"><?php echo $projects['project_status']; ?></div>
                                                    <div class="buttons">
                                                        <a class="btn btn-theme ripple-effect"  href="<?php //echo $this->getProjectsUrl($projects->id, $projects->seo_url, 'ongoing');   ?>">More Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>           
                                </div>
                            </div>
                            <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
                            <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
                        </div>
                    <?php } ?>
                </div>
                <div class="tab-pane fade active <?php if (empty($current) && empty($upcoming)) echo 'in'; ?>" id="tab-3">
                    <?php
                    if (!empty($completed)) {
                        ?>
                        <div class="swiper swiper--offers-best">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php
                                    foreach ($completed as $projects) {
                                        ?>
                                        <div class="swiper-slide">
                                            <div class="thumbnail no-border no-padding thumbnail-car-card" align="center">
                                                <?php if (!empty($projects['project_logo'])) { ?>
                                                    <a class="btn btn-theme ripple-effect"  href="<?php //echo $this->getProjectsUrl($projects->id, $projects->seo_url, 'ongoing');   ?>">
                                                        <div class="media" align="center">
                                                            <?php $path = $projects['project_logo'];
                                                            ?>
                                                            <img src="<?php echo "[[config('global.s3Path')]]project/project_logo/" . $path; ?>" alt=""/>
                                                        </div>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                                <div class="caption text-center">
                                                    <h4 class="caption-title"><a href="#"><?php
                                                            echo ucwords(substr($projects['project_name'], 0, 20));
                                                            if (strlen($projects['project_name']) > 20) {
                                                                echo '...';
                                                            }
                                                            ?></a></h4>
                                                    <div class="caption-text"><?php echo $projects['project_status']; ?></div>
                                                    <div class="buttons">
                                                        <a class="btn btn-theme ripple-effect"  href="<?php //echo $this->getProjectsUrl($projects->id, $projects->seo_url, 'ongoing');   ?>">More Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>           
                                </div>
                            </div>
                            <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
                            <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection();   
<style>
    .swiper-container {
        width: 100%;
        height: 43% !important;
    }

</style>