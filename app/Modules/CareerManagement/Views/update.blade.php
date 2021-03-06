<div class="row" ng-controller="careerCtrl" ng-init="getCareer(<?php echo $id; ?>);">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Edit Job Details</span>
            </div>
            <div class="widget-body">
                <form  ng-submit="jobPosting.$valid && dojobPostingAction(career)" name="jobPosting"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="row">
                        <input type="hidden" class="form-control" ng-model="id" name="id" >                                                   
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Job Title <span class="sp-err">*</span></label>
                                <div class="form-group">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="career.job_title" name="job_title" capitalizeFirst ng-change="errorMsg = null" required oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_title.$error">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                            <div ng-if="errorMsg" class="sp-err">{{errorMsg}}</div>
                                        </div>
                                        <div ng-if="job_title" class="sp-err job_title">{{job_title}}</div>
                                        <br/>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Job Location <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="career.job_locations" name="job_locations" capitalizeFirst required oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_locations.$error">
                                        <div ng-message="required" class="sp-err">This field is required.</div>
                                    </div>
                                    <div ng-if="job_locations" class="sp-err job_locations">{{job_locations}}</div>
                                    <br/>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Job Eligibility <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="career.job_eligibility" name="job_eligibility" class="form-control capitalize ng-pristine ng-valid ng-valid-maxlength ng-touched" required></textarea>

                                </span>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_eligibility.$error">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                                <div ng-if="job_eligibility" class="sp-err job_eligibility">{{job_eligibility}}</div>
                                <br/>
                            </div> 
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group" ">
                                <label>Job Role <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="career.job_role" name="job_role" capitalizeFirst required>
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_role.$error">
                                        <div ng-message="required" class="sp-err">This field is required.</div>
                                    </div>
                                    <div ng-if="job_role" class="sp-err job_role">{{job_role}}</div>
                                    <br/>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>job Responsibilities<span class="sp-err">*</span></label>
                                <div class="form-group">
                                    <span class="input-icon icon-right">
                                        <textarea ng-model="career.job_responsibilities" name="job_responsibilities" class="form-control capitalize ng-pristine ng-valid ng-valid-maxlength ng-touched" required></textarea>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_responsibilities.$error">
                                            <div ng-message="required" class="sp-err">This field is required.</div>
                                        </div>
                                        <div ng-if="job_responsibilities" class="sp-err job_responsibilities">{{job_responsibilities}}</div>
                                        <br/>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div ng-controller="DatepickerDemoCtrl" class="form-group" >
                                <label>Application start date<span class="sp-err">*</span></label>
                                <p class="input-group">
                                    <input type="text" ng-model="career.application_start_date" name="application_start_date" id="application_start_date" class="form-control" datepicker-popup="{{format}}" is-open="opened"  max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                    <span class="input-group-btn" >
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                </p>
                                <div  class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.application_start_date.$error">
                                    <div ng-message="required" class="sp-err">This field is required.</div>
                                </div>
                                <div ng-if="application_start_date" class="sp-err application_start_date">{{application_start_date}}</div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-xs-12 ">
                            <div ng-controller="DatepickerDemoCtrl" class="form-group" >
                                <label>Application End Date<span class="sp-err">*</span></label>
                                <p class="input-group">
                                    <input type="text" ng-model="career.application_close_date"  min-date="career.application_start_date"  min-date="model.application_start_date" name="application_close_date" id="application_close_date" class="form-control" datepicker-popup="{{format}}" is-open="opened"   datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                </p>
                                <div  class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.application_close_date.$error">
                                    <div ng-message="required">This field is required.</div>
                                </div>
                                <div ng-if="application_close_date" class="sp-err application_close_date">{{application_close_date}}</div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label>Number of positions<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="career.number_of_positions" name="number_of_positions" required  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.number_of_positions.$error">
                                        <div ng-message="required" class="sp-err">This field is required.</div>
                                    </div>
                                    <div ng-if="number_of_positions" class="sp-err number_of_positions">{{number_of_positions}}</div>
                                    <br/>
                                </span>
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-sm-12 col-xs-12" align="right">
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="editjob">Update</button>
                            <a href="[[ config('global.backendUrl') ]]#/career/index" class="btn btn-primary">Cancel</a>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</div>
