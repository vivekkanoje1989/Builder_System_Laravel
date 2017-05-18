<style>
    .help-block{
        color:red !important;
    }    
</style>
<div class="row">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="wingsController" ng-init="manageWings([[ $id ]])">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{pageHeading}}</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <div id="customer-form">
                    <form novalidate role="form" name="wingForm" ng-submit="wingForm.$error && saveWingsInfo(wingData, [[ $id ]])">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-sm-4 col-xs-6">  
                                    <div class="form-group">
                                        <label>Projects<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="wingData.project_id" ng-controller="projectCtrl" name="project_id" class="form-control" required>
                                                <option value="">Select type</option>
                                                <option ng-repeat="plist in projectList" value="{{plist.id}}" ng-selected="wingData.project_id == plist.id">{{plist.project_name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="savebtn" ng-messages="wingForm.project_id.$error" class="help-block errMsg">
                                                <div ng-message="required">Please select project</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Wing Name<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="wingData.wing_name" name="wing_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                            <i class="fa fa-user"></i>
                                            <div ng-show="savebtn" ng-messages="wingForm.wing_name.$error" class="help-block errMsg">
                                                <div ng-message="required">Please enter first name</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Number of Floors<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="wingData.number_of_floors" name="number_of_floors" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required >
                                            <i class="fa fa-user"></i>
                                            <div ng-show="savebtn" ng-messages="wingForm.number_of_floors.$error" class="help-block errMsg">
                                                <div ng-message="required">Please enter number of floor</div>
                                            </div>
                                            <!--<div ng-if="first_name" class="errMsg first_name">{{first_name}}</div>-->
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-sm-4 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Company<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="wingData.company_id" ng-controller="companyCtrl" name="company_id" class="form-control" required>
                                                <option value="">Select company</option>
                                                <option ng-repeat="list in firmPartnerList" value="{{list.id}}" ng-selected="wingData.company_id == list.id">{{list.legal_name}}</option>
                                            </select>{{ firmPartnerList }}
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="savebtn" ng-messages="wingForm.company_id.$error" class="help-block errMsg">
                                                <div ng-message="required">Please select project</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Stationary<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="wingData.stationary_id" ng-controller="stationaryCtrl" name="stationary_id" class="form-control" required>
                                                <option value="">Select stationary</option>
                                                <option ng-repeat="list in stationaryList" value="{{list.id}}" ng-selected="wingData.stationary_id == list.id">{{list.stationary_set_name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                            <div ng-show="savebtn" ng-messages="wingForm.stationary_id.$error" class="help-block errMsg">
                                                <div ng-message="required">Please select stationary</div>
                                            </div>
                                        </span>
                                    </div>
                                </div>   
                                <div class="col-sm-4 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Number of floors below ground</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="wingData.number_of_floors_below_ground" name="number_of_floors_below_ground"  maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                            <i class="fa fa-user"></i>                                           
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">    
                                <div class="col-sm-4 col-sx-6">
                                    <div class="control-group">
                                        <label>Status<span class="sp-err">*</span></label>
                                        <div class="radio">
                                            <label>
                                                <input name="form-field-radio" type="radio" ng-model="wingData.wing_status" value="2" class="colored-success" ng-checked="true">
                                                <span class="text">Launched</span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="form-field-radio" type="radio" ng-model="wingData.wing_status" value="1" class="colored-blue">
                                                <span class="text">Not Launched</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-sx-6">
                                    <div class="control-group">
                                        <label>Enquiries Status<span class="sp-err">*</span></label>
                                        <div class="radio">
                                            <label>
                                                <input name="wing_status_for_enquiries" type="radio" ng-model="wingData.wing_status_for_enquiries" value="2" class="colored-success" ng-checked="true">
                                                <span class="text"> Allowed</span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="wing_status_for_enquiries" type="radio" ng-model="wingData.wing_status_for_enquiries" value="1" class="colored-blue" >
                                                <span class="text">Not Allowed</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-sx-6">
                                    <div class="control-group">
                                        <label>Booking Status<span class="sp-err">*</span></label>
                                        <div class="radio">
                                            <label>
                                                <input name="wing_status_for_bookings" type="radio" ng-model="wingData.wing_status_for_bookings" value="2" class="colored-success" ng-checked="true">
                                                <span class="text">Allowed</span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input name="wing_status_for_bookings" type="radio" ng-model="wingData.wing_status_for_bookings" value="1" class="colored-blue">
                                                <span class="text">Not Allowed</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-sm-3 col-sx-6">
                                    <button type="submit" class="btn btn-primary" ng-click="savebtn == true">{{ savebtn}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>