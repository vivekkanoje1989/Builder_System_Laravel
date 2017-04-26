<div class="row" ng-controller="careerCtrl"  ng-init = "getCareer(<?php echo $id; ?>);">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Blog Management</span>

                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>

            <div class="widget-body table-responsive">     
                <form  ng-submit="jobPosting.$valid && dojobPostingAction()" name="jobPosting"  novalidate enctype="multipart/form-data">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                   
                    <table class="table table-hover table-striped table-bordered" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <td colspan="2">Add New Job</td>
                            <tr>
                        </thead>
                        <tbody>
                             <input type="hidden" class="form-control" ng-model="id" name="id" >
                                            
                            <tr>
                                <td>Job Title <span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.job_title.$dirty && jobPosting.job_title.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="job_title" name="job_title"  ng-change="errorMsg = null" required>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_title.$error">
                                                <div ng-message="required">Title is required</div>
                                                <div ng-if="errorMsg">{{errorMsg}}</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                             <tr>
                                <td>Job Location <span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.job_locations.$dirty && jobPosting.job_locations.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="job_locations" name="job_locations"  required>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_locations.$error">
                                                <div ng-message="required">Job location is required</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr><td>Eligibility Criteria <span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.job_eligibility.$dirty && jobPosting.job_eligibility.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <textarea ng-model="job_eligibility" name="job_eligibility" cols="50" rows="5" required ></textarea>

                                        </span>
                                        <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_eligibility.$error">
                                            <div ng-message="required">Eligibility criteria is required</div>
                                        </div>
                                        <br/>
                                    </div>    
                                </td>
                            </tr>
                            <tr>
                                <td>Job Role <span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.job_role.$dirty && jobPosting.job_role.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="job_role" name="job_role"   required>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_locations.$error">
                                                <div ng-message="required">Title is required</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Job Responsibilities <span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.job_responsibilities.$dirty && jobPosting.job_responsibilities.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="job_responsibilities" name="job_responsibilities" placeholder="Job Responsibilities"  required>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.job_responsibilities.$error">
                                                <div ng-message="required"> Job responsibilities is required</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr><td>Application Start Date <span class="sp-err">*</span></td>
                                <td>
                            <div ng-controller="DatepickerDemoCtrl" class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.application_start_date.$dirty  || jobPosting.application_start_date.$invalid)}">
                                <p class="input-group">
                                <input type="text" ng-model="model.application_start_date" name="application_start_date" id="application_start_date" class="form-control" datepicker-popup="{{format}}" is-open="opened"  max-date=maxDate datepicker-options="dateOptions" close-text="Close" placeholder="Application Start Date" ng-click="toggleMin()" readonly required/>
                                <span class="input-group-btn" >
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                                </p>
                                <div  class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.application_start_date.$error">
                                    <div ng-message="required">Application closing date is required.</div>
                                </div>
                            </div>
                          </td>          
                        </tr>
                            <tr><td>Application Closing Date <span class="sp-err">*</span></td>
                                <td>
                            <div ng-controller="DatepickerDemoCtrl" min-date="application_start_date" class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.application_close_date.$dirty  || jobPosting.application_close_date.$invalid)}">
                                <p class="input-group">
                                <input type="text" ng-model="model.application_close_date" name="application_close_date" id="application_close_date" class="form-control" datepicker-popup="{{format}}" is-open="opened"  max-date=maxDate datepicker-options="dateOptions" close-text="Close" placeholder="Application Close Date" ng-click="toggleMin()"  required/>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                                </p>
                                <div  class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.application_close_date.$error">
                                    <div ng-message="required">Application closing date is required.</div>
                                </div>
                            </div>
                          </td>          
                        </tr>
                         <tr>
                                <td>Number of positions <span class="sp-err">*</span></td>
                                <td>
                                    <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!jobPosting.number_of_positions.$dirty && jobPosting.number_of_positions.$invalid) }">
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="number_of_positions" name="number_of_positions"  required>
                                            <div class="help-block" ng-show="sbtBtn" ng-messages="jobPosting.number_of_positions.$error">
                                                <div ng-message="required">Number of position is required</div>
                                            </div>
                                            <br/>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr><td></td>
                                <td><button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

