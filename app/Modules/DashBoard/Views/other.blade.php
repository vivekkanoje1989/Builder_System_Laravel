<div class="row" ng-controller="dashboardCtrl" ng-init="getEmployees()">  
    <div>
        <flash-message duration="5000"></flash-message>
    </div>
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Request Other Approval</span>

                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>

            <div class="widget-body table-responsive">     
                <form  ng-submit="requestLeave.$valid && doOtherApprovalAction('2')" name="requestLeave"  novalidate>
                    <table class="table table-hover table-striped table-bordered" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <td colspan="2">Request leave</td>
                            <tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Application To*</td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.application_to.$dirty && requestLeave.application_to.$invalid) }">
                                        <span class="input-icon icon-right">

                                            <select class="form-control" ng-model="application_to" name="application_to" ng-change="getEmployeesCC()" required>
                                                <option value="">Select User</option>
                                                <option  ng-repeat="itemone in employeeRow" ng-selected="{{ application_to == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + (itemone.designation)}}</option>
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
                                <td>Application CC:*</td>
                                <td>
                                   <span class="input-icon icon-right">
                                            <select class="form-control" ng-model="application_cc" name="application_cc" >
                                                <option value="">Select User</option>
                                                <option  ng-repeat="itemone in employeeRowCC" ng-selected="{{ application_cc == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + (itemone.designation)}}</option>
                                            </select>
                                            <br/>
                                        </span>
                                </td>
                            </tr>
                            <tr><td>Application Description*</td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.req_desc.$dirty && requestLeave.req_desc.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <textarea ng-model="req_desc" name="req_desc" cols="50" rows="5" required placeholder="Description"></textarea>

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

