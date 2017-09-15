<style>
    .thumb{
        width: 60px;
        height: 60px;
        margin-top: 0px !important;
    }
    .help-block {
        color: #e46f61;
    }
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
<div class="row" ng-controller="themesController" ng-init="manageThemes()"> 
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Themes</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row table-toolbar">
                    <!--<a id="editabledatatable_new" href="" class="btn btn-default" data-toggle="modal" data-target="#verticalModal" ng-click="initialModal(0, '', '', '', '')">Add New Vertical</a>-->
                    <a data-toggle="modal" id="editabledatatable_new" data-target="#themesModal" ng-click="initialModal(0, '', '')" class="btn btn-default">Create Themes</a>
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href="" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="themeExportToxls()" ng-show="exportData == '1'">
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
                                        <strong ng-if="key === 'theme_name'" data-toggle="tooltip" title="Theme Name"><strong> Theme Name : </strong> {{ value}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" placeholder="30" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
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
                                <th style="width:5%">Sr. No.</th> 
                                <th style="width: 30%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'theme_name'; reverseSort = !reverseSort">Themes
                                        <span ng-show="orderByField == 'theme_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th>  
                                <th style="width: 5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="list in themesRow| filter:search | filter:searchData  | orderBy:orderByField:reverseSort | itemsPerPage:itemsPerPage">
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                                <td>{{ list.theme_name}}</td>   
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit {{ list.theme_name}}"  data-toggle="modal" data-target="#themesModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.theme_name}}','{{list.image_url}}',{{ itemsPerPage}},{{$index}})" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                    <span class="" tooltip-html-unsafe="Delete"><a href="" ng-click="deleteTheme({{list.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"  ng-show="(themesRow|filter:search|filter:searchData).length == 0" align="center">Record Not Found</td>   
                            </tr>
                        </tbody>
                    </table>
                    <div class="DTTTFooter">
                        <div class="col-sm-6">
                            <!--<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing {{itemsPerPage * (noOfRows-1)+1}} to of {{ listUsersLength }} entries</div>-->
                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                            </div>
                        </div>
                    </div>
                    <div data-ng-include="'/Themes/showFilter'"></div>
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
            <form name="themeFilter" role="form" ng-submit="filterDetails(searchDetails)">

                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">Theme Name</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="searchDetails.theme_name" name="theme_name" class="form-control">
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

    <div class="modal fade modal-primary" id="themesModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="themesForm.$valid && doThemesAction(theme.image_url, theme)" name="themesForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">

                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!themesForm.theme_name.$dirty && themesForm.theme_name.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="_id">

                            <span class="input-icon icon-right">
                                <label>Theme Name<span class="sp-err">*</span></label>
                                <input type="text" class="form-control" ng-model="theme.theme_name" name="theme_name" ng-change="errorMsg = null" required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="themesForm.theme_name.$error">
                                    <div ng-message="required">Theme name is required</div>
                                    <div ng-if="errorMsg" class="err">{{errorMsg}}</div>
                                </div>
                                <div ng-if="theme_name" class="sp-err theme_name">{{theme_name}}</div>
                            </span>
                        </div>
                        <input type="hidden" class="form-control" ng-model="id" name="_id">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!themesForm.theme_name.$dirty && themesForm.theme_name.$invalid)}">
                            <span class="input-icon icon-right">
                                <label>Theme Image<span class="sp-err">*</span></label>
                                <input type="file" ngf-select   ng-model="theme.image_url" name="image_url" id="image_url"  accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                <div class="help-block" ng-show="sbtBtn" ng-messages="themesForm.image_url.$error">
                                    <div ng-message="required">Image is required</div>
                                </div>
                                <div ng-if="image_url" class="sp-err image_url">{{image_url}}</div>
                                <span class="help-block">{{image_url_err}}</span>
                            </span>
                            <div class="img-div2" ng-if="image == ''" data-title="name" ng-repeat="list in image_url_preview">    
                                <img ng-src="{{list}}" class="thumb photoPreview">
                            </div>
                            <div ng-if="image">
                                <img ng-src="[[ Config('global.s3Path') ]]/Themes/{{image}}" width="80px" height="80px">
                            </div>
                        </div>
                        <div class="modal-footer" align="center">
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="webTheme">{{action}}</button>
                        </div> 
                </form>           
            </div>
        </div>
    </div>

</div>
</div>
