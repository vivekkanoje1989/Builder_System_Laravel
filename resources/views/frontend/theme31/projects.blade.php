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
                    @if(!empty($current)) {
                        <li class="active"><a href="#tab-1" data-toggle="tab">Current Projects</a></li>
                        @if(!empty($upcoming))
                            <li ><a href="#tab-2" data-toggle="tab">Future Projects</a></li>
                        @endif
                        @if (!empty($completed))
                            <li ><a href="#tab-3" data-toggle="tab">Completed Projects</a></li>
                        @endif
                    @elseif (!empty($upcoming)) 
                        ?>
                        <li class="<?php if (empty($current)) echo 'active'; ?>"><a href="#tab-2" data-toggle="tab">Future Projects</a></li>                
                        @if(!empty($completed))
                            <li><a href="#tab-3" data-toggle="tab">Completed Projects</a></li>
                        @endif
                    @elseif(!empty($completed))
                        <li class="@if(empty($current) && empty($upcoming)) echo 'active'; @endif"> <a href="#tab-3" data-toggle="tab">Completed Projects</a></li>
                    @endif
                </ul>
            </div>

            <div class="tab-content wow fadeInUp" data-wow-offset="70" data-wow-delay="500ms" style="height:300px;">
                <div class="tab-pane fade active in" id="tab-1">
                   
                    @if(!empty($current))
                       
                        <div class="swiper swiper--offers-popular">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                   
                                    @foreach($current as $projects)                                          
                                           
                                        <div class="swiper-slide">
                                            <div class="thumbnail no-border no-padding thumbnail-car-card"  align="center">
                                                @if(!empty($projects['project_logo']))
                                                    <a class="btn btn-theme ripple-effect"  href="<?php //echo $this->getProjectsUrl($projects->id, $projects->seo_url, 'ongoing');    ?>">
                                                        <div class="media" align="center" style="width:200px; height:150px;">
                                                            <?php $path = $projects['project_logo'];
                                                            ?>
                                                            <img ng-src="[[config('global.s3Path')]]project/project_logo/[[$path]]" alt=""/>
                                                        </div>
                                                    </a>
                                                   @endif
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

                                    @endforeach          
                                </div>
                            </div>
                            <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
                            <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade active <?php if (empty($current)) echo 'in'; ?> " id="tab-2">
                    
                    @if(!empty($upcoming))
                        
                        <div class="swiper swiper--offers-economic">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                   
                                    @foreach ($upcoming as $projects) 
                                        
                                        <div class="swiper-slide">
                                            <div class="thumbnail no-border no-padding thumbnail-car-card"  align="center">
                                                @if(!empty($projects['project_logo']))
                                                    <a class="btn btn-theme ripple-effect"  href="<?php //echo $this->getProjectsUrl($projects->id, $projects->seo_url, 'ongoing');    ?>">
                                                        <div class="media" align="center" style="width:200px; height:150px;">
                                                            <?php $path = $projects['project_logo'];
                                                            ?>
                                                            <img ng-src="[[config('global.s3Path')]]project/project_logo/[[$path]]" alt=""/>
                                                        </div>
                                                    </a>
                                                 @endif    
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
                                    @endforeach         
                                </div>
                            </div>
                            <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
                            <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade active <?php if (empty($current) && empty($upcoming)) echo 'in'; ?>" id="tab-3">
                 
                    @if(!empty($completed))
                       
                        <div class="swiper swiper--offers-best">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($completed as $projects) 
                                         <div class="swiper-slide">
                                            <div class="thumbnail no-border no-padding thumbnail-car-card"  align="center">
                                                @if (!empty($projects['project_logo']))
                                                    <a class="btn btn-theme ripple-effect"  href="<?php //echo $this->getProjectsUrl($projects->id, $projects->seo_url, 'ongoing');    ?>">
                                                        <div class="media" align="center" style="width:200px; height:150px;">
                                                            <?php $path = $projects['project_logo'];
                                                            ?>
                                                            <img ng-src="[[config('global.s3Path')]]project/project_logo/[[$path]]"  alt=""/>
                                                        </div>
                                                    </a>
                                                 @endif   
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
                                    @endforeach         
                                </div>
                            </div>
                            <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
                            <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
                        </div>
                    @endif   
                </div>
            </div>
        </div>
    </section>
    @endsection() 