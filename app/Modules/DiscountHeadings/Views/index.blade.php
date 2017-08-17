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
<div class="row" ng-controller="discountheadingController" ng-init="manageDiscountHeading()">  
    <div class=" mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Discount Heading</span>                
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
                                <a data-toggle="modal" data-target="#discountheadingModal" ng-click="initialModal(0, '', '', '')" class="btn btn-primary btn-right">Add discount heading</a>
                                <button type="button" class="btn btn-primary btn-right toggleForm" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</button>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- filter data--> 
                <div class="row" style="border:2px;" id="filter-show">
                    <div class="col-sm-12 col-xs-12">
                        <b ng-repeat="(key, value) in searchData" >
                            <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                <div class="alert alert-info fade in">
                                    <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                    <strong ng-if="key === 'discount_name'" data-toggle="tooltip" title="Discount Name"><strong> Discount Name : </strong> {{ value}}</strong>
                                    <strong ng-if="key === 'status'" data-toggle="tooltip" title="status"><strong> status : </strong> {{ value == 1? "Active" : "In active"}}</strong>
                                </div>
                            </div>
                        </b>                        
                    </div>
                </div>
                <!-- filter data-->
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                        <tr>
                            <th style="width:5%">Sr No.</th> 
                            <th style="width: 30%">Discount name</th>
                            <th style="width:5%">Status</th> 
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="list in DiscountHeadingRow| filter:search | filter:searchData | itemsPerPage:itemsPerPage" >
                            <td>{{ itemsPerPage * (pageNumber - 1) + $index + 1}}</td>      
                            <td>{{ list.discount_name}}</td>                           
                            <td>{{list.status == 1? "Active" : "In active"}}</td> 
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit discount heading" style="display: block;" data-toggle="modal" data-target="#discountheadingModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.discount_name}}',{{ list.status}},{{itemsPerPage}},{{$index}})"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{pageNumber}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'manageDiscountHeading', [[$loggedInUserId]])" template-url="/dirPagination"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
                <div data-ng-include="'/DiscountHeadings/showFilter'"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="discountheadingModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="discountheadingForm.$valid && doDiscountHeadingAction()" name="discountheadingForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">

                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!discountheadingForm.name.$dirty && discountheadingForm.name.$invalid) && (!discountheadingForm.status.$dirty && discountheadingForm.status.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="actionModal" name="actionModal">
                            <label>Discount name<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="discount_name" name="discount_name" ng-change="errorMsg = null" required>

                                <div class="help-block" ng-show="sbtBtn" ng-messages="discountheadingForm.discount_name.$error">
                                    <div ng-message="required" class="sp-err">This field is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span>
                            <br/><br/>
                            <label>Status<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="status" name="status" required>
                                    <option value="" Selected>Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="discountheadingForm.status.$error">
                                    <div ng-message="required" class="sp-err">This field is required</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true">{{action}}</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="discountHeadingFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Country Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.discount_name" name="discount_name" class="form-control" >
                        </span>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">status </label>
                        <span class="input-icon icon-right">
                            <select class="form-control" ng-model="searchDetails.status" name="status" >
                                <option value="" Selected>Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
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
