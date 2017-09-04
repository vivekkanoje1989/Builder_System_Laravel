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
<div class="row" ng-controller="storageCtrl" ng-init="allImages('<?php echo $folderId; ?>'); getSharedEmployees('<?php echo $folderId; ?>'); getSubDirectory('<?php echo $folderId; ?>')">  
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
                                <button confirmed-click="restoreFolder('<?php echo $folderId; ?>');" ng-confirm-click="Are you sure restore folder?" class="btn btn-primary btn-right">Restore Folder</button>
                            </span>
                        </div>
                    </div>
                </div>  
                <h5 class="row-title ng-scope" ng-if="subDirectories != ''"><i class="fa fa-folder-open-o"></i>Folders</h5>
                <div class="row" ng-if="subDirectories != ''">
                    <div class="foldr-main col-md-2" ng-repeat="imgs in subDirectories track by $index | unique:'imgs' ">
                        <a  href="[[ config('global.backendUrl') ]]#/storage-list/SubFolderRestore/{{imgs.id}}">
                        <img ng-src="/backend/assets/img/folder.jpg" width="100px" height="120px;" ><br/>
                        <h5 style="margin-left: 20px;">{{imgs.folder}}</h5></a>
                    </div>
                </div>
                <hr>
                <h5 class="row-title ng-scope" ng-if="folderImages != ''"><i class="fa fa-picture-o"></i>Images</h5>
                <div class="row" ng-if="folderImages != ''">
                    <div class="col-md-2" ng-repeat="imgs in folderImages track by $index | unique:'imgs' " style="margin:15px 0 25px 0;">
                        <div class="img-wrap"> 
                            <a  data-reveal-id="sharing_files" ng-click="imageShared(imgs.id); getSharedImagesEmployees(imgs.id)"  data-toggle="modal" data-target="#imageModel" >
                                <img title="Share " ng-src="/backend/assets/img/share-img.png" class="share" style="display: block;"> 
                            </a>
                            <span class="close" ng-click="deleteImages($index, imgs.id)">&times;</span>
                            <a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/{{imgs.file_url}}" target="_blank"> <img ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/{{imgs.file_url}}" height="100px;" width="100px;"></a>
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
                    <h4 class="modal-title" align="center">Create New File</h4>
                </div>
                <form  ng-submit="storageForm.$valid && dosubstorageFormAction(fileName, '<?php echo $folderId; ?>')" name="storageForm"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="modal-body">
                        <label>Image</label>
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
                <form  ng-submit="sharedForm.$valid && sharedFormWith('<?php echo $folderId; ?>')" name="sharedForm"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
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
                                    <td><a href="javascript:void(0)" ng-click="removeEmployees($index, Shared.employee_id, '<?php echo $folderId; ?>');" class="btn btn-primary">Remove</a></td>
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
                            <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button>
                        </div>
                    </div>
                </form>                    
            </div>
        </div>
    </div>
    <div class="modal fade" id="folderModel" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Create New Folder</h4>
                </div>
                <form  ng-submit="folderForm.$valid && dofolderstorageAction('<?php echo $folderId; ?>')" name="folderForm"  novalidate>
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="modal-body">
                        <label>Sub folder name </label>
                        <div class="form-group"    ng-class="{ 'has-error' : sbtBtn && (!folderForm.folderName.$dirty && folderForm.folderName.$invalid)}">
                            <span class="input-icon icon-right" >
                                <input type="text"   ng-model="folderName" name="folderName"  class="form-control" required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="folderForm.folderName.$error">
                                    <div ng-message="required">Folder name is required</div>
                                </div>
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

    <div class="modal fade" id="imageModel" role="dialog" tabindex="-1" ng-init="getEmployees()">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Sharing History</h4>
                </div>

                <form  ng-submit="sharedImage.$valid && sharedImageWith('<?php echo $folderId; ?>')" name="sharedImage"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
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
                                <tr ng-repeat="Shared in imageSharedEmployees">
                                    <td>{{$index + 1}}</td>
                                    <td>{{Shared.first_name + ' ' + Shared.last_name}}</td>
                                    <td><a href="javascript:void(0)" ng-click="removeImageSharedEmp($index, Shared.employee_id, '<?php echo $folderId; ?>');" class="btn btn-primary">Remove</a></td>
                                </tr>
                            </tbody>    
                        </table>
                        <br/><br/>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!sharedImage.share_with.$dirty && sharedImage.share_with.$invalid) }">
                            <label>Employee</label>
                            <input type="hidden" name="image_id" ng-model="image_id">
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="share_with" name="share_with" ng-change="errorMsg = null" required>
                                    <option value="">Select Employee</option>
                                    <option  ng-repeat="itemone in employeeRow" ng-selected="{{ share_with == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}}</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="sharedImage.share_with.$error">
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