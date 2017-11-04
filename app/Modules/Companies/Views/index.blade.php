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
<div class="row" ng-controller="companyCtrl" ng-init="manageCompany()">  
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Company</span> 
                 <span data-toggle="modal" data-target="#help" class="helpDescription">Help <i class="fa fa-question-circle" aria-hidden="true"></i></span>
              </div>
            <div class="widget-body table-responsive">

                <div class="row table-toolbar">
                    <a href="[[ config('global.backendUrl') ]]#/companies/create" class="btn btn-default">Add New Company</a>
                     <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href=""  ng-hide="disableBtn" ><i class="btn-label fa fa-filter" ></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2"  ng-disabled="disableBtn" >
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"  ng-disabled="disableBtn" ><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href="" ng-click="companiesExportToxls()" ng-show="exportData == '1'">Export</a>
                                </li>

                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search"  ng-disabled="disableBtn"  class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'punch_line'" data-toggle="tooltip" title="Punch Line"><strong> Punch Line : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'legal_name'" data-toggle="tooltip" title="Legal Name"><strong> Legal Name : </strong> {{ value}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select  ng-disabled="disableBtn"  class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
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
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('punch_line')">Punch Line
                                        <span ><img ng-hide="(sortKey == 'punch_line' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'punch_line' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'punch_line' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>                           
                                <th style="width:20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('legal_name')">Legal Name
                                        <span ><img ng-hide="(sortKey == 'legal_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'legal_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'legal_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>  
                                <th style="width: 5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="list in CompanyRow| filter:search |filter:searchData | itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort" id='{{list.id}}'>
                                <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{list.punch_line}}</td> 
                                <td>{{list.legal_name}}</td> 
                                <td class="">
                                    <span class="" tooltip-html-unsafe="Edit Information" data-toggle="modal" data-target="#companyModal"><a href="[[ config('global.backendUrl') ]]#/companies/edit/{{list.id}}" class="btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a></span>
                            
                                    <span  ng-show="deleteBtn == '1'" id="dialog" class="" tooltip-html-unsafe="Delete"  ng-click="confirm({{list.id}},{{$index}})" ><a href="" class="btn-danger btn-xs "><i class="fa fa-trash-o"></i>Delete</a></span>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="4"  ng-show="(CompanyRow|filter:search | filter:searchData ).length == 0" align="center">Record Not Found</td>   
                                <td colspan="4"  ng-show="totalCount == 0" align="center">Record Not Found</td>   
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
        <form name="firm&partnersFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Punch Line</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.punch_line" name="punch_line" class="form-control">
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Legal Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.legal_name" name="legal_name" class="form-control">
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
                                <label class="helpContent">- This listing shows information of all companies.</label>
                                <label class="helpContent">- After clicked on "Add New Company" button the new form arise for adding new firms
and partners.</label>
                                <span class="input-icon icon-right">                                    
                                    
                                </span>
                            </div>                            
                        </div>
                    </div>  
            </div>
        </div>
    </div>
</div>

<!--<script>
   $( document ).ready(function() {
       $('.abcd').click(function(){
    alert('fh')
})

function fnOpenNormalDialog() {
    $("#dialog-confirm").html("Confirm Dialog Box");
alert($(this).attr("data-deletedid"));
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Modal",
        height: 250,
        width: 400,
        buttons: {
            "Yes": function () {
                $(this).dialog('close');
                callback(true);
            },
                "No": function () {
                $(this).dialog('close');
                callback(false);
            }
        }
    });
}

$('.abcd').click(function(){
    alert('fh')
})

//$('.btn-danger').click(fnOpenNormalDialog);
   });
</script>-->