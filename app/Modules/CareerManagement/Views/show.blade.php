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
<div class="row" ng-controller="careerCtrl" ng-init = "viewApplicants(<?php echo $career_id; ?>);">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Career</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <a href="[[ config('global.backendUrl') ]]#/career/create" class="btn btn-default">Add Details</a>
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="jobPostingApplicationExportToxls()" ng-show="exportApplicationData == '1'">
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
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData" ng-if="value != 0">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'first_name'" data-toggle="tooltip" title="First Name"><strong> First Name: </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'last_name'" data-toggle="tooltip" title="Last Name"><strong> Last Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'mobile_number'" data-toggle="tooltip" title="Mobile Number"><strong> Mobile Number : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'email_id'" data-toggle="tooltip" title=" Email Id"><strong> Email Id : </strong> {{ value}}</strong>
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
                                <th style="width:5%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'id'; reverseSort = !reverseSort">Sr. No.
                                        <span ng-show="orderByField == 'id'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>                          
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'first_name'; reverseSort = !reverseSort">First name
                                        <span ng-show="orderByField == 'first_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:25%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'last_name'; reverseSort = !reverseSort">Last name
                                        <span ng-show="orderByField == 'last_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'mobile_number'; reverseSort = !reverseSort">Mobile number
                                        <span ng-show="orderByField == 'mobile_number'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'email_id'; reverseSort = !reverseSort">Email
                                        <span ng-show="orderByField == 'email_id'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>                           
                                <th style="width: 10%">Download Resume</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" dir-paginate="list in viewApplicantsRow| filter:search | filter:searchData | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort" >
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                                <td>{{list.first_name}}</td> 
                                <td>{{list.last_name}}</td> 
                                <td>{{list.mobile_number}}</td> 
                                <td>{{list.email_id}}</td> 
                                <td><span ng-if="list.resume_file_name"><a href="/download/{{list.resume_file_name}}" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-download"></i>Download</a></span></td>

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
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="careerFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">First Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.first_name" name="first_name" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Last Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.last_name" name="last_name" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Mobile Number</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.mobile_number" name="mobile_number" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Email</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.email_id" name="email_id" class="form-control">
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
