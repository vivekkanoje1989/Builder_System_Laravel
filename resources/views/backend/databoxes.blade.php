﻿<div class="row" ng-controller="DataboxesCtrl">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="well bordered-left bordered-themeprimary">
                    <p>BeyondAdmin's Databoxes are meant to provide you a completely flexible  and very easy to customize tool to visualize data. You can create databoxes in multiple sizes and different styles. </p>
                    <p>Basically there are two types of Databoxes: <strong>Horizontal</strong> and <strong>Vertical</strong>.</p>
                    <p>You can user pre-defined styles to create infinite types of Databoxes to visualize data in your own fashion. These are just examples that i've made to show you how databoxes work. There is no limitation in your imagination and creativity.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox databox-graded">
                    <div class="databox-left no-padding">
                        <img src="backend/assets/img/avatars/divyia.jpg" style="width:65px; height:65px;">
                    </div>
                    <div class="databox-right padding-top-20">
                        <div class="databox-stat yellow radius-bordered">
                            <i class="stat-icon fa fa-envelope-o"></i>
                        </div>
                        <div class="databox-text darkgray">DIVYIA JONES</div>
                        <div class="databox-text darkgray">Manager</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox">
                    <div class="databox-left bg-white">
                        <div class="databox-sparkline">
                            <div style="height: 240px;" ui-jq="sparkline" ui-options="[5,6,7,2,0,-4,-2,4], {type:'bar', height:40, width:'100%', barColor:'#57b5e3', negBarColor:'#a0d468', zeroColor:'#d73d32', barWidth:5, barSpacing:1  }"></div>
                        </div>
                    </div>
                    <div class="databox-right bg-white bordered bordered-platinum">
                        <span class="databox-number sky">2485</span>
                        <div class="databox-text darkgray">PAGE VIEWS</div>
                        <div class="databox-stat bg-palegreen radius-bordered">
                            <div class="stat-text">8%</div>
                            <i class="stat-icon fa fa-arrow-up"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox radius-bordered databox-shadowed databox-graded">
                    <div class="databox-left bg-lightred">
                        <div class="databox-piechart">
                            <div class="easyPieChart" ui-jq="easyPieChart" ui-options="{ percent: 50, lineWidth: 3, barColor:'#fff', trackColor: 'rgba(255,255,255,0.1)' , scaleColor:false, size: 47, lineCap: 'butt', animate: 500 }"><span class="white font-90">50%</span></div>
                        </div>
                    </div>
                    <div class="databox-right">
                        <span class="databox-number lightred">322</span>
                        <div class="databox-text darkgray">UNIQUE USERS</div>
                        <div class="databox-stat bg-lightred radius-bordered">
                            <div class="stat-text">4%</div>
                            <i class="stat-icon fa fa-arrow-down"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox databox-halved radius-bordered databox-shadowed">
                    <div class="databox-left bg-whitesmoke">
                        <div style="height: 240px;" ui-jq="sparkline" ui-options="[4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], {type:'line', height:45, width:'100%', fillColor:false, lineColor:'#a0d468' , highlightSpotColor:'#a0d468', highlightLineColor:'#a0d468'  }"></div>
                    </div>
                    <div class="databox-right bg-sky padding-10">
                        <span class="databox-title white">Users</span>
                        <div class="databox-text white">Visit Statistics</div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="databox radius-bordered databox-shadowed databox-graded">
                    <div class="databox-left bg-orange">
                        <div class="databox-piechart">
                            <div class="easyPieChart" ui-jq="easyPieChart" ui-options="{ percent: 42, lineWidth: 3, barColor:'#fff', trackColor: 'rgba(255,255,255,0.1)' , scaleColor:false, size: 47, lineCap: 'butt', animate: 500 }"><span class="white font-90">42%</span></div>
                        </div>
                    </div>
                    <div class="databox-right">
                        <span class="databox-number orange">14</span>
                        <div class="databox-text darkgray">NEW TASKS</div>
                        <div class="databox-stat orange radius-bordered">
                            <i class="stat-icon icon-lg fa fa-tasks"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="databox radius-bordered databox-shadowed databox-graded">
                    <div class="databox-left bg-yellow">
                        <div class="databox-piechart">
                            <div class="easyPieChart" ui-jq="easyPieChart" ui-options="{ percent: 15, lineWidth: 3, barColor:'#fff', trackColor: 'rgba(255,255,255,0.1)' , scaleColor:false, size: 47, lineCap: 'butt', animate: 500 }"><span class="white font-90">15%</span></div>

                        </div>
                    </div>
                    <div class="databox-right">
                        <span class="databox-number yellow">1</span>
                        <div class="databox-text darkgray">NEW MESSAGE</div>
                        <div class="databox-stat yellow radius-bordered">
                            <i class="stat-icon  icon-lg fa fa-envelope-o"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="databox radius-bordered databox-shadowed databox-graded">
                    <div class="databox-left bg-azure">
                        <div class="databox-piechart">
                            <div class="easyPieChart" ui-jq="easyPieChart" ui-options="{ percent: 76, lineWidth: 3, barColor:'#fff', trackColor: 'rgba(255,255,255,0.1)' , scaleColor:false, size: 47, lineCap: 'butt', animate: 500 }"><span class="white font-90">76%</span></div>
                        </div>
                    </div>
                    <div class="databox-right">
                        <span class="databox-number azure">98</span>
                        <div class="databox-text darkgray">NEW USERS</div>
                        <div class="databox-state bg-azure">
                            <i class="fa fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox databox-transparent">
                    <div class="databox-left no-padding">
                        <div class="databox-piechart">
                            <div class="easyPieChart block-center" ui-jq="easyPieChart" ui-options="{ percent: 80, lineWidth: 2, barColor:'#fb6e52', trackColor: '#eee' , scaleColor:false, size: 65, lineCap: 'butt', animate: 500 }"><span class="databox-text darkgray">VISITS</span></div>
                        </div>
                    </div>
                    <div class="databox-right">
                        <div class="databox-sparkline padding-5">
                            <div style="height: 240px;" ui-jq="sparkline" ui-options="[4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], {type:'bar', height:50, width:'100%', barColor:'#fff', negBarColor:'#f5f5f5', zeroColor:'#d73d32' , barWidth:6, barSpacing:5 }"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <h6 class="row-title before-blue">Large Databoxes</h6>
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="databox databox-lg radius-bordered databox-shadowed">
                    <div class="databox-left bg-white">
                        <div class="databox-sparkline">
                            <div style="height: 240px;" ui-jq="sparkline" ui-options="[2,2,3,1,3,3,2,2,1], {type:'bar', height:40, width:'100%', barColor:'#11a9cc', barwidth:7, barspacing:3 }"></div>
                        </div>
                    </div>
                    <div class="databox-right bordered-thick bordered-sky bg-white">
                        <span class="databox-number sky"><i class="fa fa-user"></i>2485</span>
                        <div class="databox-text darkgray">NEW & RETURNING USERS</div>
                        <div class="databox-stat bg-sky radius-bordered">
                            <div class="stat-text">10 %</div>
                            <i class="stat-icon fa fa-long-arrow-up"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="databox databox-lg radius-bordered databox-shadowed databox-graded">
                    <div class="databox-left bg-palegreen">
                        <div class="databox-piechart">
                            <div class="easyPieChart" ui-jq="easyPieChart" ui-options="{ percent: 50, lineWidth: 3, barColor:'#fff', trackColor: '#aadc95' , scaleColor:false, size: 60, lineCap: 'butt', animate: 500 }"><span class="white font-90">50%</span></div>
                        </div>
                    </div>
                    <div class="databox-right">
                        <span class="databox-number green">206</span>
                        <div class="databox-text darkgray">TRAFFIC USED (GB)</div>
                        <div class="databox-stat bg-palegreen radius-bordered">
                            <div class="stat-text">10%</div>
                            <i class="stat-icon fa fa-arrow-up"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="databox databox-halved databox-lg radius-bordered databox-shadowed">
                    <div class="databox-left bg-white">
                        <div class="databox-sparkline">
                            <div style="height: 240px;" ui-jq="sparkline" ui-options="[8,4,0,1,4,6,2,4,4,8,10,7,10], {type:'bar', height:40, width:'100%', barColor:'#5db2ff', negBarColor:'#f4b400', zeroColor:'#d73d32', barwidth:7, barspacing:5 }"></div>
                        </div>
                    </div>
                    <div class="databox-right bg-pink">
                        <span class="databox-title white">Users</span>
                        <div class="databox-text white">Visit Statistics</div>

                    </div>
                </div>
            </div>
        </div>
        <h6 class="row-title before-darkorange">Larger Databoxes</h6>
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="databox databox-xlg radius-bordered databox-shadowed">
                    <div class="databox-left bg-snow">
                        <div class="databox-piechart">
                            <div class="easyPieChart" ui-jq="easyPieChart" ui-options="{ percent: 60, lineWidth: 7, barColor:'#11a9cc', trackColor: '#ffce55' , scaleColor:false, size: 150, lineCap: 'butt', animate: 500 }"><span class="sky font-150"><i class="fa fa-envelope"></i> Mail</span></div>
                        </div>
                    </div>
                    <div class="databox-right no-padding bordered-thick bordered-whitesmoke">
                        <div class="databox-row row-6 bg-orange padding-10">
                            <div style="height: 65px;" ui-jq="sparkline" ui-options="[2,6,7,9,8,5,3,4,4,3,6,7], {type:'line', height:65, width:'100%', fillColor:false, lineColor:'#fff', spotColor:'#fafafa', minSpotColor:'#fafafa', maxSpotColor:'#ffce55', highlightSpotColor:'#fff', highlightLineColor:'#fff', lineWidth:3, spotRadius:5 }"></div>
                        </div>
                        <div class="databox-row row-3 bg-yellow padding-10">
                            <span class="databox-title pull-left no-margin"><i class="fa fa-envelope"></i> Inbox</span>
                            <span class="databox-number pull-right no-margin">129</span>
                        </div>
                        <div class="databox-row row-3 bg-sky padding-10">
                            <span class="databox-title pull-left"><i class="fa fa-mail-forward"></i> Sent</span>
                            <span class="databox-number pull-right no-margin">32</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="databox databox-xlg radius-bordered databox-shadowed databox-graded">
                    <div class="databox-left bg-pink">
                        <div class="databox-piechart">
                            <div class="easyPieChart" ui-jq="easyPieChart" ui-options="{ percent: 60, lineWidth: 7, barColor:'#fff', trackColor: '#f89cbd' , scaleColor:false, size: 150, lineCap: 'butt', animate: 500 }"><span class="white font-150"><i class="fa fa-bell"></i> Users</span></div>
                        </div>
                    </div>
                    <div class="databox-right bordered-thick bordered-warning">
                        <div class="databox-row row-6 bordered-bottom bordered-platinum padding-10">
                            <div class="databox-cell cell-6 no-padding">
                                <span class="databox-title darkgray">Overview</span>
                                <span class="databox-text darkgray">Your website statistics</span>
                            </div>
                            <div class="databox-cell cell-6 no-padding">

                            </div>

                        </div>
                        <div class="databox-row row-3 bordered-bottom bordered-platinum">
                            <span class="databox-text darkgray padding-10">RETURNING USERS</span>
                            <div class="databox-stat bg-yellow radius-bordered">
                                <div class="stat-text">12 %</div>
                                <i class="stat-icon fa fa-arrow-down"></i>
                            </div>
                        </div>
                        <div class="databox-row row-3">
                            <span class="databox-text darkgray padding-10">NEW USERS</span>
                            <div class="databox-stat bg-pink radius-bordered">
                                <div class="stat-text">8 %</div>
                                <i class="stat-icon fa fa-arrow-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="databox databox-xlg radius-bordered databox-shadowed databox-graded databox-inverted">
                    <div class="databox-left bg-orange no-padding">
                        <div class="horizontal-space"></div>
                        <div class="databox-stat bg-white radius-bordered">
                            <div class="stat-text orange">8%</div>
                            <i class="stat-icon fa fa-arrow-up orange"></i>
                        </div>
                        <div class="databox-stat stat-left radius-bordered">
                            <div class="stat-text">Burndown</div>
                        </div>
                        <div class="databox-sparkline">
                            <div ui-jq="sparkline" ui-options="[2,6,7,9,8,5,3,4,4,3,6,7], {type:'line', height:158, width:'100%', fillColor:'#fc8973', lineColor:'#fff', spotColor:'#fafafa', minSpotColor:'#fafafa', maxSpotColor:'#ffce55', highlightSpotColor:'#fff', highlightLineColor:'#fff', lineWidth:3, spotRadius:0 }"></div>
                        </div>
                    </div>
                    <div class="databox-right bordered-thick bordered-white bg-whitesmoke">
                        <div class="databox-row row-3 bordered-bottom bordered-platinum padding-10">
                            <span class="databox-text darkgray pull-left no-margin">Messages</span>
                            <span class="badge badge-default graded pull-right">1</span>
                        </div>
                        <div class="databox-row row-3 bordered-bottom bordered-platinum padding-10">
                            <span class="databox-text darkgray pull-left no-margin">Tasks In Progress</span>
                            <span class="badge badge-default graded pull-right">8</span>
                        </div>
                        <div class="databox-row row-3 bordered-bottom bordered-platinum padding-10">
                            <span class="databox-text darkgray pull-left no-margin">Tasks Done</span>
                            <span class="badge badge-default graded pull-right">7</span>
                        </div>
                        <div class="databox-row row-3 padding-10">
                            <span class="databox-text darkgray pull-left no-margin">Backlogs</span>
                            <span class="badge badge-default graded pull-right">2</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="databox databox-xlg radius-bordered databox-shadowed databox-graded">

                    <div class="databox-left bg-ivory">
                        <div class="databox-piechart padding-10">
                            <div class="easyPieChart" ui-jq="easyPieChart" ui-options="{ percent: 25, lineWidth: 10, barColor:'#2dc3e8', trackColor: '#fafafa' , scaleColor:false, size: 130, lineCap: 'butt', animate: 500 }"><span class="sky font-150"><i class="fa fa-cloud-download"></i> 25% </span></div>
                        </div>
                    </div>
                    <div class="databox-right bg-azure bordered-thick bordered-white no-padding">
                        <div class="horizontal-space space-lg"></div>
                        <div class="databox-stat radius-bordered">
                            <div class="stat-text">Download/Upload</div>
                        </div>

                        <div class="databox-sparkline">
                            <div style="height: 65px;" ui-jq="sparkline" ui-options="[5, 4, 1, 5, 3, 2, 1, 2], {type:'line', height:153, width:'100%', fillColor:false, lineColor:'#fff', spotColor:'#fafafa', minSpotColor:'#fafafa', maxSpotColor:'#ffce55', highlightSpotColor:'#fff', highlightLineColor:'#fff', lineWidth:2, spotRadius:0 }"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <h6 class="row-title before-yellow">Largest Databoxes</h6>
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="databox databox-xxlg radius-bordered databox-shadowed databox-halved">
                    <div class="databox-left bg-whitesmoke padding-top-10">
                        <div class="databox-stat bg-orange radius-bordered">
                            <div class="stat-text">24 %</div>
                            <i class="stat-icon fa fa-long-arrow-down"></i>
                        </div>
                        <div class="databox-stat stat-left radius-bordered">
                            <div class="stat-text darkgray">CPU USAGE</div>
                        </div>
                        <canvas id="pie" height="230" width="230"></canvas>
                    </div>
                    <div class="databox-right bordered-thick bordered-whitesmoke bg-blue no-padding">
                        <div class="databox-stat bg-yellow radius-bordered">
                            <div class="stat-text">10 %</div>
                            <i class="stat-icon fa fa-long-arrow-up"></i>
                        </div>
                        <div class="databox-stat stat-left radius-bordered">
                            <div class="stat-text white">CPU USAGE</div>
                        </div>
                        <div databox-flot-chart-realtime class="chart chart-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vertical Databoxes -->
        <h6 class="row-title before-azure">Vertical Databoxes</h6>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
                    <div class="databox-top bg-blue">
                        <div class="databox-icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                    <div class="databox-bottom text-align-center">
                        <span class="databox-text">FRIDAY - 2014 16 MAY</span>
                        <span class="databox-text">11:24 - AM</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox radius-bordered databox-shadowed databox-vertical">
                    <div class="databox-top bg-orange no-padding">
                        <div class="databox-row row-2"></div>
                        <div class="databox-row row-10">
                            <div class="databox-sparkline">
                                <div style="height: 65px;" ui-jq="sparkline" ui-options="[2,4,5,6,3,2,0,4,2,4,3,2,6,4,5,1,4,5,6,9,1], {type:'bar', height:42, width:'100%', barColor:'#e7573a', negBarColor:'#e7573a', zeroColor:'#e7573a', barWidth:7, barSpacing:3 }"></div>
                            </div>
                        </div>
                    </div>
                    <div class="databox-bottom no-padding bg-white">
                        <div class="databox-row">
                            <div class="databox-cell cell-6 text-align-center bordered-right bordered-platinum">
                                <span class="databox-number lightcarbon">206</span>
                                <span class="databox-text sonic-silver no-margin">FOLLOWERS</span>
                            </div>
                            <div class="databox-cell cell-6 text-align-center">
                                <span class="databox-number lightcarbon">405</span>
                                <span class="databox-text sonic-silver no-margin">FOLLOWING</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
                    <div class="databox-top no-padding ">
                        <div class="databox-row">
                            <div class="databox-cell cell-6 text-align-center bg-sky">
                                <span class="databox-number">13</span>
                                <span class="databox-text">TASKS</span>
                            </div>
                            <div class="databox-cell cell-6 text-align-center bg-azure">
                                <span class="databox-number">9</span>
                                <span class="databox-text">BACKLOGS</span>
                            </div>
                        </div>
                    </div>
                    <div class="databox-bottom">
                        <span class="databox-text">TASKS</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar progress-bar-azure" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                <span class="sr-only">
                                    20% Complete
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox radius-bordered databox-shadowed databox-graded databox-vertical">
                    <div class="databox-top no-padding ">
                        <div class="databox-row">
                            <div class="databox-cell cell-6 text-align-center bg-orange">
                                <span class="databox-number">9</span>
                                <span class="databox-text">ORDERS</span>
                            </div>
                            <div class="databox-cell cell-6 text-align-center bg-darkorange">
                                <span class="databox-number">3</span>
                                <span class="databox-text">DELIVERED</span>
                            </div>
                        </div>
                    </div>
                    <div class="databox-bottom">
                        <span class="databox-text">DELIVERY PERCENT</span>
                        <div class="progress progress-sm">
                            <div class="progress-bar progress-bar-orange" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:30%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <h6 class="row-title before-orange">Large Vertical Databoxes</h6>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox databox-lg databox-inverted radius-bordered databox-shadowed databox-graded databox-vertical">
                    <div class="databox-top bg-palegreen no-padding">
                        <div class="horizontal-space space-lg"></div>
                        <div class="databox-sparkline no-margin">
                            <div style="height: 65px;" ui-jq="sparkline" ui-options="[8,4,1,2,4,6,2,4,4,8,10,7,10], {type:'line', height:82, width:'100%', fillColor:false, lineColor:'#fff', spotColor:'#fafafa', minSpotColor:'#fafafa', maxSpotColor:'#ffce55', highlightSpotColor:'#fff', highlightLineColor:'#fff', lineWidth:2, spotRadius:3 }"></div>
                        </div>
                    </div>
                    <div class="databox-bottom no-padding">
                        <div class="databox-row">
                            <div class="databox-cell cell-6 text-align-left">
                                <span class="databox-text">Sales Total</span>
                                <span class="databox-number">$23,657</span>
                            </div>
                            <div class="databox-cell cell-6 text-align-right">
                                <span class="databox-text">September</span>
                                <span class="databox-number font-70">$1,257</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox databox-lg databox-inverted radius-bordered databox-shadowed databox-graded databox-vertical">
                    <div class="databox-top no-padding">
                        <img src="backend/assets/img/temp1.png" alt="" style="height:100px; width:100%;" />
                    </div>
                    <div class="databox-bottom no-padding bordered-thick bordered-orange">
                        <div class="databox-row">
                            <div class="databox-cell cell-4 no-padding text-align-center bordered-right bordered-platinum">
                                <span class="databox-number lightcarbon no-margin">510</span>
                                <span class="databox-text sonic-silver  no-margin">Posts</span>
                            </div>
                            <div class="databox-cell cell-4 no-padding text-align-center bordered-right bordered-platinum">
                                <span class="databox-number lightcarbon no-margin">908</span>
                                <span class="databox-text sonic-silver no-margin">Followers</span>
                            </div>
                            <div class="databox-cell cell-4 no-padding text-align-center">
                                <span class="databox-number lightcarbon no-margin">286</span>
                                <span class="databox-text sonic-silver no-margin">Following</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6 col-xs-12">
                <div class="databox databox-lg databox-halved radius-bordered databox-shadowed databox-vertical">
                    <div class="databox-top bg-darkorange no-padding">
                        <div class="databox-icon">
                            <i class="wi wi-cloudy-windy"></i>
                        </div>
                    </div>
                    <div class="databox-bottom bg-white no-padding">
                        <div class="databox-row text-align-center">
                            <div class="databox-cell cell-6 bordered-right bordered-platinum padding-5">
                                <span class="databox-number lightcarbon">14°</span>
                                <span class="databox-header lightcarbon"><i class="wi wi-strong-wind"></i></span>


                            </div>
                            <div class="databox-cell cell-6 padding-5">
                                <span class="databox-number lightcarbon">13°</span>
                                <span class="databox-header lightcarbon"><i class="wi wi-rain"></i></span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-4 col-xs-6">
                <div class="databox databox-lg databox-vertical databox-inverted bg-white databox-shadowed">
                    <div class="databox-top">
                        <div class="databox-piechart">
                            <div class="easyPieChart block-center" ui-jq="easyPieChart" ui-options="{ percent: 40, lineWidth: 8, barColor:'#e75b8d', trackColor: '#eee' , scaleColor:false, size: 100, lineCap: 'butt', animate: 500 }"><span class="white font-200"><i class="fa fa-tags pink"></i></span></div>
                        </div>
                    </div>
                    <div class="databox-bottom no-padding text-align-center">
                        <span class="databox-number lightcarbon no-margin">11</span>
                        <span class="databox-text lightcarbon no-margin">NEW TICKETS</span>

                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-4 col-xs-6">
                <div class="databox databox-lg databox-vertical databox-inverted databox-graded">
                    <div class="databox-top">
                        <div class="databox-piechart">
                            <div class="easyPieChart block-center" ui-jq="easyPieChart" ui-options="{ percent: 80, lineWidth: 8, barColor:'#11a9cc', trackColor: '#eee' , scaleColor:false, size: 100, lineCap: 'butt', animate: 500 }"><span class="white font-200"><i class="fa fa-gift sky"></i></span></div>
                        </div>
                    </div>
                    <div class="databox-bottom no-padding text-align-center">
                        <span class="databox-number lightcarbon no-margin">9</span>
                        <span class="databox-text lightcarbon no-margin">NEW PRODUCTS</span>

                    </div>
                </div>
            </div>
        </div>
        <h6 class="row-title before-blueberry">Larger Vertical Databoxes</h6>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox databox-xlg radius-bordered databox-shadowed databox-vertical">
                    <div class="databox-top bg-blue">
                        <span class="databox-header">JANUARY 2014</span>
                    </div>
                    <div class="databox-bottom bg-white no-padding">
                        <div id="donut-chart" style="height:150px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="databox databox-xlg databox-halved radius-bordered databox-shadowed databox-vertical">
                    <div class="databox-top bg-white padding-10">
                        <div class="col-lg-4 col-sm-4 col-xs-4">
                            <img src="backend/assets/img/avatars/Sergey-Azovskiy.jpg" style="width:75px; height:75px;" class="image-circular bordered-3 bordered-palegreen" />
                        </div>
                        <div class="col-lg-8 col-sm-8 col-xs-8 text-align-left padding-10">
                            <span class="databox-header carbon no-margin">Martin James</span>
                            <span class="databox-text lightcarbon no-margin"> Software Manager at Microsoft </span>
                        </div>
                    </div>
                    <div class="databox-bottom bg-white no-padding">
                        <div class="databox-row row-12">
                            <div class="databox-row row-6 no-padding">
                                <div class="databox-cell cell-4 no-padding text-align-center bordered-right bordered-platinum">
                                    <span class="databox-text sonic-silver  no-margin">Posts</span>
                                    <span class="databox-number lightcarbon no-margin">510</span>
                                </div>
                                <div class="databox-cell cell-4 no-padding text-align-center bordered-right bordered-platinum">
                                    <span class="databox-text sonic-silver no-margin">Followers</span>
                                    <span class="databox-number lightcarbon no-margin">908</span>
                                </div>
                                <div class="databox-cell cell-4 no-padding text-align-center">
                                    <span class="databox-text sonic-silver no-margin">Following</span>
                                    <span class="databox-number lightcarbon no-margin">286</span>
                                </div>
                            </div>
                            <div class="databox-row row-6 padding-10">
                                <button class="btn btn-palegreen btn-sm pull-right">FOLLOW</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-sm-6 col-xs-12">
                <div class="databox databox-xlg radius-bordered databox-shadowed databox-vertical">
                    <div class="databox-top bg-white">
                        <span class="databox-header orange">WEEKLY SALE STAT</span>
                    </div>
                    <div class="databox-bottom bg-white no-padding">
                        <div class="databox-sparkline">
                            <div style="height: 65px;" ui-jq="sparkline" ui-options="[2,6,7,9,8,5,3,4,4,3,6,7], {type:'line', height:158, width:'100%', fillColor:'#ffce55', lineColor:'#fb6e52', spotColor:'#fb6e52', minSpotColor:'#fafafa', maxSpotColor:'#ffce55', highlightSpotColor:'#fff', highlightLineColor:'#fff', lineWidth:3, spotRadius:0 }"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h6 class="row-title before-pink">Larger-er Vertical Databoxes</h6>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox databox-xxlg databox-inverted databox-vertical databox-shadowed databox-graded">
                    <div class="databox-top padding-10">
                        <div ui-jq="plot" ui-options="{{BandwidthPieData}},{{BandwidthPieOptions}}" class="chart chart"></div>
                        <div class="flot-donut-caption">
                            <span class="databox-number lightcarbon no-margin">160GB</span>
                            <span class="databox-text sonic-silver  no-margin">Total Usage</span>
                        </div>
                    </div>
                    <div class="databox-bottom no-padding bg-white bordered bordered-platinum">
                        <div class="databox-row row-12 no-padding">
                            <div class="databox-cell cell-4 no-padding text-align-center bordered-bottom-5 bordered-sky">
                                <span class="databox-title lightcarbon no-margin"><i class="fa fa-picture-o"></i></span>
                                <span class="databox-text sonic-silver  no-margin">50GB</span>
                            </div>
                            <div class="databox-cell cell-4 no-padding text-align-center bordered-bottom-5 bordered-yellow">
                                <span class="databox-title lightcarbon no-margin"><i class="fa fa-video-camera"></i></span>
                                <span class="databox-text sonic-silver  no-margin">80GB</span>
                            </div>
                            <div class="databox-cell cell-4 no-padding text-align-center bordered-bottom-5 bordered-pink">
                                <span class="databox-title lightcarbon no-margin"><i class="fa fa-music"></i></span>
                                <span class="databox-text sonic-silver no-margin">30GB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="databox databox-xxlg databox-vertical databox-inverted">
                    <div class="databox-top bg-whitesmoke no-padding">
                        <div class="databox-row row-2 bg-orange no-padding">
                            <div class="databox-cell cell-1 text-align-center no-padding padding-top-5">
                                <span class="databox-number white"><i class="fa fa-bar-chart-o no-margin"></i></span>
                            </div>
                            <div class="databox-cell cell-8 no-padding padding-top-5 text-align-left">
                                <span class="databox-number white">PAGE VIEWS</span>
                            </div>
                            <div class="databox-cell cell-3 text-align-right padding-10">
                                <span class="databox-text white">13 DECEMBER</span>
                            </div>
                        </div>
                        <div class="databox-row row-4">
                            <div class="databox-cell cell-6 no-padding padding-10 padding-left-20 text-align-left">
                                <span class="databox-number orange no-margin">534,908</span>
                                <span class="databox-text sky no-margin">OVERAL VIEWS</span>
                            </div>
                            <div class="databox-cell cell-2 no-padding padding-10 text-align-left">
                                <span class="databox-number orange no-margin">4,129</span>
                                <span class="databox-text darkgray no-margin">THIS WEEK</span>
                            </div>
                            <div class="databox-cell cell-2 no-padding padding-10 text-align-left">
                                <span class="databox-number orange no-margin">329</span>
                                <span class="databox-text darkgray no-margin">YESTERDAY</span>
                            </div>
                            <div class="databox-cell cell-2 no-padding padding-10 text-align-left">
                                <span class="databox-number orange no-margin">104</span>
                                <span class="databox-text darkgray no-margin">TODAY</span>
                            </div>
                        </div>
                        <div class="databox-row row-6 no-padding">
                            <div class="databox-sparkline">
                                <div style="height: 65px;" ui-jq="sparkline" ui-options="[5,7,6,5,9,4,3,7,2], {type:'line', height:126, width:'100%', fillColor:'#37c2e2', lineColor:'#37c2e2', spotColor:'#fafafa', minSpotColor:'#fafafa', maxSpotColor:'#ffce55', highlightSpotColor:'#fff', highlightLineColor:'#fff', lineWidth:2, spotRadius:0 }"></div>
                            </div>
                        </div>
                    </div>
                    <div class="databox-bottom bg-sky no-padding">
                        <div class="databox-cell cell-2 text-align-center no-padding padding-top-5">
                            <span class="databox-header white">Mon</span>
                        </div>
                        <div class="databox-cell cell-2 text-align-center no-padding padding-top-5">
                            <span class="databox-header white">Tues</span>
                        </div>
                        <div class="databox-cell cell-2 text-align-center no-padding padding-top-5">
                            <span class="databox-header white">Wed</span>
                        </div>
                        <div class="databox-cell cell-2 text-align-center no-padding padding-top-5">
                            <span class="databox-header white">Thu</span>
                        </div>
                        <div class="databox-cell cell-2 text-align-center no-padding padding-top-5">
                            <span class="databox-header white">Fri</span>
                        </div>
                        <div class="databox-cell cell-2 text-align-center no-padding padding-top-5">
                            <span class="databox-header white">Sat</span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox databox-xxlg databox-inverted databox-vertical databox-shadowed databox-graded radius-bordered">
                    <div class="databox-top bg-white ">
                        <div class="databox-row row-1">
                            <div class="databox-stat orange radius-bordered font-120">
                                <i class="stat-icon wi wi-rain icon-xlg"></i>
                            </div>
                        </div>
                        <div class="databox-row row-8">
                            <div ui-jq="plot" ui-options="{{WeatherPieData}},{{WeatherPieOptions}}" class="chart" style="height:160px;">
                            </div>
                            <div class="flot-donut-caption">
                                <span class="databox-number sonic-silver no-margin">2014</span>
                                <span class="databox-text sonic-silver  no-margin">December</span>
                            </div>
                        </div>
                        <div class="databox-row row-3 padding-10">
                            <span class="databox-number darkorange no-margin">Weather</span>
                            <span class="databox-text carbon no-margin">ALL SEASON</span>
                        </div>
                    </div>
                    <div class="databox-bottom no-padding bg-white bordered bordered-platinum">
                        <div class="databox-row row-12 no-padding">
                            <div class="databox-cell cell-3 no-padding text-align-center bg-yellow">
                                <span class="databox-number no-margin">30%</span>
                                <span class="databox-text no-margin">Rain</span>
                            </div>
                            <div class="databox-cell cell-3 no-padding text-align-center bg-orange">
                                <span class="databox-number no-margin">11%</span>
                                <span class="databox-text no-margin">Wind</span>
                            </div>
                            <div class="databox-cell cell-3 no-padding text-align-center bg-darkorange">
                                <span class="databox-number no-margin">37%</span>
                                <span class="databox-text no-margin">Sunny</span>
                            </div>
                            <div class="databox-cell cell-3 no-padding text-align-center bg-danger">
                                <span class="databox-number no-margin">22%</span>
                                <span class="databox-text no-margin">Snow</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox databox-vertical databox-xxlg databox-halved radius-bordered databox-shadowed">
                    <div class="databox-top no-padding bg-palegreen">
                        <div class="databox-row row-5 text-align-left padding-10">
                            <div class="databox-stat white bg-palegreen font-120">
                                <i class="stat-icon fa fa-caret-up icon-xlg"></i>
                            </div>
                            <span class="databox-number no-margin">639.73</span>
                            <span class="databox-text no-margin">-29 (4.2%)</span>
                        </div>
                        <div class="databox-row row-7">
                            <div class="databox-sparkline no-margin">
                                <div style="height: 65px;" ui-jq="sparkline" ui-options="[8,4,1,2,4,6,2,4,4,8,10,7, 7, 6, 5, 7, 9, 10, 8, 7, 6, 6], {type:'bar', height:88, width:'100%', barColor:'#bfe19a', barWidth:5, barSpacing:5 }"></div>
                            </div>
                        </div>
                    </div>
                    <div class="databox-bottom bg-white no-padding">
                        <div class="databox-row row-2 padding-10">
                            <span class="databox-text sonic-silver no-margin"><i class="glyphicon glyphicon-time gray"></i>Today, 4:15 PM</span>
                        </div>
                        <div class="databox-row row-4 padding-10">
                            <div class="col-lg-6 bg-whitesmoke text-align-center">
                                <span class="databox-number gray">16.8 M</span>
                            </div>
                            <div class="col-lg-6 bg-whitesmoke text-align-center bordered-left-3 bordered-white">
                                <span class="databox-number gray">12 M</span>
                            </div>
                        </div>
                        <div class="databox-row row-2">
                            <div class="col-lg-6">
                                <span class="databox-text sonic-silver no-margin"><i class="fa fa-caret-down orange"></i>Monthly</span>
                            </div>
                            <div class="col-lg-6">
                                <span class="databox-text sonic-silver no-margin"><i class="fa fa-caret-up palegreen"></i>Yearly</span>
                            </div>
                        </div>
                        <div class="databox-row row-4">
                            <div class="col-lg-6 text-align-center">
                                <div class="databox-sparkline">
                                    <div style="height: 65px;" ui-jq="sparkline" ui-options="[2,2,3,1,4,2,3,1,3], {type:'bar', height:35, width:'100%', barColor:'#a0d468', barWidth:5, barSpacing:3 }"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 padding-5 text-align-center">
                                <div class="databox-sparkline">
                                    <div style="height: 65px;" ui-jq="sparkline" ui-options="[2,6,7,9,8,5,3,4,4,3,6,7], {type:'line', height:35, width:'100%', fillColor:false, lineColor:'#bfe19a', spotColor:'#fafafa', minSpotColor:'#fafafa', maxSpotColor:'#ffce55', highlightSpotColor:'#fb6e52', highlightLineColor:'#fb6e52', lineWidth:2, spotRadius:3 }"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-12">
                <div class="databox databox-xxlg radius-bordered databox-shadowed databox-vertical databox-graded">
                    <div class="databox-top bordered-bottom-2 bordered-orange bg-ivory">
                        <div class="col-lg-8 col-sm-8 col-xs-8 text-align-left">
                            <span class="databox-text carbon">DATA TRANSFER STATS</span>
                            <span class="databox-text carbon no-margin">Last Week</span>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-4 text-align-right">
                            <div class="databox-stat bg-palegreen radius-bordered">
                                <div class="stat-text">58%</div>
                                <i class="stat-icon fa fa-arrow-up"></i>
                            </div>
                        </div>
                    </div>
                    <div class="databox-bottom">
                        <div ui-jq="plot" ui-options="{{DataTransferChartData}}, {{DataTransferChartOptions}}" class="chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="databox databox-xxlg databox-halved radius-bordered databox-shadowed databox-graded databox-vertical">
                    <div class="databox-top bg-pink padding-30">
                        <div class="databox-stat stat-left radius-bordered">
                            <div class="stat-text white">PAGE VIEWS</div>
                        </div>
                        <div class="databox-stat white font-120">
                            <i class="stat-icon fa fa-caret-down icon-xlg"></i>
                        </div>
                        <div class="databox-sparkline">
                            <div ui-jq="sparkline" ui-options="[1,3,2,5,4,0,5,7,6,5], {type:'line', height:90, width:'100%', fillColor:false, lineColor:'#fff', spotColor:'#fafafa', minSpotColor:'#fafafa', maxSpotColor:'#ffce55', highlightSpotColor:'#f5f5f5', highlightLineColor:'#f5f5f5', lineWidth:3, spotRadius:0 }"></div>
                        </div>
                    </div>
                    <div class="databox-bottom padding-20">
                        <div class="databox-row row-6">
                            <div class="databox-cell cell-4">
                                <span class="databox-number pink no-margin">4,129</span>
                                <span class="databox-text darkgray no-margin">Profile</span>
                            </div>
                            <div class="databox-cell cell-8 padding-10">
                                <div class="databox-sparkline">
                                    <div ui-jq="sparkline" ui-options="[2,4,5,6,3,2,0,4,2,4,3,2,6,3,2], {type:'bar', height:20, width:'100%', barColor:'#ccc', barWidth:5, barSpacing:2 }"></div>
                                </div>
                            </div>
                        </div>
                        <div class="databox-row row-6">
                            <div class="databox-cell cell-4">
                                <span class="databox-number pink no-margin">2,703</span>
                                <span class="databox-text darkgray no-margin">About</span>
                            </div>
                            <div class="databox-cell cell-8 padding-10">
                                <div class="databox-sparkline">
                                    <div ui-jq="sparkline" ui-options="[4,2,4,3,2,6,3,2,2,4,5,6,3,2,0], {type:'bar', height:20, width:'100%', barColor:'#ccc', barWidth:5, barSpacing:2 }"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h6 class="row-title before-sky">Largest Vertical Databoxes</h6>
        <div class="row">
            <div class="col-lg-8 col-sm-12 col-xs-12">
                <div class="databox databox-vertical databox-xxxlg radius-bordered databox-shadowed">
                    <div class="databox-top bg-white bordered-bottom-1 bordered-platinum text-align-left padding-10">
                        <div class="databox-text darkgray">CONSUMPTION</div>
                    </div>
                    <div class="databox-bottom bg-white no-padding ">
                        <div class="databox-row row-3 block-center bg-ivory">
                            <div class="databox-cell cell-4 padding-10">
                                <div class="databox-piechart">
                                    <div class="easyPieChart pull-right block-center" ui-jq="easyPieChart" ui-options="{ percent: 60, lineWidth: 5, barColor:'#5db2ff', trackColor: '#eeeeee' , scaleColor:false, size: 100, lineCap: 'butt', animate: 500 }"><span class="white font-180"><i class="glyphicon glyphicon-map-marker blue"></i></span></div>
                                </div>
                            </div>
                            <div class="databox-cell cell-4 padding-10">
                                <div class="databox-piechart">
                                    <div class="easyPieChart block-center" ui-jq="easyPieChart" ui-options="{ percent: 70, lineWidth: 5, barColor:'#e75b8d', trackColor: '#eeeeee' , scaleColor:false, size: 100, lineCap: 'butt', animate: 500 }"><span class="white font-150"><i class="fa fa-camera pink"></i></span></div>
                                </div>
                            </div>
                            <div class="databox-cell cell-4 padding-10">
                                <div class="databox-piechart">
                                    <div class="easyPieChart pull-left block-center" ui-jq="easyPieChart" ui-options="{ percent: 60, lineWidth: 5, barColor:'#8cc474', trackColor: '#eeeeee' , scaleColor:false, size: 100, lineCap: 'butt', animate: 500 }"><span class="white font-200"><i class="fa fa-bolt green"></i></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="databox-row row-1 bg-ivory bordered-bottom-1 bordered-lightgray" style="border-bottom-style:dashed;">
                            <div class="databox-cell cell-4 padding-right-20">
                                <span class="databox-text darkcarbon pull-right no-margin"><i class="fa fa-arrow-up green"></i></span>
                                <span class="databox-number carbon pull-right">909</span>
                                <span class="databox-number gray pull-right"> $</span>
                            </div>
                            <div class="databox-cell cell-4">
                                <div class="block-center" style="width:75px;">
                                    <span class="databox-text darkcarbon pull-right no-margin"><i class="fa fa-check blue"></i></span>
                                    <span class="databox-number carbon pull-right">643</span>
                                    <span class="databox-number gray pull-right"> $</span>
                                </div>
                            </div>
                            <div class="databox-cell cell-4 padding-left-30">
                                <span class="databox-number gray pull-left"> $</span>
                                <span class="databox-number carbon pull-left">257</span>
                                <span class="databox-text darkcarbon pull-left no-margin"><i class="fa fa-arrow-down orange"></i></span>
                            </div>
                        </div>
                        <div class="databox-row row-2 no-padding bg-ivory">
                            <div class="databox-cell cell-12 no-padding bordered-left-3 bordered-pink">
                                <div class="horizontal-space"></div>
                                <div class="databox-sparkline">
                                    <div ui-jq="sparkline" ui-options="[2,4,5,6,3,2,0,4,2,4,3,2,6,4,5,1,4,5,6,9,1], {type:'bar', height:62, width:'100%', barColor:'#cfd3de', barWidth:16, barSpacing:5 }"></div>
                                </div>
                            </div>
                        </div>
                        <div class="databox-row row-1 padding-10">
                            <div class="databox-text darkgray no-margin">DISTRIBUTION</div>
                        </div>
                        <div class="databox-row row-3 no-padding bg-ivory bordered-bottom-1 bordered-platinum silver" style="font-size:12px;">
                            <table class="table table-condensed table-striped">
                                <tbody>
                                    <tr>
                                        <td class="padding-left-10">
                                            iPad
                                        </td>
                                        <td>
                                            1208
                                        </td>
                                        <td>
                                            874,993
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="padding-left-10">
                                            iPhone
                                        </td>
                                        <td>
                                            7864
                                        </td>
                                        <td>
                                            761,083
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="padding-left-10">
                                            iPod
                                        </td>
                                        <td>
                                            903
                                        </td>
                                        <td>
                                            874,032
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="padding-left-10">
                                            iMac
                                        </td>
                                        <td>
                                            987
                                        </td>
                                        <td>
                                            165,973
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="databox-row row-2 padding-20 bg-whitesmoke">
                            <a href="javascript:void(0);" class="btn btn-default pull-right">Save Report</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="databox databox-vertical databox-xxxlg radius-bordered databox-shadowed">
                    <div class="databox-top bg-orange text-align-left padding-left-30">
                        <span class="databox-header"><i class="glyphicon glyphicon-map-marker"></i> NEW YORK CITY</span>
                    </div>
                    <div class="databox-bottom no-padding bg-sky">
                        <div class="databox-row row-4 bg-yellow padding-30 text-align-left">
                            <span class="databox-text padding-bottom-5" style="font-size:20px;">FRI 29/09</span>
                            <span class="databox-number" style="font-size:44px;">14° <i class="wi wi-day-cloudy"></i></span>
                        </div>
                        <div class="databox-row row-1 padding-5 padding-left-30 text-align-left bordered-bottom bordered-whitesmoke">
                            <div class="databox-cell cell-8">
                                <span class="databox-title no-margin">SAT</span>
                            </div>
                            <div class="databox-cell cell-4">
                                <span class="databox-number">18°  <i class="wi wi-day-cloudy"></i></span>
                            </div>
                        </div>
                        <div class="databox-row row-1 padding-5 padding-left-30 text-align-left bordered-bottom bordered-whitesmoke">
                            <div class="databox-cell cell-8">
                                <span class="databox-title no-margin">SUN</span>
                            </div>
                            <div class="databox-cell cell-4">
                                <span class="databox-number">25°  <i class="wi wi-cloudy-gusts"></i></span>
                            </div>
                        </div>
                        <div class="databox-row row-1 padding-5 padding-left-30 text-align-left bordered-bottom bordered-whitesmoke">
                            <div class="databox-cell cell-8">
                                <span class="databox-title no-margin">MON</span>
                            </div>
                            <div class="databox-cell cell-4">
                                <span class="databox-number">22°  <i class="wi wi-windy"></i></span>
                            </div>
                        </div>
                        <div class="databox-row row-1 padding-5 padding-left-30 text-align-left bordered-bottom bordered-whitesmoke">
                            <div class="databox-cell cell-8">
                                <span class="databox-title no-margin">TUE</span>
                            </div>
                            <div class="databox-cell cell-4">
                                <span class="databox-number">19°  <i class="wi wi-day-showers"></i></span>
                            </div>
                        </div>
                        <div class="databox-row row-1 padding-5 padding-left-30 text-align-left bordered-bottom bordered-whitesmoke">
                            <div class="databox-cell cell-8">
                                <span class="databox-title no-margin">WED</span>
                            </div>
                            <div class="databox-cell cell-4">
                                <span class="databox-number">16°  <i class="wi wi-day-fog"></i></span>
                            </div>
                        </div>
                        <div class="databox-row row-1 padding-5 padding-left-30 text-align-left bordered-bottom bordered-whitesmoke">
                            <div class="databox-cell cell-8">
                                <span class="databox-title no-margin">THU</span>
                            </div>
                            <div class="databox-cell cell-4">
                                <span class="databox-number">14°  <i class="wi wi-day-lightning"></i></span>
                            </div>
                        </div>
                        <div class="databox-row row-1 padding-5 padding-left-30 text-align-left bordered-bottom bordered-whitesmoke">
                            <div class="databox-cell cell-8">
                                <span class="databox-title no-margin">FRI</span>
                            </div>
                            <div class="databox-cell cell-4">
                                <span class="databox-number">11°  <i class="wi wi-day-rain-mix"></i></span>
                            </div>
                        </div>
                        <div class="databox-row row-1 padding-5 padding-left-30 text-align-left">
                            <div class="databox-cell cell-8">
                                <span class="databox-title no-margin">SAT</span>
                            </div>
                            <div class="databox-cell cell-4">
                                <span class="databox-number">29°  <i class="wi wi-day-hail"></i></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
