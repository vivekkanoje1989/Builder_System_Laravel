@extends('layouts/frontend/Theme39/main')
@section('content')
<section id="featured-title" class="featured-title row-background row-parallax">
    <div class="strip-bg"></div>
    <div class="container">
        <div class="row">
            <div class="title"><h1>Projects</h1><h3 class='subtitle'>Let's take a look at our best & big projects</h3></div>
        </div>
    </div>
</section>
<div class="breadcrumb-wrapper container">
    <ul class="breadcrumb">
        <li>
            <span><a class="home" href="<?php // echo Yii::app()->getBaseUrl(true);   ?>"><span itemprop="title">Home</span></a></span>
        </li>
        <li>
            <span><span>Projects</span></span>
        </li>
    </ul>
</div>

<main id="main" class="main clearfix">
    <div class="container">
        <div class="row woocommerce">

            <div class="fitsc-tab fitsc-active" id="tab-reviews">
                <div id="reviews">
                    <div id="comments">

                        <ol class="commentlist">


                            <?php
                            $i = 1;
                            foreach ($carrier as $jobrecords) {
                                ?>
                                <li itemprop="review" itemscope="" itemtype="http://schema.org/Review" class="comment even thread-even depth-1" id="li-comment-61">

                                    <div id="comment-61" class="comment_container">

                                       
                                        <div class="comment-text">
                                            <p class="meta">
                                                <strong itemprop="author"><?php echo $jobrecords->job_title; ?></strong> –
                                                <time itemprop="datePublished" ><?php echo date('d-m-Y', strtotime($jobrecords->job_posting_date)); ?></time>:
                                            </p>


                                            <div itemprop="description" class="description">
                                                <p><strong>Eligibility criteria&nbsp;:&nbsp;</strong><?php echo $jobrecords->eligibility; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php $i++;
                            }
                            ?>  


                            <!-- #comment-## -->
                        </ol>
                    </div>
                    <div id="review_form_wrapper">
                        <div id="review_form">
                            <div id="respond" class="comment-respond">
                                <h3 id="reply-title" class="comment-reply-title">Apply For Job</h3>
                                <form  method="post" name='Recruitment' enctype="multipart/form-data" id="resumeform"  class="comment-form">
                                    <p class="comment-form-email">
                                        <label for="author">First Name <span class="required">*</span>
                                        </label>
                                        <input type="text"   id="r_firstname" name="Recruitment[r_firstname]" autocomplete="on"  onkeypress=" $(this).val(capital($(this).val())); onlychar(event);" />
                                    </p>
                                    <p class="comment-form-email">
                                        <label>Last Name <span class="required">*</span>
                                        </label>
                                        <input type="text"  id="r_lastname" name="Recruitment[r_lastname]" autocomplete="on" onkeypress=" $(this).val(capital($(this).val())); onlychar(event);" />
                                    </p>
                                    <p class="comment-form-email">
                                        <label>Mobile No. <span class="required">*</span>
                                        </label>
                                        <input type="text" id="r_mobile" name="Recruitment[r_mobile]" autocomplete="on" onkeypress="onlynum(event);" maxlength="10" />
                                    </p>
                                    <p class="comment-form-email">
                                        <label for="email">Email <span class="required">*</span>
                                        </label>
                                        <input type="text" id="r_email" name="Recruitment[r_email]" autocomplete="on" />
                                    </p>
                                    <p class="comment-form-email">
                                        <label>Select Position <span class="required">*</span>
                                        </label>
                                        <?php
//														$criteria = new CDbCriteria;
//														$currentdate = date('Y-m-d');
//														$criteria->addCondition('app_closing_date >="'.$currentdate.'" ');
//														$criteria->addCondition('display_portal = 1');
//														$carrier = JobPosting::model()->findAll($criteria);
//														$list=CHtml::listData(JobPosting::model()->findAll($criteria),'id','job_title');
//														echo CHtml::dropDownList('job_id','job_id',$list,array('empty'=>'-- Select Position --','class'=>''));
//														
                                        ?>
                                    </p>

                                    <p class="comment-form-email">
                                        <label>Upload Your CV<span class="required">*</span>
                                        </label>
                                        <input id="r_resume" name="JobApplicants[r_resume]" value="" type="file" autocomplete="on" placeholder="Upload CV"  /> 

                                    </p>

                                    <p class="comment-form-email">
                                        <img id="resume_captcha" style="margin-bottom: 5px;" src="<?php //echo Yii::app()->getBaseUrl(true);   ?>/captcha_code_file.php?rand=<?php echo rand(); ?>&name=resume_captcha">
                                        <span style="padding: 0 0 0 5px;"> <a sclass="here" href="javascript: refreshCaptcha('resume_captcha');" style='color: #000;'>Click here to refresh</a></span>
                                    </p>
                                    <p class="comment-form-email">
                                        <label>Captcha Text<span class="required">*</span>
                                        </label>
                                        <input type="text" id="resume_captchatxt" name="resume_captchatxt" autocomplete="on" />
                                    </p>		
                                    <br>
                                    <p class="form-submit">
                                        <span id="wait_resume" style="color:black;">Please Wait</span> <div id="loading_resume" style="    margin-left: 15px;"><img id="loadimg_resume" src="<?php //echo Yii::app()->baseUrl;   ?>/common/images/loading.gif" alt=""  />


                                        </p>
                                        <button class="submit" id="sbt_resume" value="Submit">Submit</button>
                                </form>
                            </div>
                            <!-- #respond -->
                        </div>
                    </div>


                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection()   