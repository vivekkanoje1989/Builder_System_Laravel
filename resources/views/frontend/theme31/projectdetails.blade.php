@extends('layouts/frontend/theme31/main')
@section('content') 
<!-- CONTENT AREA -->
<div class="content-area" ng-controller="webAppController" ng-init="getProjectDetails('[[$projectId]]')">
    <!-- PAGE WITH SIDEBAR -->
    <section class="page-section with-sidebar sub-page">
        <div class="container">
            <div class="row">
                <!-- CONTENT -->
                <div class="col-md-9 content" id="content">

                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Project Name</h3>
                    <div class="car-big-card alt">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
                                    <div class="overlay"></div>
                                    <ol class="carousel-indicators">
                                        <li data-target="#bs-carousel"  ng-repeat="banner in bannerImgs track by $index" ng-class="{'active':$first}" data-slide-to="{{$index}}" class="active"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div  ng-repeat="banner in bannerImgs track by $index" ng-class="{'active':$first}" class="item slides">
                                            <div class="slide-{{$index + 1}}" style="background-image: url(https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_banner_images/{{banner}}"></div>
                                        </div>
                                    </div> 
                                </div>

                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="car-details">
                                    <div class="list">
                                        <ul>
                                            <li class="title">
                                                <h2>Available <span>AMENITIES</span></h2>
                                            </li>
                                            <li ng-repeat="aminity in aminities">{{aminity.name_of_amenity}}</li>
                                            
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="car-details">
                                    <div class="list">
                                        <ul>
                                            <li class="title">
                                                <h2>Available <span>Specification</span></h2>

                                            </li>
                                            <li>{{specification | htmlToPlaintext}}</li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="page-divider half transparent"/>

                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Description</h3>
                    <div class="row">

                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <p>{{description | htmlToPlaintext}} </p>

                        </div>
                    </div>


                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Availability</h3>
                    <div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <!-- faq1 -->
                        <div class="panel panel-default" ng-repeat="avail in availble">
                            <div class="panel-heading" role="tab">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#{{avail.id}}" aria-expanded="false" aria-controls="collapse2">
                                        <span class="dot"></span>{{avail.block_name}}
                                    </a>
                                </h4>
                            </div>
                            <div id="{{avail.id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                                <div class="panel-body row-centered">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-centered">
                                        <h4>  1 BHK Of 600 Sq Ft </h4>
                                        <p>1 BHK flats with modern specifications , luxurious amenities and peaceful environment. </p>
                                        <a class="btn btn-theme btn-theme-dark" href="#" data-toggle="modal" data-target="#inter-mod">I Like It</a>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-centered">
                                        <h4>  1 BHK Of 600 Sq Ft </h4>
                                        <p>1 BHK flats with modern specifications , luxurious amenities and peaceful environment. </p>
                                        <a class="btn btn-theme btn-theme-dark" href="#" data-toggle="modal" data-target="#inter-mod">I Like It</a>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-centered">
                                        <h4>  1 BHK Of 600 Sq Ft </h4>
                                        <p>1 BHK flats with modern specifications , luxurious amenities and peaceful environment. </p>
                                        <a class="btn btn-theme btn-theme-dark" href="#" data-toggle="modal" data-target="#inter-mod">I Like It</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Specification Images</h3>
                    <div class="row row-centered">
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='1'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='1'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='1'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>

                    </div>

                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Amenities Images</h3>
                    <div class="row row-centered">
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='1'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='1'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='1'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>

                    </div>

                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Layout Plans</h3>
                    <div class="row row-centered">
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img2.jpg' class='fancybox' data-fancybox-group='2'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='2'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img2.jpg' class='fancybox' data-fancybox-group='2'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>

                    </div>
                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Floor Plans</h3>
                    <div class="row row-centered">
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img1.jpg' class='fancybox' data-fancybox-group='3'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='3'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-1 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='3'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>

                    </div>
                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Gallery</h3>
                    <div class="row row-centered">
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='4'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img2.jpg' class='fancybox' data-fancybox-group='4'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='4'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-centered">
                            <a href='assets/img/img3.jpg' class='fancybox' data-fancybox-group='4'>
                                <img src="assets/img/proj-img.jpg" class="proj-img" >
                            </a>	
                        </div>

                    </div>		

                </div>
                <!-- /CONTENT -->

                <!-- SIDEBAR -->
                <aside class="col-md-3 sidebar" id="sidebar">
                    <!-- widget detail reservation -->

                    <div class="widget shadow widget-details-reservation">
                        <h4 class="widget-title">Project Logo </h4>
                        <div class="widget-content">
                            <img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/{{project_logo}}" class="proj-img">
                        </div>
                    </div>
                    <div class="widget shadow widget-details-reservation">
                        <h4 class="widget-title">Project Address </h4>
                        <div class="widget-content">
                            <h5 class="widget-title-sub">Location</h5>

                            <div class="media">
                                <span class="media-object pull-left"><i class="fa fa-location-arrow"></i></span>
                                <div class="media-body"><p>BMS for Builders 1 Baner - Mhalunge Road, Baner, Pune, Maharashtra 411045</p></div>
                            </div>

                            <div class="media">
                                <span class="media-object pull-left"><i class="fa fa-phone"></i></span>
                                <div class="media-body"><p>00-00-00-00</p></div>
                            </div>
                            <div class="media">
                                <span class="media-object pull-left"><i class="fa fa-envelope-o"></i></span>
                                <div class="media-body"><p>demo@gmail.com</p></div>
                            </div>

                        </div>
                    </div>
                    <!-- /widget detail reservation -->
                    <!-- widget testimonials -->
                    <div class="widget shadow">
                        <div class="widget-title">Other projects</div>
                        <div class="testimonials-carousel">
                            <div class="owl-carousel" id="testimonials">
                                <div class="testimonial">
                                    <div class="media">
                                        <div class="media-body">
                                            <img src="assets/img/proj-img.jpg" class="proj-img">
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial">
                                    <div class="media">
                                        <div class="media-body">
                                            <img src="assets/img/proj-img.jpg" class="proj-img">
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial">
                                    <div class="media">
                                        <div class="media-body">
                                            <img src="assets/img/proj-img.jpg" class="proj-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /widget testimonials -->
                    <!-- widget helping center -->
                    <div class="widget shadow widget-helping-center">
                        <h4 class="widget-title">Helping Center</h4>
                        <div class="widget-content">
                            <p>Vivamus eget nibh. Etiam cursus leo vel metus. Nulla facilisi. Aenean nec eros.</p>
                            <h5 class="widget-title-sub">+90 555 444 66 33</h5>
                            <p><a href="mailto:support@supportcenter.com">support@supportcenter.com</a></p>
                            <div class="button">
                                <a href="#" class="btn btn-block btn-theme btn-theme-dark">Download Brochure</a>
                            </div>
                        </div>
                    </div>
                    <!-- /widget helping center -->
                    <div class="widget shadow widget-helping-center">
                        <h4 class="widget-title">Location Map</h4>
                        <div class="widget-content">
                            <a href='assets/img/location-map.jpg' class='fancybox' data-fancybox-group='Loc'>
                                <img src="assets/img/location-map.jpg" class="proj-img" >
                            </a>
                        </div>
                    </div>

                    <div class="widget shadow widget-helping-center">
                        <h4 class="widget-title">Google Map</h4>
                        <div class="widget-content">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3782.204208294423!2d73.77941731478177!3d18.56483007266471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2becdc1d67b2b%3A0xd7eddb46e6814db5!2sedynamics+(H.O.+Pune)!5e0!3m2!1sen!2sin!4v1457762025461" width="100%" height="250px" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>

                </aside>
                <!-- /SIDEBAR -->

            </div>
        </div>
    </section>


</div>
<!-- FOOTER -->
<script>

//
//    function getProjectDetails()
//    {
//        var _token = $("#_token").val();
//        var id = $("#id").val();
//
//        $.ajax({
//            type: "POST",
//            url: "/website/getProjectDetails",
//            type: "POST",
//            data: {"_token": _token, 'id': id},
//            success: function (output) {
//                var projectRow = JSON.parse(output);
//                var availble = projectRow.availble;
//                var specification_images = JSON.parse(projectRow.result.specification_images);
//                var layout_plan_images = JSON.parse(projectRow.result.layout_plan_images);
//                var floor_plan_images = JSON.parse(projectRow.result.floor_plan_images);
//                var project_name = projectRow.result.project_name;
//                var project_logo = projectRow.result.project_logo;
//                var project_address = projectRow.result.project_address;
//                var project_banner = projectRow.result.project_banner_images;
//                var project_banner = project_banner.split(',');
//                var amenities_images = projectRow.result.amenities_images;
//                var amenities = amenities_images.split(',');
//                var project_gallery = projectRow.result.project_gallery;
//                var gallery = project_gallery.split(',');
//                var location_map_images = projectRow.result.location_map_images;
//                var brief_description = projectRow.result.brief_description;
//                var projects = projectRow.projects;
//                var aminities = projectRow.aminities;
//                var brochure = projectRow.result.project_broacher;
//                var google_map_iframe = projectRow.result.google_map_iframe;
//                console.log(google_map_iframe)
//                var specification_description = projectRow.result.specification_description;
//                $("#spec_desc").append(specification_description);
//                $("#project_name").html(project_name);
//                $("#address").html(project_address)
//                $("#logo").attr('ng-src', "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/" + project_logo);
//                $("#brochure").attr('href',"https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project_broacher/"+brochure);
//                $("#googleframe").attr('ng-src',google_map_iframe)
//                $("#description").html(brief_description);
//                $("#location_map_images").attr('ng-src', "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/location_map_images/" + location_map_images);
//                for ($i = 0; $i < projectRow.availble.length; $i++)
//                {
//                    var block = projectRow.availble[$i];
//
//                    //$("#availble").append('<div class="panel panel-default"><div class="panel-heading" onclick="getSubBlock(' + block.id + ',' + block.project_id + ')" role="tab"><h4 class="panel-title"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#' + block.id + '" aria-expanded="false" aria-controls="collapse2"><span class="dot"></span>' + block.block_name + '</a></h4></div><div id="' + block.id + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2"><div class="panel-body row-centered"><div class="col-md-6 col-sm-6 col-xs-12 col-centered"><h4 class="subblock"></h4><p>1 BHK flats with modern specifications , luxurious amenities and peaceful environment. </p><a class="btn btn-theme btn-theme-dark" href="#" data-toggle="modal" data-target="#inter-mod">I Like It</a></div></div></div></div>');
//                    $("#availble").append('<div class="panel-group" id="accordion"><div class="panel panel-default"><div onclick="getSubBlock(' + block.id + ',' + block.project_id + ')" class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+block.id+'">'+block.block_name+'</a></h4></div><div id="collapse'+block.id+'" class="panel-collapse collapse"><div class="panel-body"><div class="subblock'+block.id+'"></div></div>')
//                }
//                
//              
//                
//                for($i=0;$i < aminities.length;$i++)
//                {
//                    var aminity = aminities[$i];
//                    $("#aminity").append('<li>'+aminity.name_of_amenity+'</li>');
//                }
//
//
//                for ($i = 0; $i < project_banner.length; $i++)
//                {
//                    var banner = project_banner[$i];
//                    if ($i == 0)
//                    {
//
//                        $("#selected").append('<li data-target="#myCarousel" data-slide-to="' + $i + '" class="active"></li>');
//                        $("#banners").append('<div  class="item active"><img class="img-responsive" ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_banner_images/' + banner + '" alt=""/></div>')
//                    } else {
//                        $("#selected").append('<li data-target="#myCarousel" data-slide-to="' + $i + '"></li>');
//                        $("#banners").append('<div  class="item"><img class="img-responsive" ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_banner_images/' + banner + '" alt=""/></div>')
//                    }
//                }
//                for ($i = 0; $i < projects.length; $i++)
//                {
//                    var project = projects[$i];
//                    if ($i == 0)
//                    {
//                        $("#selectedPro").append('<li data-target="#carousel" data-slide-to="' + $i + '" class="active"></li>');
//                        $("#projects").append('<div class="item active"><img ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/' + project.project_logo + '"><div class="carousel-caption"><h3>' + project.project_name + '</h3></div></div>')
//                    } else {
//                        $("#selectedPro").append('<li data-target="#carousel" data-slide-to="' + $i + '"></li>');
//                        $("#projects").append('<div class="item"><img ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/' + project.project_logo + '"><div class="carousel-caption"><h3>' + project.project_name + '"</h3></div></div>')
//                    }
//                }
//                for ($i = 0; $i < specification_images.length; $i++)
//                {
//                    var specific = specification_images[$i];
//                    $("#specification").append('<div class="col-md-3 col-sm-4 col-xs-12 col-centered"><a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/specification_images/' + specific.specification_images + '" class="fancybox" data-fancybox-group="1"><img ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/specification_images/' + specific.specification_images + '" class="proj-img"></a></div>')
//                }
//
//                for ($i = 0; $i < amenities.length; $i++)
//                {
//                    var amenitie = amenities[$i];
//                    $("#amenities").append('<div class="col-md-3 col-sm-4 col-xs-12 col-centered"><a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/amenities_images/' + amenitie + '" class="fancybox" data-fancybox-group="1"><img ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/amenities_images/' + amenitie + '" class="proj-img"></a></div>')
//                }
//
//                for ($i = 0; $i < layout_plan_images.length; $i++)
//                {
//
//                    var layout_plan = layout_plan_images[$i];
//                    $("#layout").append('<div class="col-md-3 col-sm-4 col-xs-12 col-centered"><a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/layout_plan_images/' + layout_plan.layout_plan_images + '" class="fancybox" data-fancybox-group="1"><img ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/layout_plan_images/' + layout_plan.layout_plan_images + '" class="proj-img"></a></div>')
//                }
//
//                for ($i = 0; $i < floor_plan_images.length; $i++)
//                {
//                    var floor_plan = floor_plan_images[$i];
//                    $("#floor").append('<div class="col-md-3 col-sm-4 col-xs-12 col-centered"><a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/floor_plan_images/' + floor_plan.floor_plan_images + '" class="fancybox" data-fancybox-group="1"><img ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/floor_plan_images/' + floor_plan.floor_plan_images + '" class="proj-img"></a></div>')
//                }
//
//                for ($i = 0; $i < gallery.length; $i++)
//                {
//                    var gallery_images = gallery[$i];
//                    $("#gallery_images").append('<div class="col-md-3 col-sm-4 col-xs-12 col-centered"><a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_gallery/' + gallery_images + '" class="fancybox" data-fancybox-group="1"><img ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_gallery/' + gallery_images + '" class="proj-img"></a></div>')
//                }
//
//            }
//        });
//    }
//
//    function getSubBlock(block_id, project_id)
//    {
//        var _token = $("#_token").val();
//       
//        $.ajax({
//            type: "POST",
//            url: "/website/getAvailbility",
//            type: "POST",
//            data: {"_token": _token, 'block_id': block_id, 'project_id': project_id},
//            success: function (output) {
//
//                var subType = JSON.parse(output).result;
//                console.log(subType.length)
//                $(".subblock"+block_id).html(null);
//                for ($i = 0; $i < subType.length; $i++)
//                {
//                    var type = subType[$i];
//                    $(".subblock"+block_id).append('<div class="col-md-6 col-sm-6 col-xs-12 col-centered" style="margin-top:10px;"><h4>' + type.block_sub_type + '</h4><p>1 BHK flats with modern specifications , luxurious amenities and peaceful environment. </p><a class="btn btn-theme btn-theme-dark" href="#" data-toggle="modal" data-target="#inter-mod">I Like It</a></div></div>');
//                }
//            }
//        })
//    }
</script> 
@endsection()                    