<style>
    .img-wrap {
        position: relative;
        display: inline-block;

        font-size: 0;
    }
    .img-wrap .close {
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
    .img-wrap:hover .close {
        opacity: 1;
    }
</style>
<div class="row" ng-controller="storageCtrl" ng-init="allImages('<?php echo $filename; ?>')">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">My Storage</span>
                <button confirmed-click="restoreFolder('<?php echo $filename; ?>');" ng-confirm-click="Are you sure restore folder?" class="btn btn-info">Restore Folder</button>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
                <div class="row">
                    <div class="col-md-2"  style="margin:0 0 25px 0;">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2" ng-repeat="imgs in folderImages track by $index | unique:'imgs' " style="margin:0 0 25px 0;">
                        <div class="img-wrap"> 
                            <span class="close" ng-click="deleteImages($index, imgs)">&times;</span>
                            <img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/{{imgs}}" height="100px;" width="100px;">
                        </div>
                    </div>
                </div>
                <div class="row" ng-if="noResult">
                    <div class="col-md-12">
                        <h3>{{noResult}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="storageModel" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Create new Storage</h4>
                </div>
                <form  ng-submit="storageForm.$valid && dosubstorageFormAction(fileName, '<?php echo $filename; ?>')" name="storageForm"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!storageForm.folderorfile.$dirty && storageForm.folderorfile.$invalid)}">
                            <label>Select type<span class="sp-err">*</span></label>                                 
                            <span class="input-icon icon-right">
                                <select name="folderorfile" ng-model="folderorfile" class="form-control" required ng-change="changeFileFolder()" >
                                    <option value="">Select</option>
                                    <option value="1">New folder</option>
                                    <option value="0">Add files</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="storageForm.folderorfile.$error">
                                    <div ng-message="required">Type is required</div>
                                </div>
                            </span>
                        </div> 
                        <div class="form-group"    ng-class="{ 'has-error' : sbtBtn && (!storageForm.fileName.$dirty && storageForm.fileName.$invalid)}">
                            <span class="input-icon icon-right" >
                                <input type="file" ngf-select  ng-model="fileName" name="fileName" required id="fileName" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                <div class="help-block" ng-show="sbtBtn" ng-messages="storageForm.fileName.$error">
                                    <div ng-message="required">Filename is required</div>
                                </div>
                            </span>
                        </div>     
                       
                        <div class="modal-footer" align="center">
                            <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button>
                        </div> 
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
                <form  ng-submit="sharedForm.$valid && sharedFormWith('<?php echo $filename; ?>')" name="sharedForm"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!sharedForm.share_with.$dirty && sharedForm.share_with.$invalid) }">
                            <span class="input-icon icon-right">

                                <select class="form-control" ng-model="share_with" name="share_with" ng-change="getEmployeesCC()" required>
                                    <option value="">Select User</option>
                                    <option  ng-repeat="itemone in employeeRow" ng-selected="{{ share_with == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}}</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="sharedForm.share_with.$error">
                                    <div ng-message="required">Application To cannot be blank.</div>
                                </div>
                                <br/>
                            </span>
                        </div>
                        <div class="modal-footer" align="center">
                            <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button>
                        </div> 
                    </div>
                </form>                    
            </div>
        </div>
    </div>
</div>