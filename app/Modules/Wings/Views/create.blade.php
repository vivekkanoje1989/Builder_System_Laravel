<div class="row">
    <div class="widget flat radius-bordered ">
        <div class="col-lg-12 col-sm-12 col-xs-12" ng-controller="wingsController">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{pageHeading}}</h5>
            <div class="widget-body bordered-top bordered-themeprimary col-lg-12 col-sm-12 col-xs-12">
                <div id="customer-form">
                    <form novalidate role="form" name="wingForm" >
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">  
                                    <div class="form-group">
                                        <label>Projects<span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="wingData.project_id" ng-controller="projectCtrl" name="project_id" class="form-control" required>
                                                <option value="">Select type</option>
                                                <option ng-repeat="plist in projectList" value="{{plist.id}}">{{plist.project_name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Wing Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="wingData.first_name" name="first_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                            <i class="fa fa-user"></i>
                                            <div ng-show="formButton" ng-messages="customerForm.first_name.$error" class="help-block errMsg">
                                                <div ng-message="required">Please enter first name</div>
                                            </div>
                                            <div ng-if="first_name" class="errMsg first_name">{{first_name}}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Number of Floors</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="wingData.first_name" name="first_name" capitalizeFirst oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')" maxlength="15" required>
                                            <i class="fa fa-user"></i>
                                            <div ng-show="formButton" ng-messages="customerForm.first_name.$error" class="help-block errMsg">
                                                <div ng-message="required">Please enter first name</div>
                                            </div>
                                            <div ng-if="first_name" class="errMsg first_name">{{first_name}}</div>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Company</label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="wingData.firm_partner_id" ng-controller="companyCtrl" name="firm_partner_id" class="form-control" required>
                                                <option value="">Select company</option>
                                                <option ng-repeat="list in firmPartnerList" value="{{list.id}}">{{list.marketing_name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Stationary</label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="wingData.stationary_id" ng-controller="stationaryCtrl" name="stationary_id" class="form-control" required>
                                                <option value="">Select stationary</option>
                                                <option ng-repeat="list in stationaryList" value="{{list.id}}">{{list.name}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>   
                                <div class="col-sm-3 col-sx-6">
                                    <div class="form-group">
                                        <label for="">Number of floors below ground</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="number_of_floors_below_ground" name="number_of_floors_below_ground" required>
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">    
                                <div class="col-sm-3 col-sx-6">
                                    <div class="control-group">
                                    <div class="radio">
                                        <label>
                                            <input name="form-field-radio" type="radio" ng-model="wing_status" value="1" class="colored-success">
                                            <span class="text">Launched</span>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input name="form-field-radio" type="radio" ng-model="wing_status" value="2" class="colored-blue">
                                            <span class="text">Not Launched</span>
                                        </label>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-sm-3 col-sx-6">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>