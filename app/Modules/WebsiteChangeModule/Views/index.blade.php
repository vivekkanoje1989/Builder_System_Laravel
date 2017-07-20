<style>
    .imagediv {
        position: relative;
        width: 25%;
    }

    .image {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%)
    }
    .below{
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 70%;
        left: 70%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%)
    }

    .imagediv:hover .image {
        opacity: 0.3;
    }

    .imagediv:hover .middle {
        opacity: 1;
    }

    .text {
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        padding: 16px 32px;
    }
</style> 
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs nav-justified" id="myTab5">
                <li class="active">
                    <a data-toggle="tab" href="#home5">
                        BMS Themes
                    </a>
                </li>
                <li class="tab-red">
                    <a data-toggle="tab" href="#profile5">
                        Special Themes
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="home5" class="tab-pane in active">
                    <div class="row">
                        <div class="col-md-3 imagediv">
                            <img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Company/firmlogo/company_firm_1048.jpg" alt="Avatar" class="image" style=" height:200px;">
                            <div class="middle">
                                <div class="text">John Doe</div>
                            </div>
                            <div class="below">
                               <i class="glyphicon glyphicon-eye-open"></i>
                            </div>
                        </div>
                         <div class="col-md-3 imagediv">
                            <img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Company/firmlogo/company_firm_1048.jpg" alt="Avatar" class="image" style=" height:200px;">
                            <div class="middle">
                                <div class="text">John Doe</div>
                            </div>
                        </div>
                         <div class="col-md-3 imagediv">
                            <img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Company/firmlogo/company_firm_1048.jpg" alt="Avatar" class="image" style=" height:200px;">
                            <div class="middle">
                                <div class="text">John Doe</div>
                            </div>
                        </div>
                         <div class="col-md-3 imagediv">
                            <img src="https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/Company/firmlogo/company_firm_1048.jpg" alt="Avatar" class="image" style=" height:200px;">
                            <div class="middle">
                                <div class="text">John Doe</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="profile5" class="tab-pane">
                    <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.</p>
                </div>
            </div>
        </div>
    </div>
</div>
