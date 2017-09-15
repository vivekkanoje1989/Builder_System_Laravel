<style>   
    .close {
        color:black;

    }
    .alert.alert-info {
        border-color: 1px solid #d9d9d9;
        /* background: rgba(173, 181, 185, 0.81); */
        background-color: #f5f5f5;
        border: 1px solid #d9d9d9;
        color: black;
        padding: 5px;
    }
</style>
<div class="row" ng-controller="enquiryController" ng-init="getTotalEnquiries('', [[$type]], 1, 30, 4);">
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">{{pagetitle}}</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row">                    
                    <div class="col-sm-2 col-xs-12">
                        <div class="form-group">
                            <label for="search">Records per page:</label>
                            <input type="text" minlength="1" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width:45%;" class="form-control" ng-model="itemsPerPage">
                        </div>
                    </div>
                    <div class="col-md-5 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">                                                                
                                <button type="button" class="btn btn-primary btn-right toggleForm" style="margin-left: 5px;"  ng-click="procName('proc_get_total_enquiries')"><i class="btn-label fa fa-filter"></i>Show Filter</button>                                
                                <div ng-if="enquiriesLength != 0">
                                    <a href="" class="btn btn-primary btn-right" id="downloadExcel" download="{{fileUrl}}" ng-show="dnExcelSheet" style="margin-left: 5px;">
                                        <i class="btn-label fa fa-file-excel-o"></i>Download excel</a>
                                    <a href id="exportExcel" uploadfile class="btn btn-primary btn-right" ng-click="exportReport(enquiries)" ng-show="btnExport" style="margin-left: 5px;">
                                        <i class="btn-label fa fa-file-excel-o"></i>Export to Excel
                                    </a> 
                                </div>
                                <button  ng-model="BulkReasign" type="button" id="BulkReasign" class="btn btn-primary btn-right"  data-toggle="modal" data-target="#BulkModal" ng-click="initBulkModal();" ng-if="BulkReasign" >Reassign</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-5 col-xs-12" ng-if="enquiriesLength != 0">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <span ng-if="enquiriesLength != 0" >&nbsp; &nbsp; &nbsp; Showing {{enquiries.length}}  Enquiries Out Of Total {{enquiriesLength}} Enquiries.  &nbsp;</span>
                                <dir-pagination-controls max-size="5"  class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'getTotalEnquiries','', [[$type]],newPageNumber,listType)" template-url="/dirPagination" ng-if="enquiriesLength"></dir-pagination-controls>                            
                            </span>
                        </div>
                    </div>
                </div>                
                <div class="row" style="border:2px;" id="filter-show">
                    <b ng-repeat="(key, value) in showFilterData" ng-if="key != 'toDate'">                         
                        <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}" ng-if="value != ''">
                            <div class="alert alert-info fade in">
                                <button class="close toggleForm" ng-click=" removeDataFromFilter('{{ key}}');" data-dismiss="alert"> ×</button>
                                <strong ng-if="key === 'channel_id' || key === 'city_id' || key === 'category_id' || key === 'source_id' || key == 'status_id'"><strong>{{  key.substring(0, key.indexOf('_'))}} :</strong>{{  value.substring(value.indexOf("_") + 1)}}</strong>
                                <strong ng-if="key === 'employee_id'" ng-repeat='emp in value track by $index'> {{ $index + 1}}){{   emp.first_name}}  {{ emp.last_name}} </strong>
                                <strong ng-if="key === 'subcategory_id'" ng-repeat='subcat in value track by $index'> {{ $index + 1}}){{   subcat.enquiry_sales_subcategory}}</strong>
                                <strong ng-if="key === 'subsource_id'" ng-repeat='subsource in value track by $index'> {{ $index + 1}}){{ subsource.sub_source}} </strong>
                                <strong ng-if="key === 'substatus_id'" ng-repeat='substatus in value track by $index'>{{ $index + 1}}) {{ substatus.enquiry_sales_substatus}} </strong>
                                <strong ng-if="key === 'enquiry_locations'" ng-repeat='loc in value track by $index'>{{ $index + 1}}) {{ loc.location}} </strong>
                                <strong ng-if="key === 'project_id'" ng-repeat='project in value track by $index'>{{ $index + 1}}) {{ project.project_name}}</strong>
                                <strong ng-if="key === 'verifiedEmailId'"> <strong>Verified Email ID:</strong>Yes</strong>
                                <strong ng-if="key === 'verifiedMobNo'" data-toggle="tooltip" title="Verified Mobile Number"> <strong>Verified Mobile:</strong>Yes</strong>
                                <strong ng-if="key === 'site_visited'" data-toggle="tooltip" title="Site Visited"> <strong ng-if="value == 1">Site Visit:Yes</strong>
                                    <strong ng-if="value == 0">Site Visit:No</strong>
                                </strong>
                                <strong ng-if="key === 'loan_required'" data-toggle="tooltip" title="Loan Required"> <strong ng-if="value == 1">Loan Required:Yes</strong>
                                    <strong ng-if="value == 0">Loan Required:No</strong>
                                </strong>
                                <strong ng-if="key === 'parking_required'" data-toggle="tooltip" title="Parking Required"> <strong ng-if="value == 1">Parking Required:Yes</strong>
                                    <strong ng-if="value == 0">Parking Required:No</strong>
                                </strong>
                                <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="Enquiry Date"><strong>Enquiry Date:</strong>{{ showFilterData.fromDate | date:'dd-MMM-yyyy' }} To {{ showFilterData.toDate |date:'dd-MMM-yyyy' }}</strong>
                                <!--<strong ng-if="key != 'channel_id' && key != 'city_id' && key != 'project_id' && key != 'substatus_id' && key != 'subsource_id' && key != 'subcategory_id' && key != 'category_id' && key != 'fromDate' && key != 'toDate' && key != 'source_id' && key != 'employee_id' && key!='status_id' " data-toggle="tooltip" title="{{ key }}">{{ value}}</strong>-->
                                <strong ng-if="key == 'max_budget' || key == 'fname' || key == 'mobileNumber' || key == 'lname' || key == 'emailId'" data-toggle="tooltip" title="{{ key}}">{{ value}}</strong>
                            </div>
                        </div>
                    </b>                    
                </div>                             
                <table class="table table-hover table-striped table-bordered" ng-if="enquiriesLength">
                    <thead>
                        <tr>
                            <th class="enq-table-th">SR / 
                                <label>
                                    <input type="checkbox" ng-click='checkAll(all_chk_reassign[pageNumber])' ng-model="all_chk_reassign[pageNumber]" name="all_chk_reassign_enq" id="all_chk_reassign_enq">
                                    <span class="text"></span>
                                </label>
                            </th>
                            <th class="enq-table-th">Customer</th>
                            <th class="enq-table-th">Enquiry</th>
                            <th class="enq-table-th">History</th>
                            <th class="enq-table-th">Next</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr dir-paginate="enquiry in filtered=( enquiries | filter:search)  | itemsPerPage: itemsPerPage | orderBy:orderByField:reverseSort" total-items="{{ enquiriesLength}}">
                            <td width="6%" style="vertical-align:middle">
                                <center>
                                {{itemsPerPage * (pageNumber - 1) + $index + 1}}<br> 

                                <label> 
                                    <input type="checkbox" name="chk_reassign_enq" ng-click="singleSelect()" ng-model="enquiry.chk_reassign_enq"  value="{{enquiry.id}}" class="chk_reassign_enq form-control" id="chk_reassign_enq_{{enquiry.id}}">
                                    <span class="text"></span>
                                </label>                                
                            </center>
                            </td>
                            <td width="20%">
                                <div>{{enquiry.title}} {{ enquiry.customer_fname}} {{ enquiry.customer_lname}}</div>
                                <div ng-if="[[Auth::guard('admin')->user()->customer_contact_numbers]] == 1 && enquiry.mobile != ''" ng-init="mobile_list = enquiry.mobile.split(',')">  
                                    <span ng-repeat="mobile_obj in mobile_list| limitTo:2">
                                        <a style="cursor: pointer;" class="Linkhref"
                                           ng-if="mobile_obj != null" ng-click="cloudCallingLog(1, [[ Auth::guard('admin')->user()->id ]],{{ enquiry.id}},'{{enquiry.customer_id}}','{{$index}}')">
                                            <img src="/images/call.png" title="Click on call icon to make a call" class="hi-icon-effect-8 psdn_session" style="height: 17px;width: 17px;" />
                                        </a>
                                        {{ mobile_obj}}
                                    </span>
                                </div>
                                <div ng-init="mobile_list = enquiry.mobile.split(',')">
                                    <p ng-if="[[ Auth::guard('admin')->user()->customer_contact_numbers]] == 0 && enquiry.mobile != ''"> 
                                        <span ng-repeat="mobile_obj in mobile_list| limitTo:2">
                                            +91-xxxxxx{{  mobile_obj.substring(mobile_obj.length - 4, mobile_obj.length)}}
                                        </span>
                                    </p>
                                    <p ng-if="[[Auth::guard('admin')-> user()->customer_email]] == 1 && enquiry.email != '' && enquiry.email != 'null'" ng-init="all_email_list = enquiry.email.split(',');" >
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <span ng-repeat="emailobj in all_email_list| limitTo:2">
                                            {{emailobj}}
                                            <span ng-if="$index == 0 && all_email_list.length >= 2">
                                                /
                                            </span>

                                        </span>                                        
                                    </p>
                                </div>                               
                                <hr class="enq-hr-line">
                                <div>
                                    <a target="_blank" href="[[ config('global.backendUrl') ]]#/sales/update/cid/{{ enquiry.customer_id}}"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Customer Id ({{enquiry.customer_id}})</a>
                                </div>                    
                                <hr class="enq-hr-line">
                                <div>
                                    <br>
                                    <span ng-if="enquiry.sales_source_name != '' && enquiry.enquiry_sub_source != null"
                                          ng-init="sourceleng = enquiry.sales_source_name.length + enquiry.enquiry_sub_source.length; source = enquiry.sales_source_name + ' / ' + enquiry.enquiry_sub_source">
                                        <strong>Source : </strong>
                                        <span data-toggle="tooltip" title="{{source}}">{{source| limitTo : 45}} </span>
                                        <span ng-if="source.length > 45" data-toggle="tooltip" title="{{source}}">...</span>
                                    </span>
                                    <span ng-if="enquiry.sales_source_name != '' && enquiry.enquiry_sub_source == null">
                                        <strong>Source : </strong>
                                        <span data-toggle="tooltip" title="{{enquiry.sales_source_name}}">    {{enquiry.sales_source_name| limitTo : 45}} </span>
                                        <span ng-if="enquiry.sales_source_name.length > 45" data-toggle="tooltip" title="{{enquiry.sales_source_name}}">...</span>
                                    </span>
                                </div>
                                <div ng-if="enquiry.area != '' && enquiry.area != null" >
                                    <hr class="enq-hr-line">
                                    <strong>Area : </strong>
                                    <span data-toggle="tooltip" title="{{enquiry.area}}">    {{enquiry.area| limitTo : 45}} </span>
                                    <span ng-if="enquiry.area > 45" data-toggle="tooltip" title="{{enquiry.area}}">...</span>
                                </div>
                            </td>                            

                            <td width="20%">
                                <div>
                                    <span ng-if="enquiry.sales_status != '' && enquiry.enquiry_sales_substatus == null"> 
                                        <b>Status : </b>  
                                        <span data-toggle="tooltip" title="{{enquiry.sales_status}}">{{ enquiry.sales_status | limitTo : 45 }}</span>
                                        <span ng-if="enquiry.sales_status > 45" data-toggle="tooltip" title="{{enquiry.sales_status}}">...</span>
                                        <hr class="enq-hr-line">
                                    </span>

                                    <span ng-if="enquiry.sales_status != '' && enquiry.enquiry_sales_substatus != null" ng-init="enquiry_status_length = enquiry.sales_status.length + enquiry.enquiry_sales_substatus.length; enquiry_status = enquiry.sales_status + ' / ' + enquiry.enquiry_sales_substatus"> 
                                        <b>Status : </b>  
                                        <span data-toggle="tooltip" title="{{enquiry_status}}">{{ enquiry_status | limitTo : 45 }}</span>
                                        <span ng-if="enquiry_status_length > 45" data-toggle="tooltip" title="{{enquiry_status}}">...</span>
                                        <hr class="enq-hr-line">
                                    </span>

                                </div>        
                                <div> 
                                    <span ng-if="enquiry.enquiry_category != '' && enquiry.enquiry_sales_subcategory == null" data-toggle="tooltip" title="{{enquiry.enquiry_category}}">
                                        <b>Category : </b>  
                                        {{ enquiry.enquiry_category | limitTo : 45 }}
                                        <span ng-if="enquiry.enquiry_category > 45" data-toggle="tooltip" title="{{enquiry.enquiry_category}}">...</span>
                                        <hr class="enq-hr-line">
                                    </span>
                                    <span ng-if="enquiry.enquiry_category != '' && enquiry.enquiry_sales_subcategory != null" data-toggle="tooltip" title="{{enquiry_sales_subcategory}}" ng-init="enquiry_sales_subcategory_length = enquiry.enquiry_sales_subcategory.length + enquiry.enquiry_sales_subcategory.length; enquiry_sales_subcategory = enquiry.enquiry_category + ' / ' + enquiry.enquiry_sales_subcategory">
                                        <b>Category : </b>  
                                        {{ enquiry_sales_subcategory | limitTo : 45 }}
                                        <span ng-if="enquiry_sales_subcategory_length > 45" data-toggle="tooltip" title="{{enquiry_sales_subcategory}}">...</span>
                                        <hr class="enq-hr-line">
                                    </span>
                                </div>
                                <div>                                   
                                    <span ng-if="enquiry.project_block_name != null && enquiry.project_block_name != ''" data-toggle="tooltip" title="{{enquiry.project_block_name}}">                                    
                                        <b>Project :</b>
                                        {{enquiry.project_block_name| limitTo : 45 }}
                                        <span ng-if="enquiry.project_block_name > 45" data-toggle="tooltip" title="{{enquiry.project_block_name}}">...</span>                                                                                                                 
                                    </span>
                                    <div ng-if="enquiry.parking_required != null">
                                        <span ng-if="enquiry.parking_required == 0"><b>Parking Required :</b> No</span>
                                        <span ng-if="enquiry.parking_required == 1"><b>Parking Required :</b> Yes</span>                                    
                                    </div> 
                                    <hr class="enq-hr-line">
                                </div>                                                              
                                <div>
                                    <span style="text-align: center;"><a target="_blank" href="[[ config('global.backendUrl') ]]#/sales/update/cid/{{ enquiry.customer_id}}/eid/{{ enquiry.id}}"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Enquiry Id ({{ enquiry.id}})</a></span>
                                </div>                                                              
                            </td>
                            <td width="30%">
                                <div><b>Enquiry Owner :</b> {{enquiry.owner_fname}} {{enquiry.owner_lname}}</div>
                                <hr class="enq-hr-line">
                                <div >
                                    <b>Last followup : </b>{{ enquiry.last_followup_date}}
                                </div>
                                <div><b>By {{enquiry.followupby_fname}} {{enquiry.followupby_lname}} : </b>
                                    <span data-toggle="tooltip" title="{{enquiry.remarks| removeHTMLTags}}">{{enquiry.remarks| limitTo : 100 | removeHTMLTags }}
                                        <span ng-if="enquiry.remarks.length > 100" data-toggle="tooltip" title="{{enquiry.remarks| removeHTMLTags}}">...</span>
                                    </span>
                                </div>
                                <div>
        <!--                                     <span ng-if="enquiry.location_name != null && enquiry.location_name != '' " data-toggle="tooltip" title="{{enquiry.location_name}}">                                    
                                        <b>Preferred Location :</b>
                                         {{enquiry.location_name | limitTo : 45 }}
                                        <span ng-if="enquiry.location_name > 45" data-toggle="tooltip" title="{{enquiry.location_name}}">...</span>                                                                        
                                         <hr class="enq-hr-line">
                                    </span>-->
                                </div>                                
                                <hr class="enq-hr-line">
                                <div>
                                    <a href data-toggle="modal" data-target="#historyDataModal" ng-click="initHistoryDataModal({{ enquiry.id}})"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View History</a>
                                </div>

                            </td>
                            <td width="20%">
                                <div><b>Followup due : </b>{{ enquiry.next_followup_date}} @ {{ enquiry.next_followup_time}}</div>                            
                                <hr class="enq-hr-line">
                                <div>
                                    <a href data-toggle="modal" data-target="#todayremarkDataModal" ng-click="getTodayRemark({{enquiry.id}},'')"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Todays Remarks</a><br/>
                                    <a href ng-if="enquiry.test_drive_given == 0"   data-toggle="modal" data-target="#testdriveDataModal" ng-click="getscheduleTestDrive({{enquiry.id}})"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Schedule Test Drive<br/></a>
                                    <a href data-toggle="modal" data-target="#sendDocumentDataModal" ng-click="sendDocuments({{enquiry.id}})"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Send Documents</a><br/>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <dir-pagination-controls max-size="5"  class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'getTotalEnquiries','', [[$type]],newPageNumber,listType)" template-url="/dirPagination" ng-if="enquiriesLength"></dir-pagination-controls>                        
                <div ng-if="enquiriesLength == 0">
                    <div>
                        <center><b>No Enquiries Found</b></center>
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
                        <div data-ng-include=" '/MasterSales/enquiryHistory'"></div>
                        <div class="modal-footer" align="center">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Today remark model =============================================================================-->
            <div class="modal fade modal-primary" id="todayremarkDataModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header navbar-inner">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" align="center">Today's Remarks</h4>
                        </div>
                        <div data-ng-include=" '/MasterSales/todaysRemark'"></div>
                        <div class="modal-footer" align="center">
                        </div>
                    </div>
                </div>
            </div>   
            <!-- send Document Data Modal ===================================================================================== -->
            <div class="modal fade modal-primary" id="sendDocumentDataModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header navbar-inner">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" align="center">Send Documents</h4>
                        </div>                        
                        <div data-ng-include=" '/MasterSales/sendDocument'"></div>
                        <div class="modal-footer" align="center">
                        </div>
                    </div>
                </div>
            </div>
            <!-- reassign ===============================================================================================   -->
            <div class="modal fade modal-primary" id="BulkModal" role="dialog" tabindex='-1'>
                <div class="modal-dialog modal-md" >
                    <div class="modal-content">
                        <div class="modal-header navbar-inner">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" align="center">Reassign</h4>
                        </div>
                        <div data-ng-include="'/MasterSales/bulkreassign'"></div> 
                        <div class="modal-footer" align="center">
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <div data-ng-include="'/MasterSales/showFilter'"></div>
</div>


