<style>

    .vT {
        background-color: #f5f5f5;    
        display: inline-block;
        color: #222;
        margin: 2px 5px;
        max-width: 325px;
        max-height: 27px;
        overflow: hidden;
        text-overflow: ellipsis;
        direction: ltr;
        cursor: move;
    }
    .vM {
        display: inline-block;
        width: 40px;
        height: 20px;
        background: no-repeat url(//ssl.gstatic.com/apps/gadgets/contactarea/contactarea_sprite_2.gif) -4px 0;
        opacity: .6;
        vertical-align: top;
        cursor: pointer;
    }
</style>

<div class="row" ng-controller="operationalCtrl" ng-init="manageCountry(); getOperationalSettings()">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption">Source Name</span>
            </div>
            <div class="widget-body no-padding">

                <accordion>
                    <accordion-group heading="Allowed Previous Enquiries" >
                        <label>Allowed enquiries</label>
                        <input type="number" name="allowedEnquiries" id="allowedEnquiries" ng-model="allowedenq" class="form-control" style="width:20%" ng-keyup="allowedenquiries(allowedenq)">
                    </accordion-group>

                    <accordion-group heading="Add Operational Area" >

                        <div class="row">
                            <div class="col-md-6">
                                <form novalidate ng-submit="operationalForm.$valid && opeartionalArea(location_id)" name="operationalForm">
                                      <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                   
                                    <div class="col-md-12">
                                        <label>Country<span class="sp-err">*</span></label>
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!operationalForm.country_id.$dirty && operationalForm.country_id.$invalid)}">

                                            <select id="country_id" name="country_id" class="form-control" ng-model="country_id" required ng-options="item.id as item.name for item in countryRow" ng-change="manageStates(country_id)" required>
                                                <option value="">Select country</option>
                                            </select>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="operationalForm.country_id.$error">
                                                <div ng-message="required">Country name is required</div>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="col-md-12">
                                        <label>State<span class="sp-err">*</span></label>
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!operationalForm.state_id.$dirty && operationalForm.state_id.$invalid)}">

                                            <select class="form-control" ng-model="state_id" name="state_id" ng-change="manageCity(state_id)" required>
                                                <option value="">Select state</option>
                                                <option  ng-repeat="itemone in statesRow"  value="{{itemone.id}}">{{itemone.name}}</option>
                                            </select>
                                            <br/>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="operationalForm.state_id.$error">
                                                <div ng-message="required">State name is required</div>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="col-md-12">
                                        <label>City<span class="sp-err">*</span></label>
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!operationalForm.city_id.$dirty && operationalForm.city_id.$invalid)}">

                                            <select class="form-control" ng-model="city_id" name="city_id" required  ng-change="manageLocation(city_id)">
                                                <option value="">Select city</option>
                                                <option  ng-repeat="itemtwo in cityRow"  value="{{itemtwo.id}}">{{itemtwo.name}}</option>
                                            </select>
                                            <br/>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="operationalForm.city_id.$error">
                                                <div ng-message="required">City name is required</div>
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="col-md-12">
                                        <label>Location<span class="sp-err">*</span></label>
                                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!operationalForm.location_id.$dirty && operationalForm.location_id.$invalid)}">

                                            <select class="form-control" ng-model="location_id" name="location_id"  required>
                                                <option value="">Select location</option>
                                                <option  ng-repeat="itemthree in locationRow"  value="{{itemthree.id}}">{{itemthree.location}}</option>
                                            </select>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="operationalForm.location_id.$error">
                                                <div ng-message="required">Location name is required</div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit"  ng-click="sbtBtn = true" value="ADD" style="width:80%; margin-top:23px;" class="btn btn-primary">
                                        <br/>
                                    </div>
                            </div>  
                            <div class="col-md-6">
                                <div id="selected_area" style="margin-bottom: 2px;" ng-repeat="step in locations_area| unique:list">

                                    <span class="vN Y7BVp a3q" ng-repeat="(key, value) in step">                    
                                        <div class="vT">&nbsp;&nbsp;
                                            {{value}}
                                        </div>
                                        <div class="vM" ng-click="del_area({{key}})"></div>
                                    </span>
                                </div>
                                <p ng-repeat="item in locationAreas"></p>
                            </div>
                            </form>
                        </div>
                    </accordion-group>

                    <accordion-group heading="Customer Budget Range" >
                        <div style="width:120px; float:left;">
                            <input type="number" name="" id="allowedEnquiries" ng-model="startRange" class="form-control" style="width:80%">
                        </div><div style="width:200px; float:left;">        
                            <h4>00,000  TO </h4>
                        </div>
                        <div style="width:120px; float:left;">        
                            <input type="number" name="" id="allowedEnquiries" ng-model="endRange" class="form-control" style="width:80%">
                        </div><div style="width:200px; float:left;">     
                            <h4>00,000</h4>
                        </div>

                        <div style="width:200px; float:left;">     
                            <input type="button" ng-click="budgetRange(startRange, endRange);" value="Save" class="btn btn-primary">
                        </div>
                    </accordion-group>

                    <accordion-group heading="Birthday wishes to customer" >
                        <label>
                            <input class="checkbox-slider slider-icon" type="checkbox" ng-model="birthdayEmail" ng-click="birthdayFlag(birthdayEmail, 'email')">
                            <span class="text ng-binding" > &nbsp;&nbsp;&nbsp; Alert Email </span>                            

                        </label>
                        <br/>  
                        <label>
                            <input class="checkbox-slider slider-icon" type="checkbox" ng-model="birthdaySms" ng-click="birthdayFlag(birthdaySms, 'sms')">
                            <span class="text ng-binding" > &nbsp;&nbsp;&nbsp; Alert Sms </span>                            
                        </label>
                    </accordion-group>

                    <accordion-group heading="Anniversary wishes to customer">
                        <label>
                            <input class="checkbox-slider slider-icon" type="checkbox" ng-model="anniversaryEmail" ng-click="anniversaryFlag(anniversaryEmail, 'email')">
                            <span class="text ng-binding" > &nbsp;&nbsp;&nbsp; Alert Email </span>                            

                        </label>
                        <br/>  
                        <label>
                            <input class="checkbox-slider slider-icon" type="checkbox" ng-model="anniversarySms" ng-click="anniversaryFlag(anniversarySms, 'sms')">
                            <span class="text ng-binding" > &nbsp;&nbsp;&nbsp; Alert Sms </span>                            
                        </label>
                    </accordion-group>
                </accordion>
            </div>
        </div>
    </div>
</div>

