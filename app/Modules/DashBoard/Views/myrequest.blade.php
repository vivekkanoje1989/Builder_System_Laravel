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
<?php $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);?>
<div class="row" ng-controller="dashboardCtrl" ng-init="getMyRequest()">    
    <div class=" mainDiv col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">My Request</span>          
            </div>
            <!--                <div class="widget-header ">
                                    <span class="widget-caption">My Request</span>
                                    <div class="widget-buttons">
                                            <a href="" data-toggle="maximize">
                                                    <i class="fa fa-expand"></i>
                                            </a>
                                            <a href="#" data-toggle="collapse">
                                                    <i class="fa fa-minus"></i>
                                            </a>
                                            <a href="" data-toggle="dispose">
                                                    <i class="fa fa-times"></i>
                                            </a>
                                    </div>
                            </div>-->
            <!--</div>-->
            <div class="widget-body table-responsive">

                <div class="row table-toolbar">
                    <!--<a id="editabledatatable_new" href="" class="btn btn-default" data-toggle="modal" data-target="#verticalModal" ng-click="initialModal(0, '', '', '', '')">Add New Vertical</a>-->
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                     <?php if (in_array('01403', $array)) { ?>
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View print view"  ng-click="ExportToxls()" >
                            <span>Export</span> <!--href="/manageVerticals/exportToxls"  ng-click="ExportToxls()"-->
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
                     <?php }?>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData"  ng-if="value != 0">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'in_date'" data-toggle="tooltip" title="Date"><strong> Date: </strong> {{ value |date:'yyyy-MM-dd'}}</strong>
                                        <strong ng-if="key === 'request_type'" data-toggle="tooltip" title="Request Type"><strong> Request Type : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'application_to'" data-toggle="tooltip" title="Application To"><strong> Application To : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'from_date'" data-toggle="tooltip" title="From Date"><strong> From Date : </strong> {{ value| date:'yyyy-MM-dd' }}</strong>
                                        <strong ng-if="key === 'to_date'" data-toggle="tooltip" title="To Date"><strong> To Date : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'status'" data-toggle="tooltip" title=" Status"><strong> Status : </strong> {{ value== 1 ? " Leave" : "Approved"}}</strong>
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
                    <!--<table class="table table-striped table-hover table-bordered dataTable no-footer" at-config="config">-->
                    <table class="table table-hover table-striped table-bordered dataTable no-footer tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                            <tr>
                                <th style="width:5%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'id'; reverseSort = !reverseSort">Sr. No.
                                        <span ng-show="orderByField == 'id'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>                          
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'in_date'; reverseSort = !reverseSort">Date
                                        <span ng-show="orderByField == 'in_date'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'request_type'; reverseSort = !reverseSort">Request Type
                                        <span ng-show="orderByField == 'request_type'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'application_to'; reverseSort = !reverseSort">Application To
                                        <span ng-show="orderByField == 'application_to'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'from_date'; reverseSort = !reverseSort">From
                                        <span ng-show="orderByField == 'from_date'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th> 
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'to_date'; reverseSort = !reverseSort">To
                                        <span ng-show="orderByField == 'to_date'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'status'; reverseSort = !reverseSort">Status
                                        <span ng-show="orderByField == 'status'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'application_close_date'; reverseSort = !reverseSort">Description
                                        <span ng-show="orderByField == 'application_close_date'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>

                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" dir-paginate="list in myRequest| filter:search |filter:searchData | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort" >
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                                <td>{{list.in_date}}</td> 
                                <td> {{list.request_type}}</td>
                                <td>{{list.application_to}}</td>
                                <td>{{list.from_date}}</td> 
                                <td>{{list.to_date}}</td>
                                <td>{{list.status == 1 ? "Leave" : "Approved" }}</td>
                                <td><a href="" data-toggle="modal" data-target="#myModal" class="btn btn-info btn-xs" ng-click="view_description({{list}})"><i class="fa fa-eye" aria-hidden="true"></i>View</a></td>

                            </tr>
                        </tbody>
                    </table>
                    <div class="DTTTFooter">
                        <div class="col-sm-6">
                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                            <!--div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div-->
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
    <div class="modal fade" id="myModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Request Description</h4>
                </div>
                <table class="table table-stripped table-bordered" style="margin:20px 20px 20px 20px; width:90%;">
                    <tr><td>Date</td><td>{{in_date}}</td></tr>
                    <tr><td>Request Type</td><td>{{request_type}}</td></tr>
                    <tr><td>To</td><td>{{to_name}}</td></tr>
                    <tr><td>CC</td><td>{{cc_name}}</td></tr>
                    <tr><td>Description</td><td>{{req_desc}}</td></tr>
                </table>
                <br/>
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
                        <label for="">Application To</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.application_to"  name="application_to" class="form-control"  oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">

                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Request Type</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.request_type" name="request_type" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for="">From Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="searchDetails.from_date" placeholder="From Date" name="from_date" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </span>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for="">To Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="searchDetails.to_date" placeholder="To Date" name="to_date" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Status</label>
                        <span class="input-icon icon-right">
                            <select class="form-control" ng-model="searchDetails.status" name="status">
                                <option value="">Select Status</option>
                                <option value="1">Leave</option>
                                <option value="3">Approved</option>
                            </select>
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