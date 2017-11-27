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
<div class="row" ng-controller="wingsController"  ng-init="manageWings([[ $id ]])">
    <div class="mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Wings</span>                
            </div>
            <div class="widget-body table-responsive">
                <!--                <div class="row">
                                    <div class="col-md-3 col-xs-12">
                                        <div class="form-group">
                                            <label for="search">Search:</label>
                                            <span class="input-icon icon-right">
                                                <input type="text" ng-model="search" name="search" class="form-control">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="form-group">
                                            <label for="search">Records per page:</label>
                                            <input type="text" minlength="1" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width:30%;" class="form-control" ng-model="itemsPerPage" name="itemsPerPage">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for=""></label>
                                            <span class="input-icon icon-right">
                                                <a href="[[ config('global.backendUrl') ]]#/wings/create" class="btn btn-primary btn-right">Create Wings</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>-->
                <div class="row table-toolbar">
                    <a href="[[ config('global.backendUrl') ]]#/wings/create" class="btn btn-default">Create Wings</a>
                    <div class="btn-group pull-right filterBtn">
                        <a class="btn btn-default toggleForm" href="" ng-hide="disableBtn"><i class="btn-label fa fa-filter"></i>Show Filter</a>
                    </div>
                </div>
                <div role="grid" id="editabledatatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                    <div class="DTTT btn-group">
                        <a class="btn btn-default DTTT_button_collection" id="ToolTables_editabledatatable_2" ng-disabled="disableBtn">
                            <span>Actions</span>
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" ng-disabled="disableBtn"><i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu dropdown-default">
                                <li>
                                    <a href=""  ng-click="projectWingsExportToxls()" ng-show="exportData == '1'">Export</a>
                                </li>
                            </ul>
                        </a>
                    </div>
                    <div  class="dataTables_filter">
                        <label>
                            <input type="search" ng-disabled="disableBtn" class="form-control input-sm" ng-model="search" name="search" >
                        </label>
                    </div>
                    <!-- filter data--> 
                    <div class="row" style="border:2px;" id="filter-show">
                        <div class="col-sm-12 col-xs-12">
                            <b ng-repeat="(key, value) in searchData" ng-if="value != 0">
                                <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                    <div class="alert alert-info fade in">
                                        <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                        <strong ng-if="key === 'project'" data-toggle="tooltip" title="Project"><strong> Project : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'wing_name'" data-toggle="tooltip" title="Wing Name"><strong> Wing Name : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'company'" data-toggle="tooltip" title="Company"><strong> Company : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'stationary'" data-toggle="tooltip" title="Stationary"><strong> Stationary : </strong> {{ value}}</strong>
                                        <strong ng-if="key === 'number_of_floors'" data-toggle="tooltip" title="Floors"><strong> Floors : </strong> {{ value}}</strong>
                                    </div>
                                </div>
                            </b>                        
                        </div>
                    </div>
                    <!-- filter data-->
                    <div class="dataTables_length" >
                        <label>
                            <select ng-disabled="disableBtn" class="form-control" ng-model="itemsPerPage" name="itemsPerPage" onchange="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
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
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('project')">Project
                                        <span ><img ng-hide="(sortKey == 'project' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'project' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'project' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('wing_name')">Name
                                        <span ><img ng-hide="(sortKey == 'wing_name' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'wing_name' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'wing_name' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th> 
                                <th style="width: 10%">
                                    <a href="javascript:void(0);" ng-click="orderByField('company')">Company
                                        <span ><img ng-hide="(sortKey == 'company' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'company' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'company' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>

                                <th style="width: 20%">
                                    <a href="javascript:void(0);" ng-click="orderByField('stationary')">Stationary
                                        <span ><img ng-hide="(sortKey == 'stationary' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'stationary' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'stationary' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 5%">
                                    <a href="javascript:void(0);" ng-click="orderByField('number_of_floors')">Floors
                                        <span ><img ng-hide="(sortKey == 'number_of_floors' && (reverseSort == true || reverseSort == false))" src="../images/sort_both.png"></img></span>
                                        <span ng-show="(sortKey == 'number_of_floors' && reverseSort == false)" ><img src="../images/sort_asc.png"></img></span>
                                        <span ng-show="(sortKey == 'number_of_floors' && reverseSort == true)" ><img src="../images/sort_desc.png"></img></span>
                                    </a>
                                </th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" dir-paginate="listWing in listWings | filter:search | filter:searchData| itemsPerPage:itemsPerPage | orderBy:sortKey:reverseSort">
                                <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td>
                                <td>{{ listWing.project}}</td>
                                <td>{{ listWing.wing_name}}</td>                            
                                <td>{{ listWing.company}}</td>
                                <td>{{ listWing.stationary}}</td>
                                <td>{{ listWing.number_of_floors}}</td>                            
                                <td class="">                                
                                    <span class="" tooltip-html-unsafe="Edit Wings" ><a href="[[ config('global.backendUrl') ]]#/wings/update/{{ listWing.id}}" class="btn-primary btn-xs"><i class="fa fa-edit"></i>Edit</a></span>                                
                                 <span ng-show="deleteBtn == '1'"  class="" tooltip-html-unsafe="Delete"><a href="" ng-click="confirm({{listWing.id}},{{$index}})" class="btn-danger btn-xs"><i class="fa fa-trash-o"></i>Delete</a></span>
                               </td>
                            </tr>
                            <tr>
                                <td colspan="7"  ng-show="(listWings|filter:search|filter:searchData).length == 0" align="center">Record Not Found</td>   
                                <td colspan="7"  ng-show="totalCount == 0" align="center">Record Not Found</td>   
                            </tr>
                        </tbody>
                    </table>
                    <div class="DTTTFooter">
                        <div class="col-sm-6">
                            <!--<div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing {{itemsPerPage * (noOfRows-1)+1}} to of {{ listUsersLength }} entries</div>-->
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
        <form name="calllogsFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Project</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.project" ng-controller="projectCtrl" name="project" class="form-control">
                                <option value="">Select type</option>
                                <option ng-repeat="plist in projectList" value="{{plist.project_name}}" ng-selected="searchDetails.project == plist.project_name">{{plist.project_name}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>

                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Wing Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.wing_name"  name="wing_name" id="fromDate" class="form-control" >
                        </span>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Company</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.company" ng-controller="companyCtrl" name="company" class="form-control" >
                                <option value="">Select company</option>
                                <option ng-repeat="list in firmPartnerList" value="{{list.legal_name}}" ng-selected="searchDetails.company == list.legal_name">{{list.legal_name}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>

                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Stationary</label>
                        <span class="input-icon icon-right">
                            <select ng-model="searchDetails.stationary" ng-controller="stationaryCtrl" name="stationary" class="form-control" >
                                <option value="">Select stationary</option>
                                <option ng-repeat="list in stationaryList" value="{{list.stationary_set_name}}" ng-selected="searchDetails.stationary == list.stationary_set_name">{{list.stationary_set_name}}</option>
                            </select>
                            <i class="fa fa-sort-desc"></i>
                        </span>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Floors</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.number_of_floors"  name="number_of_floors" id="fromDate" class="form-control" />
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

