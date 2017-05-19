<div class="row" ng-controller="employeeDocumentsCtrl" ng-init="manageEmployeeDocuments()"> 
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Documents</span>
                <a data-toggle="modal" data-target="#documentModal" ng-click="initialModal(0, '', '')" class="btn btn-info">Create document</a>&nbsp;&nbsp;&nbsp;
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">                
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                        <tr>
                            <th style="width:5%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'id'; reverseSort = !reverseSort">SR No.
                                    <span ng-show="orderByField == 'id'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th> 
                            <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'document_name'; reverseSort = !reverseSort">Document name
                                    <span ng-show="orderByField == 'document_name'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                    </span>
                                </a>
                            </th>  
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><input type="text" ng-model="search" class="form-control"  placeholder="Search"></td>                           
                            <td></td>                        </tr>
                        <tr role="row" ng-repeat="list in DocumentsRow| filter:search | orderBy:orderByField:reverseSort">
                            <td>{{ $index + 1}}</td>
                            <td>{{ list.document_name}}</td>   
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit documents" style="display: block;" data-toggle="modal" data-target="#documentModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.document_name}}', $index)"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="documentModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Documents</h4>
                </div>
                <form novalidate ng-submit="documentForm.$valid && doDocumentsAction()" name="documentForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                   
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!documentForm.document_name.$dirty && documentForm.document_name.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">

                            <span class="input-icon icon-right">
                                <label>Document name<span class="sp-err">*</span></label>
                                <input type="text" class="form-control" ng-model="document_name" name="document_name" ng-change="errorMsg = null" required>

                                <div class="help-block" ng-show="sbtBtn" ng-messages="documentForm.document_name.$error">
                                    <div ng-message="required">Document name is required</div>
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

