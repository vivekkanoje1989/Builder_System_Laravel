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
<div class="row" ng-controller="enquiryLocationCtrl" ng-init="enquiryLocation([[$loggedInUserId]], 1, [[config('global.recordsPerPage')]]); manageCountry()">  
    <div class=" mainDiv col-xs-12 col-md-12">
        <div class="widget flat radius-bordered">
            <div class="widget-header bordered-bottom bordered-themeprimary">
                <span class="widget-caption">Manage Enquiry Location</span>                
            </div>
            <div class="widget-body table-responsive">
                <div class="row">
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
                            <input type="text" minlength="1" maxlength="3" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" style="width:30%;" class="form-control" ng-model="itemsPerPage">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for=""></label>
                            <span class="input-icon icon-right">
                                <a href="" data-toggle="modal" data-target="#locationModal" ng-click="initialModal(0, '', '', '', '', '')" class="btn btn-primary btn-right">Create Enquiry Location</a>
                                <button type="button" class="btn btn-primary btn-right toggleForm" style="margin-right: 10px;"><i class="btn-label fa fa-filter"></i>Show Filter</button>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- filter data--> 
                <div class="row" style="border:2px;" id="filter-show">
                    <div class="col-sm-12 col-xs-12">
                        <b ng-repeat="(key, value) in searchData" ng-if="value != 0 && key != 'toDate'">
                            <div class="col-sm-2" data-toggle="tooltip" title="{{  key.substring(0, key.indexOf('_'))}}"> 
                                <div class="alert alert-info fade in">
                                    <button class="close" ng-click="removeFilterData('{{ key}}');" data-dismiss="alert"> ×</button>
                                    <strong ng-if="key === 'city_name'" data-toggle="tooltip" title="City Name"><strong> City Name : </strong> {{ value}}</strong>
                                    <strong ng-if="key === 'location'" data-toggle="tooltip" title="Location"><strong> Location : </strong> {{ value}}</strong>
                                </div>
                            </div>
                        </b>                        
                    </div>
                </div>
                <!-- filter data-->
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                            <th style="width:5%">Sr No.</th>
                            <th style="width:25%">City</th> 
                            <th style="width:25%">Location</th>                           
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr role="row" dir-paginate="list in enquiryLocationRow| filter:search | filter:searchData | itemsPerPage:itemsPerPage">
                            <td>{{ itemsPerPage * (noOfRows - 1) + $index + 1}}</td>   
                            <td>{{ list.city_name}}</td> 
                            <td>{{ list.location}}</td>                          
                            <td class="fa-div">
                                <div class="fa-hover" tooltip-html-unsafe="Edit" style="display: block;" data-toggle="modal" data-target="#locationModal"><a href="javascript:void(0);" ng-click="initialModal({{list.id}},{{list}},{{ itemsPerPage}},{{$index}})"><i class="fa fa-pencil"></i></a></div>
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
                <div data-ng-include="'/EnquiryLocations/showFilter'"></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="locationModal" role="dialog" tabindex="-1">    
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">{{heading}}</h4>
                </div>
                <form novalidate ng-submit="EnqLocationForm.$valid && doEnqLocationAction(EnqLocation)" name="EnqLocationForm">
                    <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!EnqLocationForm.country_id.$dirty && EnqLocationForm.country_id.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <label>Country</label>
                            <span class="input-icon icon-right">
                                <select id="country_id" name="country_id" required class="form-control"  ng-model="EnqLocation.country_id" ng-change="manageStates(EnqLocation.country_id)">
                                    <option value="">Select Country</option>
                                    <option ng-repeat="country in countryRow" ng-selected="{{country_id == country.id}}" value="{{country.id}}">{{country.name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="EnqLocationForm.country_id.$error">
                                    <div ng-message="required">Select country</div>
                                </div>
                            </span>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!EnqLocationForm.state_id.$dirty && EnqLocationForm.state_id.$invalid) }" >
                            <label>State</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="EnqLocation.state_id" name="state_id"  required   ng-change="manageCity(EnqLocation.state_id)">
                                    <option value="">Select state</option>
                                    <option  ng-repeat="itemone in statesRow" ng-selected="{{ states == itemone.id}}" value="{{itemone.id}}">{{itemone.name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="EnqLocationForm.state_id.$error">
                                    <div ng-message="required">Select state</div>
                                </div>
                            </span>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!EnqLocationForm.city_id.$dirty && EnqLocationForm.city_id.$invalid) }">
                            <label>City</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="EnqLocation.city_id" name="city_id"  required>
                                    <option value="">Select city</option>
                                    <option  ng-repeat="itemone in cityRow" ng-selected="{{ city == itemone.id}}" value="{{itemone.id}}">{{itemone.name}}</option>
                                </select>
                                <i class="fa fa-sort-desc"></i>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="EnqLocationForm.city_id.$error">
                                    <div ng-message="required">Select state</div>
                                </div>
                            </span>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!EnqLocationForm.location.$dirty && EnqLocationForm.location.$invalid)}">
                            <label>Location</label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="EnqLocation.location" name="location" ng-change="errorMsg = null" required>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="EnqLocationForm.location.$error">
                                    <div ng-message="required">Location name is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-primary" ng-click="sbtBtn = true">{{action}}</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>

    <!-- Filter Form Start-->
    <div class="wrap-filter-form show-widget" id="slideout">
        <form name="enqLocationFilter" role="form" ng-submit="filterDetails(searchDetails)" class="embed-contact-form">
            <strong>Filter</strong>   
            <button type="button" class="close toggleForm" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><hr>

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">City Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.city_name" name="city_name" class="form-control" >
                        </span>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Location Name</label>
                        <span class="input-icon icon-right">
                            <input type="text" ng-model="searchDetails.location" name="location" class="form-control">
                        </span>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" >
                    <div class="form-group">
                        <span class="input-icon icon-right" >
                            <button type="submit"  style="margin-left: 46%;" name="sbtbtn" value="Search" class="btn btn-primary toggleForm">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/js/filterSlider.js"></script>
    <!-- Filter Form End-->
</div>

