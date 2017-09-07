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
<div class="row" ng-controller="blogsCtrl" ng-init="manageBlogs()">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Blog Management</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <!--<a id="editabledatatable_new" href="" class="btn btn-default" data-toggle="modal" data-target="#verticalModal" ng-click="initialModal(0, '', '', '', '')">Add New Vertical</a>-->
                    <a title="Create blog" class="btn btn-default " href="[[ config('global.backendUrl') ]]#/blog/create" id="editabledatatable_new">Create Blog</a>
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href="" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                     <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Execl" ng-click="blogManagementExportToxls()" ng-show="exportData == '1'">
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
                                        <strong ng-if="key === 'blog_title'" data-toggle="tooltip" title="Page Name"><strong> Page Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'blog_seo_url'" data-toggle="tooltip" title="Seo Url"><strong>Seo Url : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'meta_description'" data-toggle="tooltip" title="Meta Description"><strong> Meta Description : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'meta_keywords'" data-toggle="tooltip" title="Meta keywords"><strong> Meta keywords: </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'blog_status'" data-toggle="tooltip" title="Status"><strong> Status : </strong> {{ value}}</strong>
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
                        <thead class="">
                            <tr>
                                <th style="width:5%">Sr. No.</th>                       
                                <th style="width:10%" >
                                    <a href="javascript:void(0);" ng-click="orderByField = 'blog_title'; reverseSort = !reverseSort">Title
                                        <span ng-show="orderByField == 'blog_title'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                    </a>
                                </th>
                                <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'blog_seo_url'; reverseSort = !reverseSort">Seo Url
                                        <span ng-show="orderByField == 'blog_seo_url'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a></th>
                                <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'meta_description'; reverseSort = !reverseSort">Meta Description
                                        <span ng-show="orderByField == 'meta_description'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th>
                                <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'meta_keywords'; reverseSort = !reverseSort">Meta Keywords
                                        <span ng-show="orderByField == 'meta_keywords'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th>
                                <th style="width:20%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'blog_status'; reverseSort = !reverseSort">Blog Status
                                        <span ng-show="orderByField == 'blog_status'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th>
                                <th style="width: 5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr role="row" dir-paginate="item in blogsRow| filter:search | filter:searchData | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{item.blog_title}}</td>
                                <td>{{item.blog_seo_url}}</td>
                                <td>{{item.meta_description}}</td>
                                <td>{{item.meta_keywords}}</td>
                                <td>{{item.blog_status}}</td>
                                <td class="">
                                    <div class="" tooltip-html-unsafe="Edit blog" style="display: block;" data-toggle="modal" ng-click="editBlogData({{item}},{{$index}})"><a href="[[ config('global.backendUrl') ]]#/blog/update/{{ item.id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></div>
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
                    <div data-ng-include="'/BlogManagement/showFilter'"></div>
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
                        <label for="">Blog title</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.blog_title" name="blog_title" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Seo Url</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.blog_seo_url" name="blog_seo_url" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Meta Description</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.meta_description" name="meta_description" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Meta Keywords</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.meta_keywords" name="meta_keywords" class="form-control">
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Blog Status</label>
                        <span class="input-icon icon-right">
                            <select class="form-control" ng-model="searchDetails.blog_status" name="blog_status">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
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