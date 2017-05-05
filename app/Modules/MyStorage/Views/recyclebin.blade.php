<div class="row" ng-controller="storageCtrl" ng-init="getRecycleList()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Recycle bin</span>

                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
                <div class="row">
                    <div class="col-md-2" ng-repeat="imgs in recycleDirectories track by $index | unique:'imgs' ">
                        <a  href="#/[[config('global.getUrl')]]/storage-list/getAllListToRestore/{{imgs.folder}}">
                            <img src="/backend/assets/img/folder.jpg" width="100px" height="120px;" >
                            <br/>
                            <h5 style="margin-left: 20px;">{{imgs.folder}}</h5></a>
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