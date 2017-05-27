<div class="widget-body table-responsive">
    <div class="row" ng-if="listsIndex.success">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-sm-3 col-xs-12">
                <label for="search">Records per page:</label>
                <input type="number" ng-model="itemsPerPage" name="itemsPerPage" min="1" max="50" style="width:30%;" class="form-control" ng-change="itemsperpageno(itemsPerPage)">
            </div>
        </div>
    </div><br/>
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px">Sr. No.</th>
                <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px">Customer Details</th>
                <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px">Enquiry Details</th>
                <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px">Last Followup</th>
                <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px">Enquiry Status</th>
                <th style="border: 1px solid #CED3D7;background-color: #EAEAEA;height:15px">Enquiry </th>
            </tr>
        </thead>
        <tbody ng-if="!listsIndex.success">
            <tr>
                <td colspan="6">{{listsIndex.records}}</td>
            </tr>
        </tbody>
        <tbody ng-if="listsIndex.success">
            <tr dir-paginate="list in listsIndex.records | filter:search | itemsPerPage:itemsPerPage">  
                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                <td>
                    <div > 
                        {{list.customer_fname}} {{list.customer_lname}} - {{ list.mobile_number}} - {{list.email_id}} </div>
                    <hr>
                    <div class="floatLeft"><a href="#/[[config('global.getUrl')]]/sales/update/cid/{{ list.customer_id }}">Customer Details</a></div> 
                    <div class="floatLeft" style="width:30%;max-width: 30%;word-wrap: break-word;"><b>Enquiries : {{ listsIndex.records.length }}</b></div>
                    <div class="floatLeft" style="width:40%;max-width: 30%;word-wrap: break-word;"><b>Booked : 0</b></div>                    
                    <div class="floatLeft" style="width:100%;"><hr></div>
                    <div style="text-align:center;">
                        <span style="margin:5px"><strong>Source: </strong>{{ list.sales_source_name}}<br></span>
                        <span style="margin:5px"><b>Budget</b>: {{list.max_budget}}</span>    
                    </div>
                </td>
                <td>
                    <div>{{list.project_block_name}} - {{list.block_name}} </div>
                    <hr>
                    <div class="floatLeft"><i class="fa fa-desktop" aria-hidden="true"></i></div>
                    <div class="floatLeft" style="width:41%"><a href="#/[[config('global.getUrl')]]/sales/update/cid/{{ list.customer_id }}/eid/{{ list.id }}">Enquiry Details</a></div>
                    <div class="floatLeft" style="width:50%">
                        <span style="margin-left:4px;background-color:orange;float:left;width:12px;height:12px;" ng-if="list.enquiry_category == 'New Enquiry'">&nbsp;</span>
                        <span style="margin-left:4px;background-color:RED;float:left;width:12px;height:12px;" ng-if="list.enquiry_category == 'Hot'">&nbsp;</span>
                        <span style="margin-left:4px;background-color:yellow;float:left;width:12px;height:12px;" ng-if="list.enquiry_category == 'Warm'">&nbsp;</span>
                        <span style="margin-left:4px;background-color:#5ABBF3;float:left;width:12px;height:12px;" ng-if="list.enquiry_category == 'Cold'">&nbsp;</span>
                        
                        <span style="float: left;margin: -4px 0px 0px 5px;">{{ list.enquiry_category}}</span>              
                    </div> 
                    <div class="floatLeft" style="width:100%;"><hr></div>
                    <div class="floatLeft">
                        <span style="float:left;"><b>No.of Followups : {{list.total_followups}}</b></span><br/>
                        <span style="float:left;"><b>Location</b> : {{ list.location_name}}</span><br/>
                        <span style="float:left;" ng-show="list.parking_required == 1">Parking Required</span>
                        <span style="float:left;" ng-show="list.parking_required == 0">No Parking Required</span>
                    </div>
                </td>
                <td width="30%">
                    <span>{{ list.last_followup_date | date:'dd M, yyyy'}} By {{list.followup_fname}} {{list.followup_lname}}</span><hr>
                    <span style="width: 100%;word-break: break-all;">{{ list.remarks}}</span>
                </td>
                <td style="vertical-align: middle;">{{ list.sales_status }}
                <hr>
                <div style="margin-bottom: 40px;text-align: left;">
                    <i class="fa fa-external-link" aria-hidden="true"></i><a href data-toggle="modal" data-target="#todaysRemarkModal" ng-click="todayRemark({{ list.id }},'{{list.followup_id}}','{{list.customer_id}}')"> Today's Remark </a><br/>
                    <i class="fa fa-external-link" aria-hidden="true"></i><a href> Convert to booking </a><br/>
                    <i class="fa fa-external-link" aria-hidden="true"></i><a href> Generate estimate </a><br/>
                    <i class="fa fa-external-link" aria-hidden="true"></i><a href> Convert in deal </a>
                </div>
                </td>
                <td align="left">
                    <div>Owner: {{list.owner_fname}} {{list.owner_lname}}</div><hr>
                    <button type="button" class="btn btn-primary ng-click-active" data-toggle="modal" data-target="#historyDataModal" ng-click="initHistoryDataModal({{ list.id }})">View History</button>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="DTTTFooter" ng-if="listsIndex.success">
        <div class="col-sm-6">
            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Page No. {{noOfRows}}</div>
        </div>
        <div class="col-sm-6">
            <div class="dataTables_paginate paging_bootstrap" id="DataTables_Table_0_paginate">
                <dir-pagination-controls class="pagination" on-page-change="pageChangeHandler(newPageNumber,itemsPerPage)" max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
            </div>
        </div>
    </div>
</div>
<!-- Enquiry history modal -->
<div data-ng-include=" '[[ config('global.getUrl') ]]/MasterSales/enquiryHistory'"></div>
<!-- Enquiry todays remark modal -->
<div data-ng-include=" '[[ config('global.getUrl') ]]/MasterSales/todaysRemark'"></div>