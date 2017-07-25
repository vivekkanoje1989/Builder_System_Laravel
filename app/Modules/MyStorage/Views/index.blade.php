<div class="row" ng-controller="storageCtrl" ng-init="getStorageList()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">My Storage</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <a href="" data-toggle="modal" data-target="#storageModel" class="btn btn-primary btn-right" style="margin-right: 20px;">Upload new</a>
                            </span>
                        </div>
                    </div>
                </div> 

                <div class="foldr-main" ng-repeat="imgs in directories track by $index | unique:'imgs' ">
                    <div class="databox databox-lg databox-halved radius-bordered databox-shadowed databox-vertical">
                        <div class="databox-top bg-gray-custom no-padding">
                            <div class="databox-icon" style="margin-top:5px;">
                                <img ng-src="/backend/assets/img/folder-img.png" class="folder-img">                   
                                <span class="databox-number lightcarbon foldr-icon-div"> 
                                    <i class="fa fa-share-alt" data-toggle="modal" data-target="#sharedModel" ng-click="share(imgs.id)"></i><br>
                                    <i class="fa fa-trash-o" confirmed-click="deleteFolder(imgs.id,$index,1);" ng-confirm-click="Are you sure delete folder?"></i>
                                </span>
                            </div>
                        </div>
                        <div class="databox-bottom bg-white no-padding">
                            <div class="databox-row text-align-center">
                                <a  href="[[ config('global.backendUrl') ]]#/storage-list/getAllList/{{imgs.id}}">  
                                    <div class="databox-cell bordered-platinum padding-5">
                                        <span class="databox-number lightcarbon"> {{imgs.folder}}</span>                                   
                                    </div>
                                </a>
                            </div>
                        </div>
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
                    <h4 class="modal-title" align="center">Create New Folder</h4>
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
                                    <div ng-if="errorMsg" class="err">{{errorMsg}}</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true">Submit</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>


    <div class="modal fade" id="sharedModel" role="dialog" tabindex="-1" ng-init="getEmployees()">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Sharing History</h4>
                </div>
                <form  ng-submit="sharedForm.$valid && sharedFormWith(id)" name="sharedForm"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <input type="hidden" ng-model="id" name="id"> 
                    <div class="modal-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Employee Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="Shared in folderSharedEmployees">
                                    <td>{{$index + 1}}</td>
                                    <td>{{Shared.first_name + ' ' + Shared.last_name}}</td>
                                    <td><a href="javascript:void(0)" ng-click="removeEmployees($index, Shared.employee_id, id);" class="btn btn-primary">Remove</a></td>
                                </tr>
                        </table>
                        <br/><br/>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!sharedForm.share_with.$dirty && sharedForm.share_with.$invalid) }">
                            <label>Employee</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="share_with" name="share_with" required  ng-change="errorMsg = null">
                                    <option value="">Select Employee</option>
                                    <option  ng-repeat="itemone in employeeRow" ng-selected="{{ share_with == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}}</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="sharedForm.share_with.$error">
                                    <div ng-message="required">Select employee.</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                                <br/>
                            </span>
                        </div>
                        <div class="modal-footer" align="center">
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true">Submit</button>
                        </div>
                    </div>
                </form>                    
            </div>
        </div>
    </div>
</div>

