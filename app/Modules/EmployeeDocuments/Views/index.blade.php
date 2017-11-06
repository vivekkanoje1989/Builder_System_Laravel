<style>
    .close {
        color:black;
    }
    .alert.alert-info {
        border-color: 1px solid #d9d9d9;
        /* background: rgba(173, 181, 185, 0.81); */
        background-color: #f5f5f5;
        border: 1px solid #d9d9d9;
        color: black;
        padding: 5px;
        width: 110%;
    }
</style>
<div class="row" ng-controller="employeeDocumentsCtrl" ng-init="manageEmployeeDocuments()"> 
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Documents</span> 
                <span data-toggle="modal" data-target="#help" class="helpDescription">Help <i class="fa fa-question-circle" aria-hidden="true"></i></span>
            </div>
            <div class="widget-body table-responsive">

                <div class="row table-toolbar">
                    <a data-toggle="modal" data-target="#documentModal" ng-click="initialModal(0, '', '')" class="btn btn-default">Create Document</a>
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href="" ng-hide="disableBtn"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">

                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2" ng-disabled="disableBtn"> 
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" ng-disabled="disableBtn"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a class="" ng-click="manageDocumentExportToExcel()" ng-show="exportData == '1'">
                                        <span>Export</span>
                                    </a>
                                </li>
                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" ng-disabled="disableBtn" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData"  ng-if="value != 0">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'document_name'" data-toggle="tooltip" title="Document Name"><strong> Document Name: </strong>{{ value}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-disabled="disableBtn" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                               <option value="30">30</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="700">700</option>
                                <option value="800">800</option>
                                <option value="900">900</option>
                                <option value="999">999</option>
                            </select>
                        </label>
                    </div>
                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <th style="width:5%">SR No</th> 
                                <th style="width: 30%">
                                    <a href="javascript:void(0);" ng-click="orderByField('document_name')">Document name
                                        <span ><img ng-hide="(sortKey == 'document_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'document_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'document_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>  
                                <th style="width: 5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" dir-paginate="list in DocumentsRow| filter:search |filter:searchData | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort">
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                                <td>{{ list.document_name}}</td>   
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit documents" data-toggle="modal" data-target="#documentModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.document_name}}', $index)" class="btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                    <span ng-show="deleteBtn == '1'" class="" tooltip-html-unsafe="Delete"><a href="" ng-click="confirm({{list.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"  ng-show="(DocumentsRow|filter:search | filter:searchData).length == 0" align="center">Record Not Found</td>   
                                <td colspan="3"  ng-show="totalCount == 0" align="center">Record Not Found</td>   
                            </tr>
                        </tbody>
                    </table>
                    <div class="DTTTFooter">
                        <div class="col-sm-6">
                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-primary" id="documentModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="documentForm.$valid && doDocumentsAction()" name="documentForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">

                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!documentForm.document_name.$dirty && documentForm.document_name.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">

                            <span class="input-icon icon-right">
                                <label>Document name<span class="sp-err">*</span></label>
                                <input type="text" class="form-control" ng-model="document_name" name="document_name" ng-change="errorMsg = null" required>

                                <div class="help-block" ng-show="sbtBtn" ng-messages="documentForm.document_name.$error">
                                    <div ng-message="required">This field is required.</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true">{{action}}</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="myRequestFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Document Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.document_name"  name="document_name" class="form-control"  oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">

                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" align="center">
                            <button type="submit" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->
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
                            <label class="helpContent">Priority </label>
                            <span class="input-icon icon-right">                                    

                            </span>
                        </div>                            
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>

