<style>
    .alert.alert-info {
        border-color: 1px solid #d9d9d9;
        background-color: #f5f5f5;
        border: 1px solid #d9d9d9;
        color: black;
        padding: 5px;
    }
</style>
<?php $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true); ?>
<div class="row" ng-controller="customercarepresalesController" ng-init="pending('', [[$type]], 1, [[config('global.recordsPerPage')]],2)" >
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">{{pagetitle}}</span>
              <span data-toggle="modal" data-target="#help" class="helpDescription">Help <i class="fa fa-question-circle" aria-hidden="true"></i></span>
             </div>
            <div class="widget-body table-responsive">
                 <div class="row table-toolbar">      
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" data-target="#showFilterModal"  ng-hide="disableBtn" ng-click="procName('proc_cc_presales_pending',2)"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div  class="dataTables_filter">                        
                        <label>
                            <input type="search" class="form-control input-sm" ng-model="search" name="search"  ng-disabled="disableBtn" >
                        </label>
                    </div>
                    <!--filter data--> 
                    <div class="row col-sm-12" style="border:2px;" id="filter-show">
                        <b ng-repeat="(key, value) in showfilterData" ng-if="value != 0 && key != 'toDate' ">
                           <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_')) }}"> 
                                <div class="alert alert-info fade in" style="padding: 6px;">
                                   <button class="toggleForm close" ng-click=" removefilter('{{ key }}');" data-dismiss="alert"> ×</button>
                                   <strong ng-if="key === 'employee_id'"> Owners Name :- <span ng-repeat='emp in value track by $index'>{{ $index + 1}}){{   emp.first_name}}  {{ emp.last_name}}&nbsp;</span> </strong>
                                   <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="Enquiry Date"><strong>Enquiry Date:</strong>{{ showfilterData.fromDate | date:'dd-MMM-yyyy' }} <span ng-if="showfilterData.toDate!='' && showfilterData.toDate!= null ">To {{ showfilterData.toDate |date:'dd-MMM-yyyy' }}</span></strong>
                                   <strong ng-if="key == 'cc_presales_status_id'">Followup Status :- {{  value.substring(value.indexOf("_")+1) }}</strong>
                                   <strong ng-if="key == 'cc_presales_category_id'">Followup Category :- {{  value.substring(value.indexOf("_")+1) }}</strong>
                                   <strong ng-if="key === 'cc_presales_substatus_id'"> Followup Sub Status :- <span ng-repeat='subst in value track by $index'> {{ $index + 1}}){{   subst.cc_presales_substatus}}</span></strong>
                                   <strong ng-if="key === 'cc_presales_subcategory_id'"> Followup Sub Category :- <span ng-repeat='subcat in value track by $index'> {{ $index + 1}}){{   subcat.cc_presales_subcategory}}</span></strong>
                                   <strong ng-if="key == 'source_id'">Source :- {{  value.substring(value.indexOf("_")+1) }}</strong>
                                   <strong ng-if="key === 'subsource_id'"> Sub Source :- <span ng-repeat='subsouc in value track by $index'> {{ $index + 1}}){{   subsouc.enquiry_subsource}}</span></strong>
                                   <strong ng-if="key == 'project_id'">Project :- <span ng-repeat='proj in value track by $index'> {{ $index + 1}}){{   proj.project_name}}</span></strong>
                                   <strong ng-if="key == 'site_visit'">Site Visit :- Yes</strong>
                                   <strong ng-if="key == 'fname'">First Name :- {{  value }}</strong>
                                   <strong ng-if="key == 'lname'">Last Name :- {{  value }}</strong>
                                   <strong ng-if="key == 'mobileNumber'">Mobile Number :- {{  value }}</strong>
                                   <strong ng-if="key == 'emailId'">Email Id :- {{  value }}</strong>
                                   <strong ng-if="key == 'verifiedMobNo'">Verified Mobile Number :- {{  value === true ? " Yes " : "No" }}</strong>
                                   <strong ng-if="key == 'verifiedEmailId'">Verified Email Id :- {{  value === true ? " Yes " : "No" }}</strong>                                   
                               </div>
                           </div>
                       </b>   
                    </div> 
                    <!--filter data-->
                    <div>
                         <span class='ShowingLength' ng-if="enquiriesLength != 0 " >&nbsp; &nbsp; &nbsp; Showing {{enquiries.length}}  Enquiries Out Of Total {{enquiriesLength}} Enquiries.  &nbsp;</span>
                       </div>
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control"  ng-disabled="disableBtn" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                                <option value="30">30</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>
                                <option value="500">500</option>
                                <option value="600">600</option>
                                <option value="700">700</option>
                                <option value="800">800</option>
                                <option value="900">900</option>
                                <option value="999">999</option>
                            </select>
                        </label>
                    </div>
                    <table class="table table-hover table-striped table-bordered tableHeader" >
                        <thead>
                            <tr>
                                <th class="enq-table-th">SR</th>
                                <th class="enq-table-th">Customer</th>
                                <th class="enq-table-th">Enquiry</th>
                                <th class="enq-table-th">History</th>
                                <th class="enq-table-th">Next</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr dir-paginate="enquiry in  enquiries | filter:search  | itemsPerPage: itemsPerPage | orderBy:orderByField:reverseSort" total-items="{{ enquiriesLength}}">
                                <td width="6%" style="vertical-align:middle">
                                    <center>
                                        {{itemsPerPage * (pageNumber - 1) + $index + 1}}<br>                              
                                    </center>
                                </td>
                                <td width="20%">
                                <div>{{enquiry.customer_title}} {{ enquiry.customer_fname}} {{ enquiry.customer_lname}}</div>
                                <?php if (in_array('01602', $array)) { ?>
                                <div ng-controller="outboundCallController" ng-if="enquiry.mobile !=''" ng-init="mobile_list=enquiry.mobile.split(',')">  
                                    <span ng-repeat="mobile_obj in mobile_list | limitTo:2">
                                        <?php if (in_array('01605', $array)) { ?>
                                            <a style="cursor: pointer;" class="Linkhref"
                                                   ng-if="mobile_obj != null" 
                                                   ng-click="cloudCallingLog(5,<?php echo Auth::guard('admin')->user()->id; ?>,{{ enquiry.id}},'{{enquiry.customer_id}}','{{$index}}')">

                                                <img src="/images/call.png" title="Click on call icon to make a call" class="hi-icon-effect-8 psdn_session" style="height: 17px;width: 17px;" />
                                            </a>
                                        <?php } ?>
                                            {{ mobile_obj}}
                                    </span>
                                </div>
                               
                                <?php } else { ?>
                                <div ng-init="mobile_list=enquiry.mobile.split(',')">
                                    <p ng-if="enquiry.mobile !='' "> 
                                        <span ng-repeat="mobile_obj in mobile_list | limitTo:2">
                                            +91-xxxxxx{{  mobile_obj.substring(mobile_obj.length - 4, mobile_obj.length)}}
                                        </span>
                                    </p>
                                </div>
                                <?php } ?>
                                <?php if (in_array('01601', $array)) { ?>
                                <div>
                                    <p ng-if="enquiry.email != '' && enquiry.email != 'null'" ng-init="all_email_list=enquiry.email.split(',');" >
                                        
                                        <span ng-repeat="emailobj in all_email_list | limitTo:2">
                                                {{emailobj}}
                                                <span ng-if="$index == 0 && all_email_list.length >= 2">
                                                    /
                                                </span>
                                        </span>
                                        
                                    </p>
                                </div>
                                <?php } ?>
                                
                                <hr class="enq-hr-line">
                                <?php if ((in_array('01602', $array)) &&  (in_array('01601', $array))) { ?>
                                    <div class="floatLeft">
                                        <a target="_blank" href="#/customer/update/{{ enquiry.customer_id}}"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Customer Id ({{enquiry.customer_id}})</a>
                                        <hr class="enq-hr-line">
                                    </div>                    
                                <?php } ?>                      
                                
                                <div>
                                    <span ng-if="enquiry.sales_source_name != '' && enquiry.enquiry_sub_source != null "
                                          ng-init="sourceleng = enquiry.sales_source_name.length + enquiry.enquiry_sub_source.length; source = enquiry.sales_source_name +' / '+ enquiry.enquiry_sub_source ">
                                        <strong>Source : </strong>
                                        <span data-toggle="tooltip" title="{{source}}">{{source | limitTo : 45}} </span>
                                        <span ng-if="source.length  > 45" data-toggle="tooltip" title="{{source}}">...</span>
                                    </span>
                                    <span ng-if="enquiry.sales_source_name != '' && enquiry.enquiry_sub_source == null ">
                                        <strong>Source : </strong>
                                        <span data-toggle="tooltip" title="{{enquiry.sales_source_name}}">    {{enquiry.sales_source_name | limitTo : 45}} </span>
                                        <span ng-if="enquiry.sales_source_name.length  > 45" data-toggle="tooltip" title="{{enquiry.sales_source_name}}">...</span>
                                    </span>
                                </div>
                                <div ng-if="enquiry.area != '' &&  enquiry.area != null " >
                                    <hr class="enq-hr-line">
                                    <strong>Area : </strong>
                                    <span data-toggle="tooltip" title="{{enquiry.area}}">    {{enquiry.area | limitTo : 45}} </span>
                                    <span ng-if="enquiry.area  > 45" data-toggle="tooltip" title="{{enquiry.area}}">...</span>
                                </div>
                            </td>

                            <td width="20%">
                                <div>
                                        <span ng-if="enquiry.cc_presales_status != null && enquiry.cc_presales_substatus == null"> 
                                            <b>Status : </b>  
                                            <span data-toggle="tooltip" title="{{enquiry.cc_presales_status}}">{{ enquiry.cc_presales_status  | limitTo : 45 }}</span>
                                            <span ng-if="enquiry.cc_presales_status.length  > 45" data-toggle="tooltip" title="{{enquiry.cc_presales_status}}">...</span>
                                            <hr class="enq-hr-line">
                                        </span>
                                    
                                        <span ng-if="enquiry.cc_presales_status != null && enquiry.cc_presales_substatus != null" ng-init="enquiry_status_length = enquiry.cc_presales_status.length + enquiry.cc_presales_substatus.length; enquiry_status = enquiry.cc_presales_status +' / '+ enquiry.cc_presales_substatus "> 
                                                <b>Status : </b>  
                                                <span data-toggle="tooltip" title="{{enquiry_status}}">{{ enquiry_status  | limitTo : 45 }}</span>
                                                <span ng-if="enquiry_status_length > 45" data-toggle="tooltip" title="{{enquiry_status}}">...</span>
                                                <hr class="enq-hr-line">
                                        </span>
                                        <span ng-if="enquiry.cc_presales_status == null && enquiry.cc_presales_substatus == null"> 
                                            <b>Status : </b>  N/A
                                             <hr class="enq-hr-line">
                                        </span>    
                                    
                                </div>        
                                <div> 
                                    <span ng-if="enquiry.cc_presales_category != null && enquiry.cc_presales_subcategory == null" data-toggle="tooltip" title="{{enquiry.cc_presales_category}}">
                                        <b>Category : </b>  
                                        {{ enquiry.cc_presales_category  | limitTo : 45 }}
                                        <span ng-if="enquiry.cc_presales_category > 45" data-toggle="tooltip" title="{{enquiry.cc_presales_category}}">...</span>
                                         <hr class="enq-hr-line">
                                    </span>
                                    <span ng-if="enquiry.cc_presales_category != '' && enquiry.cc_presales_subcategory != null " data-toggle="tooltip" title="{{cc_presales_subcategory}}" ng-init="cc_presales_subcategory_length = enquiry.cc_presales_subcategory.length + enquiry.cc_presales_subcategory.length; cc_presales_subcategory = enquiry.cc_presales_category +' / '+ enquiry.cc_presales_subcategory ">
                                        <b>Category : </b>  
                                        {{ cc_presales_subcategory  | limitTo : 45 }}
                                        <span ng-if="cc_presales_subcategory_length  > 45" data-toggle="tooltip" title="{{cc_presales_subcategory}}">...</span>
                                        <hr class="enq-hr-line">
                                    </span>
                                    <span ng-if="enquiry.cc_presales_category == null && enquiry.cc_presales_subcategory == null" >
                                        <b>Category : </b>  N/A
                                         <hr class="enq-hr-line">
                                    </span>
                                
                                </div>
                                <div>                                   
                                    <span ng-if="enquiry.project_block_name != null && enquiry.project_block_name != ''" data-toggle="tooltip" title="{{enquiry.project_block_name}}">                                    
                                        <b>Project :</b>
                                        {{enquiry.project_block_name| limitTo : 45 }}
                                        <span ng-if="enquiry.project_block_name > 45" data-toggle="tooltip" title="{{enquiry.project_block_name}}">...</span>                                                                                                                 
                                    </span>                                   
                                </div>
                                
                            </td>
                            <td width="30%">
                                <div ng-if="enquiry.owner_fname != null"><b>Enquiry Owner :</b> {{enquiry.owner_fname}} {{enquiry.owner_lname}}</div>
                                <div ng-if="enquiry.owner_fname == null"><b>Enquiry Owner :</b> N/A</div>
                                <hr class="enq-hr-line">
                                <div>
                                    <b>Site Visit :</b> 
                                    <span ng-if="enquiry.site_visit == '0' ">No</span>
                                    <span ng-if="enquiry.site_visit == '1' ">Yes</span>                                    
                                </div>                                
                                <hr class="enq-hr-line">
                                <div ng-if="enquiry.last_followup_date !=null">
                                    <b>Last followup : </b>{{ enquiry.last_followup_date}}
                                </div>
                                <div ng-if="enquiry.last_followup_date == null">
                                    <b>Last followup : </b>N/A
                                </div>
                                <div>
                                        <b> <span ng-if="enquiry.followupby_fname != null">By {{enquiry.followupby_fname}} {{enquiry.followupby_lname}} : </span></b>
                                        <span data-toggle="tooltip" title="{{enquiry.remarks | removeHTMLTags}}">{{enquiry.remarks | limitTo : 100 | removeHTMLTags }}
                                            <span ng-if="enquiry.remarks.length  >100" data-toggle="tooltip" title="{{enquiry.remarks | removeHTMLTags}}">...</span>
                                        </span>
                                </div>
                                <hr class="enq-hr-line">
                                <div>
                                    <a href data-toggle="modal" data-target="#historyDataModal" ng-click="initerrorflag = false;initHistoryDataModal({{ enquiry.id}},{{initmoduelswisehisory}},1);"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View History</a>
                                </div>
                                
                            </td>
                            <td width="20%">
                                <div><b>Followup due : </b>
                                    <span ng-if="enquiry.next_followup_date !=null">   {{ enquiry.next_followup_date}} @ {{ enquiry.next_followup_time}}</span> 
                                    <span ng-if="enquiry.next_followup_date ==null"> N/A</span> 
                                </div>                            
                                <hr class="enq-hr-line">
                                <div>
                                    <a href data-toggle="modal" data-target="#todayremarkDataModal" ng-click="gettodayremarksEnquiry({{enquiry.id}})"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Todays Remarks</a><br/>
                                </div>

                            </td>                                
                            </tr>
                            <tr>
                                <td colspan="5"  ng-if="enquiriesLength == 0 ||(enquiries|filter:search).length == 0 " align="center">Followups Not Found</td>   
                            </tr>
                        </tbody>
                    </table>
                    <div class="DTTTFooter">
                        <div class="col-sm-6">
                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{pageNumber}}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                                <dir-pagination-controls class="pagination" on-page-change="pageChanged(newPageNumber,'pending','', [[$type]], newPageNumber, itemsPerPage)" max-size="5" direction-links="true" boundary-links="true" ng-if="enquiriesLength"></dir-pagination-controls>
                            </div>
                        </div>
                    </div>
                </div>
                </div>     
            
            <!-- Today history model =============================================================================-->
            <div class="modal fade modal-primary" id="historyDataModal" role="dialog" tabindex='-1'>
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header navbar-inner">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" align="center">Enquiry History</h4>
                        </div>
                        <div data-ng-include="'/customer-care/presales/history'"></div>
                        <div class="modal-footer" align="center">
                        </div>
                    </div>
                </div>
            </div>
            
            
             <!-- Today remark model =============================================================================-->
            <div class="modal fade modal-primary" id="todayremarkDataModal" role="dialog" tabindex='-1'>
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header navbar-inner">
                            <button type="button" class="close"  data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" align="center">Today Remarks</h4>
                        </div>
                        <div data-ng-include=" '/customer-care/presales/todayremarks'"></div>
                        <div class="modal-footer" align="center">
                        </div>
                    </div>
                </div>
            </div>
               
            </div>
        </div>
        <div data-ng-include="'/customer-care/presales/filter'"></div>
        <div class="modal fade" id="help" role="dialog" tabindex="-1" >    
        <div class="modal-dialog">
           
            <div class="modal-content helpModal" >
                <div class="modal-header helpModalHeader bordered-bottom bordered-themeprimary" >
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title" align="center">Task Priority Help Info</h4>
                </div>                
                <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="helpContent">Priority </label>
                                <span class="input-icon icon-right">                                    
                                    
                                </span>
                            </div>                            
                        </div>
                    </div>  
            </div>
        </div>
    </div>
    </div>    
