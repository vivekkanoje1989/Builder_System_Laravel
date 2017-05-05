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
    .errMsg{
        color:red;
    }
</style>
<div class="row">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="userDocumentController" ng-init="getEmployees(); manageEmployeeDocuments();" >
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{pageHeading}}</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <div id="user-form">
                    <form role="form" name="userForm" method="post"  ng-submit="userForm.$valid && createUserDocuments(userData.documentUrl,userData)"   novalidate enctype="multipart/form-data">
                        <input type="hidden" ng-model="userData.csrfToken" name="csrftoken" id="csrftoken" ng-init="userData.csrfToken = '[[ csrf_token() ]]'">
                        <input type="hidden" ng-model="searchData.userId" name="userId" id="custId" value="{{searchData.userId}}">
                        <div class="row col-lg-12 col-sm-12 col-xs-12">
                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-title">
                                    User Documents  
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">User</label>
                                            <span class="input-icon icon-right">                                    
                                                <select class="form-control" ng-model="userData.employee_id" name="employee_id"  required ng-change="getUserDocumentsLists(userData.employee_id)">
                                                    <option value="">Select User</option>
                                                    <option  ng-repeat="itemone in employeeRow"  value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}}</option>
                                                </select>
                                                <i class="glyphicon glyphicon-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                        </div>
                        <div class="row col-lg-12 col-sm-12 col-xs-12" ng-if="showDiv">
                            <hr class="wide" />
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-title">
                                    Document Details
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Document</label>
                                            <span class="input-icon icon-right">
                                                <select ng-model="userData.document_id"  name="document_id" class="form-control" required  ng-change="changeErrorMsg()">
                                                    <option value="">Select Document</option>
                                                    <option  ng-repeat ="doc in DocumentsRow" value="{{doc.id}}">{{doc.document_name}}</option>
                                                </select>
                                                <i class="fa fa-sort-desc"></i> 
                                                <div ng-show="formButton" ng-messages="userForm.document_id.$error" class="help-block errMsg" ng-if="submitted">
                                                    <div ng-message="required">Please select document</div>
                                                    <div ng-if="errorMsgg">{{errorMsgg}}</div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Document Number</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" class="form-control" ng-model="userData.document_number" name="document_number" capitalizeFirst oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="15" required   >

                                                <div ng-show="formButton" ng-messages="userForm.document_number.$error" class="help-block errMsg" ng-if="submitted">
                                                    <div ng-message="required">Please enter document number</div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Upload document</label>
                                            <span class="input-icon icon-right">
                                                <input type="file" ngf-select ng-model="userData.documentUrl" name="documentUrl" id="documentUrl" accept="image/*" ngf-max-size="2MB" class="form-control imageFile" required ngf-model-invalid="errorFile" >
                                                <!--<input type="file"    ng-model="userData.documentUrl" name="documentUrl" id="documentUrl" accept="image/*" class="form-control imageFile"  ngf-model-invalid="errorFile" >-->
                                                <br/>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xs-12 col-md-12" align="center">
                                    <button type="submit" class="btn btn-primary" ng-show="showDiv" ng-disabled="disableCreateButton" ng-click="formButton = true">Save & Continue</button>
                                </div>
                            </div> 
                            <hr class="wide col-md-12" />   
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
                                                <th>File name</th>
                                                <th>Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="list in documentRow">
                                                <td>{{$index + 1}}</td>
                                                <td>{{list.document_name}}</td>
                                                <td>{{list.document_url}}</td>
                                                <td>{{list.document_number}}</td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr class="wide col-lg-12 col-xs-12 col-md-12" ng-if="showDiv"/>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
