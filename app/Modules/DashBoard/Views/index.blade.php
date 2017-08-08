<div class="row" ng-controller="dashboardCtrl" ng-init="getEmployees()">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Request leave</span>
            </div>
            <div class="widget-body">
                <div id="registration-form">
                    <form  ng-submit="requestLeave.$valid && dorequestLeaveAction(request, '1')" name="requestLeave"  novalidate>
                        <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 ">
                                <div class="form-group">
                                    <label>Application To <span class="sp-err">*</span></label>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.application_to.$dirty && requestLeave.application_to.$invalid) }">
                                        <span class="input-icon icon-right">

                                            <select class="form-control" ng-model="request.application_to" name="application_to" ng-change="getEmployeesCC()" required>
                                                <option value="">Select User</option>
                                                <option  ng-repeat="itemone in employeeRow" ng-selected="{{ application_to == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.application_to.$error">
                                                <div ng-message="required">Application To is required</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label>Application CC </label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="request.application_cc" name="application_cc" >
                                            <option value="">Select User</option>
                                            <option  ng-repeat="itemone in employeeRowCC" ng-selected="{{ application_cc == itemone.id}}" value="{{itemone.id}}">{{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <br/>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label>Application Start Date<span class="sp-err">*</span></label>
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.from_date.$dirty || requestLeave.from_date.$invalid)}">
                                        <p class="input-group">
                                            <input type="text" ng-model="request.from_date" name="from_date" min-date=minDate id="from_date" class="form-control" datepicker-popup="{{format}}" ui-date="dateOptions" is-open="opened"  close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly required/>
                                            <span class="input-group-btn" >
                                                <button type="button" class="btn btn-default" ng-click="open($event);"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </p>
                                        <div  class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.from_date.$error">
                                            <div ng-message="required">Start date is required.</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label>Application End Date<span class="sp-err">*</span></label>
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.to.$dirty || requestLeave.to.$invalid)}">
                                        <p class="input-group">
                                            <input type="text" ng-model="request.to_date"  min-date="request.from_date" name="to" id="to_date" class="form-control" datepicker-popup="{{format}}" is-open="opened"  datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        </p>
                                        <div  class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.to.$error">
                                            <div ng-message="required">Closing date is required.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.req_desc.$dirty && requestLeave.req_desc.$invalid) }">
                                    <label>Application Description<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <textarea ng-model="request.req_desc" name="req_desc" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" maxlength="100" required></textarea>
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
                                <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="reqLeave">Submit</button>
                                <a href="[[ config('global.backendUrl') ]]#/my-request/index" class="btn btn-primary"><< Back to list</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
	</div>
    </div>
</div>

