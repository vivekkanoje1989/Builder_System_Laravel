<div class="row" ng-controller="dashboardCtrl" ng-init="getEmployees()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Request leave</span>

                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
                <form  ng-submit="requestLeave.$valid && dorequestLeaveAction('1')" name="requestLeave"  novalidate>
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                    <table class="table table-hover table-striped table-bordered" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <td colspan="2">Request leave</td>
                            <tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>Application To<span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.application_to.$dirty && requestLeave.application_to.$invalid) }">
                                        <span class="input-icon icon-right">

                                            <select class="form-control" ng-model="application_to" name="application_to" ng-change="getEmployeesCC()" required>
                                                <option value="">Select User</option>
                                                <option  ng-repeat="itemone in employeeRow" ng-selected="{{ application_to == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + "("+ itemone.designation + ")"}}</option>
                                            </select>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.application_to.$error">
                                                <div ng-message="required">Application To cannot be blank.</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Application CC<span class="sp-err">*</span></td>
                                <td>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="application_cc" name="application_cc" >
                                            <option value="">Select User</option>
                                            <option  ng-repeat="itemone in employeeRowCC" ng-selected="{{ application_cc == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + "("+ itemone.designation + ")"}}</option>
                                        </select>
                                        <br/>
                                    </span>
                                </td>
                            </tr>
                            <tr><td>Application Start Date<span class="sp-err">*</span></td>
                                <td>
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.from.$dirty || requestLeave.from.$invalid)}">
                                        <p class="input-group">
                                            <input type="text" ng-model="model.from_date" name="from" id="from_date" class="form-control" datepicker-popup="{{format}}" is-open="opened"  max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                            <span class="input-group-btn" >
                                                <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </p>
                                        <div  class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.from.$error">
                                            <div ng-message="required">From cannot be blank..</div>
                                        </div>
                                    </div>
                                </td>          
                            </tr>
                            <tr><td>Application Closing Date<span class="sp-err">*</span></td>
                                <td>
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.to.$dirty || requestLeave.to.$invalid)}">
                                        <p class="input-group">
                                            <input type="text" ng-model="model.to_date"  min-date="model.to" name="to" id="to_date" class="form-control" datepicker-popup="{{format}}" is-open="opened"  max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </p>
                                        <div  class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.to.$error">
                                            <div ng-message="required">To cannot be blank.</div>
                                        </div>
                                    </div>
                                </td>          
                            </tr>
                            <tr><td>Application Description<span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.req_desc.$dirty && requestLeave.req_desc.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <textarea ng-model="req_desc" name="req_desc" cols="50" rows="5" required ></textarea>

                                        </span>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.req_desc.$error">
                                            <div ng-message="required">	
                                                Application Description cannot be blank.</div>
                                        </div>
                                        <br/>
                                    </div>    
                                </td>
                            </tr>
                            <tr><td></td>
                                <td><button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button></td>
                            </tr>

                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

