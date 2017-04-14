<form name="userForm" novalidate >
    <input type="hidden" ng-model="userForm.csrfToken" name="csrftoken" id="csrftoken" ng-init="userForm.csrfToken = '<?php echo csrf_token(); ?>'" class="form-control">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h5 class="row-title before-themeprimary"><i class="fa  fa-arrow-circle-o-right themeprimary"></i>{{ pageHeading}}</h5>
            <div id="WiredWizard" class="wizard wizard-wired" data-target="#WiredWizardsteps">
                <ul class="steps">
                    <li class="wiredstep1 active"><span class="step">1</span><span class="title">Step 1</span><span class="chevron"></span></li>
                    <li class="wiredstep2"><span class="step">2</span><span class="title">Step 2</span> <span class="chevron"></span></li>
                    <li class="wiredstep3"><span class="step">3</span><span class="title">Step 3</span> <span class="chevron"></span></li>
                    <li class="wiredstep4"><span class="step">4</span><span class="title">Step 4</span> <span class="chevron"></span></li>
                    <li class="wiredstep5"><span class="step">5</span><span class="title">Step 5</span> <span class="chevron"></span></li>
                </ul>
            </div>
            <div class="step-content" id="WiredWizardsteps">
                <div class="step-pane active" id="wiredstep1">
                    <div class="form-title">Personal Information</div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-nxt1">Next</button>
                        </div>
                    </div>
                </div>	
                <div class="step-pane" id="wiredstep2">	
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre2">Prev</button>
                            <button type="button" class="btn btn-primary btn-nxt2">Next</button>
                        </div>
                    </div>
                </div>
                <div class="step-pane" id="wiredstep3">	
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre3">Prev</button>
                            <button type="button" class="btn btn-primary btn-nxt3">Next</button>
                        </div>
                    </div>
                </div>
                <div class="step-pane" id="wiredstep4">	
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre4">Prev</button>
                            <button type="button" class="btn btn-primary btn-nxt4">Next</button>
                        </div>
                    </div>
                </div>
                <div class="step-pane" id="wiredstep5">	
                    <div class="row">
                        <div class="col-md-12 col-xs-12" align="right">
                            <button type="button" class="btn btn-primary btn-pre5">Prev</button>
                            <button type="button" class="btn btn-primary btn-nxt5">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        $(".btn-nxt1").mouseup(function(e){
            if($(".step1").hasClass("ng-active")) {
                e.preventDefault();
            }else{
                $("#wiredstep1").hide();
                $("#wiredstep2").show();
                $(".wiredstep2").addClass("active");
                $(".wiredstep1").removeClass("active");
                $(".wiredstep1").addClass("complete");
            }
        });
        $(".btn-nxt2").click(function(e){
            if($(".step2").hasClass("ng-active")) {
                e.preventDefault();
            }else{
                $("#wiredstep2").hide();
                $("#wiredstep3").show();
                $(".wiredstep3").addClass("active");
                $(".wiredstep2").removeClass("active");
                $(".wiredstep2").addClass("complete");
            }
        });
        $(".btn-nxt3").click(function(e){
            if($(".step3").hasClass("ng-active")) {
                e.preventDefault();
            }else{
                $("#wiredstep3").hide();
                $("#wiredstep4").show();
                $(".wiredstep4").addClass("active");
                $(".wiredstep3").removeClass("active");
                $(".wiredstep3").addClass("complete");
            }
        });
        $(".btn-nxt6").click(function(e){
            if($(".step4").hasClass("ng-active")) {
                e.preventDefault();
            }else{
                $("#wiredstep4").hide();
                $("#wiredstep5").show();
                $(".wiredstep5").addClass("active");
                $(".wiredstep4").removeClass("active");
                $(".wiredstep4").addClass("complete");
            }
            if( $(".select2-input").attr('placeholder') === '' && $(".step4").hasClass("ng-hide")) {
            }
            else{ $(".department").removeClass("ng-hide");}
        });
        $(".btn-submit-last").click(function(e){
            if($(".step5").hasClass("ng-active")) {
                e.preventDefault();
            }
        });
        
        $(".btn-pre2").click(function(){
            $("#wiredstep1").show();
            $("#wiredstep2").hide();
            $(".wiredstep1").addClass("active");
            $(".wiredstep2").removeClass("active");
            $(".wiredstep1").removeClass("complete");
        });
        $(".btn-pre3").click(function(){
            $("#wiredstep2").show();
            $("#wiredstep3").hide();
            $(".wiredstep2").addClass("active");
            $(".wiredstep3").removeClass("active");
            $(".wiredstep2").removeClass("complete");
        });
        $(".btn-pre4").click(function(){
            $("#wiredstep3").show();
            $("#wiredstep4").hide();
            $(".wiredstep3").addClass("active");
            $(".wiredstep4").removeClass("active");
            $(".wiredstep3").removeClass("complete");
        });
        $(".btn-pre5").click(function(){
            $("#wiredstep4").show();
            $("#wiredstep5").hide();
            $(".wiredstep4").addClass("active");
            $(".wiredstep5").removeClass("active");
            $(".wiredstep4").removeClass("complete");
        });
    });

</script>