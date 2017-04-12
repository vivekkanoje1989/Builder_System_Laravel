<form name="enquiryForm" novalidate >
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
                                        <input type="text" ng-model="customerData.sales_enquiry_date" name="sales_enquiry_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required />
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
                                    <select class="form-control">
                                        <option value="">Select Title</option>                                       
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="">Block <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <textarea class="form-control"></textarea>
                                    <i class="fa fa-info"></i>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="">Block Details <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <textarea class="form-control"></textarea>
                                    <i class="fa fa-info"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-nxt1">Next</button>
                        </div>
                    </div>
                </div>	
                <div class="step-pane" id="wiredstep2">	
                    <div class="form-title">Requirement Details</div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Parking Required <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control">
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
                                    <select class="form-control">
                                        <option value="">Common Parking</option>                                       
                                        <option value="">Private Parking</option>                                       
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Covered <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control">
                                        <option value="">Covered</option>                                       
                                        <option value="">Uncovered</option>                                       
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">No of 2 wheeler parking</label>
                                <span class="input-icon icon-right">
                                    <input class="form-control" type="text">
                                    <i class="fa fa-motorcycle"></i>
                                </span>
                            </div>
                        </div>                    
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Loan Required <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control">
                                        <option value="">Covered</option>                                       
                                        <option value="">Uncovered</option>                                       
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Loan Form</label>
                                <span class="input-icon icon-right">
                                    <input class="form-control" type="text">
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div> 
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Loan account with any bank</label>
                                <span class="input-icon icon-right">
                                    <input class="form-control" type="text">
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div> 
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Bank Name</label>
                                <span class="input-icon icon-right">
                                    <input class="form-control" type="text">
                                    <i class="fa fa-newspaper-o"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Loan Account Number</label>
                                <span class="input-icon icon-right">
                                    <input class="form-control" type="text">
                                    <i class="fa fa-money"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Further action taken for loan</label>
                                <span class="input-icon icon-right">
                                    <textarea class="form-control"></textarea>
                                    <i class="fa fa-bullseye"></i>

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
                                    <select class="form-control">
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
                                    <textarea class="form-control"></textarea>
                                    <i class="fa fa-map-marker"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Tentative Possession Date</label>
                                <span class="input-icon icon-right">
                                    <input class="form-control" type="text">
                                    <i class="fa fa-calendar"></i>

                                </span>
                            </div> 
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Interested In</label>
                                <div class="checkbox" style="margin-top: 0px;">
                                    <label>
                                        <input type="checkbox" class="inverted" checked="checked">
                                        <span class="text">Ready Possession </span>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="inverted" checked="checked">
                                        <span class="text">Under Construction</span>
                                    </label>
                                </div>
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
                    <div class="form-title">Other Details</div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Enquiry Category <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control">
                                        <option value="">Hot</option>                                       
                                        <option value="">Warm</option>          
                                        <option value="">Cold</option>          
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Enquiry Source <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control">
                                        <option value="">Source 1</option>                                       
                                        <option value="">Source 2</option>                                       
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Other Requirements</label>
                                <span class="input-icon icon-right">
                                    <textarea class="form-control"></textarea>
                                    <i class="fa fa-bullseye"></i>
                                </span>
                            </div>               
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Remarks</label>
                                <span class="input-icon icon-right">
                                    <textarea class="form-control"></textarea>
                                    <i class="fa fa-bullseye"></i>

                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Next Followup Date <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">                                    
                                    <i class="fa fa-calendar"></i>                                   
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Next Followup Time <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">      
                                    <i class="fa fa-clock-o"></i>                                   
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label for="">Enter colleague name to reassign enquiry <span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control">      
                                    <i class="fa fa-sign-in"></i>                                   
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre3">Prev</button>
                            <button type="button" class="btn btn-primary btn-nxt3">Next</button>
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
        $(".btn-nxt3").click(function (e) {
            if ($(".step3").hasClass("ng-active")) {
                e.preventDefault();
            } else {
                $("#wiredstep3").hide();
                $("#wiredstep4").show();
                $(".wiredstep4").addClass("active");
                $(".wiredstep3").removeClass("active");
                $(".wiredstep3").addClass("complete");
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