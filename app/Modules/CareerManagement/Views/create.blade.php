<div class="row" ng-controller="careerCtrl">
    <div  class="col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Add Job Description</span>
            </div>
            <div class="widget-body">
                <form  ng-submit="jobPosting.$valid && dojobPostingAction(career)" name="jobPosting"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label>Job Title <span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.job_title.$dirty && jobPosting.job_title.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <input type="text" class="form-control" ng-model="career.job_title" name="job_title"  ng-change="errorMsg = null" required oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_title.$error">
                                            <div ng-message="required">Job title is required</div>
                                            <div ng-if="errorMsg" class="sp-err">{{errorMsg}}</div>
                                        </div>
                                         <div ng-if="job_title" class="sp-err job_title">{{job_title}}</div>
                                        <br/>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.job_locations.$dirty && jobPosting.job_locations.$invalid) }">
                                <label>Job Location <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="career.job_locations" name="job_locations" required  oninput="if (/[^A-Za-z ]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z ]/g,'')">
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_locations.$error">
                                        <div ng-message="required">Job location is required</div>
                                    </div>
                                    <div ng-if="job_locations" class="sp-err job_locations">{{job_locations}}</div>
                                    <br/>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.job_eligibility.$dirty && jobPosting.job_eligibility.$invalid) }">
                                <label>Job Eligibility <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <textarea ng-model="career.job_eligibility" name="job_eligibility" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" required></textarea>

                                </span>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_eligibility.$error">
                                    <div ng-message="required">Eligibility criteria is required</div>
                                </div>
                                <div ng-if="job_eligibility" class="sp-err job_eligibility">{{job_eligibility}}</div>
                                <br/>
                            </div> 
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.job_role.$dirty && jobPosting.job_role.$invalid) }">
                                <label>Job Role <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="career.job_role" name="job_role"  required>
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_role.$error">
                                        <div ng-message="required">Job role is required</div>
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
                                <label>Job Responsibilities<span class="sp-err">*</span></label>
                                <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.job_responsibilities.$dirty && jobPosting.job_responsibilities.$invalid) }">
                                    <span class="input-icon icon-right">
                                        <textarea ng-model="career.job_responsibilities" name="job_responsibilities" class="form-control ng-pristine ng-valid ng-valid-maxlength ng-touched" required></textarea>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_responsibilities.$error">
                                            <div ng-message="required"> Job responsibilities is required</div>
                                        </div>
                                         <div ng-if="job_responsibilities" class="sp-err job_responsibilities">{{job_responsibilities}}</div>
                                        <br/>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 ">
                            <div ng-controller="DatepickerDemoCtrl" class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.application_start_date.$dirty || jobPosting.application_start_date.$invalid)}">
                                <label>Application Start Date<span class="sp-err">*</span></label>
                                <p class="input-group">
                                    <input type="text" ng-model="career.application_start_date" min-date="minDate" name="application_start_date" id="application_start_date" class="form-control" datepicker-popup="{{format}}" is-open="opened"  max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                    <span class="input-group-btn" >
                                        <button type="button" class="btn btn-default" ng-click="open($event);  clearToDate()"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                </p>
                                <div  class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.application_start_date.$error">
                                    <div ng-message="required">Application starting date is required.</div>
                                </div>
                                <div ng-if="application_start_date" class="sp-err application_start_date">{{application_start_date}}</div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-xs-12 ">
                            <div ng-controller="DatepickerDemoCtrl" class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.application_close_date.$dirty || jobPosting.application_close_date.$invalid)}">
                                <label>Application End Date<span class="sp-err">*</span></label>
                                <p class="input-group">
                                    <input type="text" ng-model="career.application_close_date"  min-date="career.application_start_date"  min-date="model.application_start_date" name="application_close_date" id="application_close_date" class="form-control" datepicker-popup="{{format}}" is-open="opened"   datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                                </p>
                                <div  class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.application_close_date.$error">
                                    <div ng-message="required">Application closing date is required.</div>
                                </div>
                                 <div ng-if="application_close_date" class="sp-err application_close_date">{{application_close_date}}</div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-xs-12">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.number_of_positions.$dirty && jobPosting.number_of_positions.$invalid) }">
                                <label>Number Of Positions<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="career.number_of_positions" name="number_of_positions" required  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.number_of_positions.$error">
                                        <div ng-message="required">Number of position is required</div>
                                    </div>
                                    <div ng-if="number_of_positions" class="sp-err number_of_positions">{{number_of_positions}}</div>
                                    <br/>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12" align="right">
                            <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true" ng-disabled="createJob">Submit</button>
                            <a href="[[ config('global.backendUrl') ]]#/job-posting/index" class="btn btn-primary"><< Back to list</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

