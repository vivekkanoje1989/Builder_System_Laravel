<form name="enquiryForm" ng-controller="enquiryController" novalidate >
    <input type="hidden" ng-model="enquiryData.csrfToken" name="csrftoken" id="csrftoken" ng-init="enquiryData.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>Enquiry Details of [[ $firstName ]] [[ $lastName ]]</h5>
            <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps">
                <ul class="steps" align="center">
                    <li class="wiredstep1 active" style="float:none"><span class="step">1</span><span class="title">Step 1</span><span class="chevron"></span></li>
                    <li class="wiredstep2" style="float:none"><span class="step">2</span><span class="title">Step 2</span> <span class="chevron"></span></li>
                    <li class="wiredstep3" style="float:none"><span class="step">3</span><span class="title">Step 3</span> <span class="chevron"></span></li>
                </ul>
            </div>
            <div class="step-content" id="WiredWizardsteps">
                <div class="step-pane active" id="wiredstep1">
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Date of enquiry <span class="sp-err">*</span></label>
                                <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                    <p class="input-group">
                                        <input type="text" ng-model="enquiryData.sales_enquiry_date" name="sales_enquiry_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required />
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                        <div ng-show="formButton" ng-messages="customerForm.sales_enquiry_date.$error" class="help-block errMsg">
                                            <div ng-message="required">Please select birth date</div>
                                        </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-title">Interested Projects</div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Project <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select ng-controller="projectCtrl" ng-model="enquiryData.project_id" name="project_id" class="form-control" required>
                                        <option value="">Select type</option>
                                        <option ng-repeat="plist in projectList" value="{{plist.id}}">{{plist.project_name}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div ng-controller="blockTypeCtrl">
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group multi-sel-div">
                                    <label for="">Select Blocks <span class="sp-err">*</span></label>	
                                    <ui-select ng-change="checkBlockLength()" multiple ng-model="enquiryData.block_id"  name="block_id" theme="select2" ng-disabled="disabled" ng-required="true">
                                        <ui-select-match>{{$item.block_name}}</ui-select-match>
                                        <ui-select-choices repeat="list in blockTypeList | filter:$select.search">
                                            {{list.block_name}} 
                                        </ui-select-choices>
                                    </ui-select>
                                    <div ng-show="emptyBlockId" class="help-block department step4 {{ applyClassBlock }}">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="form-group multi-sel-div">
                                    <label for="">Select Sub Blocks <span class="sp-err">*</span></label>	
                                    <ui-select multiple ng-model="enquiryData.sub_block_id" name="sub_block_id" theme="select2" ng-disabled="disabled" ng-required="true" ng-change="checkSubBlockLength()">
                                        <ui-select-match>{{$item.block_sub_type}}</ui-select-match>
                                        <ui-select-choices repeat="list1 in subBlockList | filter:$select.search">
                                            {{list1.block_sub_type}} 
                                        </ui-select-choices>
                                    </ui-select>
                                    <div ng-show="emptySubBlockId" class="help-block department step4 {{ applyClassSubBlock }}">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Sr. No.</th>
                                        <th style="width: 20%;">Project</th>
                                        <th style="width: 20%;">Blocks</th>
                                        <th style="width: 35%;">Sub Blocks</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>abc</td>
                                        <td>abc</td>
                                        <td>abc</td>
                                        <td>Edit Delete</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-nxt1">Next</button>
                        </div>
                    </div>
                </div>	
                <div class="step-pane" id="wiredstep2">	
                    <div class="form-title">Other Details</div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Enquiry Category <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control" ng-controller="salesEnqCategoryCtrl" ng-model="enquiryData.sales_category_id" name="sales_category_id">
                                        <option value="">Please Select</option>                                       
                                        <option ng-repeat="list in salesEnqCategoryList" value="{{list.id}}">{{list.enquiry_category}}</option>          
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Other Requirements</label>
                                <span class="input-icon icon-right">
                                    <textarea class="form-control" ng-model="enquiryData.sub_block_id" name="sub_block_id"></textarea>
                                    <i class="fa fa-bullseye"></i>
                                </span>
                            </div>               
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Remarks</label>
                                <span class="input-icon icon-right">
                                    <textarea class="form-control" ng-model="enquiryData.remarks" name="remarks"></textarea>
                                    <i class="fa fa-bullseye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Next Followup Date <span class="sp-err">*</span></label>
                                <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                    <p class="input-group">
                                        <input type="text" ng-model="enquiryData.next_followup_date" name="next_followup_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required />
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                        </span>
                                        <div ng-show="formButton" ng-messages="customerForm.sales_enquiry_date.$error" class="help-block errMsg">
                                            <div ng-message="required">Please select birth date</div>
                                        </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div ng-controller="TimepickerDemoCtrl">
                                <timepicker ng-model="enquiryData.next_follwoup_time" ng-change="changed()" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></timepicker>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group" ng-controller="employeesCtrl" >
                                <label for="">Enter colleague name to reassign enquiry <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <ui-select ng-model="enquiryData.followup_by_employee_id" theme="bootstrap">
                                        <ui-select-match placeholder="Select employee">{{$select.selected.first_name}}</ui-select-match>
                                        <ui-select-choices repeat="item in employeeList | filter: $select.search">
                                            <div ng-bind-html="item.first_name | highlight: $select.search"></div>
                                            <small ng-bind-html="item.designation | highlight: $select.search"></small>
                                        </ui-select-choices>
                                    </ui-select>     
                                    <i class="fa fa-sign-in"></i>                                   
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre2">Prev</button>
                            <button type="button" class="btn btn-primary btn-nxt2">Next</button>
                        </div>
                    </div>
                    
                </div>
                <div class="step-pane" id="wiredstep3">	
                    <div class="form-title">Requirement Details</div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Parking Required <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control" ng-model="enquiryData.parking_required" name="parking_required">
                                        <option value="">Yes</option>                                       
                                        <option value="">No</option>                                       
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Parking Type <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control" ng-model="enquiryData.parking_type" name="parking_type">
                                        <option value="">Common Parking</option>                                       
                                        <option value="">Private Parking</option>                                       
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Number of 2 wheeler parkings required</label>
                                <span class="input-icon icon-right">
                                    <input class="form-control" type="text" ng-model="enquiryData.two_wheeler_parkings_required" name="two_wheeler_parkings_required">
                                    <i class="fa fa-motorcycle"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Number of 4 wheeler parkings required</label>
                                <span class="input-icon icon-right">
                                    <input class="form-control" type="text" ng-model="enquiryData.four_wheeler_parkings_required" name="four_wheeler_parkings_required">
                                    <i class="fa fa-motorcycle"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Finance Required <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control" ng-model="enquiryData.finance_required" name="finance_required">
                                        <option value="1">Yes</option>                                       
                                        <option value="0">No</option>                                       
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Finance will be taken care by</label>
                                 <select class="form-control" ng-model="enquiryData.finance_required_from" name="finance_required_from">
                                    <option value="1">In house finance department</option>                                       
                                    <option value="2">Finance tieup agency</option>                                       
                                    <option value="3">Customer himself</option>                                       
                                </select>
                            </div>
                        </div> 
                        <!--
                        if Finance will be taken care by = 1 then show label = Select finance department colleague (foreign key of employee id)
                        if Finance will be taken care by = 2 then show label = Select finance tie up agency (foreign key of enquiry_finance_tieup)
                        if Finance will be taken care by = 3 then hide this field
                        -->
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Select finance department colleague</label>
                                <span class="input-icon icon-right">
                                    <input class="form-control" type="text" ng-model="enquiryData.finance_employee_id" name="finance_employee_id">
                                    <input class="form-control" type="text" ng-model="enquiryData.finance_tieup_id" name="finance_tieup_id">
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div> 
                    </div>
                    <div class="form-title">Preferences</div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Preferred City <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control" ng-model="enquiryData.sub_block_id" name="sub_block_id">
                                        <option value="">Pune</option>                                       
                                        <option value="">Mumbai</option>                                       
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Preferred Area's<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <textarea class="form-control" ng-model="enquiryData.enquiry_locations" name="enquiry_locations"></textarea>
                                    <i class="fa fa-map-marker"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Tentative Possession Date</label>
                                <span class="input-icon icon-right">
                                    <input class="form-control" type="text" ng-model="enquiryData.sub_block_id" name="sub_block_id">
                                    <i class="fa fa-calendar"></i>

                                </span>
                            </div> 
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Interested In</label>
                                <div class="radio" style="margin-top: 0px;">
                                    <label>
                                        <input type="radio" class="inverted" ng-model="enquiryData.property_possession_type" name="property_possession_type">
                                        <span class="text">Ready Possession </span>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="inverted" checked="checked" ng-model="enquiryData.property_possession_type" name="property_possession_type">
                                        <span class="text">Under Construction</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre3">Prev</button>
                            <button type="button" class="btn btn-primary btn-nxt3">Finish</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $(".btn-nxt1").mouseup(function (e) {
            if ($(".step1").hasClass("ng-active")) {
                e.preventDefault();
            } else {
                $("#wiredstep1").hide();
                $("#wiredstep2").show();
                $(".wiredstep2").addClass("active");
                $(".wiredstep1").removeClass("active");
                $(".wiredstep1").addClass("complete");
            }
        });
        $(".btn-nxt2").click(function (e) {
            if ($(".step2").hasClass("ng-active")) {
                e.preventDefault();
            } else {
                $("#wiredstep2").hide();
                $("#wiredstep3").show();
                $(".wiredstep3").addClass("active");
                $(".wiredstep2").removeClass("active");
                $(".wiredstep2").addClass("complete");
            }
        });
        $(".btn-submit-last").click(function (e) {
            if ($(".step5").hasClass("ng-active")) {
                e.preventDefault();
            }
        });
        $(".btn-pre2").click(function () {
            $("#wiredstep1").show();
            $("#wiredstep2").hide();
            $(".wiredstep1").addClass("active");
            $(".wiredstep2").removeClass("active");
            $(".wiredstep1").removeClass("complete");
        });
        $(".btn-pre3").click(function () {
            $("#wiredstep2").show();
            $("#wiredstep3").hide();
            $(".wiredstep2").addClass("active");
            $(".wiredstep3").removeClass("active");
            $(".wiredstep2").removeClass("complete");
        });
    });

</script>