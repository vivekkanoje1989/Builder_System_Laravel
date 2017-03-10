<div class="row" ng-controller="hrController" ng-init="showchartdata()">
     <style>
		  
		  .tree-user{
			border-radius: 50%;
			width: 80px;
			height: 80px;
			border: 2px solid #fff;  
		  }
		  .tree-usr-name{
				font-family: 'Open Sans', 'Segoe UI'; 
				font-size: 13px;
				font-weight: 600;
				color: #666;
                                line-height: 15px;
		  }
		  
		  .usr-designation{
		      font-size: 10px;
                      font-weight: 600;
		  }
		  
		  .google-visualization-orgchart-node{
				background: #ddd !important;
				padding:0 10px !important;
				border: none !important;
		  }
                  
                  .usr-status{
                        font-size: 9px;
                        position: relative;
                        bottom: 2px;
                        line-height: 13px;
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

