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
<div class="row" ng-controller="lostReasonsController" ng-init="manageLostReasons()">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Lost Reasons</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <a data-toggle="modal" data-target="#lostReasonModal" ng-click="initialModal(0, '', '', '')" class="btn btn-default">Add Lost Reason</a>
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href="" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="lostReasonExportToxls()" ng-show="exportData=='1'">
                            <span>Export</span>
                        </a>
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Options</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="javascript:void(0);">Action</a>
                                </li>
                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'reason'" data-toggle="tooltip" title="Reason"><strong> Reason : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'lost_reason_status'" data-toggle="tooltip" title="Status"><strong> Status : </strong> {{ value == 1? "Active" : "In active"}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                                <option value="1">1</option>
                                <option value="5">5</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="100">100</option>
                            </select>
                        </label>
                    </div>
                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                            <tr>
                                <th style="width:5%">Sr. No.</th> 
                                <th style="width: 30%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'reason'; reverseSort = !reverseSort">Reason
                                        <span ng-show="orderByField == 'reason'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th>
                                <th style="width:5%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'lost_reason_status'; reverseSort = !reverseSort">Status
                                        <span ng-show="orderByField == 'lost_reason_status'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th> 
                                <th style="width: 5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="listLostReason in listLostReasons| filter:search |filter:searchData | orderBy:orderByField:reverseSort | itemsPerPage:itemsPerPage" >
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                                <td>{{ listLostReason.reason}}</td>                           
                                <td>{{ (listLostReason.lost_reason_status) == 1 ? 'Active' :'In Active'}}</td> 
                                <td class="">
                                    <div class="" tooltip-html-unsafe="Edit Lost Reason" style="display: block;" data-toggle="modal" data-target="#lostReasonModal"><a href="javascript:void(0);" ng-click="initialModal({{ listLostReason.id}},'{{ listLostReason.reason}}',{{ listLostReason.lost_reason_status}},{{ itemsPerPage}},{{$index}})" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></div>
                                </td>
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
    <div class="modal fade modal-primary" id="lostReasonModal" role="dialog" tabindex="-1">   
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="lostReasonForm.$valid && doLostReasonsAction()" name="lostReasonForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <input type="hidden" class="form-control" ng-model="actionModal" name="actionModal" >
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!lostReasonForm.reason.$dirty && lostReasonForm.reason.$invalid) }">
                            <label>Lost reason<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="reason" name="reason"  ng-change="errorMsg = null" required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="lostReasonForm.reason.$error">
                                    <div ng-message="required">Source is required</div>
                                    <div ng-if="errorMsg" class="err">{{errorMsg}}</div>
                                </div>
                            </span>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!lostReasonForm.lost_reason_status.$dirty && lostReasonForm.lost_reason_status.$invalid)}">
                            <label>Status<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">                                
                                <select ng-model="lost_reason_status" name="lost_reason_status" class="form-control" required>
                                    <option value="">Select status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="lostReasonForm.lost_reason_status.$error">
                                    <div ng-message="required"> status is required</div>
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
        <form name="designationFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Reason</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.reason" name="reason" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Status</label>
                        <span class="input-icon icon-right">
                            <select name="lost_reason_status" ng-model="searchDetails.lost_reason_status" class="form-control" >
                                <option value="">Select status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
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
</div>

