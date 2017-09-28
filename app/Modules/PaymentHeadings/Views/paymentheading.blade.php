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
<div class="row" ng-controller="paymentHeadingController" ng-init="managePaymentHeading()">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget">
                        <div class="widget-header bordered-bottom bordered-themeprimary">
                            <span class="widget-caption">Manage Payment Heading</span>                
                        </div>
<!--            <div class="widget-header ">
                <span class="widget-caption">Manage Payment Heading</span>
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
                    <a data-toggle="modal" data-target="#paymentheadingModal" ng-click="initialModal(0, '', '', '', '', '', '')" class="btn btn-default ">Add Payment Heading</a>
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="paymentHeadingExportToxls()" ng-show="exportData=='1'">
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
                            <b ng-repeat="(key, value) in searchData" ng-if="value != 0 && key != 'toDate'">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'payment_heading'" data-toggle="tooltip" title="Payment Heading"><strong> Payment Heading : </strong> {{ value}}</strong>
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
                                <th style="width:5%">Sr. No.</th> 
                                <th style="width:35%">
                                     <a href="javascript:void(0);" ng-click="orderByField('payment_heading')">Payment Heading
                                        <span ><img ng-hide="(sortKey == 'payment_heading' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'payment_heading' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'payment_heading' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th> 
                                <th style="width: 5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="list in paymentDetails| filter:search | filter:searchData | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort">
                                <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td>            
                                <td>{{ list.payment_heading}}</td> 
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit payment heading"  data-toggle="modal" data-target="#paymentheadingModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.payment_heading}}',{{list.tax_heading}},{{list.date_dependent_tax}},{{list.tax_applicable}},{{itemsPerPage}},{{$index}})" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                 <span  ng-show="deleteBtn == '1'"  class="" tooltip-html-unsafe="Delete"><a href="" ng-click="deletePaymentHeading({{list.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"  ng-show="(paymentDetails|filter:search|filter:searchData).length == 0" align="center">Record Not Found</td>   
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
                    <div data-ng-include="'/PaymentHeadings/showFilter'"></div>
                </div>
            </div>
        </div>
    </div>

        <div class="modal fade modal-primary" id="paymentheadingModal" role="dialog" tabindex="-1">    
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" align="center">{{heading}}</h4>
                    </div>
                    <form novalidate ng-submit="paymentheadingForm.$valid && dopaymentheadingAction(paymentData)" name="paymentheadingForm">
                        <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">

                        <div class="modal-body">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!paymentheadingForm.payment_heading.$dirty && paymentheadingForm.payment_heading.$invalid)}">
                                <input type="hidden" class="form-control" ng-model="id" name="id">
                                <span class="input-icon icon-right">
                                    <label>Payment heading<span class="sp-err">*</span></label>
                                    <input type="text" class="form-control" ng-model="paymentData.payment_heading" name="payment_heading"  required>

                                    <div class="help-block" ng-show="sbtBtn" ng-messages="paymentheadingForm.payment_heading.$error">
                                        <div ng-message="required" class='sp-err'>Payment heading is required</div>
                                        <div ng-if="errorMsg" class="sp-err">{{errorMsg}}</div>
                                    </div>
                                    <div ng-if="payment_heading" class="sp-err payment_heading">{{payment_heading}}</div>
                                    <br/>
                                </span>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!paymentheadingForm.tax_heading.$dirty && paymentheadingForm.tax_heading.$invalid)}">

                                        <span>

                                            <label>Tax Heading<span class="sp-err">*</span></label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="control-group">
                                                        <div class="radio">
                                                            <label>
                                                                <input name="tax_heading" type="radio" ng-model="paymentData.tax_heading" value="1" class="colored-blue" required>
                                                                <span class="text">Yes </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">   
                                                    <div class="radio">
                                                        <label>
                                                            <input name="tax_heading" type="radio" ng-model="paymentData.tax_heading" value="0" class="colored-danger" required>
                                                            <span class="text"> No  </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="paymentheadingForm.tax_heading.$error">
                                                <div ng-message="required" class="sp-err">Tax heading is required</div>
                                            </div>
                                            <div ng-if="tax_heading" class="sp-err tax_heading">{{tax_heading}}</div>
                                        </span>
                                    </div>    
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!paymentheadingForm.date_dependent_tax.$dirty && paymentheadingForm.date_dependent_tax.$invalid)}">

                                        <span>
                                            <label>Date dependent<span class="sp-err">*</span></label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="control-group">
                                                        <div class="radio">
                                                            <label>
                                                                <input name="date_dependent_tax" type="radio" ng-model="paymentData.date_dependent_tax" value="1" class="colored-blue" >
                                                                <span class="text">Yes </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="radio">
                                                        <label>
                                                            <input name="date_dependent_tax" type="radio" ng-model="paymentData.date_dependent_tax" value="0" class="colored-danger" >
                                                            <span class="text"> No  </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="paymentheadingForm.date_dependent_tax.$error">
                                                <div ng-message="required" class="sp-err">Date dependants is required</div>
                                            </div>
                                            <div ng-if="date_dependent_tax" class="sp-err date_dependent_tax">{{date_dependent_tax}}</div>
                                        </span>

                                    </div>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!paymentheadingForm.tax_applicable.$dirty && paymentheadingForm.tax_applicable.$invalid)}">

                                        <span>
                                            <label>Tax applicable<span class="sp-err">*</span></label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="control-group">
                                                        <div class="radio">
                                                            <label>
                                                                <input name="tax_applicable" type="radio" ng-model="paymentData.tax_applicable" value="1" class="colored-blue" required>
                                                                <span class="text">Yes </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="radio">
                                                        <label>
                                                            <input name="tax_applicable" type="radio" ng-model="paymentData.tax_applicable" value="0" class="colored-danger" required>
                                                            <span class="text"> No  </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="paymentheadingForm.tax_applicable.$error">
                                                <div ng-message="required" class="sp-err">Tax applicable is required</div>
                                            </div>
                                            <div ng-if="tax_applicable" class="sp-err tax_applicable">{{tax_applicable}}</div>
                                        </span>
                                    </div>      
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" align="center">
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="payHeading">{{action}}</button>
                        </div> 
                    </form>           
                </div>
            </div>
        </div>
        <!-- Filter Form Start-->
        <div class="wrap-filter-form show-widget" id="slideout">
            <form name="paymentHeadingFilter" role="form" ng-submit="filterDetails(searchDetails)">
                <strong>Filter</strong>   
                <button type="button" class="close toggleForm" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button><hr>                               
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="">Payment Heading</label>
                            <span class="input-icon icon-right">
                                <input type="text" ng-model="searchDetails.payment_heading" name="payment_heading" class="form-control">
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

