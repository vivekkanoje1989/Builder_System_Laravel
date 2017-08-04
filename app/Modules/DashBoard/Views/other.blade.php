<div class="row" ng-controller="dashboardCtrl" ng-init="getEmployees()">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Request other approval</span>
            </div>
            <div class="widget-body">
                <form  ng-submit="requestLeave.$valid && doOtherApprovalAction(request, '2')" name="requestLeave"  novalidate>
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Application To <span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.application_to.$dirty && requestLeave.application_to.$invalid) }">
                                    <span class="input-icon icon-right">

                                        <select class="form-control" ng-model="request.application_to" name="application_to" ng-change="getEmployeesCC()" required>
                                            <option value="">Select User</option>
                                            <option  ng-repeat="itemone in employeeRow" ng-selected="{{ application_to == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + (itemone.designation)}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.application_to.$error">
                                            <div ng-message="required">Application To is required.</div>
                                        </div>
                                        <br/>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Application CC</label>

                                <span class="input-icon icon-right">
                                    <select class="form-control" ng-model="request.application_cc" name="application_cc" >
                                        <option value="">Select User</option>
                                        <option  ng-repeat="itemone in employeeRowCC" ng-selected="{{ application_cc == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + (itemone.designation)}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.req_desc.$dirty && requestLeave.req_desc.$invalid) }">
                                <label>Application description<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="request.req_desc" name="req_desc" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" maxlength="500" required></textarea>
                                </span>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.req_desc.$error">
                                    <div ng-message="required">Application Description is required.</div>
                                </div>
                                <br/>
                            </div>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="reqOtherLeave">Submit</button>
                            <a href="[[ config('global.backendUrl') ]]#/my-request/index" class="btn btn-primary"><< Back to list</a>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</div>

