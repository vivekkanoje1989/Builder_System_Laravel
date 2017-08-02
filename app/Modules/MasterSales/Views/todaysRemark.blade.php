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
.custom-btn{
    float: right;
    margin:5px;
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
#divMyTags div.existingTag p {
    color: black;
}
.help-block{
    color: red;
}


.call-img{
    height:17px;width:17px;
    position: absolute;
}

.call-img:hover{
    height:22px;width:22px;
}


div#cover {
  background-color: lightblue;
  width: 90px;
  height: 30px;
  position: absolute;
  bottom: 0px;
  z-index: 10;
}
.slide {
  background-color: white;
  width: 90px;
  height: 30px;
  position: absolute;
  bottom: 30px;
  z-index: 5;
  transition: 1s ease bottom !important;
  display: block !important;
}
.slide.ng-hide {
  bottom: 0;
}
</style>

<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <form name="remarkForm" novalidate ng-submit="remarkForm.$valid && insertRemark(remarkData)">
                <input type="hidden" ng-model="remarkData.enquiryId" name="enquiryId" id="custId" value="{{searchData.customerId}}">
                <input type="hidden" ng-model="remarkData.Id" name="customerId" id="custId" value="{{searchData.customerId}}">
                <div class="row">
                    <div class="col-sm-6"  ng-show="custInfo">
                        <h4><b>{{remarkData.title}} {{remarkData.customer_fname}} {{remarkData.customer_lname}}</b></h4>   
                    </div>
                    <div class="col-md-6 col-xs-12" ng-show="editableCustInfo">
                        <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!remarkForm.title_id.$dirty && remarkForm.title_id.$invalid)}">
                                <label for="">Title</label>
                                <span class="input-icon icon-right">
                                    <select ng-model="remarkData.title_id" ng-controller="titleCtrl" name="title_id" class="form-control" ng-required="editableCustInfo">
                                        <option value="">Select Title</option>
                                        <option ng-repeat="t in titles track by $index" value="{{t.id}}" ng-selected="{{ t.id == remarkData.title_id}}">{{t.title}}</option>
                                    </select>
                                    <i class="fa fa-sort-desc"></i>
                                    <div ng-show="sbtBtn" ng-messages="remarkForm.title_id.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!remarkForm.first_name.$dirty && remarkForm.first_name.$invalid)}">
                                <label for="">First Name</label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="remarkData.first_name" name="first_name" class="form-control" ng-required="editableCustInfo">
                                    <i class="fa fa-user"></i>
                                    <div ng-show="sbtBtn" ng-messages="remarkForm.first_name.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" ng-class="{ 'has-error' : step1 && (!remarkForm.last_name.$dirty && remarkForm.last_name.$invalid)}">
                                <label for="">Last Name</label>
                                <span class="input-icon icon-right">
                                    <input type="text" ng-model="remarkData.last_name" name="last_name" class="form-control" ng-required="editableCustInfo">
                                    <i class="fa fa-user"></i>
                                    <div ng-show="sbtBtn" ng-messages="remarkForm.last_name.$error" class="help-block">
                                        <div ng-message="required">This field is required.</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>

                    </div>

                    <div class="col-sm-6">
                        <p ng-repeat="mlist in mobileList track by $index" style="float: left;  margin: 0;margin-right: 20px;">    
                           <img src="/images/call.png" title="Click on call icon to make a call" class="hi-icon-effect-8 psdn_session call-img">
                           <span class="text" style="margin-left: 23px;">{{mlist}}</span>
                        </p>
                    </div>
                </div>

                <div class="row" ng-controller="enquirySourceCtrl" ng-show="source">
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!remarkForm.last_name.$dirty && remarkForm.last_name.$invalid)}">
                            <label for="">Source</label>
                            <span class="input-icon icon-right">
                                <select ng-change="onEnquirySourceChange(remarkData.source_id)" class="form-control" ng-model="remarkData.source_id" name="source_id"  id="source_id" ng-required="source">
                                    <option value="">Select Source</option>
                                    <option ng-repeat="source in sourceList" value="{{source.id}}" ng-selected="{{source.id == customerData.source_id}}">{{source.sales_source_name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="formButton" ng-messages="remarkForm.source_id.$error" class="help-block errMsg">
                                    <div ng-message="required">Please select source</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group" ng-class="{ 'has-error' : step1 && (!remarkForm.last_name.$dirty && remarkForm.last_name.$invalid)}">
                            <label for="">Sub Source</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="remarkData.subsource_id" name="subsource_id" id="subsource_id" ng-required="source">
                                    <option value="">Select Sub Source</option>
                                    <option ng-repeat="subSource in subSourceList" value="{{subSource.id}}" ng-selected="{{subSource.id == customerData.subsource_id}}">{{subSource.sub_source}}</option>
                                </select>   
                                <i class="fa fa-sort-desc"></i>
                                <div ng-show="formButton" ng-messages="customerForm.source_description.$error" class="help-block errMsg">
                                    <div ng-message="required">Please enter source description</div>
                                </div>
                            </span>                                            
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Source Description</label>
                            <span class="input-icon icon-right">
                                <textarea type="text" ng-model="remarkData.source_description" name="source_description" class="form-control" ng-required="source"></textarea>
                                <i class="fa fa fa-align-left"></i>
                                <div ng-show="formButton" ng-messages="customerForm.source_description.$error" class="help-block errMsg">
                                    <div ng-message="required">Please enter source description</div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div> 
                <div class="row" ng-controller="salesEnqCategoryCtrl" >
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Enquiry Category</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="remarkData.sales_category_id" name="sales_category_id" id="sales_category_id" ng-click="getSubCategory(remarkData.sales_category_id)">                                  
                                    <option ng-repeat="list in salesEnqCategoryList" value="{{list.id}}" ng-selected="{{ list.id == remarkData.sales_category_id}}">{{list.enquiry_category}}</option>          
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Enquiry Sub Category</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="remarkData.sales_subcategory_id" name="sales_subcategory_id" id="sales_subcategory_id">
                                    <option value="">Select Sub Category</option>
                                    <option ng-repeat="list in salesEnqSubCategoryList" value="{{list.id}}">{{list.enquiry_sales_subcategory}}</option>          
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row" ng-controller="salesEnqStatusCtrl">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Enquiry Status</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="remarkData.sales_status_id" name="sales_status_id" ng-click="getSubStatus(remarkData.sales_status_id)">                                      
                                    <option ng-repeat="list in salesEnqStatusList" value="{{list.id}}" ng-selected="{{ list.id == remarkData.sales_status_id}}">{{list.sales_status}}</option>          
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Enquiry Sub Status</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="remarkData.sales_substatus_id" name="sales_substatus_id">       
                                    <option value="">Select Sub Status</option>
                                    <option ng-repeat="list in salesEnqSubStatusList" value="{{list.id}}">{{list.enquiry_sales_substatus}}</option>          
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>
                </div>                                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group multi-sel-div">
                            <label for="">Conversation held regarding project</label>	
                            <ui-select multiple name="project_id" ng-model="remarkData.project_id" id="project_id" theme="select2" ng-disabled="disabled" ng-change="checkProjectLength()">
                                <ui-select-match placeholder='Select project'>{{$item.project_name}}</ui-select-match>
                                <ui-select-choices repeat="plist in projectList | filter:$select.search">
                                    {{plist.project_name}} 
                                </ui-select-choices>
                            </ui-select>     
                            <div ng-if="!enquiryData.project_id"  ng-show="emptyProjectId" class="help-block {{ applyClassProject }}">
                                This field is required.
                            </div>                               
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group multi-sel-div">
                            <label for="">Blocks</label>	
                            <ui-select ng-change="checkBlockLength()" multiple ng-model="remarkData.block_id"  name="block_id" theme="select2" ng-disabled="disabled" ng-change="checkBlockLength()">
                                <ui-select-match placeholder='Select blocks'>{{$item.block_name}}</ui-select-match>
                                <ui-select-choices repeat="list in blockTypeList | filter:$select.search">
                                    {{list.block_name}} 
                                </ui-select-choices>
                            </ui-select>     
                            <div ng-if="!enquiryData.block_id"  ng-show="emptyBlockId" class="help-block {{ applyClassBlock}}">
                                This field is required.
                            </div>                               
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
                                <div ng-show="sbtBtn" ng-messages="remarkForm.next_followup_date.$error" class="help-block enqFormBtn">
                                    <div ng-message="required">Please select followup date</div>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">  
                        <div class="form-group">
                            <div ng-controller="TimepickerDemoCtrl">
                                <timepicker ng-model="remarkData.next_followup_time" ng-change="changed()" hour-step="hstep" format="HH:mm" minute-step="mstep" show-meridian="ismeridian" value="{{ remarkData.next_followup_time | date:'HH:mm:ss' }}" style="margin: -0.5% 0 0 -2%; position: fixed;" id="timepicker"></timepicker>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Reassign to</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-controller="getEmployeesCtrl" ng-model="remarkData.followup_by_employee_id" name="followup_by_employee_id">
                                    <option ng-repeat="list in employeeList" value="{{list.id}}">{{list.first_name}} {{list.last_name}}</option>                                              
                                </select>
                                <i class="fa fa-sort-desc"></i>
                            </span>
                        </div>
                    </div>                                    
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="timeline-unit"> Remark through </div>
                        <a href ng-click="text()"><img src="/images/text.png" tooltip-html-unsafe="Enter Remark"/></a><span>&nbsp; OR &nbsp;</span>
                        <a href ng-click="sms()"><img src="/images/sms.png" tooltip-html-unsafe="Send SMS"/></a><span ng-show="emailList.length > 0">&nbsp; OR &nbsp;</span>
                        <a href ng-click="email()" ng-show="emailList.length > 0"><img src="/images/email.png" tooltip-html-unsafe="Send Email"/></a>
                    </div>
                </div>
                <div class="row mod-sh-div" ng-show="divText">
                    <div class="col-sm-12">
                        <div id="divMyTags">
                            <div class="existingTag">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Remark <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <textarea class="form-control" rows="4" cols="50" ng-model="remarkData.textRemark" name="textRemark" ng-required="divText"></textarea>
                                            <i class="fa fa-file-text"></i>
                                        </span>
                                        <div ng-show="sbtBtn3" ng-messages="remarkForm.textRemark.$error" class="help-block">
                                            <div ng-message="required">Please enter remark</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary custom-btn" ng-click="[sbtBtn3=true,sbtBtn=true]">Submit</button>
                    </div>
                </div>

                <div class="row mod-sh-div" ng-show="divSms">
                    <div class="col-sm-12"><br/>
                        <div id="divMyTags">
                            <div class="existingTag">   
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Select mobile number <span class="sp-err">*</span></label>
                                        <div class="control-group">                                                            
                                            <div class="checkbox" ng-repeat="mlist in mobileList track by $index">
                                                <label>
                                                    <input type="checkbox" ng-model="mobile_number" ng-change="checkedMobileNo(mlist,$index)" value="{{mlist}}" id="mob_{{$index}}" class="clsMobile">
                                                    <span class="text">{{mlist}}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div><br/><br/>
                                    <div ng-show="sbtBtn1" ng-messages="remarkForm.mobile_number.$error" class="help-block">
                                        <div ng-message="required">Please select mobile number</div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="">Remark <span class="sp-err">*</span></label>
                                        <span class="input-icon icon-right">
                                            <textarea class="form-control" rows="4" ng-model="remarkData.msgRemark" name="msgRemark" ng-required="divSms"></textarea>
                                            <i class="fa fa-file-text"></i>
                                        </span>
                                        <div ng-show="sbtBtn1" ng-messages="remarkForm.msgRemark.$error" class="help-block">
                                            <div ng-message="required">Please enter remark</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary custom-btn">SMS Reminder History</button>
                        <button type="submit" class="btn btn-primary custom-btn" ng-click="[sbtBtn1=true,sbtBtn=true]">Set Reminder SMS</button>
                        <button type="submit" class="btn btn-primary custom-btn" ng-click="[sbtBtn1=true,sbtBtn=true]">Send SMS</button>
                        <button type="submit" class="btn btn-primary custom-btn" ng-click="[sbtBtn1=true,sbtBtn=true]">Call</button>
                    </div>  
                </div>

                <div class="row mod-sh-div" ng-show="divEmail">
                    <div class="col-sm-12">
                        <div id="divMyTags">
                            <div class="existingTag">
                                <div class="row">                                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Select email id<span class="sp-err">*</span></label>
                                            <div class="control-group">
                                                <div class="checkbox" ng-repeat="elist in emailList track by $index">
                                                    <label>
                                                        <input type="checkbox" ng-model="email_id" ng-change="checkedEmailId(elist,$index)" value="{{elist}}" id="email_{{$index}}" class="clsEmail">
                                                        <span class="text">{{elist}}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div ng-show="sbtBtn2" ng-messages="remarkForm.email_id.$error" class="help-block">
                                            <div ng-message="required">Please select email id</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Subject<span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="remarkData.subject" name="subject" class="form-control" ng-required="divEmail">
                                                <i class="fa fa-info" aria-hidden="true"></i>
                                            </span>
                                            <div ng-show="sbtBtn2" ng-messages="remarkForm.subject.$error" class="help-block">
                                                <div ng-message="required">Please enter subject</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">Mail Content<span class="sp-err">*</span></label>
                                            <span class="input-icon icon-right">
                                                <div class="widget flat radius-bordered" style="margin: 0 0 -15px 0 !important;">
                                                    <div class="widget-body no-padding">   
                                                        <div class="form-group">
                                                            <div text-angular name="email_content" capitalizeFirst ng-model="remarkData.email_content" ta-text-editor-class="editor-text" ta-html-editor-class="editor-text" ng-required="divEmail" style="height: 130px;"></div>
                                                        </div>                                                                        
                                                    </div>
                                                    <div ng-show="sbtBtn2" ng-messages="remarkForm.email_content.$error" class="help-block">
                                                        <div ng-message="required">Please enter email content</div>
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
                        <button type="submit" class="btn btn-primary custom-btn">Email Reminder History</button>
                        <button class="btn btn-primary custom-btn" ng-click="[sbtBtn2=true,sbtBtn=true]">Submit</button>
                    </div> 
                </div>                              
            </form>
        </div>
    </div>
</div>