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
<div class="row" ng-controller="storageCtrl" ng-init="allImages('<?php echo $folderId; ?>'); getSharedEmployees('<?php echo $folderId; ?>'); getSubDirectory('<?php echo $folderId; ?>');" >  
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
                                <a href="" data-toggle="modal" data-target="#folderModel" ng-click="initialModal()" class="btn btn-primary btn-right" style="margin-left:10px;">Upload new folder</a> 
                                <a href="" data-toggle="modal" data-target="#storageModel" ng-click="initialModal()" class="btn btn-primary btn-right">Upload new file</a>
                            </span>
                        </div>
                    </div>
                </div>   

                <h5 class="row-title ng-scope" ng-if="subDirectories != ''"><i class="fa fa-folder-open-o"></i>Folders</h5> 
                <div class="row" >   
                    <div class="foldr-main" ng-repeat="imgs in subDirectories track by $index | unique:'imgs' ">
                        <div class="databox databoxone databox-halved radius-bordered databox-shadowed databox-vertical">
                            <div class="databox-top bg-darkorange no-padding">
                                <div class="databox-icon" style="margin-top:5px;">
                                    <img ng-src="/backend/assets/img/folder-img.png" class="folder-img">                   
                                    <span class="databox-number lightcarbon foldr-icon-div"> 
                                        <i class="fa fa-share-alt" data-toggle="modal" data-target="#sharedModel" ng-click="share(imgs.id)"></i><br>
                                        <i class="fa fa-trash-o" confirmed-click="deleteFolder(imgs.id,$index,2);" ng-confirm-click="Are you sure delete folder?"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="databox-bottom bg-white no-padding">
                                <div class="databox-row text-align-center">
                                    <a  href="[[ config('global.backendUrl') ]]#/storage-list/getSubFolderImages/{{imgs.id}}">  
                                        <div class="databox-cell bordered-platinum padding-5">
                                            <span class="databox-number lightcarbon"> {{imgs.folder}}</span>                                   
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="subDirectories.length == 0">
                            <div class="col-md-12">
                                <h3 >Sub folders not availble</h3>
                            </div>
                        </div>
                        <br/><br/>
                    </div>
                </div>    
                <hr>
                <h5 class="row-title ng-scope" ng-if="folderImages != ''"><i class="fa fa-picture-o"></i>Images</h5>
                <div class="row">
                    <div class="col-md-2" ng-repeat="imgs in folderImages track by $index | unique:'imgs' " style="margin:15px 0 25px 0;">
                        <div class="img-wrap"> 
                            <a data-reveal-id="sharing_files" ng-click="imageShared(imgs.id); getSharedImagesEmployees(imgs.id);"  data-toggle="modal" data-target="#sharedImageModel" >
                                <img title="Share" ng-src="/backend/assets/img/share-img.png" class="share" style="display: block;"> 
                            </a>
                            <span class="close" ng-click="deleteImages($index, imgs.id)">&times;</span>
                            <a href="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/{{imgs.file_url}}" target="_blank"> <img ng-src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/{{imgs.file_url}}" height="100px;" width="100px;"></a>
                        </div>
                    </div>
                </div>
                <div class="row" ng-if="folderImages.length == 0">
                    <div class="col-md-12">
                        <h3 >Images not availble</h3>
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
    <div class="modal fade" id="sharedImageModel" role="dialog" tabindex="-1" ng-init="getEmployees()">    
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Sharing History</h4>
                </div>
                <form  ng-submit="sharedForm.$valid && sharedImageWith(id)" name="sharedForm"  novalidate enctype="multipart/form-data">
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
                                <tr ng-repeat="Shared in imageSharedEmployees">
                                    <td>{{$index + 1}}</td>
                                    <td>{{Shared.first_name + ' ' + Shared.last_name}}</td>
                                    <td><a href="javascript:void(0)" ng-click="removeImageSharedEmp($index, Shared.employee_id);" class="btn btn-primary">Remove</a></td>
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
                                    <div ng-message="required">Select employee</div>
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
                                <input type="text"   ng-model="folderName" name="folderName"  class="form-control" required ng-change="errorMsg == null">
                                <div class="help-block" ng-show="sbtBtn" ng-messages="folderForm.folderName.$error">
                                    <div ng-message="required">Folder name is required</div>
                                    <div ng-if="errorMsg" class="err">{{errorMsg}}</div>
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