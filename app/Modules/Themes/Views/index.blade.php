<style>
    .thumb{
        width: 60px;
        height: 60px;
        margin-top: 0px !important;
    }
    .help-block {
        color: #e46f61;
    }
</style>
<div class="row" ng-controller="themesController" ng-init="manageThemes()"> 
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Website Themes</span>
                <a data-toggle="modal" data-target="#themesModal" ng-click="initialModal(0, '', '')" class="btn btn-primary">Create Themes</a>&nbsp;&nbsp;&nbsp;
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">  
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <label for="search">Search:</label>
                        <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search">
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <label for="search">Records per page:</label>
                        <input type="number" min="1" max="50" style="width:25%;" class="form-control" ng-model="itemsPerPage">
                    </div>
                </div><br> 
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                        <tr>
                            <th style="width:5%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'id'; reverseSort = !reverseSort">SR No.
                                    <span ng-show="orderByField == 'id'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th> 
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
                        <tr role="row" dir-paginate="list in themesRow| filter:search | orderBy:orderByField:reverseSort | itemsPerPage:itemsPerPage">
                            <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>
                            <td>{{ list.theme_name}}</td>   
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit Themes" style="display: block;" data-toggle="modal" data-target="#themesModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.theme_name}}','{{list.image_url}}',{{ itemsPerPage}},{{$index}})"><i class="fa fa-pencil"></i></a></div>
                            </td>
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
            </div>
        </div>
    </div>
    <div class="modal fade" id="themesModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="themesForm.$valid && doThemesAction(Theme.image_url)" name="themesForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">

                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!themesForm.theme_name.$dirty && themesForm.theme_name.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="_id">

                            <span class="input-icon icon-right">
                                <label>Theme Name<span class="sp-err">*</span></label>
                                <input type="text" class="form-control" ng-model="theme_name" name="theme_name" ng-change="errorMsg = null" required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="themesForm.theme_name.$error">
                                    <div ng-message="required">Project type is required</div>
                                    <div ng-if="errorMsg" class="err">{{errorMsg}}</div>
                                </div>
                            </span>
                        </div>
                        <input type="hidden" class="form-control" ng-model="id" name="_id">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!themesForm.theme_name.$dirty && themesForm.theme_name.$invalid)}">
                            <span class="input-icon icon-right">
                                <label>Theme Image<span class="sp-err">*</span></label>
                                <input type="file" ngf-select   ng-model="Theme.image_url" name="image_url" id="image_url" ng-required="require" accept="image/*" ngf-max-size="2MB" class="form-control imageFile"  ngf-model-invalid="errorFile" >
                                <div class="help-block" ng-show="sbtBtn" ng-messages="themesForm.image_url.$error">
                                    <div ng-message="required">Image is required</div>
                                </div>
                            </span>
                            <div class="img-div2" ng-if="image == '' " data-title="name" ng-repeat="list in image_url_preview">    
                                <img ng-src="{{list}}" class="thumb photoPreview">
                            </div>
                            <div ng-if="image">
                                <img ng-src="[[ Session::get('s3Path') ]]Themes/{{image}}" width="80px" height="80px">
                            </div>
                        </div>
                        <div class="modal-footer" align="center">
                            <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">{{action}}</button>
                        </div> 
                </form>           
            </div>
        </div>
    </div>

</div>
