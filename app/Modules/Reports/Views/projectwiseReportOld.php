<div class="row" ng-controller="reportsController">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Project wise report</span>
            </div>
            <div class="widget-body table-responsive">     
                <div class="row">
                    <div class="col-sm-3 col-xs-12" ng-controller="projectCtrl">
                        <label for="search">Select Project:</label>
                        <select id="country_id" name="country_id" class="form-control" ng-model="project" ng-options="item.id as item.project_name for item in projectList" ng-change="projectWiseReport(item.id)" required>
                            <option value="">Select Projects</option>
                        </select>
                        <br/> </div>

                    <table class="table table-hover table-striped table-bordered" at-config="config">
                        <thead class="bord-bot">
                            <tr>
                            <tr>
                                <th style="width:25%">
                                    category wise report
                                </th> 
                                <th style="width:25%">
                                    status wise report
                                </th>                           
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row">
                                <td>
                                    <hr/>
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <tbody>
                                            <tr><td>Hot</td><td></td></tr>
                                            <tr><td>Warm</td><td></td></tr>
                                            <tr><td>Cold</td><td></td></tr>
                                            <tr><td>Total</td><td></td></tr>
                                        </tbody>
                                    </table>    
                                </td>                         
                                <td>
                                    <hr/>
                                    <table class="table table-hover table-striped table-bordered" at-config="config">
                                        <tbody>
                                            <tr><td>Open</td><td></td></tr>
                                            <tr><td>Booked</td><td></td></tr>
                                            <tr><td>Lost</td><td></td></tr>
                                            <tr><td>Total</td><td></td></tr>
                                        </tbody>
                                    </table>    
                                </td>                        

                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="cityModal" role="dialog" tabindex="-1">    
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" align="center">{{heading}}</h4>
                    </div>
                    <form novalidate ng-submit="citiesForm.$valid && doCitiesAction()" name="citiesForm">
                        <input type="hidden" ng-model="csrfToken" name="csrftoken" id="csrftoken" ng-init="csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">

                        <div class="modal-body">
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!citiesForm.country_id.$dirty && citiesForm.country_id.$invalid)}">
                                <input type="hidden" class="form-control" ng-model="id" name="id">
                                <label>Country<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select id="country_id" name="country_id" class="form-control" ng-model="country_id" ng-options="item.id as item.name for item in countryRow" ng-change="manageStates()" required>
                                        <option value="">Select country</option>
                                    </select>
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="citiesForm.country_id.$error">
                                        <div ng-message="required">Select Country</div>
                                    </div>
                                </span>
                            </div>    
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!citiesForm.state_id.$dirty && citiesForm.state_id.$invalid)}">

                                <label>State<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <select class="form-control" ng-model="state_id" name="state_id" required>
                                        <option value="">Select state</option>
                                        <option  ng-repeat="itemone in statesRow" ng-selected="{{ itemone.id == states}}" value="{{itemone.id}}">{{itemone.name}}</option>
                                    </select>
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="citiesForm.state_id.$error">
                                        <div ng-message="required">Select State</div>
                                    </div>
                                </span>
                            </div>
                            <div class="form-group" ng-class="{ 'has-error' : sbtBtn && (!citiesForm.name.$dirty && citiesForm.name.$invalid)}">
                                <label>City<span class="sp-err">*</span></label>
                                <span class="input-icon icon-right">
                                    <input type="text" class="form-control" ng-model="name" name="name"  ng-change="errorMsg = null" required>
                                    <div class="help-block" ng-show="sbtBtn" ng-messages="citiesForm.name.$error">
                                        <div ng-message="required">City name is required</div>
                                        <div ng-if="errorMsg" class="err">{{errorMsg}}</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer" align="center">
                            <button type="Submit" class="btn btn-sub" ng-click="sbtBtn = true">{{action}}</button>
                        </div> 
                    </form>           
                </div>
            </div>
        </div>
    </div>

