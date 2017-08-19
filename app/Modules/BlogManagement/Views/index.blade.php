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
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Search:</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="search" name="search" class="form-control">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="search">Records per page:</label>
                            <input type="text" minlength="1" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width:30%;" class="form-control" ng-model="itemsPerPage">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <a title="Create blog" class="btn btn-primary btn-right" href="[[ config('global.backendUrl') ]]#/blog/create" >Create Blog</a>
                                <button type="button" class="btn btn-primary btn-right toggleForm" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</button>
                            </span>
                        </div>
                    </div>
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
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr. No.</th>                       
                            <th style="width:10%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'blog_title'; reverseSort = !reverseSort">Title
                                    <span ng-show="orderByField == 'blog_title'">
                                        <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a>
                            </th>
                            <th style="width:20%">Seo Url</th>
                            <th style="width:20%">Meta Description</th>
                            <th style="width:20%">Meta Keywords</th>
                            <th style="width:20%">Blog Status</th>
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
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit blog" style="display: block;" data-toggle="modal" ng-click="editBlogData({{item}},{{$index}})"><a href="[[ config('global.backendUrl') ]]#/blog/update/{{ item.id}}"><i class="fa fa-pencil"></i></a></div>
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