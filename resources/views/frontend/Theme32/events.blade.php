<style>
    .body-bg{
        padding-bottom: 30px;
        color: inherit;
        background-color:#ebeef0;
    }
    .white-bg{
        background:#fff;
        padding:20px;
        margin-bottom: 30px;
    }
    .event-hr{
        border: 2px solid #ccc;
        width: 85px;
    }
    .event-h1{
        text-transform: capitalize;
        font-size: 30px;
        color: #fff;
        font-weight: 600;
    }
    .event-bnr{
        width: 100%;
        max-height: 450px;
        min-height: 130px;
        height: auto;
    }

    .event-div .nav-pills>li+li {
        margin-left: 2px;
        width: 32%;
        text-align: center;

    }
    .event-div .nav-pills>li {
        float: left;
        width: 32%;

    }
    .event-div .nav-pills>li a{
        border-bottom: 2px dotted #ccc;
    }

    /*            .event-div .nav-pills>li a:hover{
                    border-bottom: 3px solid #ccc;
                    background:transparent;
                }*/
    .event-div .nav-pills>li>a {
        border-radius: 0px;
        font-size: 15px;
        color: #000;
        text-transform: uppercase;
        font-weight: 600;
        word-wrap: break-word;
    }

    .pad20{
        padding:20px;
    }
    .txt-left{
        text-align: left !important;
    }

    .event-gall-img{
        width:100%;
        height:auto;
    }

    .event-gall-img{
        padding: 20px;
        border: 1px solid #ccc;
        max-width: 340px;
        max-height: 340px;
        margin-bottom: 10px !important;
    }

    .row-centered {
        text-align:center;
    }
    .col-centered {
        display:inline-block;
        float:none;
        margin-right:-4px;
    }

    .event-ul li{
        padding: 10px;
        background: #ebeef0;
        margin: 5px;
    }

    .read-more-div{
        position: relative;
        margin: 40px 0;
    }

    .read-more-div a{  
        position: absolute;
        top: -25px;
        left: 45%;
        background: #ebeef0;
        padding: 10px;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        line-height: 30px;
        text-align: center;
        font-weight: 600;
        color: #000;
        text-decoration: none;
    }
    .blk-title{
        font-size: 20px !important;
        text-transform: uppercase !important;
        position: relative;
        top: -25px;
        margin-bottom: 0;
    }
    .blog-bg{
        background:#fff;
        position:relative;
    }
    .blog-img{
        position: relative;
        top: -18px;
        border: 10px solid #FFF;
        min-height: 165px;
    }	
    .mar-top50{
        margin-top: 50px !important;
    }
    .blog-social li{
        display: inline-block;
    }
    .blog-social{
        position: relative;
        top: -41px;
        right: 10px;
    }
    .blog-img:hover{
        opacity: 0.6;
    }
    .latest-blog-img{
        width: 85px;
        height: 55px;
        margin-bottom: 10px;
    }
    .bord-r8{
        border-right: 1px solid #ebeef0;
    }
    .blk-tit2{
        font-size: 20px !important;
        text-transform: uppercase !important;
        margin: 0;
    }
    @media screen and (max-width: 767px) {
        .event-div .nav-pills > li > a{
            font-size: 12px;
        }
        .event-h1{
            font-size: 25px;
        }
        .event-hr{
            margin-top: 10px;
        }
    }
    .event-h1 {
        text-transform: capitalize;
        font-size: 30px;
        color: #444141;
        font-weight: 600;
    }
    .event-h1 {
        text-transform: capitalize;
        font-size: 30px;
        color: #444;
        font-weight: 600;
        margin-top: 85px;
    }
    blockquote {
        border-left: none;
    }
    ul li {
        list-style: none;
        margin-top: 15px;
    }


    blockquote {
        border-left: 5px solid #e60000;
        color: #000;
        background:transparent;
    }

    .fancybox-opened .fancybox-title h4 {
        font-size: 24px;
        font-weight: 300;
        margin-bottom: 10px;
        display: none;
    }
</style>
@extends('layouts/frontend/Theme32/main')
@section('content')
<main class="main-content"  >
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/index">Home</a></li>
                <li><span>Events</span></li>
            </ul>
        </div>
    </div>
    <div class="container" ng-init="getEvents();">
        <header class="heading page-heading">
            <h1>Events</h1>
        </header>
        <div class="row" ng-repeat="event in events track by $index" style="padding: 5px 5px 5px 5px; margin-top: 30px; border: 1px solid black;" >
            <h2 style="font-weight: 600; padding-left: 30px;">{{event.name}}</h2>    
            <div class="col-md-8 col-xs-8">
                <h3>Description</h3>
                <P>{{event.description| htmlToPlaintext | limitTo : 300}}{{event.description > 300 ? '...' : ''}}</p>
                <br/><br/>
                <a href="[[ URL::to('/') ]]/[[config('global.getWebsiteUrl')]]/event-details/{{event.id}}"><button class="btn">Show More</button></a>
            </div> 
        </div>
    </div>       
    @endsection()    