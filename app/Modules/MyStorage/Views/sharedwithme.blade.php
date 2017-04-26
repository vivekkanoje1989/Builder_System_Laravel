<div class="row" ng-controller="storageCtrl" ng-init="getmyStorageList()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Shared with Me</span>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
                <div class="row">
                    <div class="col-md-2" ng-repeat="imgs in directories track by $index | unique:'imgs' ">
                        <a  href="#/[[config('global.getUrl')]]/storage-list/getAllMyList/{{imgs.folder}}">
                            <img src="/backend/assets/img/folder.jpg" width="100px" height="120px;" >
                            <br/>
                            <h5 style="margin-left: 20px;">{{imgs.folder}}</h5></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
