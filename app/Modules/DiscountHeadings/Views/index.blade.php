<div class="row" ng-controller="discountheadingController" ng-init="manageDiscountHeading()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Discount Heading</span>
                <a data-toggle="modal" data-target="#discountheadingModal" ng-click="initialModal(0,'','','')" class="btn btn-info">Create discount heading</a>&nbsp;&nbsp;&nbsp;
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
                            <a href="javascript:void(0);" ng-click="orderByField ='id'; reverseSort = !reverseSort">SR No.
                              <span ng-show="orderByField == 'id'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th> 
                             <th style="width: 30%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'discount_name'; reverseSort = !reverseSort">Discount name
                                <span ng-show="orderByField == 'discount_name'">
                                  <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                </span>
                                </a>
                            </th>                             
                            
                            <th style="width:5%">
                            <a href="javascript:void(0);" ng-click="orderByField ='lost_reason_status'; reverseSort = !reverseSort">Status.
                              <span ng-show="orderByField == 'status'">
                              <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                            </a></th> 
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><input type="text" ng-model="search" class="form-control"  placeholder="Search"></td>                           
                            <td></td>
                            <td></td>
                        </tr>
                        <tr role="row" ng-repeat="list in DiscountHeadingRow| filter:search | orderBy:orderByField:reverseSort" ng-class="{'selected':$index == selectedRow}" ng-click="setClickedRow($index)">
                            <td>{{ $index + 1}}</td>
                            <td>{{ list.discount_name}}</td>                           
                            <td>{{ (list.status) == 1 ? 'Active' :'In Active' }}</td> 
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit discount heading" style="display: block;" data-toggle="modal" data-target="#discountheadingModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.discount_name}}',{{ list.status}},$index)"><i class="fa fa-pencil"></i></a></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                   
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!discountheadingForm.name.$dirty && discountheadingForm.name.$invalid) && (!discountheadingForm.status.$dirty && discountheadingForm.status.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="actionModal" name="actionModal">
                            <label>Discount name<span class="sp-err">*</span></label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="discount_name" name="discount_name" ng-change="errorMsg = null" required>
                             
                                <div class="help-block" ng-show="sbtBtn" ng-messages="discountheadingForm.discount_name.$error">
                                    <div ng-message="required">This field is required</div>
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
                                <div class="help-block" ng-show="sbtBtn" ng-messages="discountheadingForm.status.$error">
                                    <div ng-message="required">This field is required</div>
                                </div>
                            </span>
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

