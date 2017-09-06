
 ------------------- Total-------------
 BEGIN
    SET @tn ='';
    set sql_mode = '';
    IF customerFirstName <> '' THEN
       SET @tn = CONCAT(@tn," AND c.first_name like '%",customerFirstName,"%'");  
    END IF;
    IF customerLastName <> '' THEN
       SET @tn = CONCAT(@tn," AND c.last_name like '%",customerLastName,"%'");  
    END IF;
    IF  emailId <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.email_id  like '%",emailId,"%'");   
    END IF;
    IF  mobileNo <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.mobile_number  like '%",mobileNo,"%'");   
    END IF;
    IF  verifiedMobNo <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.mobile_verification_status = ",verifiedMobNo);  
    END IF;
    IF  verifiedEmailId <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.email_verification_status = ",verifiedEmailId);  
    END IF;
    IF  ccCategory <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.cc_presales_category_id = ",ccCategory);  
    END IF;
    IF  ccSubCategory <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.cc_presales_substatus_id IN( ",ccSubCategory,")");  
    END IF;
    IF  salesSource <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_source_id = ",salesSource);  
    END IF;
    IF  salesSubSource <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_subsource_id IN( ",salesSubSource,")");  
    END IF;
    IF  modelId <> '' THEN
       SET @tn = CONCAT(@tn," AND ed.model_id = ",modelId);  
    END IF;
    IF  enquiryFromDate <> '0000-00-00' && enquiryToDate <> '0000-00-00' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_enquiry_date between '",enquiryFromDate,"' and '",enquiryToDate,"'");

    END IF;
    
    IF (testDriveGiven = 1) THEN
       SET testDriveGiven = 0;
       SET @tn = CONCAT(@tn," AND enq.test_drive_given = ",testDriveGiven);
    END IF;
    IF  testDriveGiven > 1 THEN
       SET @tn = CONCAT(@tn," AND testdrive.testdrive_status_id = ",testDriveGiven);
    END IF;
    
    IF  ccStatus <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.cc_presales_status_id IN (",ccStatus,")");
       ELSE    
    SET @tn = CONCAT(@tn," AND enq.cc_presales_status_id IN (0,1,3)"); 
    END IF;



    SET @sqldata = CONCAT("SELECT SQL_CALC_FOUND_ROWS
    enq.id,enq.client_id,enq.customer_id,enq.sales_enquiry_date,enq.cc_presales_employee_id,enq.test_drive_given,
    enq.sales_source_id,enq.sales_subsource_id,enq.sales_source_description,enq.cc_presales_status_id,enq.cc_presales_substatus_id,
    enq.cc_presales_category_id,enq.cc_presales_subcategory_id,
    DATE_FORMAT(ccprefollowup.followup_date_time,'%d-%m-%Y @ %h:%i %p') as last_followup_date,
    DATE_FORMAT(ccprefollowup.next_followup_date,'%d-%m-%Y') as next_followup_date,
    DATE_FORMAT(ccprefollowup.next_followup_time,'%h:%i %p') as next_followup_time, 
    ccprefollowup.remarks,ccprefollowup.id as followupid, 
    mlm.model_name,mlsub.sub_model_name,mlvari.varient_name,
    c.title_id,custtitle.title as customer_title, c.first_name as customer_fname, c.last_name as customer_lname, 
    e.first_name as owner_fname, e.last_name as owner_lname,
    cc.mobile_number,cc.area_name as customer_area_name,cc.email_id,cc.landline_number,
    empfollowupby.first_name as followupby_fname,empfollowupby.last_name as followupby_lname,
    cc_presales_subst.cc_presales_substatus,mlccprest.cc_presales_status,
    cc_presales_subc.cc_presales_subcategory,mlccprecat.cc_presales_category,
    mless.sales_source_name, enq_sub_source.enquiry_subsource as enquiry_sub_source,
    group_concat(distinct cc.mobile_number)as mobile,
    group_concat(distinct cc.email_id)as email,
    group_concat(distinct cc.mobile_calling_code) as calling_code,
    group_concat(distinct cc.area_name) as area 
    FROM enquiries as enq
    LEFT JOIN `cc_presales_followups` as ccprefollowup ON enq.id = ccprefollowup.enquiry_id and ccprefollowup.id = (select max(`id`) from `cc_presales_followups` where `enquiry_id` = enq.id group by `enquiry_id`) 
    LEFT JOIN `employees` as empfollowupby ON empfollowupby.id = ccprefollowup.followup_by
    LEFT JOIN `customers`as c ON c.id = enq.customer_id 
    LEFT JOIN `enquiry_details` as ed ON ed.enquiry_id = enq.id
    LEFT JOIN `customers_contacts` as cc ON cc.customer_id = c.id 
    LEFT JOIN `employees` as e ON e.id = enq.cc_presales_employee_id 

    LEFT JOIN lmsauto_master_final.mlst_lmsa_enquiry_sales_sources as mless ON mless.id = enq.sales_source_id 
    LEFT JOIN lmsauto_master_final.mlst_lmsa_cc_presales_categories as mlccprecat ON mlccprecat.id = enq.cc_presales_category_id     
    LEFT JOIN lmsauto_master_final.mlst_lmsa_cc_presales_status as mlccprest ON enq.cc_presales_status_id = mlccprest.id

    LEFT JOIN enquiry_sales_subsources as enq_sub_source ON enq_sub_source.id = enq.sales_subsource_id
    LEFT JOIN cc_presales_substatus as cc_presales_subst ON cc_presales_subst.id = enq.cc_presales_substatus_id 
    LEFT JOIN cc_presales_subcategories as cc_presales_subc ON cc_presales_subc.id = enq.cc_presales_subcategory_id

    LEFT JOIN lmsauto_master_final.mlst_titles as custtitle ON custtitle.id = c.title_id
    LEFT JOIN lmsauto_master_final.mlst_lmsa_models as mlm ON mlm.id = ed.model_id
    LEFT JOIN lmsauto_master_final.mlst_lmsa_submodels as mlsub ON mlsub.id = ed.sub_model_id 
    LEFT JOIN lmsauto_master_final.mlst_lmsa_varients as mlvari ON mlvari.id = ed.veriant_id
    LEFT JOIN testdrives as testdrive ON enq.id= testdrive.enquiry_id and testdrive.id = (select max(`id`) from `testdrives` where `enquiry_id` = enq.id group by `enquiry_id`)
    WHERE
    enq.`cc_presales_employee_id` IN (",employee_id,") AND enq.sales_status_id != 3 ",@tn," 
    group by enq.id,ccprefollowup.id ORDER BY ccprefollowup.id DESC limit ",page_no,",",recordPerPage);

    PREPARE stmt FROM @sqldata; 
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END



BEGIN
set sql_mode = '';
    SET @tn ='';
    IF customerFirstName <> '' THEN
       SET @tn = CONCAT(@tn," AND c.first_name like '%",customerFirstName,"%'");  
    END IF;
    IF customerLastName <> '' THEN
       SET @tn = CONCAT(@tn," AND c.last_name like '%",customerLastName,"%'");  
    END IF;
    IF  emailId <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.email_id  like '%",emailId,"%'");   
    END IF;
    IF  mobileNo <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.mobile_number  like '%",mobileNo,"%'");   
    END IF;
    IF  verifiedMobNo <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.mobile_verification_status = ",verifiedMobNo);  
    END IF;
    IF  verifiedEmailId <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.email_verification_status = ",verifiedEmailId);  
    END IF;
    IF  salesCategory <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_category_id = ",salesCategory);  
    END IF;
    IF  salesSubCategory <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_subcategory_id IN( ",salesSubCategory,")");  
    END IF;
    IF  salesSource <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_source_id = ",salesSource);  
    END IF;
    IF  salesSubSource <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_subsource_id IN( ",salesSubSource,")");  
    END IF;
    IF  modelId <> '' THEN
       SET @tn = CONCAT(@tn," AND ed.model_id = ",modelId);  
    END IF;
    IF  enquiryFromDate <> '0000-00-00' && enquiryToDate <> '0000-00-00' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_enquiry_date between '",enquiryFromDate,"' and '",enquiryToDate,"'");

    END IF;
    
    BEGIN
set sql_mode = '';
     SET @tn ='';
    IF customerFirstName <> '' THEN
       SET @tn = CONCAT(@tn," AND c.first_name like '%",customerFirstName,"%'");  
    END IF;
    IF customerLastName <> '' THEN
       SET @tn = CONCAT(@tn," AND c.last_name like '%",customerLastName,"%'");  
    END IF;
    IF  emailId <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.email_id  like '%",emailId,"%'");   
    END IF;
    IF  mobileNo <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.mobile_number  like '%",mobileNo,"%'");   
    END IF;
    IF  verifiedMobNo <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.mobile_verification_status = ",verifiedMobNo);  
    END IF;
    IF  verifiedEmailId <> '' THEN
       SET @tn = CONCAT(@tn," AND cc.email_verification_status = ",verifiedEmailId);  
    END IF;
    IF  salesCategory <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_category_id = ",salesCategory);  
    END IF;
    IF  salesSubCategory <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_subcategory_id IN(' ",salesSubCategory,"')");  
    END IF;
    IF  salesSource <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_source_id = ",salesSource);  
    END IF;
    IF  salesSubSource <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_subsource_id IN(' ",salesSubSource,"')");  
    END IF;
    IF  modelId <> '' THEN
       SET @tn = CONCAT(@tn," AND ed.model_id = ",modelId);  
    END IF;
    IF  enquiryFromDate <> '0000-00-00' && enquiryToDate <> '0000-00-00' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_enquiry_date between '",enquiryFromDate,"' and '",enquiryToDate,"'");

    END IF;
    
    IF testDriveGiven = 1 THEN
       SET testDriveGiven = 0;
       SET @tn = CONCAT(@tn," AND enq.test_drive_given = ",testDriveGiven);
    END IF;
    IF  testDriveGiven > 1 THEN
       SET @tn = CONCAT(@tn," AND testdrive.testdrive_status_id = ",testDriveGiven);
    END IF;
    
	 IF  statusId <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_status_id IN (",statusId,")");
       ELSE    
    SET @tn = CONCAT(@tn," AND enq.sales_status_id IN (1,2,5)"); 
    END IF;
	 IF  subStatusId <> '' THEN
       SET @tn = CONCAT(@tn," AND enq.sales_substatus_id IN( ",subStatusId,")");  
    END IF;
	IF  companyName <> '' THEN
       SET @tn = CONCAT(@tn," AND company_name like  '%",companyName,"%'");  
    END IF;
IF  pendingFrom <> '' THEN
		IF pendingFrom < 3 THEN
       SET @tn = CONCAT(@tn," AND enqf.`next_followup_date` = DATE_ADD(CURDATE(), INTERVAL - ",pendingFrom," DAY)");
       ELSEIF pendingFrom = 3 THEN
       SET @tn = CONCAT(@tn," AND enqf.`next_followup_date` < DATE_ADD(CURDATE(), INTERVAL - ",pendingFrom," DAY)");
       END IF;
	ELSE
	SET @tn = CONCAT(@tn," AND enqf.`next_followup_date` < CURDATE()");
    END IF;
	
SET @sqldata = CONCAT("SELECT SQL_CALC_FOUND_ROWS enq.id,enq.client_id,enq.customer_id,enq.sales_enquiry_date,enq.sales_employee_id,enq.test_drive_given,enq.max_budget,
	enq.sales_source_id,enq.sales_subsource_id,enq.sales_source_description,enq.sales_status_id,enq.sales_substatus_id,enq.sales_category_id,enq.sales_subcategory_id,
	enq.sales_lost_reason_id,enq.sales_lost_sub_reason_id,finance_required,exchange_required,quotation_given,
	DATE_FORMAT(enqf.followup_date_time,'%d-%m-%Y %h:%i %p') as last_followup_date,enqf.remarks,
	DATE_FORMAT(enqf.next_followup_date,'%d-%m-%Y') as next_followup_date, 
	DATE_FORMAT(enqf.next_followup_time,'%h:%i %p') as next_followup_time,mesc.enquiry_category, 
	mless.sales_source_name,c.title_id, c.first_name as customer_fname, c.last_name as customer_lname, e.first_name as owner_fname,sales_status,  
    empfollowupby.first_name as followupby_fname,empfollowupby.last_name as followupby_lname, custtitle.title as customer_title,enqsubstatus.enquiry_sales_substatus,enqsubcategory.enquiry_sales_subcategory,mlm.model_name,mlsub.sub_model_name,mlvari.varient_name,
    enq_sub_source.enquiry_subsource as enquiry_sub_source, 
    group_concat(distinct cc.mobile_number)as mobile,group_concat(distinct cc.email_id)as email,group_concat(distinct cc.mobile_calling_code) as calling_code,group_concat(distinct cc.area_name) as area,
    group_concat(distinct testdrive.address) as testdrive_address,company_name,
    e.last_name as owner_lname,cc.landline_number,DATEDIFF(CURDATE(),enqf.`next_followup_date`) as pending_from,testdrive.testdrive_status_id FROM 
	`enquiries` enq 
    LEFT JOIN `enquiry_followups` as enqf  ON enq.id = enqf.enquiry_id and enqf.id = (select max(`id`) from `enquiry_followups` where `enquiry_id` = enq.id group by `enquiry_id`)
    LEFT JOIN `customers`as c ON c.id = enq.customer_id 
    LEFT JOIN `customers_contacts` as cc ON cc.customer_id = c.id 
	LEFT JOIN lmsauto_master_final.mlst_lmsa_companies as custcomp ON custcomp.id = c.company_id
    LEFT JOIN `employees` as e ON e.id = enq.sales_employee_id 
    LEFT JOIN `enquiry_details` as ed ON ed.enquiry_id = enq.id 
    LEFT JOIN lmsauto_master_final.mlst_lmsa_models as mlm ON mlm.id = ed.model_id 
    LEFT JOIN lmsauto_master_final.mlst_enquiry_sales_categories as mesc ON mesc.id = enq.sales_category_id 
    LEFT JOIN lmsauto_master_final.mlst_lmsa_enquiry_sales_sources as mless ON mless.id = enq.sales_source_id
    LEFT JOIN enquiry_sales_subsources as enq_sub_source ON enq_sub_source.id = enq.sales_subsource_id
    
    LEFT JOIN lmsauto_master_final.mlst_enquiry_sales_status as mlest ON mlest.id = enq.sales_status_id
    LEFT JOIN `employees` as empfollowupby ON empfollowupby.id = enqf.followup_by 
    LEFT JOIN lmsauto_master_final.mlst_titles as custtitle ON custtitle.id = c.title_id 
    LEFT JOIN enquiry_sales_substatus as enqsubstatus ON enqsubstatus.id = enq.sales_substatus_id 
   LEFT JOIN enquiry_sales_subcategories as enqsubcategory ON enqsubcategory.id = enq.sales_subcategory_id 
   LEFT JOIN lmsauto_master_final.mlst_lmsa_submodels as mlsub ON mlsub.id = ed.sub_model_id 
   LEFT JOIN lmsauto_master_final.mlst_lmsa_varients as mlvari ON mlvari.id = ed.veriant_id 
   LEFT JOIN testdrives as testdrive ON enq.id= testdrive.enquiry_id and testdrive.id = (select max(`id`) from `testdrives` where `enquiry_id` = enq.id group by `enquiry_id`)
    WHERE FIND_IN_SET (enq.`sales_employee_id`,'",employee_id,"')   ",@tn,"   
    GROUP BY enq.id,enqf.id ORDER BY pending_from DESC limit ",page_no,",",recordPerPage);

    PREPARE stmt FROM @sqldata; 
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END