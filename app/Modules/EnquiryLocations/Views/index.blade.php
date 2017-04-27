<div class="row" ng-controller="enquiryLocationCtrl" ng-init="enquiryLocation(); manageCountry();">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Manage Enquiry Location</span>
                <a href="" data-toggle="modal" data-target="#locationModal" ng-click="initialModal(0, '', '', '','','')" class="btn btn-info">Create Enquiry Location</a>&nbsp;&nbsp;&nbsp;
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <label for="search">Search:</label>
                        <input type="text" ng-model="search" class="form-control" style="width:25%;" placeholder="Search">
                    </div>

                    <div class="col-sm-6 col-xs-12">
                        <label for="search">Records per page:</label>
                        <input type="number" min="1" max="50" style="width:25%;" class="form-control" ng-model="itemsPerPage">
                    </div>
                </div><br>           
                <table class="table table-hover table-striped table-bordered" at-config="config">
                    <thead class="bord-bot">
                        <tr>
                        <tr>
                            <th style="width:5%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'id'; reverseSort = !reverseSort">SR No.
                                    <span ng-show="orderByField == 'id'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th> 

                            <th style="width:25%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'city'; reverseSort = !reverseSort">City
                                    <span ng-show="orderByField == 'city'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th> 
                            <th style="width:25%">
                                <a href="javascript:void(0);" ng-click="orderByField = 'location'; reverseSort = !reverseSort">Enquiry location
                                    <span ng-show="orderByField == 'location'">
                                        <span ng-show="!reverSort">^</span><span ng-show="reverseSort">v</span></span>
                                </a></th>                           
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr role="row" dir-paginate="list in enquiryLocationRow| filter:search | itemsPerPage:itemsPerPage | orderBy:orderByField:reverseSort">
                            <td>{{itemsPerPage * (noOfRows - 1) + $index + 1}} </td>

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
                <form novalidate ng-submit="EnqLocationForm.$valid && doEnqLocationAction(state_id)" name="EnqLocationForm">
                     <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken='<?php echo csrf_token(); ?>'" class="form-control">
                   
                    <div class="modal-body">
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!EnqLocationForm.country_id.$dirty && EnqLocationForm.country_id.$invalid)}">
                            <input type="hidden" class="form-control" ng-model="id" name="id">
                            <label>Country</label>
                            <span class="input-icon icon-right">
                                <select id="country_id" name="country_id" required class="form-control" ng-model="country_id" ng-options="item.id as item.name for item in countryRow" ng-change="manageStates()">
                                    <option value="">Select country</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="EnqLocationForm.country_id.$error">
                                    <div ng-message="required">Select country</div>
                                </div>
                            </span>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!EnqLocationForm.state_id.$dirty && EnqLocationForm.state_id.$invalid) }" >
                            <label>State</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="state_id" name="state_id"  required   ng-change="manageCity(state_id)">
                                    <option value="">Select state</option>
                                    <option  ng-repeat="itemone in statesRow" ng-selected="{{ state_id == itemone.id}}" value="{{itemone.id}}">{{itemone.name}}</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="EnqLocationForm.state_id.$error">
                                    <div ng-message="required">Select state</div>
                                </div>
                            </span>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!EnqLocationForm.city_id.$dirty && EnqLocationForm.city_id.$invalid) }">
                            <label>City</label>
                            <span class="input-icon icon-right">
                                <select class="form-control" ng-model="city_id" name="city_id"  required>
                                    <option value="">Select city</option>
                                    <option  ng-repeat="itemone in cityRow" ng-selected="{{ city_id == itemone.id}}" value="{{itemone.id}}">{{itemone.name}}</option>
                                </select>
                                <div class="help-block" ng-show="sbtBtn" ng-messages="EnqLocationForm.city_id.$error">
                                    <div ng-message="required">Select state</div>
                                </div>
                            </span>
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!EnqLocationForm.location.$dirty && EnqLocationForm.location.$invalid)}">
                            <label>Location</label>
                            <span class="input-icon icon-right">
                                <input type="text" class="form-control" ng-model="location" name="location" ng-change="errorMsg = null" required>
                              
                                <div class="help-block" ng-show="sbtBtn" ng-messages="EnqLocationForm.location.$error">
                                    <div ng-message="required">Location name is required</div>
                                    <div ng-if="errorMsg">{{errorMsg}}</div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">Submit</button>
                    </div> 
                </form>           
            </div>
        </div>
    </div>
</div>

