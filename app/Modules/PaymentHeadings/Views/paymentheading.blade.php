<div class="row" ng-controller="managePaymentHeadingCtrl" ng-init="managePaymentHeading();">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Payment heading</span>
                <a data-toggle="modal" data-target="#paymentheadingModal" ng-click="initialModal(0, '', '', '', '', '', '')" class="btn btn-info">Create payment heading</a>&nbsp;&nbsp;&nbsp;
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">                
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                        <tr>
                            <th style="width:5%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'id'; reverseSort = !reverseSort">SR No.
                                    <span ng-show="orderByField == 'id'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th> 


                            <th style="width:35%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'payment_heading'; reverseSort = !reverseSort">Payment heading
                                    <span ng-show="orderByField == 'payment_heading'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th> 
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td ><input type="text" ng-model="search" class="form-control"  placeholder="Search"></td>                           

                            <td></td>
                        </tr>
                        <tr role="row" ng-repeat="list in PaymentHeadingRow| filter:search | orderBy:orderByField:reverseSort" >
                            <td>{{ $index + 1}}</td>                          
                            <td>{{ list.payment_heading}}</td> 
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit payment heading" style="display: block;" data-toggle="modal" data-target="#paymentheadingModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.payment_heading}}',{{list.tax_heading}},{{list.date_dependent_tax}},{{list.tax_applicable}},$index)"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                <form novalidate ng-submit="paymentheadingForm.$valid && dopaymentheadingAction()" name="paymentheadingForm">
                     <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                   
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!paymentheadingForm.payment_heading.$dirty && paymentheadingForm.payment_heading.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <span class="input-icon icon-right">
                                <label>Payment heading<span class="sp-err">*</span></label>
                                <input type="text" class="form-control" ng-model="payment_heading" name="payment_heading"  required>

                                <div class="help-block" ng-show="sbtBtn" ng-messages="paymentheadingForm.payment_heading.$error">
                                    <div ng-message="required">Payment heading is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
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
                                                            <input name="tax_heading" type="radio" ng-model="tax_heading" value="1" class="colored-blue" required>
                                                            <span class="text">Yes </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">   
                                                <div class="radio">
                                                    <label>
                                                        <input name="tax_heading" type="radio" ng-model="tax_heading" value="0" class="colored-danger" required>
                                                        <span class="text"> No  </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="paymentheadingForm.payment_heading.$error">
                                            <div ng-message="required">Tax heading is required</div>

                                        </div>
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
                                                            <input name="date_dependent_tax" type="radio" ng-model="date_dependent_tax" value="1" class="colored-blue" required>
                                                            <span class="text">Yes </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="radio">
                                                    <label>
                                                        <input name="date_dependent_tax" type="radio" ng-model="date_dependent_tax" value="0" class="colored-danger" required>
                                                        <span class="text"> No  </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="paymentheadingForm.date_dependent_tax.$error">
                                            <div ng-message="required">Date dependants is required</div>

                                        </div>
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
                                                            <input name="tax_applicable" type="radio" ng-model="tax_applicable" value="1" class="colored-blue" required>
                                                            <span class="text">Yes </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="radio">
                                                    <label>
                                                        <input name="tax_applicable" type="radio" ng-model="tax_applicable" value="0" class="colored-danger" required>
                                                        <span class="text"> No  </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="paymentheadingForm.tax_applicable.$error">
                                            <div ng-message="required">Tax applicable is required</div>

                                        </div>
                                    </span>
                                </div>      
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>

</div>

