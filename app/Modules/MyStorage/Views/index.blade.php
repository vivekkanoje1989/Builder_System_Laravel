<div class="row" ng-controller="storageCtrl" ng-init="getStorageList()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">My Storage</span>
                <a href="" data-toggle="modal" data-target="#storageModel"  class="btn btn-info">Upload new</a>&nbsp;&nbsp;&nbsp;
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
                <div class="row">
                    <div class="col-md-2" ng-repeat="imgs in directories track by $index | unique:'imgs' ">
                        <a  href="#/[[config('global.getUrl')]]/storage-list/getAllList/{{imgs.folder}}">
                        <img src="/backend/assets/img/folder.jpg" width="100px" height="120px;" >
                        <br/>
                        <h5 style="margin-left: 20px;">{{imgs.folder}}</h5></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="storageModel" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Create new Storage</h4>
                </div>
                <form novalidate ng-submit="storageForm.$valid && dostorageFormAction()" name="storageForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!storageForm.filename.$dirty && storageForm.filename.$invalid)}">
                            <label>File name<span class="sp-err">*</span></label>                            
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="filename" name="filename"  ng-change="errorMsg = null" required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="storageForm.filename.$error">
                                    <div ng-message="required">Filename is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>
</div>
