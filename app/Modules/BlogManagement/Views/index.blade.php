<div class="row" ng-controller="blogsCtrl" ng-init="manageBlogs()">  
    <div class="col-xs-12 col-md-12">
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
                            </span>
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
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
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <tr role="row" dir-paginate="item in blogsRow| filter:search  | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                            <td>{{item.blog_title}}</td>
                            <td>{{item.blog_seo_url}}</td>
                            <td>{{item.meta_description}}</td>
                            <td>{{item.meta_keywords}}</td>
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit blog" style="display: block;" data-toggle="modal"><a href="[[ config('global.backendUrl') ]]#/blog/update/{{ item.id}}"><i class="fa fa-pencil"></i></a></div>
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