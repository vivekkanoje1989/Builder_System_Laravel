@extends('layouts/frontend/theme31/main')
@section('content') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- CONTENT AREA -->
<div class="content-area">
    <input type="hidden"  name="_token" id="_token" value="[[csrf_token()]]" class="form-control">
    <input type="hidden"  name="id" id="id" value="<?php echo $projectId; ?>" class="form-control">
    <!-- PAGE WITH SIDEBAR -->
    <section class="page-section with-sidebar sub-page">
        <div class="container">
            <div class="row">
                <!-- CONTENT -->
                <div class="col-md-9 content" id="content">

                    <h3 id="project_name" class="block-title alt" ><i class="fa fa-angle-down"></i><p ></p></h3>
                    <div class="car-big-card alt">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators" id="selected">
                                    </ol>
                                    <div class="carousel-inner" id="banners">    
                                    </div><a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="car-details">
                                    <div class="list">
                                        <ul id="aminity">
                                            <li class="title">
                                                <h2>Available <span>AMENITIES</span></h2>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="car-details">
                                    <div class="list">
                                        <ul id="spec_desc">
                                            <li class="title">
                                                <h2>Available <span>Specification</span></h2>
                                            </li>
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
                            <p id="description"> </p>

                        </div>
                    </div>


                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Availability</h3>
                    <div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div id="availble"></div>
                    </div>
                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Specification Images</h3>
                    <div class="row row-centered" id="specification">
                    </div>

                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Amenities Images</h3>
                    <div class="row row-centered" id="amenities"></div>

                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Layout Plans</h3>
                    <div class="row row-centered" id="layout"></div>
                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Floor Plans</h3>
                    <div class="row row-centered" id="floor"></div>
                    <h3 class="block-title alt"><i class="fa fa-angle-down"></i>Gallery</h3>
                    <div class="row row-centered" id="gallery_images"></div>		

                </div>
                <aside class="col-md-3 sidebar" id="sidebar">
                    <div class="widget shadow widget-details-reservation">
                        <h4 class="widget-title">Project Logo </h4>
                        <div class="widget-content">
                            <img id="logo" class="proj-img">
                        </div>
                    </div>
                    <div class="widget shadow widget-details-reservation">
                        <h4 class="widget-title">Project Address </h4>
                        <div class="widget-content">
                            <h5 class="widget-title-sub">Location</h5>

                            <div class="media">
                                <span class="media-object pull-left"><i class="fa fa-location-arrow"></i></span>
                                <div class="media-body"><p id="address"></p></div>
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
                    <div class="widget shadow">
                        <div class="widget-title">Other projects</div>
                        <div id="carousel" class="carousel slide" data-ride="carousel">

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" id="projects">

                            </div>
                            <div id="#myCarousel" class="carousel slide" data-ride="#myCarousel">
                                <ul class="carousel-indicators" id="selectedPro">
                                    <li data-target="#carousel" data-slide-to="0" class="active"></li>
                                </ul>
                            </div>           


                        </div>
                    </div>
                    <div class="widget shadow widget-helping-center">
                        <h4 class="widget-title">Helping Center</h4>
                        <div class="widget-content">
                            <p>Vivamus eget nibh. Etiam cursus leo vel metus. Nulla facilisi. Aenean nec eros.</p>
                            <h5 class="widget-title-sub">+90 555 444 66 33</h5>
                            <p><a href="mailto:support@supportcenter.com">support@supportcenter.com</a></p>
                            <div class="button">
                                <a id="brochure" class="btn btn-block btn-theme btn-theme-dark">Download Brochure</a>
                            </div>
                        </div>
                    </div>
                    <!-- /widget helping center -->
                    <div class="widget shadow widget-helping-center">
                        <h4 class="widget-title">Location Map</h4>
                        <div class="widget-content">
                            <a  class='fancybox' data-fancybox-group='Loc'>
                                <img id="location_map_images" class="proj-img" >
                            </a>
                        </div>
                    </div>

                    <div class="widget shadow widget-helping-center">
                        <h4 class="widget-title">Google Map</h4>
                        <div class="widget-content">
                            <iframe  id="googleframe" width="100%" height="250px" frameborder="0" style="border:0" allowfullscreen></iframe>
<!--                         -->
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
    window.onload = getProjectDetails();

    function getProjectDetails()
    {
        var _token = $("#_token").val();
        var id = $("#id").val();

        $.ajax({
            type: "POST",
            url: "/website/getProjectDetails",
            type: "POST",
            data: {"_token": _token, 'id': id},
            success: function (output) {
                var projectRow = JSON.parse(output);
                var availble = projectRow.availble;
                var specification_images = JSON.parse(projectRow.result.specification_images);
                var layout_plan_images = JSON.parse(projectRow.result.layout_plan_images);
                var floor_plan_images = JSON.parse(projectRow.result.floor_plan_images);
                var project_name = projectRow.result.project_name;
                var project_logo = projectRow.result.project_logo;
                var project_address = projectRow.result.project_address;
                var project_banner = projectRow.result.project_banner_images;
                var project_banner = project_banner.split(',');
                var amenities_images = projectRow.result.amenities_images;
                var amenities = amenities_images.split(',');
                var project_gallery = projectRow.result.project_gallery;
                var gallery = project_gallery.split(',');
                var location_map_images = projectRow.result.location_map_images;
                var brief_description = projectRow.result.brief_description;
                var projects = projectRow.projects;
                var aminities = projectRow.aminities;
                var brochure = projectRow.result.project_broacher;
                var google_map_iframe = projectRow.result.google_map_iframe;
                console.log(google_map_iframe)
                var specification_description = projectRow.result.specification_description;
                $("#spec_desc").append(specification_description);
                $("#project_name").html(project_name);
                $("#address").html(project_address)
                $("#logo").attr('src', "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/" + project_logo);
                $("#brochure").attr('href',"https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project_broacher/"+brochure);
                $("#googleframe").attr('src',google_map_iframe)
                $("#description").html(brief_description);
                $("#location_map_images").attr('src', "https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/location_map_images/" + location_map_images);
                for ($i = 0; $i < projectRow.availble.length; $i++)
                {
                    var block = projectRow.availble[$i];

                    //$("#availble").append('<div class="panel panel-default"><div class="panel-heading" onclick="getSubBlock(' + block.id + ',' + block.project_id + ')" role="tab"><h4 class="panel-title"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#' + block.id + '" aria-expanded="false" aria-controls="collapse2"><span class="dot"></span>' + block.block_name + '</a></h4></div><div id="' + block.id + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2"><div class="panel-body row-centered"><div class="col-md-6 col-sm-6 col-xs-12 col-centered"><h4 class="subblock"></h4><p>1 BHK flats with modern specifications , luxurious amenities and peaceful environment. </p><a class="btn btn-theme btn-theme-dark" href="#" data-toggle="modal" data-target="#inter-mod">I Like It</a></div></div></div></div>');
                    $("#availble").append('<div class="panel-group" id="accordion"><div class="panel panel-default"><div onclick="getSubBlock(' + block.id + ',' + block.project_id + ')" class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+block.id+'">'+block.block_name+'</a></h4></div><div id="collapse'+block.id+'" class="panel-collapse collapse"><div class="panel-body"><div class="subblock'+block.id+'"></div></div>')
                }
                
              
                
                for($i=0;$i < aminities.length;$i++)
                {
                    var aminity = aminities[$i];
                    $("#aminity").append('<li>'+aminity.name_of_amenity+'</li>');
                }


                for ($i = 0; $i < project_banner.length; $i++)
                {
                    var banner = project_banner[$i];
                    if ($i == 0)
                    {

                        $("#selected").append('<li data-target="#myCarousel" data-slide-to="' + $i + '" class="active"></li>');
                        $("#banners").append('<div  class="item active"><img class="img-responsive" src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_banner_images/' + banner + '" alt=""/></div>')
                    } else {
                        $("#selected").append('<li data-target="#myCarousel" data-slide-to="' + $i + '"></li>');
                        $("#banners").append('<div  class="item"><img class="img-responsive" src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_banner_images/' + banner + '" alt=""/></div>')
                    }
                }
                for ($i = 0; $i < projects.length; $i++)
                {
                    var project = projects[$i];
                    if ($i == 0)
                    {
                        $("#selectedPro").append('<li data-target="#carousel" data-slide-to="' + $i + '" class="active"></li>');
                        $("#projects").append('<div class="item active"><img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/' + project.project_logo + '"><div class="carousel-caption"><h3>' + project.project_name + '</h3></div></div>')
                    } else {
                        $("#selectedPro").append('<li data-target="#carousel" data-slide-to="' + $i + '"></li>');
                        $("#projects").append('<div class="item"><img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_logo/' + project.project_logo + '"><div class="carousel-caption"><h3>' + project.project_name + '"</h3></div></div>')
                    }
                }
                for ($i = 0; $i < specification_images.length; $i++)
                {
                    var specific = specification_images[$i];
                    $("#specification").append('<div class="col-md-3 col-sm-4 col-xs-12 col-centered"><a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/specification_images/' + specific.specification_images + '" class="fancybox" data-fancybox-group="1"><img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/specification_images/' + specific.specification_images + '" class="proj-img"></a></div>')
                }

                for ($i = 0; $i < amenities.length; $i++)
                {
                    var amenitie = amenities[$i];
                    $("#amenities").append('<div class="col-md-3 col-sm-4 col-xs-12 col-centered"><a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/amenities_images/' + amenitie + '" class="fancybox" data-fancybox-group="1"><img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/amenities_images/' + amenitie + '" class="proj-img"></a></div>')
                }

                for ($i = 0; $i < layout_plan_images.length; $i++)
                {

                    var layout_plan = layout_plan_images[$i];
                    $("#layout").append('<div class="col-md-3 col-sm-4 col-xs-12 col-centered"><a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/layout_plan_images/' + layout_plan.layout_plan_images + '" class="fancybox" data-fancybox-group="1"><img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/layout_plan_images/' + layout_plan.layout_plan_images + '" class="proj-img"></a></div>')
                }

                for ($i = 0; $i < floor_plan_images.length; $i++)
                {
                    var floor_plan = floor_plan_images[$i];
                    $("#floor").append('<div class="col-md-3 col-sm-4 col-xs-12 col-centered"><a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/floor_plan_images/' + floor_plan.floor_plan_images + '" class="fancybox" data-fancybox-group="1"><img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/floor_plan_images/' + floor_plan.floor_plan_images + '" class="proj-img"></a></div>')
                }

                for ($i = 0; $i < gallery.length; $i++)
                {
                    var gallery_images = gallery[$i];
                    $("#gallery_images").append('<div class="col-md-3 col-sm-4 col-xs-12 col-centered"><a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_gallery/' + gallery_images + '" class="fancybox" data-fancybox-group="1"><img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/project/project_gallery/' + gallery_images + '" class="proj-img"></a></div>')
                }

            }
        });
    }

    function getSubBlock(block_id, project_id)
    {
        var _token = $("#_token").val();
       
        $.ajax({
            type: "POST",
            url: "/website/getAvailbility",
            type: "POST",
            data: {"_token": _token, 'block_id': block_id, 'project_id': project_id},
            success: function (output) {

                var subType = JSON.parse(output).result;
                console.log(subType.length)
                $(".subblock"+block_id).html(null);
                for ($i = 0; $i < subType.length; $i++)
                {
                    var type = subType[$i];
                    $(".subblock"+block_id).append('<div class="col-md-6 col-sm-6 col-xs-12 col-centered" style="margin-top:10px;"><h4>' + type.block_sub_type + '</h4><p>1 BHK flats with modern specifications , luxurious amenities and peaceful environment. </p><a class="btn btn-theme btn-theme-dark" href="#" data-toggle="modal" data-target="#inter-mod">I Like It</a></div></div>');
                }
            }
        })
    }
</script> 
@endsection()                    