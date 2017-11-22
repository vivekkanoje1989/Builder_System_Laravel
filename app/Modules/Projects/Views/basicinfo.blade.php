<style>
    .editor-text {
        border: 1px solid #cecece;
        margin-top: 10px;
        background-color: #fff;
        padding: 10px;
    }
</style>
<div>
    <tabset>
        <tab heading="Project Basic Information" id="basicInfoTab">
            <form role="form" name="basicInfoForm" ng-submit="basicInfoForm.$dirty && webpageSettings(projectData.prid,projectData)">
                <input type="hidden" ng-model="projectData.csrfToken" name="csrftoken" id="csrftoken" ng-init="projectData.csrfToken = '[[ csrf_token() ]]'"/>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>Project Alias</label>
                            <input type="text" class="form-control" ng-model="projectData.project_alias" name="project_alias" id="projectAlias" maxlength="200" />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Alias Status</label>
                            <div class="radio">
                                <label>
                                    <input name="form-field-radio" type="radio" ng-model="projectData.alias_status" ng-selected="1" name="alias_status" value="1" class="colored-blue" />
                                    <span class="text">Active</span>
                                </label> &nbsp;&nbsp;
                                <label>
                                    <input name="form-field-radio" type="radio" ng-model="projectData.alias_status" name="alias_status" value="0" class="colored-danger" />
                                    <span class="text">Inactive</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6 col-lg-6">  
                        <div class="widget flat radius-bordered">
                            <div class="widget-header bordered-bottom bordered-themeprimary">
                                <span class="widget-caption">Short Description</span>
                            </div>
                            <div class="widget-body no-padding">
                                <div ng-controller="TextAngularCtrl">
                                    <div text-angular ng-model="projectData.short_description" name="short_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6 col-lg-6">  
                        <div class="widget flat radius-bordered">
                            <div class="widget-header bordered-bottom bordered-themeprimary">
                                <span class="widget-caption">Brief Description</span>
                            </div>
                            <div class="widget-body no-padding">
                                <div ng-controller="TextAngularCtrl">
                                    <div text-angular ng-model="projectData.brief_description" name="brief_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{btnLabel}}</button>
                            <button type="button" class="btn btn-primary" ng-click="cancel_basic_info()">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </tab>
        <tab heading="Project Contact Details" id="contactInfoTab">
            <form role="form" name="contactInfoForm" ng-submit="contactInfoForm.$dirty && webpageSettings(projectData.prid,contactData)">
                <input type="hidden" ng-model="prid" name="prid" id="prid" />
                <div class="row" ng-controller="currentCountryListCtrl">
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>Country</label>
                            <span class="input-icon icon-right">
                                <select ng-change="onCountryChange()" ng-model="contactData.project_country" name="project_country" id="current_country_id" class="form-control">
                                    <option value="">Select Country</option>
                                    <option ng-repeat="country in countryList" value="{{country.id}}" ng-selected="{{ country.id == contactData.project_country}}">{{country.name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>State</label>
                            <span class="input-icon icon-right">
                                <select ng-change="onStateChange()" ng-model="contactData.project_state" name="project_state" id="current_state_id" class="form-control">
                                    <option value="">Select State</option>
                                    <option ng-repeat="state in stateList track by $index" value="{{state.id}}" ng-selected="{{ state.id == contactData.project_state}}">{{state.name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>City</label>
                            <span class="input-icon icon-right">
                                <select ng-change="onCityChange()" ng-model="contactData.project_city" name="project_city" id="current_city_id" class="form-control">
                                    <option value="">Select City</option>
                                    <option ng-repeat="city in cityList track by $index" value="{{city.id}}" ng-selected="{{ city.id == contactData.project_city}}">{{city.name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>Location</label>
                            <span class="input-icon icon-right">
                                <select ng-model="contactData.project_location" name="project_location" id="current_location_id" class="form-control">
                                    <option value="">Select Location</option>
                                    <option ng-repeat="llist in locationList" value="{{llist.id}}" ng-selected="{{ llist.id == contactData.project_location}}">{{llist.location}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" ng-model="contactData.project_address" name="project_address"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>Contact Numbers (Comma separated contact numbers)</label>
                            <textarea class="form-control" ng-model="contactData.project_contact_numbers" name="project_contact_numbers"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{btnLabel}}</button>
                            <button type="button" class="btn btn-primary" ng-click="cancel_basic_info()">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </tab>
        <tab heading="Project Seo Setting" id="seoTab">
            <form role="form" name="seoInfoForm" ng-submit="seoInfoForm.$pristine && webpageSettings(projectData.prid,seoData)">
                <input type="hidden" ng-model="prid" name="prid" id="prid" />
                <div class="row">
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>Page Title</label>
                            <input type="text" class="form-control" ng-model="seoData.page_title" name="page_title" />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>Seo Url</label>
                            <input type="text" class="form-control" ng-model="seoData.seo_url" name="seo_url" />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>Meta Description</label>
                            <input type="text" class="form-control" ng-model="seoData.meta_description" name="meta_description" />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>Meta Keywords</label>
                            <input type="text" class="form-control" ng-model="seoData.meta_keywords" name="meta_keywords" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <label>Canonical Tag</label>
                            <input type="text" class="form-control" ng-model="seoData.canonical_tag" name="canonical_tag" />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label>Project Website</label>
                            <input type="text" class="form-control" ng-model="seoData.project_website" name="project_website">
                        </div>
                    </div>
                </div>              
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{btnLabel}}</button>  
                            <button type="button" class="btn btn-primary" ng-click="cancel_basic_info()">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </tab>
    </tabset>    
</div>