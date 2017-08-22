<div class="modal-body">
    <div class="">
        <div class="widget-main ">
            <tabset flat="true">
                <tab heading="Schedule Test Drive">
                    <form novalidate role="form" name="todayRemarkForm" ng-submit="todayRemarkForm.$valid && scheduleTestDrive(customerData, enquiryData)"> 
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Customer Name :</label>
                                </div>
                            </div>
                            <!--                            <div class="row">
                                                            <div class="col-md-3">
                                                                <select ng-model="customerData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" required>
                                                                    <option value="">Select Title</option>
                                                                    <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.title_id}}">{{t.title}}</option>
                                                                </select>
                                                                <div ng-show="enquiryformButton && todayRemarkForm.title_id.$invalid" ng-messages="todayRemarkForm.title_id.$error" class="help-block errMsg">
                                                                    <div ng-message="required" >This field is required</div>
                                                                </div>
                                                                <div class="horizontal-space"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" name="first_name" ng-model="customerData.first_name"placeholder="First Name" class="form-control"  capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" maxlength="15" required>
                                                                <div ng-show="enquiryformButton && todayRemarkForm.first_name.$invalid" ng-messages="todayRemarkForm.first_name.$error" class="help-block errMsg">
                                                                    <div ng-message="required" >Please enter first name</div>
                                                                </div>
                                                                <div class="horizontal-space"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" name="last_name" ng-model="customerData.last_name" placeholder="Last Name"   capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" maxlength="15" class="form-control">
                                                                <div class="horizontal-space"></div>
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                        </div>-->
                            <div class="row">
                                <div class="col-md-4" ng-if="tdis == false">
                                    <select  ng-model="customerData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" required>
                                        <option value="">Select Title</option>
                                        <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == customerData.title_id}}">{{t.title}}</option>
                                    </select>
                                    <div class="horizontal-space"></div>
                                    <div ng-show="enquiryformButton && todayRemarkForm.title_id.$invalid" ng-messages="todayRemarkForm.title_id.$error" class="help-block errMsg">
                                        <div ng-message="required" >This field is required</div>
                                    </div>

                                </div>
                                <div class="col-md-4" ng-if="tdis == true">
                                    <span ng-if="customerData.title_id == 1">Mr.</span><span ng-if="customerData.title_id == 2">Ms.</span>
                                    <span ng-if="customerData.title_id == 3">Mrs.</span>
                                    <span ng-if="customerData.title_id == 4">Doctor.</span>
                                </div>
                                <div class="col-md-4" ng-if="fdis == false">
                                    <input type="text" name="first_name" ng-model="customerData.first_name" placeholder="First Name"   capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" maxlength="15" class="form-control" required>
                                    <div ng-show="enquiryformButton && todayRemarkForm.first_name.$invalid" ng-messages="todayRemarkForm.first_name.$error" class="help-block errMsg">
                                        <div ng-message="required" >Please enter first name</div>
                                    </div>
                                    <div class="horizontal-space"></div>
                                </div>
                                <div class="col-md-4" ng-if="fdis == true">
                                    <span>{{customerData.first_name}}</span>
                                </div>
                                <div class="col-md-4" ng-if="ldis == false">
                                    <input type="text" name="last_name" ng-model="customerData.last_name" placeholder="Last Name"  capitalization oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')" maxlength="15" class="form-control">
                                    <div class="horizontal-space"></div>
                                </div>
                                <div class="col-md-4" ng-if="ldis == true">
                                    <span>{{customerData.last_name}}</span>
                                </div>
                                <br>
                                <br>
                            </div>

                            <div class="row">
                                <div class="col-md-6" >
                                    <label>Schedule date & time :</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8" >
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                        <p class="input-group">
                                            <!--<input type="hidden" ng-model="enquiryData.enquiry_id">-->
                                            <input type="text" ng-model="enquiryData.testdrive_date" name="testdrive_date" id="" class="form-control" ng-change="timeChange(enquiryData.testdrive_date)" placeholder="Schedule date" datepicker-popup="dd-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        <div ng-show="enquiryformButton && todayRemarkForm.testdrive_date.$invalid" ng-messages="todayRemarkForm.testdrive_date.$error" class="help-block errMsg">
                                            <div ng-message="required" >This field is required</div>
                                        </div>
                                        </p>
                                    </div>  
                                </div>  
                                <div class="col-md-4" >
                                    <select ng-model="enquiryData.testdrive_time" name="testdrive_time" class="form-control" required>
                                        <option value="">--  Time  --</option>
                                        <option ng-repeat="time in timeList" value="{{time.value}}" ng-selected="{{time.value == enquiryData.testdrive_time}}">{{time.label}}</option>
                                    </select>
                                    <div ng-show="enquiryformButton && todayRemarkForm.testdrive_time.$invalid" ng-messages="todayRemarkForm.testdrive_time.$error" class="help-block errMsg">
                                        <div ng-message="required" >This field is required</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" >
                                    <label>Select Vehicle :</label>
                                </div>
                            </div>
                            <div class="row" ng-controller="testdriveVehiclesCtrl">
                                <div class="col-md-8" >
                                    <select  ng-model="enquiryData.testdrive_vehicle_ids" name="testdrive_vehicle_ids" id="testdrive_vehicle_ids" class="form-control">
                                        <option value="">Select Vehicle</option>
                                        <option ng-repeat="vehicle in vehicleList" value="{{vehicle.id}}" ng-selected="{{ vehicle.id == enquiryData.testdrive_vehicle_ids}}">{{vehicle.friendly_name}}</option>
                                    </select> 
                                </div>  
                            </div>
                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" ng-controller="enqCountryListCtrl">
                            <!--div class="row">
                                <div class="col-md-4" >
                                    <label>Country</label>
                                </div>
                                <div class="col-md-8" >
                                    <select ng-change="onCountryChange()" ng-model="enquiryData.country_id" name="country_id" id="current_country_id" class="form-control">
                                        <option value="">Select Country</option>
                                        <option ng-repeat="country in countryList" value="{{country.id}}" ng-selected="{{ country.id == enquiryData.country_id}}">{{country.name}}</option>
                                    </select>
                                    <div class="horizontal-space"></div>
                                </div>
                            </div-->
                            <div class="row">
                                <div class="col-md-4" >
                                    <label>State</label>
                                </div>
                                <div class="col-md-8">

                                    <select ng-model="enquiryData.state_id" ng-change="onStateChange()" name="state_id" id="current_state_id" class="form-control" required="">
                                        <option value="">Select State</option>
                                        <option ng-repeat="state in stateList" value="{{state.id}}" ng-selected="{{ state.id == enquiryData.state_id}}">{{state.name}}</option>
                                    </select>
                                    <div class="horizontal-space"></div>
                                    <div  ng-show="enquiryformButton && todayRemarkForm.state_id.$invalid" ng-messages="todayRemarkForm.state_id.$error" class="help-block">
                                        <div ng-message="required" style="color: red !important;">This field is required</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" >
                                    <label>City</label>
                                </div>
                                <div class="col-md-8">
                                    <select ng-model="enquiryData.city_id" name="city_id" class="form-control" required>
                                        <option value="">Select City</option>
                                        <option ng-repeat="city in cityList" value="{{city.id}}" ng-selected="{{ city.id == enquiryData.city_id}}">{{city.name}}</option>
                                    </select>
                                    <div class="horizontal-space"></div>
                                    <div  ng-show="enquiryformButton && todayRemarkForm.city_id.$invalid" ng-messages="todayRemarkForm.city_id.$error" class="help-block">
                                        <div ng-message="required" style="color: red !important;">This field is required</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" >
                                    <label>Area:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" ng-model="enquiryData.address" name="address" placeholder="Area" required>
                                    <div  ng-show="enquiryformButton && todayRemarkForm.address.$invalid" ng-messages="todayRemarkForm.address.$error" class="help-block">
                                        <div ng-message="required" style="color: red !important;">This field is required</div>
                                    </div>
                                </div>
                            </div>                            
                        </div>


                        <hr class="col-lg-12">

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                            <button type="submit" class="btn btn-primary" ng-click="enquiryformButton = true">{{value}}</button>
                            <button class="btn btn-primary" ng-if="showschedulebtn" ng-click="scheduleSmsEmail(customerData, enquiryData)">{{schedule}}</button>
                        </div>
                    </form>    

                </tab>
            </tabset>
        </div>
    </div>
</div>
<style>
    .errMsg{
        color:red;
    }
    .modal-content{
        position: absolute !important;
    }
</style>