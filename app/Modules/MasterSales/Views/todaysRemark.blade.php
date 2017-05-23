<style>
.timeline-unit:before, .timeline-unit:after {
    top: 0;
    border: solid transparent;
    border-width: 1.65em;
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}

.timeline-unit:after {
    content: " ";
    left: 100%;
    border-left-color: rgba(51, 51, 51, 0.8);
}

.timeline-unit {
    margin-right: 25px;
    position: relative;
    display: inline-block;
    background: rgba(51,51,51,.8);
    padding: 1em;
    line-height: 1.25em;
    color: #FFF;
    
    -webkit-filter: drop-shadow(0 0 2px black);
            filter: drop-shadow(0 0 0 2px black);
}

.btn-send-sms{
    float: right;
    margin:5px;
}
#divMyTags
{
    /*text-align: center;*/
}
#divMyTags div.existingTag
{
    position: relative;
    color: #EEE;
    font-size: 15px;
    display: inline-block;
    border: 2px solid #324566;
    border-radius: 4px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    background-color: #283957;
    padding: 8px;
    margin: 5px;
    width:100%;
}
.closeButton
{
    display:block;
    position:absolute;
    top:-10px;
    right:-10px;
    width:27px;
    height:27px;
    background:url('http://cdn-sg1.pgimgs.com/images/pg/close-button.png') no-repeat center center;
}
</style>
<div class="modal fade" id="todaysRemarkModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Todays Remark</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!--<div class="row">-->
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <tabset justified="true">
                                <tab heading="Todays Remark">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">Title</label>
                                                <span class="input-icon icon-right">
                                                    <select ng-model="remarkData.title_id" name="title_id" class="form-control">
                                                        <option value="">Select Title</option>
                                                        <option value="1">Mr.</option>
                                                        <option value="2">Mrs.</option>
                                                        <option value="3">Miss.</option>
                                                        <option value="4">Dr.</option>
                                                    </select>
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">First Name</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="remarkData.first_name" name="first_name" class="form-control">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Last Name</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="remarkData.last_name" name="last_name" class="form-control">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Enquiry Category</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="remarkData.first_name" name="first_name" class="form-control">
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Enquiry Status</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="remarkData.first_name" name="first_name" class="form-control">
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Reassign to</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="remarkData.first_name" name="first_name" class="form-control">
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Conversation held regarding project</label>
                                                <span class="input-icon icon-right">
                                                    <input type="text" ng-model="remarkData.first_name" name="first_name" class="form-control">
                                                    <i class="fa fa-sort-desc"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Next Followup Date & Time<span class="sp-err">*</span></label>
                                                <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                                    <p class="input-group">
                                                        <input type="text" ng-model="remarkData.next_followup_date" name="next_followup_date" class="form-control" datepicker-popup="{{format}}" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required />
                                                        <span class="input-group-btn" >
                                                            <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    <div ng-show="enqFormBtn" ng-messages="enquiryForm.next_followup_date.$error" class="help-block enqFormBtn">
                                                        <div ng-message="required">Please select followup date</div>
                                                    </div>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-6">  
                                            <div class="form-group">
                                                <div ng-controller="TimepickerDemoCtrl">
                                                    <timepicker ng-model="remarkData.next_followup_time" ng-change="changed()" hour-step="hstep" format="HH:mm" minute-step="mstep" show-meridian="ismeridian" value="{{ remarkData.next_followup_time | date:'HH:mm:ss' }}" style="margin: -1.5% 0 0 -5%;" id="timepicker"></timepicker>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="timeline-unit"> Remark through </div>
                                            <a href ng-click="sms()"><img src="/images/sms.png" tooltip-html-unsafe="Send SMS"/></a><span>&nbsp; OR &nbsp;</span>
                                            <a href ng-click="email()"><img src="/images/email.png" tooltip-html-unsafe="Send Email"/></a><span>&nbsp; OR &nbsp;</span>
                                            <a href ng-click="text()"><img src="/images/text.png" tooltip-html-unsafe="Enter Text"/></a>
                                        </div>
                                    </div>
                                    <div class="row" ng-show="divSms">
                                        <div class="col-sm-12"><br/>
                                            <div id="divMyTags">
                                                <div class="existingTag">   
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Select mobile number <span class="sp-err">*</span></label>
                                                            <div class="control-group">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input name="mobile_number" type="radio" ng-model="remarkData.mobile_number" checked="true" value="1" class="colored-success">
                                                                        <span class="text">9898989898</span>
                                                                    </label>&nbsp;&nbsp;
                                                                    <label>
                                                                        <input name="mobile_number" type="radio" ng-model="remarkData.mobile_number" value="0" class="colored-success">
                                                                        <span class="text">8889998889</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Remark <span class="sp-err">*</span></label>
                                                            <span class="input-icon icon-right">
                                                                <textarea class="form-control" rows="4" ng-model="remarkData.remark" name="remark"></textarea>
                                                                <i class="fa fa-file-text"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                                                                      
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary btn-send-sms">Set Reminder SMS</button>
                                            <button class="btn btn-primary btn-send-sms">Send SMS</button>
                                            <button class="btn btn-primary btn-send-sms">Call</button>
                                        </div>  
                                    </div>
                                    <div class="row" ng-show="divEmail">
                                        <div class="col-sm-12">
                                            <div id="divMyTags">
                                                <div class="existingTag">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="">Subject</label>
                                                                <span class="input-icon icon-right">
                                                                    <input type="text" ng-model="remarkData.subject" name="subject" class="form-control">
                                                                    <i class="fa fa-envelope"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="">Mail Content</label>
                                                                <span class="input-icon icon-right">
                                                                    <div class="widget flat radius-bordered">
                                                                        <div class="widget-body no-padding">   
                                                                            <div class="form-group">
                                                                                <div text-angular name="blog_description" capitalizeFirst ng-model="blog_description" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text" required></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary btn-send-sms">Submit</button>
                                        </div> 
                                    </div>
                                    <div class="row" ng-show="divText">
                                        <div class="col-sm-12">
                                            <div id="divMyTags">
                                                <div class="existingTag">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Remark <span class="sp-err">*</span></label>
                                                            <span class="input-icon icon-right">
                                                                <textarea class="form-control" rows="4" ng-model="remarkData.remark" name="remark"></textarea>
                                                                <i class="fa fa-file-text"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary btn-send-sms">Submit</button>
                                        </div>
                                    </div>
                                </tab>
                                <tab heading="Upcoming scheduled SMS / Emails">
                                    <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.</p>
                                </tab>
                            </tabset>
                        </div>
                    <!--</div>-->  
                    
                </div>
            </div>
        </div>
    </div>
</div>