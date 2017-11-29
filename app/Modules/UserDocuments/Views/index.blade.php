<style>
    .btn-round{
        border-radius: 50%;
        height: 40px;
        width: 40px;
        line-height: 28px;
        padding-left: 13px;
        outline: none !important;
    }
    @media (min-width:768px){
        .modal-dialog {
            width: 700px !important;
        }
    }
    .editor-text {
        border: 1px solid #cecece;
        margin-top: 10px;
        background-color: #fff;
        padding: 10px;
    }
</style>
<div class="row">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="userDocumentController" ng-init="getEmployees(); manageEmployeeDocuments();" >
            <div class="widget-header bordered-bottom bordered-themeprimary ">
                <span class="widget-caption">User Documents</span>
                <span data-toggle="modal" data-target="#help" class="helpDescription">Help <i class="fa fa-question-circle" aria-hidden="true"></i></span>
            </div>
            <div class="widget-body col-lg-12 col-sm-12 col-xs-12">
                <div id="user-form">
                    <form role="form" name="userForm" method="post"  ng-submit="userForm.$valid && createUserDocuments(userData.documentUrl, userData)"   novalidate enctype="multipart/form-data">
                        <input type="hidden" ng-model="userData.csrfToken" name="csrftoken" id="csrftoken" ng-init="userData.csrfToken = '[[ csrf_token() ]]'">
                        <input type="hidden" ng-model="searchData.userId"  name="userId"    id="custId"    value="{{searchData.userId}}">
                        <div class="row col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">User List</label>
                                            <span class="input-icon icon-right">                                    
                                                <select class="form-control" ng-model="userData.employee_id" name="employee_id"  required ng-change="getUserDocumentsLists(userData.employee_id)">
                                                    <option value="">Please Select User</option>
                                                    <option  ng-repeat="itemone in employeeRow"  value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                        </div>
                        <div class="row col-lg-12 col-sm-12 col-xs-12" ng-if="showDiv">                            
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-title">
                                    Document Details
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <input type="text" ng-model="id" class="form-control">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Document Name <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="userData.document_id"  name="document_id" class="form-control"  required ng-change="changeErrorMsg()">
                                                    <option value="">Select Document</option>
                                                    <option  ng-repeat ="doc in DocumentsRow" value="{{doc.id}}">{{doc.document_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i> 
                                                <div ng-show="sbtBtn" ng-messages="userForm.document_id.$error" class="help-block errMsg">
                                                    <div ng-message="required"  class="sp-err">This field is required</div>
                                                    <div ng-if="errorMsgg">{{errorMsgg}}</div>
                                                </div>
                                                <div ng-if="document_id" class="errMsg status sp-err">{{document_id}}</div>
                                            </span>

                                        </div>     
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Document Number <span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="userData.document_number" name="document_number" ng-pattern="/^[a-zA-Z0-9]*$/" required maxlength="15"  >
                                                <div ng-show="sbtBtn" ng-messages="userForm.document_number.$error" class="help-block errMsg">
                                                    <div ng-message="required" class="sp-err">This field is required</div>
                                                    <div ng-message="pattern" class="sp-err">Invalid document number</div>
                                                </div>
                                                <div ng-if="document_number" class="errMsg status sp-err">{{document_number}}</div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Upload Document</label>
                                            <span class="input-icon icon-right">
                                                <input type="file" ngf-select ng-model="userData.documentUrl" name="documentUrl" id="documentUrl" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" ><br/>
                                            </span>
                                        </div>
                                        <div  ng-show="document_url" style="margin-top:18px;">
                                            <div  class="img-div2" data-title="name">   
                                                <i class="fa fa-times rem-icon" ng-if="document_url" ng-click="removeImg('{{document_url}}',{{id}})"></i>
                                                <img ng-if="document_url" ng-src="[[ Config('global.s3Path') ]]/Employee-Documents/{{document_url}}" style="width: 60px;height: 60px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-xs-12 col-md-12" align="left">
                                        <button type="submit" class="btn btn-primary" ng-disabled="userdisables"  ng-click="sbtBtn = true">{{action}}</button>
                                    </div>
                                </div><br>
                            </div>   
                        </div> 
                        <div class="col-xs-12 col-md-12" ng-if="showDiv">
                            <div class="widget">                                
                                <div class="widget-header">
                                    <span class="widget-caption" style="font-size: 15px;font-weight: 600 !important;">Document List <span id="errContactDetails" class="errMsg"></span></span>
                                </div>
                                <div class="widget-body table-responsive">
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <thead class="bord-bot">
                                            <tr>
                                                <th>Sr. No. </th>
                                                <th>Document name</th>
                                                <th>Document Number</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="list in documentRow">
                                                <td>{{$index + 1}}</td>
                                                <td>{{list.user_documents.document_name}}</td>
                                                <td>{{list.document_number}}</td>
                                                <td class="fa-div">
                                                    <div class="fa-hover" tooltip-html-unsafe="Edit Document" style="display: block;"><a href="javascript:void(0);" ng-click="updateDocument({{list}},{{$index}})"><i class="fa fa-pencil"></i></a></div>
                                                </td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="help" role="dialog" tabindex="-1" >    
        <div class="modal-dialog">

            <div class="modal-content helpModal" >
                <div class="modal-header helpModalHeader bordered-bottom bordered-themeprimary" >
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title" align="center">Task Priority Help Info</h4>
                </div>                
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label class="helpContent">- After selecting the user showing the documents information about that user. </label>

                        </div>                            
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
