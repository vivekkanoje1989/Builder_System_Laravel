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
<div class="row" ng-controller="projectController" ng-init="manageproject()">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Project</span>                
            </div>
            <div class="widget-body table-responsive">
               
                <div class="row table-toolbar">
                    <!--<a href="[[ config('global.backendUrl') ]]#/job-posting/create" class="btn btn-default">Post Job</a>-->
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="manageProjectsExportToExcel()" ng-show="exportData== '1'">
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
                            <b ng-repeat="(key, value) in searchData">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'created_at'" data-toggle="tooltip" title="Date"><strong> Date : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'fullName'" data-toggle="tooltip" title="Registered by"><strong> Registered by : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'project_name'" data-toggle="tooltip" title="Name"><strong> Company Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'projectType'" data-toggle="tooltip" title="PProject roject Type"><strong> Project Type : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'projectStatus'" data-toggle="tooltip" title="Status"><strong>  Status : </strong> {{ value}}</strong>
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
                                    <a href="javascript:void(0);" ng-click="orderByField = 'created_at'; reverseSort = !reverseSort">Registration Date & Time
                                        <span ng-show="orderByField == 'created_at'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>

                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'fullName'; reverseSort = !reverseSort">Registered by
                                        <span ng-show="orderByField == 'fullName'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'project_name'; reverseSort = !reverseSort">Project Name
                                        <span ng-show="orderByField == 'project_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'projectType'; reverseSort = !reverseSort">Project Type
                                        <span ng-show="orderByField == 'projectType'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>
                                <th style="width:15%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'projectStatus'; reverseSort = !reverseSort">Project Status
                                        <span ng-show="orderByField == 'projectStatus'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a></th>  
                                <th style="width: 15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="list in projectRow| filter:search |filter:searchData | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{list.created_at}}</td>
                                <td>{{list.fullName}}</td>
                                <td>{{list.project_name}}</td>
                                <td>{{list.projectType}}</td>
                                <td>{{list.projectStatus}}</td>
                                <td class="">
                                    <!--<div class="" tooltip-html-unsafe="Edit" style="display: block;"><a href="javascript:void(0);" ng-click="showWebPage({{list.id}})" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></div>-->
                                    <span class="" tooltip-html-unsafe="Edit"><a href="[[ config('global.backendUrl') ]]#/projects/webpageDetails/{{ list.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
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
        <form name="bankAccountFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Registered By</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.fullName" name="customer_name" class="form-control" oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Project Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.project_name" name="project_name" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Prooject Type</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.projectType" name="projectType" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group" ng-controller="projectStatusCntrl" >
                        <label>Project Status <span class="sp-err">*</span></label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.projectStatus" name="projectStatus" class="form-control">
                                <option value="">Select Status</option>
                                <option ng-repeat="slist in statusList" value="{{slist.project_status}}">{{slist.project_status}}</option>
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
