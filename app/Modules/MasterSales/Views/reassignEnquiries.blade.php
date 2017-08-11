<style>    
     .close {
        color:black;
    }
.alert.alert-info {
    border-color: 1px solid #d9d9d9;
    background-color: #f5f5f5;
    border: 1px solid #d9d9d9;
    color: black;
    padding: 5px;
    width: auto;
    margin-right: 5px;
}
</style>
<?php $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);?>
<div class="row" ng-controller="enquiryController" ng-init="reassignEnquiries('',[[ $type ]],1, [[config('global.recordsPerPage')]])" >
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
              <span class="widget-caption">{{pagetitle}}</span>          
            </div>
            <div class="widget-body table-responsive">
                 <div class="row">
                    <div class="col-sm-6 col-xs-12" style="float:left">                        
                        <div class="col-sm-3 center">
                            <input type="text" minlength="1" maxlength="3" placeholder="Records per page" ng-model="itemsPerPage" ng-change="reassignEnquiries('',[[ $type ]],{{pageNumber}}, itemsPerPage)" ng-model-options="{ updateOn: 'blur' }" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control">
                        </div> 
                        <?php if (in_array('01604', $array)) { ?>
                        <div class="col-sm-3"  ng-if="BulkReasign">
                        <button type="button"  class="btn btn-primary"  data-toggle="modal" data-target="#BulkModal" ng-click="initBulkModal();">
                                     Bulk Reassign</button>
                        </div>
                        <?php } ?>
                        <div class="col-sm-3 center">
                            <button type="button" class="btn btn-primary ng-click-active"  data-toggle="modal" data-target="#showFilterModal" ng-click="procName('proc_reassign_enquiries')">
                                <i class="btn-label fa fa-filter"></i>Show Filter</button>
                        </div>
                        <?php if (in_array('01603', $array)) { ?>
                        <div ng-if="enquiriesLength != 0 " class="col-sm-3 center">
                            <a href="" class="btn btn-primary" id="downloadExcel" download="{{fileUrl}}"  ng-show="dnExcelSheet">
                                <i class="btn-label fa fa-file-excel-o"></i>Download excel</a>
                            <a href="javascript:void(0);" id="exportExcel" uploadfile class="btn btn-primary" ng-click="exportReport(enquiries)" ng-show="btnExport">
                                <i class="btn-label fa fa-file-excel-o"></i>Export to Excel
                            </a> 
                        </div>  
                        <?php } ?>
                    </div>                       
                    <div class="col-sm-6 col-xs-12 dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginat">                         
                        <span ng-if="enquiriesLength != 0 " >&nbsp; &nbsp; &nbsp; Showing {{enquiries.length}}  Enquiries Out Of Total {{enquiriesLength}} Enquiries.  &nbsp;</span>
                        <dir-pagination-controls max-size="5"  class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'reassignEnquiries','',[[ $type ]],newPageNumber, itemsPerPage,listType)" template-url="/dirPagination" ng-if="enquiriesLength"></dir-pagination-controls>
                    </div>
                </div> 
                <hr>
                <div class="row col-sm-12 col-xs-12" style="border:2px;" id="filter-show">
                    <div class="col-sm-2 alert alert-info fade in"  ng-repeat="(key, value) in showFilterData" ng-if="value != 0 && key != 'toDate' ">
                       <button class="close" ng-click=" removeDataFromFilter('{{ key }}');" data-dismiss="alert"> ×</button>
                       <strong ng-if="key === 'category_id' || key === 'source_id' || key === 'model_id' || key === 'status_id'">{{  value.substring(value.indexOf("_")+1) }}</strong>
                       <strong ng-if="key === 'employee_id' " ng-repeat='emp in value track by $index'>{{ $index +1 }}) {{   emp.first_name  }}  {{ emp.last_name }} </strong>
                       <strong ng-if="key === 'subcategory_id' " ng-repeat='subcat in value track by $index'>{{ $index +1 }}) {{   subcat.enquiry_sales_subcategory  }}  </strong>
                       <strong ng-if="key === 'substatus_id' " ng-repeat='substatus in value track by $index'> {{ $index +1 }}){{ substatus.enquiry_sales_substatus }} </strong>
                       <strong ng-if="key === 'subsource_id' " ng-repeat='subsource in value track by $index'>{{ $index +1 }}) {{ subsource.enquiry_subsource }} </strong>
                       <strong ng-if="key === 'test_drive_given' && value == 1 " data-toggle="tooltip" title="Test Drive"> <strong>Test Drive Given:</strong>Yes</strong>
                       <strong ng-if="key === 'verifiedEmailId' && value == 1 "> <strong>Verified Email ID:</strong>Yes</strong>
                       <strong ng-if="key === 'verifiedMobNo' && value == 1  " data-toggle="tooltip" title="Verified Mobile Number"> <strong>Verified Mobile No:</strong>Yes</strong>
                       <strong ng-if="key === 'fromDate'"  data-toggle="tooltip" title="Enquiry Date"><strong>Enquiry Date:</strong>{{ showFilterData.fromDate | date:'dd-MMM-yyyy' }} To {{ showFilterData.toDate |date:'dd-MMM-yyyy' }}</strong>
                       <strong ng-if="key != 'status_id' && key != 'substatus_id' && key != 'subsource_id' && key != 'subcategory_id' && key != 'category_id' && key != 'fromDate' && key != 'toDate' && key != 'source_id' && key != 'model_id' && key != 'test_drive_given' && key != 'employee_id' " data-toggle="tooltip" title="{{ key }}"> {{ value}}</strong>
                   </div>   
               </div>
                <br>     
                <table class="table table-hover table-striped table-bordered" at-config="config" ng-if="enquiriesLength">
                    <thead>
                        <tr>
                            <th class="enq-table-th">SR <?php if (in_array('01604', $array)) {?>/ 
                                <label>
                                   
                                    <input type="checkbox"  ng-click='checkAll(all_chk_reassign[pageNumber])' ng-model="all_chk_reassign[pageNumber]" name="all_chk_reassign_enq" id="all_chk_reassign_enq">
                                    <span class="text"></span>
                                </label> 
                                    <?php } ?>
                            </th>
                            <th class="enq-table-th">Customer</th>
                            <th class="enq-table-th">Enquiry</th>
                            <th class="enq-table-th">History</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr dir-paginate="enquiry in  enquiries | filter:search | itemsPerPage: itemsPerPage | orderBy:orderByField:reverseSort" total-items="{{ enquiriesLength}}">
                             <td width="6%" style="vertical-align:middle">
                                <center>
                                    {{itemsPerPage * (pageNumber - 1) + $index + 1}}<br> 
                                    <?php if (in_array('01604', $array)) {?>
                                <label>
                                        
                                         <input type="checkbox" name="chk_reassign_enq" ng-click="singleSelect()" ng-model="chk_reassign_enq"  value="{{enquiry.id}}" class="chk_reassign_enq form-control" id="chk_reassign_enq">   
                                        <span class="text"></span>
                                </label> 
                                <?php } ?>
                                </center>
                            </td>
                            <td width="20%">
                                <div>{{enquiry.customer_title}} {{ enquiry.customer_fname}} {{ enquiry.customer_lname}}</div>
                                <?php if (in_array('01602', $array)) { ?>
                                <div ng-if="enquiry.mobile !=''" ng-init="mobile_list=enquiry.mobile.split(',')">  
                                    <span ng-repeat="mobile_obj in mobile_list | limitTo:2">
                                    <?php if (in_array('01605', $array)) { ?>
                                    <a style="cursor: pointer;" class="Linkhref"
                                           ng-if="mobile_obj != null" 
                                           ng-click="cloudCallingLog(1,<?php echo Auth::guard('admin')->user()->id; ?>,{{ enquiry.id}},'{{enquiry.customer_id}}','{{$index}}')">

                                        <img src="/images/call.png" title="Click on call icon to make a call" class="hi-icon-effect-8 psdn_session" style="height: 17px;width: 17px;" />
                                    </a>
                                        <?php } ?>
                                        {{ mobile_obj}}
                                    </span>
                                    <?php if (in_array('01601', $array)) { ?>
                                    <p ng-if="enquiry.email != ''" ng-init="all_email_list = enquiry.email.split(',');" >

                                        <span ng-repeat="emailobj in all_email_list| limitTo:2">
                                            {{emailobj}}
                                            <span ng-if="$index == 0 && all_email_list.length >= 2">
                                                /
                                            </span>

                                        </span>

                                    </p>
                                    <?php } ?>
                                </div>
                                <?php }else{ ?>
                                <div ng-init="mobile_list=enquiry.mobile.split(',')">
                                    <p ng-if="enquiry.mobile !='' "> 
                                        <span ng-repeat="mobile_obj in mobile_list | limitTo:2">
                                            <?php if (in_array('01605', $array)) { ?>
                                                <a style="cursor: pointer;" class="Linkhref"
                                                        ng-if="mobile_obj != null" 
                                                        ng-click="cloudCallingLog(1,<?php echo Auth::guard('admin')->user()->id; ?>,{{ enquiry.id}},'{{enquiry.customer_id}}','{{$index}}')">

                                                     <img src="/images/call.png" title="Click on call icon to make a call" class="hi-icon-effect-8 psdn_session" style="height: 17px;width: 17px;" />
                                                 </a>
                                                <?php } ?>
                                            +91-xxxxxx{{  mobile_obj.substring(mobile_obj.length - 4, mobile_obj.length)}}
                                        </span>
                                    </p>
                                    <?php if (in_array('01601', $array)) { ?>
                                    <p ng-if="enquiry.email != '' " ng-init="all_email_list=enquiry.email.split(',');" >
                                        
                                        <span ng-repeat="emailobj in all_email_list | limitTo:2">
                                                {{emailobj}}
                                                <span ng-if="$index == 0 && all_email_list.length >= 2">
                                                    /
                                                </span>
                                              
                                        </span>
                                        
                                    </p>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                                <hr class="enq-hr-line">
                                <?php if (in_array('01602', $array)) { ?>
                                <div class="floatLeft">
                                    <a target="_blank" href="#/customer/update/{{ enquiry.customer_id}}"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;Customer Id ({{enquiry.customer_id}})</a>
                                </div>                    
                                <hr class="enq-hr-line">
                                <?php } ?>
                                <div>
                                    <span ng-if="enquiry.company_name != '' && enquiry.company_name != null ">
                                        <strong>Company : </strong>
                                        <span data-toggle="tooltip" title="{{enquiry.company_name}}">    {{enquiry.company_name | limitTo : 45}} </span>
                                        <span ng-if="enquiry.company_name.length  > 45" data-toggle="tooltip" title="{{enquiry.company_name}}">...</span>
                                        <br>
                                    </span>
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
                                        <span ng-if="enquiry.sales_status != '' && enquiry.enquiry_sales_substatus == null"> 
                                            <b>Status : </b>  
                                            <span data-toggle="tooltip" title="{{enquiry.sales_status}}">{{ enquiry.sales_status  | limitTo : 45 }}</span>
                                            <span ng-if="enquiry.sales_status  > 45" data-toggle="tooltip" title="{{enquiry.sales_status}}">...</span>
                                <hr class="enq-hr-line">
                                        </span>
                                    
                                        <span ng-if="enquiry.sales_status != '' && enquiry.enquiry_sales_substatus != null" ng-init="enquiry_status_length = enquiry.sales_status.length + enquiry.enquiry_sales_substatus.length; enquiry_status = enquiry.sales_status +' / '+ enquiry.enquiry_sales_substatus "> 
                                                <b>Status : </b>  
                                                <span data-toggle="tooltip" title="{{enquiry_status}}">{{ enquiry_status  | limitTo : 45 }}</span>
                                                <span ng-if="enquiry_status_length > 45" data-toggle="tooltip" title="{{enquiry_status}}">...</span>
                                <hr class="enq-hr-line">
                                        </span>
                                    
                                </div>        
                                <div> 
                                    <span ng-if="enquiry.enquiry_category != '' && enquiry.enquiry_sales_subcategory == null" data-toggle="tooltip" title="{{enquiry.enquiry_category}}">
                                        <b>Category : </b>  
                                        {{ enquiry.enquiry_category  | limitTo : 45 }}
                                        <span ng-if="enquiry.enquiry_category > 45" data-toggle="tooltip" title="{{enquiry.enquiry_category}}">...</span>
                                         <hr class="enq-hr-line">
                                    </span>
                                    <span ng-if="enquiry.enquiry_category != '' && enquiry.enquiry_sales_subcategory != null " data-toggle="tooltip" title="{{enquiry_sales_subcategory}}" ng-init="enquiry_sales_subcategory_length = enquiry.enquiry_sales_subcategory.length + enquiry.enquiry_sales_subcategory.length; enquiry_sales_subcategory = enquiry.enquiry_category +' / '+ enquiry.enquiry_sales_subcategory ">
                                        <b>Category : </b>  
                                        {{ enquiry_sales_subcategory  | limitTo : 45 }}
                                        <span ng-if="enquiry_sales_subcategory_length  > 45" data-toggle="tooltip" title="{{enquiry_sales_subcategory}}">...</span>
                                        <hr class="enq-hr-line">
                                    </span>
                                   
                                
                                </div>
                                 <div>                                   
                                    <span ng-if="enquiry.project_block_name != null && enquiry.project_block_name != '' " data-toggle="tooltip" title="{{enquiry.project_block_name}}">                                    
                                        <b>Project :</b>
                                         {{enquiry.project_block_name | limitTo : 45 }}
                                        <span ng-if="enquiry.project_block_name > 45" data-toggle="tooltip" title="{{enquiry.project_block_name}}">...</span>                                                                                                                 
                                    </span>
                                     <div ng-if="enquiry.parking_required != null">
                                        <span ng-if="enquiry.parking_required == 0"><b>Parking Required :</b> No</span>
                                        <span ng-if="enquiry.parking_required == 1"><b>Parking Required :</b> Yes</span>                                    
                                    </div> 
                                    <hr class="enq-hr-line">
                                </div> 
                                <div>
                                    <span style="text-align: center;"><strong>&nbsp;Enquiry Id ({{ enquiry.id}})</strong></span>
                                </div>
                            </td>
                            <td width="30%">
                                <div><b>Enquiry Owner :</b> {{enquiry.owner_fname}} {{enquiry.owner_lname}}</div>
                                <hr class="enq-hr-line">
                                <div>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#historyDataModal" ng-click="initHistoryDataModal({{ enquiry.id}})"><i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View History</a>
                                </div>
                            </td>
                        </tr>
                        <tr ng-show="(enquiries|filter:search).length == 0">
                            <td colspan="7" align="center">Record Not Found</td>   
                        </tr>
                    </tbody>
                </table>
                <hr>
                <dir-pagination-controls max-size="5"  class="pull-right pagination" on-page-change="pageChanged(newPageNumber,'reassignEnquiries','',[[ $type ]], newPageNumber, itemsPerPage,listType)" template-url="/dirPagination" ng-if="enquiriesLength"></dir-pagination-controls>
                <div ng-if="enquiriesLength == 0 ">
                    <div>
                        <center><b>No Enquiries Found</b></center>
                    </div>
                </div>
            </div>
            <!-- Today history model =========================================================================================-->
            <div class="modal fade" id="historyDataModal" role="dialog" tabindex='-1'>
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
            <div class="modal fade" id="todayremarkDataModal" role="dialog" tabindex='-1'>
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header navbar-inner">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" align="center">Today Remarks</h4>
                        </div>

                        <div data-ng-include=" '/MasterSales/todaysRemark' "></div>
                        <div class="modal-footer" align="center">
                        </div>
                    </div>
                </div>
            </div>
            <div data-ng-include="'/MasterSales/showFilter'"></div>
             <!--<div data-ng-include="'/MasterSales/blukreassign'"></div>--> 
        </div>
    </div>
</div>