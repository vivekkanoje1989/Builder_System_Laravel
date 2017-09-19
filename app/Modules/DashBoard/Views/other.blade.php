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
                        <div class="col-md-3 col-xs-12 "></div>
                        <div class="col-md-6 col-xs-12 ">
                            <div class="col-xs-12 ">
                                <div class="form-group">
                                    <label>Application To <span class="sp-err">*</span></label>
                                    <div class="form-group multi-sel-div" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.application_to.$dirty && requestLeave.application_to.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <!--                                                    <ui-select  ng-model="request.application_to" name="application_to" id="roleId"  theme="select2" ng-init="getEmployees()" style='width: 100%;' ng-change="getEmployeesCC()" required>                                        
                                                                                                    <ui-select-match placeholder="Select or Search Application to">{{$select.selected.first_name + " " + $select.selected.last_name + " " + "(" + $select.selected.designation + ")"}}</ui-select-match>
                                                                                                    <ui-select-choices repeat="itemone in employeeRow | filter: $select.search">
                                                                                                        <div ng-bind-html="itemone.first_name+' '+ itemone.last_name + '('+ itemone.designation+')' | highlight: $select.search" ></div>
                                                                                                    </ui-select-choices>
                                                                                                </ui-select> -->
                                            <ui-select multiple ng-model="request.application_to" name="application_to" theme="select2" ng-disabled="disabled" style="width: 100%;" ng-required="true"  ng-init="getEmployees()" ng-change="getEmployeesCC()">
                                                <ui-select-match placeholder="Select or Search Application to">{{$item.first_name + " " + $item.last_name + " " + "(" + $item.designation + ")"}}</ui-select-match>
                                                <ui-select-choices repeat="itemone in employeeRow | filter:$select.search" >
                                                    {{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}} 
                                                </ui-select-choices>
                                            </ui-select>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.application_to.$error">
                                                <div ng-message="required">Application To is required</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <div class=" col-xs-12">
                                <div class="form-group">
                                    <label>Application CC </label>
                                    <span class="input-icon icon-right">
                                        <!--                                                <ui-select ng-model="request.application_cc" name="application_cc" id="roleId"  theme="select2"  style='width: 100%;' ng-change="getEmployeesCC()" required>                                        
                                                                                            <ui-select-match placeholder="Select or Search Application cc">{{$select.selected.first_name + " " + $select.selected.last_name + " " + "(" + $select.selected.designation + ")"}}</ui-select-match>
                                                                                            <ui-select-choices repeat="itemone in employeeRowCC | filter: $select.search">
                                                                                                <div ng-bind-html="itemone.first_name+' '+ itemone.last_name + '('+ itemone.designation+')' | highlight: $select.search" ></div>
                                                                                            </ui-select-choices>
                                                                                        </ui-select> -->
                                        <ui-select multiple ng-model="request.application_cc" name="application_cc" theme="select2" ng-disabled="disabled" style="width: 100%;" ng-required="true" required>
                                            <ui-select-match placeholder="Select or Search Application CC">{{$item.first_name + " " + $item.last_name + " " + "(" + $item.designation + ")"}}</ui-select-match>
                                            <ui-select-choices repeat="itemone in employeeRow | filter:$select.search" >
                                                {{itemone.first_name + " " + itemone.last_name + " " + "(" + itemone.designation + ")"}} 
                                            </ui-select-choices>
                                        </ui-select>
                                        <br/>
                                    </span>
                                </div>
                            </div>
                            <div class=" col-xs-12">
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!requestLeave.req_desc.$dirty && requestLeave.req_desc.$invalid) }">
                                    <label>Application Description<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <textarea ng-model="request.req_desc" name="req_desc" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" style="height: 238px;" maxlength="100" required></textarea>
                                    </span>
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="requestLeave.req_desc.$error">
                                        <div ng-message="required">Application Description is required.</div>
                                    </div>
                                    <br/>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12" align="right">
                                    <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="reqOtherLeave">Submit</button>
                                    <!--<a href="[[ config('global.backendUrl') ]]#/my-request/index" class="btn btn-primary"><< Back to list</a>-->
                                    <a href=""  class="btn btn-primary" ng-click="resetForm(request)">Cancel</a>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-3"></div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

