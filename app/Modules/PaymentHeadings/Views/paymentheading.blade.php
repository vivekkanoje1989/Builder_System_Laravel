<div class="row" ng-controller="managePaymentHeadingCtrl" ng-init="managePaymentHeading(); getProjectNames()">  
 <div>
          <flash-message duration="5000"></flash-message>
 </div> 
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Payment heading</span>
                <a data-toggle="modal" data-target="#paymentheadingModal" ng-click="initialModal(0,'','','','','','')" class="btn btn-info">Create payment heading</a>&nbsp;&nbsp;&nbsp;
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
                                                        
                            
                            <th style="width:35%">
                            <a href="javascript:void(0);" ng-click="orderByField ='type_of_payment'; reverseSort = !reverseSort">Payment heading
                              <span ng-show="orderByField == 'type_of_payment'">
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
                            <td>{{ list.type_of_payment }}</td> 
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit payment heading" style="display: block;" data-toggle="modal" data-target="#paymentheadingModal"><a href="javascript:void(0);" ng-click="initialModal({{ list.id}},'{{ list.type_of_payment}}',{{ list.project_type_id}},{{list.is_tax_heading}},{{list.is_date_dependent}},$index)"><i class="fa fa-pencil"></i></a></div>
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
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!paymentheadingForm.project_id.$dirty && paymentheadingForm.project_id.$invalid) && (!paymentheadingForm.payment_type.$dirty && paymentheadingForm.payment_type.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                             <span class="input-icon icon-right">
                                <select class="form-control" ng-model="project_type_id" name="project_id" required >
                                    <option value="">Select project type</option>
                                    <option  ng-repeat="list in getProjectNamesRow" value="{{list.project_type_id}}" selected>{{list.project_type_name}}</option>
                                </select>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="paymentheadingForm.project_id.$error">
                                    <div ng-message="required">This field is required</div>
                                </div>
                            </span>
                            <br/><br/>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="type_of_payment" name="payment_type" placeholder="Payment_heading" required>
                                <i class="fa fa-user thm-color circular"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="paymentheadingForm.payment_type.$error">
                                    <div ng-message="required">This field is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span>
                            <div class="row">
                                 <div class="col-md-6">
                            <span>
                                 
                                <label>Tax Heading</label>
                                <div class="row">
                                    <div class="col-md-6">
                                <div class="control-group">
                                   <div class="radio">
                                       <label>
                                           <input name="form-field-radione" type="radio" ng-model="is_tax_heading" value="1" class="colored-blue" >
                                           <span class="text">Yes </span>
                                       </label>
                                   </div>
                                </div>
                                    </div>
                                     <div class="col-md-6">   
                                   <div class="radio">
                                       <label>
                                           <input name="form-field-radioone" type="radio" ng-model="is_tax_heading" value="0" class="colored-danger">
                                           <span class="text"> No  </span>
                                       </label>
                                   </div>
                                     </div>
                                    </div>
                                 
                            </span>
                                 </div>
                                  <div class="col-md-6">
                             <span>
                                <label>Date dependent</label>
                                 <div class="row">
                                    <div class="col-md-6">
                                <div class="control-group">
                                   <div class="radio">
                                       <label>
                                           <input name="form-field-radio" type="radio" ng-model="is_date_dependent" value="1" class="colored-blue">
                                           <span class="text">Yes </span>
                                       </label>
                                   </div>
                                    </div>
                                    </div>
                                     <div class="col-md-6">
                                   <div class="radio">
                                       <label>
                                           <input name="form-field-radio" type="radio" ng-model="is_date_dependent" value="0" class="colored-danger" >
                                           <span class="text"> No  </span>
                                       </label>
                                   </div>
                                     </div>
                                 </div>
                               
                            </span>
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

