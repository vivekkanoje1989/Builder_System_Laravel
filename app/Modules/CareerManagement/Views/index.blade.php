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
<div class="row" ng-controller="careerCtrl" ng-init="manageCareers()">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Career</span>                
            </div>
            <div class="widget-body table-responsive">
                
                <div class="row table-toolbar">
                    <a href="[[ config('global.backendUrl') ]]#/job-posting/create" class="btn btn-default">Post Job</a>
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="jobPostingExportToxls()" ng-show="exportData=='1'">
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
                                        <strong ng-if="key === 'job_title'" data-toggle="tooltip" title="Job Title"><strong> Job Title : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'application_start_date'" data-toggle="tooltip" title="Page Title"><strong> Application Start Date : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'application_close_date'" data-toggle="tooltip" title="Page Title"><strong> Application Close Date : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'meta_keywords'" data-toggle="tooltip" title="Page Title"><strong> Page Title : </strong> {{ value}}</strong>
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
                                    <a href="javascript:void(0);" ng-click="orderByField = 'job_title'; reverseSort = !reverseSort">Job title
                                        <span ng-show="orderByField == 'job_title'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:30%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'job_eligibility'; reverseSort = !reverseSort">Eligibility
                                        <span ng-show="orderByField == 'job_eligibility'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'application_start_date'; reverseSort = !reverseSort">Application start date
                                        <span ng-show="orderByField == 'application_start_date'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'application_close_date'; reverseSort = !reverseSort">Application close date
                                        <span ng-show="orderByField == 'application_close_date'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th> 
                                <th style="width:15%">
                                    <a href="javascript:void(0);"reverseSort = !reverseSort">Go to
                                    </a></th>                            
                                <th style="width: 15%">Actions</th>

                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" dir-paginate="list in careerRow| filter:search | filter:searchData | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort" >
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                                <td>{{list.job_title}}</td> 
                                <td>{{list.job_eligibility}}</td> 
                                <td>{{list.application_start_date}}</td> 
                                <td>{{list.application_close_date}}</td>
                                <td><a href="[[ config('global.backendUrl') ]]#/job-posting/show/{{ list.id}}" class="btn btn-info btn-xs"><i class="fa fa-eye"></i>View Application</a></td>
                                <td class="">	
                                    <span class="" tooltip-html-unsafe="Edit" ><a href="[[ config('global.backendUrl') ]]#/job-posting/update/{{ list.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                    <span class="" tooltip-html-unsafe="Delete"><a ng-click="deleteJob({{list.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
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
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="calllogsFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Job title</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.job_title" name="job_title" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for="">Application Start Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="searchDetails.application_start_date" placeholder="Application Start Date" name="application_start_date" id="fromDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12" ng-controller="DatepickerDemoCtrl">
                    <div class="form-group">
                        <label for="">Application Close Date</label>
                        <span class="input-icon icon-right">
                            <p class="input-group">
                                <input type="text" ng-model="searchDetails.application_close_date" placeholder="Application Close Date" name="application_close_date" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
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
