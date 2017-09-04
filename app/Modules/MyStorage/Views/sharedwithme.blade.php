<style>
    .img-wrap {
        position: relative;
        display: inline-block;

        font-size: 0;
    }
    .img-wrap .close{
        position: absolute;
        top: 2px;
        right: 2px;
        z-index: 100;
        background-color: #FFF;
        padding: 5px 2px 2px;
        color: #000;
        font-weight: bold;
        cursor: pointer;
        opacity: .2;
        text-align: center;
        font-size: 22px;
        line-height: 10px;
        border-radius: 50%;
    }
    .img-wrap .share{
        position: absolute;
        top: 2px;
        left: 2px;
        z-index: 100;
        background-iamge: red;
        padding: 2px 2px 2px -2px;
        color: #000;
        font-weight: bold;
        cursor: pointer;
        opacity: .2;
        text-align: center;
        font-size: 22px;
        line-height: 10px;
        width:16px;
        border-radius: 50%;
    }
    .img-wrap:hover .close {
        opacity: 1;
    }
    .img-wrap:hover .share {
        opacity: 1;

    }
</style>
<div class="row" ng-controller="storageCtrl" ng-init="getmyStorageList(); getMySharedImages();">  
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Shared with Me</span>                
            </div>
            <div class="widget-body table-responsive" >     
                <h5 class="row-title ng-scope" ng-if="directories != ''"><i class="fa fa-folder-open-o"></i>Folders</h5>
                <div class="row" ng-if="directories != ''">
                    <div class="foldr-main" ng-repeat="imgs in directories track by $index | unique:'imgs' ">
                        <div class="databox databoxone databox-halved radius-bordered databox-shadowed databox-vertical">
                            <div class="databox-top bg-gray-custom no-padding">
                                <div class="databox-icon" style="margin-top:5px;">
                                    <img ng-src="/backend/assets/img/folder-img.png" class="folder-img">                   
                                    <span class="databox-number lightcarbon foldr-icon-div"> 
                                    </span>
                                </div>
                            </div>
                            <div class="databox-bottom bg-white no-padding">
                                <div class="databox-row text-align-center">
                                    <a  href="[[ config('global.backendUrl') ]]#/storage-list/getAllMyList/{{imgs.id}}">  
                                        <div class="databox-cell bordered-platinum padding-5">
                                            <span class="databox-number lightcarbon"> {{imgs.folder}}</span>                                   
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>     
                <hr>
                <h5 class="row-title ng-scope" ng-if="myImageStore != ''"><i class="fa fa-picture-o"></i>Images</h5>
                    <div class="row" ng-if="myImageStore != ''">
                        <div class="col-md-2" ng-repeat="imgs in myImageStore track by $index | unique:'imgs' " style="margin:0 0 25px 0;">
                            <div class="img-wrap"> 
                                <a  data-reveal-id="sharing_files" ng-click="imageShared(imgs.id); getSharedImagesEmployees(imgs.id)"  data-toggle="modal" data-target="#imageModel" >
                                    <img title="Share " ng-src="/backend/assets/img/share-img.png" class="share" style="display: block;"> 
                                </a>
                                <span class="close" ng-click="deleteImages($index, imgs.id)">&times;</span>
                                <a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/{{imgs.file_url}}" target="_blank"> <img ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/{{imgs.file_url}}" height="100px;" width="100px;"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
