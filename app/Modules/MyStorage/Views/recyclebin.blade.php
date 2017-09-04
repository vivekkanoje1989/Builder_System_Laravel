<div class="row" ng-controller="storageCtrl" ng-init="getRecycleList()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Recycle bin</span>                
            </div>
            <div class="widget-body table-responsive">      
                <div class="foldr-main" ng-repeat="imgs in recycleDirectories track by $index | unique:'imgs' ">
                    <div class="databox databox-lg databox-halved radius-bordered databox-shadowed databox-vertical">
                        <div class="databox-top bg-gray-custom no-padding">
                            <div class="databox-icon" style="margin-top:5px;">
                                <img ng-src="/backend/assets/img/folder-img.png" class="folder-img">                   
                                <span class="databox-number lightcarbon foldr-icon-div"> 
                                </span>
                            </div>
                        </div>
                        <div class="databox-bottom bg-white no-padding">
                            <div class="databox-row text-align-center">
                                <a  href="[[ config('global.backendUrl') ]]#/storage-list/getAllListToRestore/{{imgs.id}}">  
                                    <div class="databox-cell bordered-platinum padding-5">
                                        <span class="databox-number lightcarbon"> {{imgs.folder}}</span>                                   
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div ng-if="recycleDirectories.length < 1" style="margin-left:30px;">
                        <h3>Recycle bin is empty</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>