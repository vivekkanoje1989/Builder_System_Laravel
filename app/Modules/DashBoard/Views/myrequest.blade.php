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
    .displayDetails td{
        border:none !important;
    }
</style>

<div class="row" ng-controller="dashboardCtrl" ng-init="getMyRequest()">    
    <div class=" mainDiv col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">My Requests</span>    
                <span data-toggle="modal" data-target="#help" class="helpDescription">Help <i class="fa fa-question-circle" aria-hidden="true"></i></span>
              </div>
            <div class="widget-body table-responsive">

                <div class="row table-toolbar">
                    <div class="btn-group">
                        <a class="btn btn-default shiny " href="javascript:void(0);">Add Request</a>
                        <a class="btn btn-default  dropdown-toggle shiny" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="[[ config('global.backendUrl') ]]#/request-leave/index">Request Leave</a>
                            </li>
                            <li>
                                <a href="[[ config('global.backendUrl') ]]#/request-approval/index">Request Other Approval</a>
                            </li>

                        </ul>
                    </div>
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""  ng-hide="disableBtn"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2"  ng-disabled="disableBtn">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"  ng-disabled="disableBtn"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="ExportToxls()" ng-show="exportMyRequest == '1'" > Export</a>
                                </li>
                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search"  ng-disabled="disableBtn" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData track by $index"  ng-if="value != 0 && value != null">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'in_date'" data-toggle="tooltip" title="Date"><strong> Date: </strong> {{ value |date:'yyyy-MM-dd'}}</strong>
                                        <strong ng-if="key === 'request_type'" data-toggle="tooltip" title="Request Type"><strong> Request Type : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'application_to'" data-toggle="tooltip" title="Application To"><strong> Application To : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'from_date'" data-toggle="tooltip" title="From Date"><strong> From Date : </strong> {{value | date:'dd-MM-yyyy' }}</strong>
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
                            <select  ng-disabled="disableBtn" class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
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
                    <table class="table table-hover table-striped table-bordered dataTable no-footer tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                            <tr>
                                <th style="width:5%">Sr. No.</th>                          
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('in_date')">Date
                                        <span ><img ng-hide="(sortKey == 'in_date' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'in_date' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'in_date' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('request_type')">Request Type
                                        <span ><img ng-hide="(sortKey == 'request_type' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'request_type' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'request_type' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('application_to')">Application To
                                        <span ><img ng-hide="(sortKey == 'application_to' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'application_to' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'application_to' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('from_date')">From
                                        <span ><img ng-hide="(sortKey == 'from_date' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'from_date' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'from_date' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th> 
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('to_date')">To
                                        <span ><img ng-hide="(sortKey == 'to_date' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'to_date' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'to_date' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('status')">Status
                                        <span ><img ng-hide="(sortKey == 'status' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'status' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'status' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width:10%">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="list in myRequest| filter:search |filter:searchData  | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort" >
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                                <td>{{list.in_date}}</td> 
                                <td>{{list.request_type}}</td>
                                <td>{{list.application_to}}</td>
                                <td>{{list.from_date}}</td> 
                                <td>{{list.to_date}}</td>
                                <td>{{list.status == 1 ? "Leave" : "Approved" }}</td>
                                <td><a href="" data-toggle="modal" data-target="#myModal" class="btn-primary btn-xs" ng-click="view_description({{list}})"><i class="fa fa-eye" aria-hidden="true"></i>View</a></td>

                            </tr>
                            <tr>
                                <td colspan="8"  ng-show="(myRequest | filter:search | filter:searchData).length == 0 || myRequestCount == 0" align="center">Records Not Found</td>   
                                <td colspan="8"  ng-if="totalCount == 0" align="center">Records Not Found</td>   
                            </tr>
                        </tbody>
                    </table>
                    <div class="DTTTFooter">
                        <div class="col-sm-6">
                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                        </div>
                        <div class="col-sm-6" ng-if="myRequest.length >= 0">
                            <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="myModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bordered-bottom bordered-themeprimary" style=" border-bottom: 2px solid #e5e5e5;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Request Description</h4>
                </div>
                <table class="table table-striped table-hover displayDetails" style="margin:20px 20px 20px 20px; width:90%;">
                    <tr><td style="font-weight: 600;">DATE</td><td class="text-center"><b>:</b></td><td>{{in_date}}</td></tr>
                    <tr><td style="font-weight: 600;">REQUEST TYPE</td><td class="text-center"><b>:</b></td><td>{{request_type}}</td></tr>
                    <tr><td style="font-weight: 600;">TO</td><td class="text-center"><b>:</b></td><td>{{to_name}}</td></tr>
                    <tr><td style="font-weight: 600;">CC</td><td class="text-center"><b>:</b></td><td>{{cc_name}}</td></tr>
                    <tr><td style="font-weight: 600;">DESCRIPTION</td><td class="text-center"><b>:</b></td><td>{{req_desc}}</td></tr>
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
                    <div class="form-group" >
                        <label for="">Application To</label>
                        <span class="input-icon icon-right" ng-init="getEmployees()"> 
                            <select class="form-control"  ng-model="searchDetails.application_to" name="application_to" id="application_to" >
                                <option value="">Select Employee</option>
                                <option ng-repeat="item in employeeRow" value="{{item.employeeName}}" ng-selected="{{ item.employeeName == searchDetails.application_to}}" >{{item.employeeName}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Request Type</label>
                        <span class="input-icon icon-right">
                            <select class="form-control" ng-model="searchDetails.request_type" name="request_type">
                                <option value="">Select Status</option>
                                <option value="Leave">Leave</option>
                                <option value="Approval">Approval</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
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
                                <label class="helpContent">-  you can see all request raised by login user.</label>
                                <label class="helpContent">-  After click on Add Request->Request Leave fill the following form for apply to leave request.</label>
                                <label class="helpContent">-  After click on Add Request->Request Other Approval fill the following form for any other approval.</label>
                                <label class="helpContent">- After Click on View button displays the description about leave application.</label>
                                <span class="input-icon icon-right">                                    
                                    
                                </span>
                            </div>                            
                        </div>
                    </div>  
            </div>
        </div>
    </div>
</div>