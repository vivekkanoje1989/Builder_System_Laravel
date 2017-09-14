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
        width: 110%;
    }
</style>
<div class="row" ng-controller="testimonialsCtrl" ng-init="manageTestimonials()">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Testimonial</span>                
            </div>
            <div class="widget-body table-responsive">

                <div class="row table-toolbar">
                    <!--<a  href="[[ config('global.backendUrl') ]]#/employeeDevice/create" class="btn btn-default">Add Device</a>-->
                    <div class="btn-group pull-right">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="manageTestimonialApproveExportToExcel()" ng-shoe="exportDetails== '1'">
                            <span>Export</span>
                        </a>
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Options</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="javascript:void(0);">Action</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Another action</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Something else here</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:void(0);">Separated link</a>
                                </li>
                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'customer_name'" data-toggle="tooltip" title="Customer Name"><strong> Customer Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'mobile_number'" data-toggle="tooltip" title="Mobile Number"><strong> Mobile Number : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'company_name'" data-toggle="tooltip" title="Company Name"><strong> Company Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'approve_status'" data-toggle="tooltip" title="Status"><strong>  Status : </strong> {{ value.approve_status == 1 ? "Approved" : "Not Approve"}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                                <option value="1">1</option>
                                <option value="5">5</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="100">100</option>
                            </select>
                        </label>
                    </div>
                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <th style="width:5%">Sr.No.</th>
                                <th style="width:10%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'block_stages'; reverseSort = !reverseSort">Customer name
                                        <span ng-show="orderByField == 'customer_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th> 
                                <th style="width: 20%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'block_stages'; reverseSort = !reverseSort">Mobile No
                                        <span ng-show="orderByField == 'mobile_number'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th> 
                                <th style="width: 30%">
                                    <a href="javascript:void(0);" ng-click="orderByField = 'company_name'; reverseSort = !reverseSort">Company Name
                                        <span ng-show="orderByField == 'company_name'">
                                            <span ng-show="!reverseSort">^</span><span ng-show="reverseSort">v</span>
                                        </span>
                                    </a>
                                </th> 
                                <th style="width: 15%">Approve Status</th>  
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="list in ApprovedTestimonialsRow|  filter:search |filter:searchData | itemsPerPage:itemsPerPage |orderBy:orderByField:reverseSort">
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{ list.customer_name}}</td>  
                                <td>{{ list.mobile_number}}</td>  
                                <td>{{ list.company_name}}</td>
                                <td>{{ (list.approve_status == 1) ? "Approved" : "Not Approve"}}</td>
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit" ><a href="[[ config('global.backendUrl') ]]#/testimonials-manage/update/{{ list.testimonial_id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                    <span class="" tooltip-html-unsafe="Delete"><a href="" ng-click="deleteApprovedList({{list.testimonial_id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td> 
                            </tr>
                             <tr>
                                <td colspan="6"  ng-show="(ApprovedTestimonialsRow|filter:search|filter:searchData).length == 0" align="center">Record Not Found</td>   
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
    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="bankAccountFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Customer Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.customer_name" name="customer_name" class="form-control" oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Mobile Number</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.mobile_number" name="mobile_number" class="form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Company Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.company_name" name="company_name" class="form-control">
                        </span>
                    </div>
                </div>
                <!--                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Account Type</label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="searchDetails.approve_status" name="approve_status" class="form-control">
                                                <option value="">Select account type</option>
                                                <option value="1">Approved</option>
                                                <option value="2">Not Approve</option>
                                            </select>
                
                                        </span>    
                                    </div>
                                </div>-->

            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" align="center">
                            <button type="submit" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->
</div>



