<div class="row" ng-controller="dashboardCtrl" ng-init="getEmployees()">
    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Request other approval</span>
            </div>
            <div class="widget-body">
                <form  ng-submit="requestLeave.$valid && doOtherApprovalAction(request, '2')" name="requestLeave"  novalidate>
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 ">
                            <div class="col-xs-12 ">
                                <div class="form-group">
                                    <label>Application To <span class="sp-err">*</span></label>
                                    <div class="form-group multi-sel-div" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.application_to.$dirty && requestLeave.application_to.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <ui-select multiple ng-model="request.application_to" name="application_to" theme="select2" ng-disabled="disabled" style="width: 100%;" ng-required="true"  ng-init="getEmployees()" ng-change="getEmployeesCC()">
                                                <ui-select-match placeholder="Select or Search Application to">{{$item.first_name + " " + $item.last_name + " " + "(" + $item.designation + ")"}}</ui-select-match>
                                                <ui-select-choices repeat="itemone in employeeRow | filter:$select.search" >
                                                    {{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}} 
                                                </ui-select-choices>
                                            </ui-select>
                                            <div ng-if="sbtBtn" ng-show="request.application_to.length == '0' || request.application_to.length == null" class="help-block department sbtBtn ">
                                                Application to is required.
                                            </div>
                                            <i class="glyphicon glyphicon-user "></i>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class=" col-xs-12">
                                <div class="form-group">
                                    <label>Application CC </label>
                                    <span class="input-icon icon-right">
                                        <ui-select multiple ng-model="request.application_cc" name="application_cc" theme="select2" ng-disabled="disabled" style="width: 100%;" ng-required="true" required>
                                            <ui-select-match placeholder="Select or Search Application CC">{{$item.first_name + " " + $item.last_name + " " + "(" + $item.designation + ")"}}</ui-select-match>
                                            <ui-select-choices repeat="itemone in employeeRowCC | filter:$select.search" >
                                                {{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}} 
                                            </ui-select-choices>
                                        </ui-select>
                                        <i class="glyphicon glyphicon-user "></i>
                                    </span>

                                </div>
                            </div>
                            <div class=" col-xs-12">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.req_desc.$dirty && requestLeave.req_desc.$invalid) }">
                                    <label>Application Description<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <textarea ng-model="request.req_desc" name="req_desc" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" style="height: 238px;" maxlength="100" required></textarea>
                                        <i class="glyphicon glyphicon-briefcase "></i>
                                    </span>
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.req_desc.$error">
                                        <div ng-message="required">Application description is required.</div>
                                    </div>


                                </div> 
                            </div>

                            <div class="col-md-12 col-xs-12" align="right">
                                <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="reqOtherLeave">Submit</button>
                                <a href=""  class="btn btn-primary" ng-click="resetForm(request)">Reset</a>
                                <a href="[[ config('global.backendUrl') ]]#/my-request/index"  class="btn btn-primary" >Cancel</a>
                            </div>
                        </div> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

