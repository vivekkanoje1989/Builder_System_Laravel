<div class="row" ng-controller="projectController" ng-init="getProjectWings(<?php echo $Id; ?>)">  
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Flat Availability Status</span>

                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
            </div>
            <div class="widget-body table-responsive">     


                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">

                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="tabbable tabs-left">
                                    <ul class="nav nav-tabs" id="myTab3">

                                        <li  ng-class='{active:$first}' class="tab-sky" ng-repeat="wings in projectWingsRow" ng-click="getFloorDetails(<?php echo $Id; ?>,{{wings.id}});">
                                            <a data-toggle="tab" href="#{{wings.project_name}}">
                                                {{wings.wing_name}}
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="{{wings.project_name}}" class="tab-pane in active"v >
                                            <div class="col-xs-12 col-md-6">
                                                <div class="well with-header with-footer">
                                                    <div class="header bg-palegreen">
                                                        <tr>
                                                               <p class="info-div">&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <span style="float:left;"><b>Availability Status :</b></span> 
                                                                <span style="margin-left: 10px;background-color:Green;float:left;width:12px;height:12px;margin-top:6px;">&nbsp;</span>
                                                                <span style="margin-left: 5px;float:left;"><b>Available</b></span> 
                                                                <span style="margin-left: 10px;background-color:orange;float:left;width:12px;height:12px;margin-top:6px;">&nbsp;</span>
                                                                <span style="margin-left: 5px;float:left;"><b>Hold</b></span> 
                                                                <span style="margin-left: 10px;background-color:#dadada;float:left;width:12px;height:12px;margin-top:6px;">&nbsp;</span>
                                                                <span style="margin-left: 5px;float:left;"><b>Sold</b></span> 

                                                            </p>
                                                            </tr>
                                                    </div>
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td width="10%">1</td>
                                                                <td><div class="row"><div class="col-md-2" >
                                                                            <div style="width:80px;height:80px;background-color:green; margin-left: 20px;" >{{floor.block_sub_type}}</div>
                                                                            
                                                                        </div><div class="col-md-2" >
                                                                        <div style="width:120px;height:80px;background-color:green; margin-left: 20px;" >{{floor.block_sub_type}}</div></div></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="horizontal-space"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

