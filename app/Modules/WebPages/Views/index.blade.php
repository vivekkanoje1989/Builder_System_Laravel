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
<div class="row" ng-controller="contentPagesCtrl" ng-init="getWebPages()">
    <div class="col-xs-12 col-md-12 mainDiv">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Web Pages</span>                
            </div>
            <!--            <div class="widget-header ">
                            <span class="widget-caption">Web Pages</span>
                            <div class="widget-buttons">
                                <a href="" data-toggle="maximize">
                                    <i class="fa fa-expand"></i>
                                </a>
                                <a href="#" data-toggle="collapse" class="collapsed">
                                    <i class="fa fa-minus"></i>
                                </a>
                                <a href="" data-toggle="dispose">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>-->
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <!--<a id="editabledatatable_new" href="" class="btn btn-default" data-toggle="modal" data-target="#verticalModal" ng-click="initialModal(0, '', '', '', '')">Add New Vertical</a>-->
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View print"  ng-click="contentManagementExportToxls()" ng-show="exportData == '1'" >
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
                                        <strong ng-if="key === 'page_name'" data-toggle="tooltip" title="Page Name"><strong> Page Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'page_title'" data-toggle="tooltip" title="Page Title"><strong> Page Title : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'status'" data-toggle="tooltip" title="Status"><strong> Status : </strong> {{ searchData.status == 1? 'Active':''}}</strong>
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
                        <thead>
                            <tr>
                                <th style="width:10%">Sr. No.</th>
                                <th style="width: 30%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'page_name'; reverseSort = !reverseSort">Page Name
                                        <span ng-show="orderByField == 'page_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width: 30%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'page_title'; reverseSort = !reverseSort">Page Title
                                        <span ng-show="orderByField == 'page_title'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>                            
                                <th style="width: 20%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'status'; reverseSort = !reverseSort">Status
                                        <span ng-show="orderByField == 'status'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>                            
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="listpage in listPages | filter:search | filter:searchData | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                                <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{ listpage.page_name}}</td>
                                <td>{{ listpage.page_title}}</td>                            
                                <td>{{ listpage.status}}</td>                            
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit Web Page Content"><a href="[[ config('global.backendUrl') ]]#/webpages/update/{{ listpage.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a> &nbsp;&nbsp;</span>                                
                                    <span class="" tooltip-html-unsafe="Delete"><a href="" ng-click="deletePage({{listpage.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="5"  ng-show="(listPages|filter:search|filter:searchData).length == 0" align="center">Record Not Found</td>   
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
                    <div data-ng-include="'/WebPages/showFilter'"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="webPageFilter" role="form" ng-submit="filterDetails(searchDetails)">

            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Page Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.page_name" name="page_name" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Page Title</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.page_title" name="page_title" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Status</label>
                        <span class="input-icon icon-right">
                            <select class="form-control" ng-model="searchDetails.status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </span>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" >
                            <button type="submit"  style="margin-left: 46%;" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->
</div>
