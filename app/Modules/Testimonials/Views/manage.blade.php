
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
<div class="row" ng-controller="testimonialsCtrl" ng-init="testimonials()">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Testimonials</span>                
            </div>
            <div class="widget-body table-responsive">

                <div class="row table-toolbar">
                    <a  href="[[ config('global.backendUrl') ]]#/testimonials/create" class="btn btn-default">Add Testimonial</a>
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <!--                        <a class="btn btn-default DTTT_button_print" id="ToolTables_editabledatatable_1" title="View Excel" ng-click="manageTestimonialDisapproveExportToExcel()" ng-show="exportData == '1'">
                                                    <span>Export</span>
                                                </a>-->
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="manageTestimonialDisapproveExportToExcel()" ng-show="exportData == '1'">Export</a>
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
                            <b ng-repeat="(key, value) in searchData"  ng-if="value != 0">
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
                    <table class="table table-hover table-striped table-bordered tableHeader" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                                <th style="width:5%">Sr. No.</th>                          
                                <th style="width: 30%">
                                    <a href="javascript:void(0);" ng-click="orderByField('customer_name')">Customer Name
                                        <span ><img ng-hide="(sortKey == 'customer_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'customer_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'customer_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th> 
                                <th style="width: 15%">
                                    <a href="javascript:void(0);" ng-click="orderByField('mobile_number')">Mobile No
                                        <span ><img ng-hide="(sortKey == 'mobile_number' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'mobile_number' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'mobile_number' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th> 
                                <th style="width: 20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('company_name')">Company Name
                                        <span ><img ng-hide="(sortKey == 'company_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'company_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'company_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th> 
                                <th style="width: 20%">Approve Status</th> 
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="list in ApprovedTestimonialsRow|  filter:search |filter:searchData  | itemsPerPage:itemsPerPage |orderBy:sortKey:reverseSort">
                                <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{ list.customer_name}}</td>  
                                <td>{{ list.mobile_number}}</td>  
                                <td>{{ list.company_name}}</td>
                                <td>{{(list.approve_status == 1) ? "Approved" : "Not Approve"}}</td>
                                <td class="">
                                   <span class="" tooltip-html-unsafe="Edit" ><a href="[[ config('global.backendUrl') ]]#/testimonials-manage/update/{{ list.testimonial_id}}" class="btn-info btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                                     <span ng-show="deleteDisApprove == '1'" class="" tooltip-html-unsafe="Delete"><a href="" ng-click="confirmDelete({{list.testimonial_id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td> 
                            </tr>
                            <tr>
                                <td colspan="6"  ng-show="(ApprovedTestimonialsRow|filter:search | filter:searchData).length == 0" align="center">Record Not Found</td>   
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
                            <input type="text" ng-model="searchDetails.customer_name" name="customer_name" capitalizeFirst class="form-control" oninput="if (/[^A-Za-z]/g.test(this.value)) this.value = this.value.replace(/[^A-Za-z]/g,'')">
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
                            <input type="text" ng-model="searchDetails.company_name" capitalizeFirst name="company_name" class="form-control">
                        </span>
                    </div>
                </div>
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


