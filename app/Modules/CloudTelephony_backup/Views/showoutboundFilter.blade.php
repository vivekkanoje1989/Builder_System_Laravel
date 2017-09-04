<div class="modal fade" id="showFilterModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Filters</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">


                        <form name="calllogsFilter" role="form" ng-submit="filteredoutboundData(filterData, 1, [[ config('global.recordsPerPage') ]])">
                            <div class="row" ng-controller="employeesWiseTeamCtrl">
                                <div class="col-sm-6 col-sx-12" ng-if="employeesData.length > 0 && type == 1">
                                    <div class="form-group">
                                        <label for="">Select Call By</label>
                                        <span class="input-icon icon-right">
                                            <ui-select multiple ng-model="filterData.empId" name="empId" theme="select2"  style="width: 100%;">
                                                <ui-select-match placeholder='Select Employee'>{{ $item.first_name}} {{$item.last_name}}</ui-select-match>
                                                <ui-select-choices repeat="list in employeesData | filter:$select.search " ng-hide="!$select.open">
                                                    <span>
                                                        {{ list.first_name}} {{ list.last_name}}
                                                    </span>
                                                </ui-select-choices>
                                            </ui-select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                    <div class="form-group">
                                        <label for="">From Date</label>
                                        <span class="input-icon icon-right">
                                            <p class="input-group">
                                                <input type="text" ng-model="filterData.fromDate" placeholder="select from date" name="fromDate" id="fromDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </span>
                                            </p>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                    <div class="form-group">
                                        <label for="">To Date</label>
                                        <span class="input-icon icon-right">
                                            <p class="input-group">
                                                <input type="text" ng-model="filterData.toDate"  placeholder="select to date" min-date="filterData.fromDate" name="toDate" id="toDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-click="toggleMin()" readonly/>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </span>
                                            </p>
                                        </span>
                                    </div>
                                </div>
                            </div>                                   
                            <div class="row" ng-controller="virtualnumberCtrl">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Call Status</label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="filterData.callstatus" name="callstatus" class="form-control">
                                                <option value="">Select call status</option>
                                                <option ng-repeat="status in statuscall" value="{{status}}">{{status}}</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>
                                 <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Customer Number</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" ng-model="filterData.customer_number" name="customer_number" class="form-control" value="{{customer_number}}">
                                            
                                        </span>
                                    </div>
                                </div>
                            
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12" >
                                    <div class="form-group">
                                        <span class="input-icon icon-right" >
                                            <button type="submit"  style="margin-left: 46%;" name="sbtbtn" value="Search" class="btn btn-primary">Search</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
