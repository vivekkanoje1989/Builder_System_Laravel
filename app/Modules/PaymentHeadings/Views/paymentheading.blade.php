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
<div class="row" ng-controller="paymentHeadingController" ng-init="managePaymentHeading([[$loggedInUserId]], 1, [[config('global.recordsPerPage')]])">  
    <div class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Payment Heading</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-sm-2 ">
                        <input type="text" minlength="1" maxlength="3" ng-model="itemsPerPage" ng-change="managePaymentHeading([[$loggedInUserId]],{{pageNumber}}, itemsPerPage)" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  class="form-control">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary ng-click-active" style="float: right;margin-left: 10px;" data-toggle="modal" data-target="#showFilterModal" ng-click="procName('proc_payment_heading', 0)">
                            <i class="btn-label fa fa-filter"></i>Show Filter</button>
                    </div>
                    <div class="col-sm-6  dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                        <span ng-if="paymentDetailsLength != 0" >&nbsp; &nbsp; &nbsp; Showing {{paymentDetails.length}} Logs Out Of Total {{paymentDetailsLength}} Logs&nbsp;</span>
                        <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'managePaymentHeading', [[$loggedInUserId]])" template-url="/dirPagination"></dir-pagination-controls>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-sm-6 col-xs-12"></div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <a data-toggle="modal" data-target="#paymentheadingModal" ng-click="initialModal(0, '', '', '', '', '', '')" class="btn btn-primary btn-right">Add Payment Heading</a>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- filter data--> 
                <div class="row" style="border:2px;" id="filter-show">
                    <div class="col-sm-12 col-xs-12">
                        <b ng-repeat="(key, value) in showFilterData" ng-if="value != 0 && key != 'toDate'">
                            <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                <div class="alert alert-info fade in">
                                    <button class="close" ng-click="removeDataFromFilter('{{ key}}');" data-dismiss="alert"> ×</button>
                                    <strong ng-if="key === 'empId'" ng-repeat='emp in value track by $index'> {{ $index + 1}}){{   emp.first_name}}  {{ emp.last_name}} </strong>
                                    <strong ng-if="key === 'payment_heading'" data-toggle="tooltip" title="Payment Heading"><strong> Payment Heading : </strong> {{ value}}</strong>
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
                            <th style="width:5%">Sr. No.</th> 
                            <th style="width:35%">Payment Heading</th> 
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="list in paymentDetails| filter:search | itemsPerPage:itemsPerPage " total-items="{{ paymentDetailsLength}}">
                             <td>{{ itemsPerPage * (pageNumber - 1) + $index + 1}}</td>            
                            <td>{{ list.payment_heading}}</td> 
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit payment heading" style="display: block;" data-toggle="modal" data-target="#paymentheadingModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.payment_heading}}',{{list.tax_heading}},{{list.date_dependent_tax}},{{list.tax_applicable}},{{itemsPerPage}},{{$index}})"><i class="fa fa-pencil"></i></a></div>
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
                            <dir-pagination-controls class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'managePaymentHeading', [[$loggedInUserId]])" template-url="/dirPagination"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
                <div data-ng-include="'/PaymentHeadings/showFilter'"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentheadingModal" role="dialog" tabindex="-1">    
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

</div>

