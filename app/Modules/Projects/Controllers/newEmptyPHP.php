<?php
if(isset($input['specificationData']) || isset($input['layoutData'])){
                echo $input['objName'];exit;
                $result = [];
                if(!empty($input['specificationData']['modalData']['floors'])){
                    $projectWingName = ProjectWing::select('wing_name')->where('id', $input['specificationData']['modalData']['wing'])->get();
                    $floorArr = array();
                    foreach($input['specificationData']['modalData']['floors'] as $key => $floor){
                        unset($floor['$hashKey'],$floor['wingId']);
                        $floorId[] = $floor['id'];
                        $floorArr[] = $floor;
                    }                  
                    sort($floorId);
                    $input['specificationData']['modalData']['specification_images'] = $implodeImgName;
                    $input['specificationData']['modalData']['floors'] = $floorId;

                    if(!empty($isProjectExist->specification_images)){
                        $mergeOldSpecification = json_decode($isProjectExist->specification_images,true);
                    }
                    $mergeOldSpecification[] = $input['specificationData']['modalData'];
                    
                    $input['specificationData']['specification_images'] = json_encode($mergeOldSpecification);
                    unset($input['specificationData']['modalData']); 
                    $specificationTitle = ["image" => $implodeImgName,"title" => $projectWingName[0]->wing_name .", Floor:". implode(",", $floorId)];
                    if (empty($isProjectExist)) {
                        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                        $input['specificationData'] = array_merge($input['specificationData'],$create);                
                        $actionProject = ProjectWebPage::create($input['specificationData']);
                        $msg = "Record added successfully";
                        
                        $result = ['success' => true, 'message' => $msg, 'specificationTitle' => $specificationTitle];
                        return json_encode($result);
                    }else{
                        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                        $input['specificationData'] = array_merge($input['specificationData'],$update);
                        $actionProject = ProjectWebPage::where('project_id', $projectId)->update($input['specificationData']);
                        
                        $msg = "Record updated successfully";
                        $result = ['success' => true, 'message' => $msg, 'specificationTitle' => $specificationTitle];
                        return json_encode($result);
                    }
                }                
            }