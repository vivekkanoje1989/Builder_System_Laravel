<div class="row" ng-controller="hrController" ng-init="showchartdata()">
<style>
    .google-visualization-orgchart-node{
            background: #ddd !important;
            padding:0 10px !important;
            border: none !important;
        }                  
        .google-visualization-orgchart-node, .google-visualization-orgchart-node-medium, .google-visualization-orgchart-nodesel
        {
            background: transparent !important;
            border: none;
            box-shadow: none;
        }            	
        .imgdata
        {
            border-radius: 50px;
            width: 90px;
            height: 90px;
            /*border: 4px double red;*/	
        }
        .myblock
        {
            border: 1px solid;
            position: relative;
            bottom: 10px;
            height:auto;
            width: 128px;
            /*z-index: -1;*/
            background-color: rgba(253, 42, 42, 0.85);
            left: 5px;
            color: white;
        }
        .mytext
        {
            position: absolute;
            left: 0;
            bottom: 0;
            color:black
        }	
</style>	
    <div class="col-xs-12 col-md-12">
        <div class="widget">
            <div class="widget-header ">
                <span class="widget-caption">Organization Chart</span>
                
                <div class="widget-buttons">
                    <a href="" widget-maximize></a>
                    <a href="" widget-collapse></a>
                    <a href="" widget-dispose></a>
                </div>
                <div id="chart_div" class="table-responsive" ng-model="chart_div"></div>
                
                <br><br>
            </div>
            
        </div>
    </div>
</div>

