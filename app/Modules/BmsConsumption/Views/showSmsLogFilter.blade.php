<div class="modal fade" id="showSmsFilterModal" role="dialog" tabindex='-1' data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header navbar-inner">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" align="center">Filters</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">


                        <form name="calllogsFilter" role="form" ng-submit="filteredData(filterData, 1, [[ config('global.recordsPerPage') ]])">
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
                            <div class="row">
<!--                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Mobile Number</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" name="mobile_number" ng-model="filterData.mobile_number" class="form-control">
                                        </span>
                                    </div>
                                </div>-->

                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Sms Type</label>
                                        <span class="input-icon icon-right">
                                            <select ng-model="filterData.sms_type" name="sms_type" class="form-control">
                                                <option value=""> Sms Type</option>
                                                <option value="0">Regular Sms</option>
                                                <option value="1">Flash Sms</option>
                                            </select>
                                            <i class="fa fa-sort-desc"></i>
                                        </span>
                                    </div>
                                </div>
<!--                            </div>
                            <div class="row">-->
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Transaction Id</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" name="externalId1" ng-model="filterData.externalId1" class="form-control">
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
