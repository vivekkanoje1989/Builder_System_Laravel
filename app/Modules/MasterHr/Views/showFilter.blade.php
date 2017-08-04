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


                        <form name="calllogsFilter" role="form" ng-submit="filteredData(filterData, 1, [[config('global.recordsPerPage')]])">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12" >
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="filterData.firstName" name="firstName" placeholder="First Name">
                                            <i class="fa fa-user thm-color circular"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Designation</label>
                                        <span class="input-icon icon-right">
                                            <p class="input-group input-icon">
                                                <input type="text" ng-model="filterData.designation_id"  name="designation_id" class="form-control" placeholder="Designation" />
                                            </p>
                                        </span>
                                    </div>
                                </div>
                            </div>        
                            <div class="row">
                                <div class="col-sm-6 col-xs-12" >
                                    <div class="form-group">
                                        <label for="">Department</label>
                                        <span class="input-icon icon-right">
                                            <input type="text" class="form-control" ng-model="filterData.department_id" name="department_id" placeholder="Department">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12" ng-controller="DatepickerDemoCtrl">
                                    <div class="form-group">
                                        <label for="">From Date</label>
                                        <span class="input-icon icon-right">
                                            <p class="input-group">
                                                <input type="text" ng-model="filterData.joining_date" placeholder="select join date" name="joining_date" id="fromDate" class="form-control" datepicker-popup="d-MM-yyyy" is-open="opened" max-date=maxDate datepicker-options="dateOptions" close-text="Close" ng-change="clearToDate()" ng-click="toggleMin()" readonly/>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                </span>
                                            </p>
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
