<style>
    #tblTotalEnquiry{
        text-align: center;
    }    
</style>
<div class="widget flat radius-bordered " ng-controller="enquiryController" ng-init="showallCloseEnquiries('')">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Total Enquiries</span>
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>        
            <div class="widget-body table-responsive">
                <div class="row">
                    <div class="col-sm-3 col-xs-12">
                        <label for="search">Search:</label>
                        <input type="text" ng-model="search" class="form-control" placeholder="Search">
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <label for="search">Records per page:</label>
                        <input type="number" min="1" max="50" style="width:30%;" class="form-control" ng-model="itemsPerPage">
                    </div>
                </div><br>
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                    <th>Sr.No.</th>
                    <th>Customer Details</th>
                    <th>Enquiry Details</th>
                    <th>Last Followup</th>
                    <th>Next Followup Date Time</th>
                    <th>Enquiry</th>
                    <th>Enquiry History</th>
                    </thead>                                 
                    <tbody id="tblTotalEnquiry">
                        <tr role="row" dir-paginate="list in listsIndex.CustomerEnquiryDetails | filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{ $index + 1}}</td>
                            <td>
                                <div>
                                    {{ list.customer_details.first_name}} {{ list.customer_details.last_name}} <br>
                                    {{ list.customer_contacts.mobile_number}}
                                </div><hr/>
                                <div>
                                    <a href="" ng-click="customerDetails('{{ list.customer_contacts.mobile_number}}')">customer Details</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    Total Enquiries : {{ listsIndex.CustomerEnquiryDetails.length}}&nbsp;&nbsp;                                   
                                </div><hr>
                                Source: {{ list.channel_name.channel_name}}
                            </td>
                            <td>
                                {{ list.get_enquiry_details.get_project_name.project_name}} <br>
                                {{ list.get_enquiry_details.get_block.block_sub_type}}<br>

                                <div>
                                    <a href="">Enquiry Details</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    Enquiry Type: {{ list.get_enquiry_category_name.enquiry_category}}
                                </div>
                                Location :{{ list.enquiry_locations}}

                            </td>
                            <td>
                                Followups : {{ list.get_followup_details.followup_date_time | date:'dd M, yyyy'}}<hr>
                                {{ list.get_followup_details.remarks}}
                                Call Duration : 00:00:00
                            </td>
                            <td>
                                {{ list.get_followup_details.next_followup_date | date:'dd M, yyyy'}} At {{ list.get_followup_details.next_followup_time }}<hr>
                                <button class="btn btn-primary">Todays Remark</button>
                            </td>
                            <td>
                                Owner: [[ Auth::guard('admin')->user()->first_name ]] [[ Auth::guard('admin')->user()->last_name ]]
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#historyDataModal" ng-click="initHistoryDataModal({{ list.id}})">View History</button>
                            </td>
                        </tr>                                       
                    </tbody>
                </table>
                <div class="DTTTFooter">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                            <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
<!-- Modal -->
<div class="modal fade" id="historyDataModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Enquiry History</h4>
            </div>
            <div data-ng-include=" '[[ config('global.getUrl') ]]/MasterSales/enquiryHistory'"></div>
            <div class="modal-footer" align="center">
            </div>
        </div>
    </div>
</div>