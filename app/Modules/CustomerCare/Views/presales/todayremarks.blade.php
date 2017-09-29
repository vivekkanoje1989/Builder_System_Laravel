<style>
    .toggleClassActive{
        font-size: 40px !important;
        cursor: pointer;
        color: #5cb85c !important;
        vertical-align: middle;
        margin-left: 5px;
    }
    .imgcls{
        width:40px;
        border-radius: 50%;
        -webkit-filter: drop-shadow(0 0 3px #00415d);
        filter: drop-shadow(0 0 0 2px #00415d);
    }
    .ta-editor.form-control.myform1-height, .ta-scroll-window.form-control.myform1-height  {
        min-height: 100px;
        height: auto;
        overflow: auto;
        font-family: inherit;
        font-size: 100%;
    }

    .form-control.myform1-height > .ta-bind {
        height: auto;
        min-height: 100px;
        padding: 6px 12px;
    }

    .timeline-unit:before, .timeline-unit:after {
        top: 0;
        border: solid transparent;
        border-width: 1.35em;
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }

    .timeline-unit:after {
        content: " ";
        left: 100%;
        border-left-color: #77b3d4; /*blue*/
    }

    .timeline-unit {
        margin-right: 25px;
        position: relative;
        display: inline-block;
        background: #77b3d4;/*grey*/
        padding: 1em;
        line-height: 0.65em;
        color: #000;
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
        color: #000; /*EEE*/
        font-size: 15px;
        display: inline-block;
        border: 3px solid;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        margin: 5px;
        width:100%;
    }
    
    #divMyTags div.existingTag p {
        color: black;
    }
    
    .csspadding{
        padding: 15px 15px 0px 15px;
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
    /*******************REMARK FOOTER**********************/

    #wrapper {
        position: fixed;
        width: 100%;
        margin: 0 auto;
        padding: 0;
        clear: both;
        float: none;
        height: 100%;
        border-bottom: 1px solid #000;
    }
    #clickme {
        cursor: pointer;
    }

    #onlinehulp {
        bottom: 0;
        color: #fff;
        height: 30px;
        margin: 0 auto;
        position: absolute;
        right: 0;
        width: 180px;
    }

    #contact-online {
        background: #FFF none repeat scroll 0 0;
        display: none;
        margin-top: -13px;
        box-shadow: 0px 0px 10px #888888;
        height:224px;
        border-radius: 0;
    }
    
    .ui-select-toggle{
        background-color: #fff !important;
    }
    
    /*******************Company**********************/
    .companyField{
        padding: 0px 0px;
        margin: 0px 0px 5px;
        max-height: 100px;
        overflow-y: scroll;
        position: absolute;
        /*width: 93%;*/
        width: 89%;
        z-index: 999;
        border:1px solid #b1acac;
        border-top: none;
    }
    .companyField li{
        padding: 10px;
        color: #5a5a5a;
        list-style:none;
        background:#f8f8f8; 
        cursor: pointer;
    }
    .companyField :hover{
        background: #ccc;
        color:#fff;
    }
    
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <tabset>
                <tab heading="Today`s Remarks" id="remarkTab">
                    <form name="remarkForm" novalidate ng-submit="remarkForm.$valid && insertCcPreSalesTodayRemark(remarkData)">
                        <input type="hidden" ng-model="remarkData.enquiryId" name="enquiryId" id="enquiryId" value="{{remarkData.enquiryId}}">
                        <input type="hidden" ng-model="remarkData.customerId" name="customerId" id="custId" value="{{remarkData.customerId}}">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <span ng-show="custInfo"><b style="font-size: 17px;">{{remarkData.title}} {{remarkData.customer_fname}} {{remarkData.customer_lname}}</b></span>  	
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span ng-if="contact_permission == 1" ng-controller="outboundCallController">
                                            <span ng-if="mobileList" ng-repeat="mlist in mobileList track by $index" style="float: left;margin: 7px 20px 0px 0px;">  
                                                <a style="cursor: pointer;" class="Linkhref" ng-click="cloudCallingLog(5,{{login_user_id}},{{ remarkData.enquiryId}},{{remarkData.customerId}},{{$index}})">
                                                    <img src="/images/call.png" title="Click on call icon to make a call" class="hi-icon-effect-8 psdn_session" style="height: 17px;width: 17px;" />
                                                </a>
                                                <span class="text">{{mlist}}</span>
                                            </span>
                                        </span>
                                        <span ng-if="contact_permission == 0">
                                            <span ng-if="mobileList" ng-repeat="mlist in mobileList track by $index" style="float: left;margin: 7px 20px 0px 0px;">    
                                                +91-xxxxxx{{  mlist.substring(mlist.length - 4, mlist.length)}}
                                            </span>
                                        </span>
                                    </div>    
                                    <div class="col-sm-12" ng-if="email_permission ">
                                        <span ng-if="emailList != 'null'" ng-repeat="elist in emailList track by $index" style="float: left;  margin: 7px 20px 5px 0px;">    
                                            <span class="text">{{elist}}</span>
                                        </span>
                                    </div>                    
                                    
                                </div>
                            </div>                            
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <strong ng-if="customer_address">Address:</strong> <span> {{customer_address}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Source: </strong><span ng-bind-html="sourceDetails"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6"></div>                            
                        </div>
                        <br/>
                        <div class="row" ng-controller="ccpresalesStatusCtrl">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Followup Status<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="remarkData.cc_presales_status_id" name="cc_presales_status_id" ng-change="onccpreSalesStatusChange(remarkData.cc_presales_status_id)" required>
                                            <option value="">Select Status</option>
                                            <option ng-repeat="list in ccpresalesstatus" value="{{list.id}}" ng-selected="{{ list.id == remarkData.cc_presales_status_id}}">{{list.cc_presales_status}}</option>          
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="sbtBtn" ng-messages="remarkForm.cc_presales_status_id.$error" class="help-block">
                                            <div ng-message="required">Please Select Status</div>
                                        </div>
                                    </span> 
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Followup Sub Status<span class="sp-err" ng-if="ccpresalessubStatusList.length != 0">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="remarkData.cc_presales_substatus_id" name="cc_presales_substatus_id" id="cc_presales_substatus_id" ng-required="ccpresalessubStatusList.length != 0">
                                            <option value="">Select Sub Status</option>
                                            <option ng-repeat="list in ccpresalessubStatusList" value="{{list.id}}" ng-selected="{{ list.id == remarkData.cc_presales_substatus_id}}">({{list.listing_position}}) {{list.cc_presales_substatus}}</option>          
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="sbtBtn" ng-messages="remarkForm.cc_presales_substatus_id.$error" class="help-block" ng-if="ccpresalessubStatusList.length != 0">
                                            <div ng-message="required">Please Select Substatus</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="remarkData.cc_presales_status_id !=2" ng-controller="ccpresalesCategoryCtrl">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Followup Category<span class="sp-err">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="remarkData.cc_presales_category_id" name="cc_presales_category_id" id="cc_presales_category_id" ng-change="onccpresalesCategoryChange(remarkData.cc_presales_category_id)" required>
                                            <option value="">Select Category</option>
                                            <option ng-repeat="list in ccpresalescategory" value="{{list.id}}" ng-selected="{{ list.id == remarkData.cc_presales_category_id}}">{{list.cc_presales_category}}</option>          
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="sbtBtn" ng-messages="remarkForm.cc_presales_category_id.$error" class="help-block">
                                            <div ng-message="required">Please select category</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Followup Sub Category<span class="sp-err" ng-if="ccpresalesSubCategoriesList.length != 0">*</span></label>
                                    <span class="input-icon icon-right">
                                        <select class="form-control" ng-model="remarkData.cc_presales_subcategory_id" name="cc_presales_subcategory_id" id="cc_presales_subcategory_id" ng-required="salesSubCategoriesList.length != 0">
                                            <option value="">Select Sub Category</option>
                                            <option ng-repeat="list in ccpresalesSubCategoriesList" value="{{list.id}}" ng-selected="{{ list.id == remarkData.cc_presales_subcategory_id}}">({{list.listing_position}}) {{list.cc_presales_subcategory}}</option>
                                        </select>
                                        <i class="fa fa-sort-desc"></i>
                                        <div ng-show="sbtBtn" ng-messages="remarkForm.cc_presales_subcategory_id.$error" class="help-block" ng-if="ccpresalesSubCategoriesList.length != 0">
                                            <div ng-message="required">Please Select Sub category</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>                        
                        <div class="row" ng-if="remarkData.cc_presales_status_id !=2">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Next Followup Date & Time<span class="sp-err">*</span></label>
                                    
                                    <div ng-controller="DatepickerDemoCtrl" class="form-group">
                                        <p class="input-group">
                                            <input type="text" ng-model="remarkData.next_followup_date" name="next_followup_date" class="form-control" ng-change="todayremarkTimeChange(remarkData.next_followup_date)" datepicker-popup="dd-MM-yyyy" is-open="opened" min-date="minDate" datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly required />
                                            <span class="input-group-btn" >
                                                <button type="button" class="btn btn-default" ng-click="!disableDataOnEnqUpdate && open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                            </span>
                                        <div ng-show="sbtBtn" ng-messages="remarkForm.next_followup_date.$error" class="help-block">
                                            <div ng-message="required">Please select followup date</div>
                                        </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-2" >
                                <label for="">&nbsp;</label>
                                    <select ng-model="remarkData.next_followup_time" name="next_followup_time" class="form-control" required>
                                        <!--<option value="">--  Time  --</option>-->
                                        <option ng-repeat="time in timeList" value="{{time.value}}" ng-selected="{{time.value == remarkData.next_followup_time}}">{{time.label}}</option>
                                    </select>
                                    <div  ng-show="sbtBtn" ng-messages="remarkForm.next_followup_time.$error" class="help-block">
                                        <div ng-message="required" >This field is required</div>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        <div class="row mod-sh-div" >
                                            <div class="col-sm-12">
                                                <div id="divMyTags"><br>
                                                    <label for="" >Today's Remarks</label>
                                                    
                                                    <div class="existingTag bordered-themeprimary">
                                                        <div class="col-sm-12 csspadding">
                                                            <div class="form-group">
                                                                <span class="input-icon icon-right">
                                                                    <textarea class="form-control" rows="5" cols="50" ng-model="remarkData.textRemark" name="textRemark" capitalization required></textarea>
                                                                </span>
                                                                <div ng-show="sbtBtn" ng-messages="remarkForm.textRemark.$error" class="help-block">
                                                                    <div ng-message="required">Please enter remark</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div> 
                                                    <div class="col-sm-12">                       
                                                    <div class="col-sm-6">
                                                        <button type="submit" ng-disabled="btn_todayremark_disable" class="btn btn-primary custom-btn" ng-click="sbtBtn = true;">Submit</button>
                                                    </div> 
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </form>
                </tab>
                <tab heading="Followup History">
                    <div>
                        <label>
                            <input type="checkbox" name="chk_today_remark_history" ng-click="getModulesWiseHistory_Today(history_enquiryId,1)"  id="chk_today_remark_history">
                            <span class="text">All</span>
                        </label>
                        &nbsp;&nbsp;                       
                        <label>
                            <input type="checkbox"  ng-click="getModulesWiseHistory_Today(history_enquiryId,0)" data-id="1" class="chk_today_remark_history_all" id="chk_today_remrk_presales">
                            <span class="text">Pre Sales</span>
                        </label>
                         &nbsp;&nbsp;
                        <label>
                            <input type="checkbox"  ng-click="getModulesWiseHistory_Today(history_enquiryId,0)" data-id="2"  class="chk_today_remark_history_all" id="chk_today_remrk_Customer_Care">
                            <span class="text">Customer Care</span>
                        </label>
                        <hr class="enq-hr-line">

                            1) <span>PS = Pre Sales</span> &nbsp;&nbsp;2) <span>CC = Customer Care</span>

                        <hr class="enq-hr-line">    
                </div>
                <div style="height: auto;max-height: 605px;margin-top: 0px;    overflow-x: hidden;overflow-y: scroll;">
                    <table class="table table-hover table-striped table-bordered" at-config="config" >
                        <thead class="bord-bot">
                            <tr>
                                <th class="enq-table-th" style="width:3%">SR</th>
                                <th class="enq-table-th" style="width: 13%;">Follow-up By </th>
                                <th class="enq-table-th" style="width: 13%">Last</th>
                                <th class="enq-table-th" style="width: 13%">Next</th>
                                <th class="enq-table-th" style="width: 20%">Status</th>
                                <th class="enq-table-th" style="width: 38%">Remarks</th>
                            </tr>
                        </thead>
                        <tbody ng-if="historyList.length > 0" ng-repeat="history in historyList track by $index | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <tr role="row" >
                                <td style="width:4%" rowspan="2">{{ $index+1}}</td>
                                <td style="width: 10%;">{{ history.first_name }} <br/> {{ history.last_name }}
                                    <span>
                                        <b>({{history.short_name}})</b>
                                    </span>
                                </td>
                                <td style="width: 10%">{{ history.last_followup_date | split:'@':0}}<br/> @ {{ history.last_followup_date | split:'@':1 }}</td>
                                <td style="width: 10%">{{ history.next_followup_date }}<br/> @ {{ history.next_followup_time }}</td>
                                <td style="width: 8%">
                                    <div ng-if="history.cc_presales_status !=''">
                                        {{history.cc_presales_status}} <span ng-if="history.cc_presales_substatus != null ">/<br/></span>
                                        {{history.cc_presales_substatus}}
                                    </div>
                                    <div ng-if="history.sales_status !=''">
                                            {{history.sales_status}} <span ng-if="history.enquiry_sales_substatus != null ">/<br/></span>
                                            {{history.enquiry_sales_substatus}}
                                    </div>
                                </td>
                                
                                <td style="width: 16%">
                                    <span data-toggle="tooltip" title="{{history.remarks | removeHTMLTags}}">{{history.remarks | removeHTMLTags | limitTo : 150 }} </span>  
                                    <span ng-if="history.remarks.length  > 150" data-toggle="tooltip" title="{{history.remarks | removeHTMLTags}}">...</span>
                                </td>
                            </tr>
                            <tr ng-if="history.call_recording_url !='' &&  history.call_recording_url !='None'">
                                <td colspan="7">
                                    <audio id="recording_today_remark_1_{{ history.id }}" style="width: 500px;" controls></audio>
                                </td>
                            </tr>
                        </tbody>
                        <tr ng-if="historyList.length == 0" align="center"><td colspan="6"> Records Not Found</td></tr>
                    </table>
                </div>
                </tab>
            </tabset>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){ 
        $("a#gotoCustomerTab").on("click",function(){
            alert("hi");
            $("li#remarkTab").removeClass('active');
            $("li#customerTab").addClass('active');
            $("li#customerTab a").trigger('click');
        });
        
        $(".modal-footer").hide();
        $( "#clickme" ).click(function() {
            $( "#contact-online" ).slideToggle( "slow");
            if($(this).hasClass('hide')){
                $('#onlinehulp').animate({bottom: '0px'}, 'slow');
                $(this).removeClass('hide').addClass('show');
            } else {
                $('#onlinehulp').animate({bottom: '218px'}, 'slow');
                $(this).removeClass('show').addClass('hide');
            }
        });
        $("#mobile_calling_code1").intlTelInput();
    });
</script>