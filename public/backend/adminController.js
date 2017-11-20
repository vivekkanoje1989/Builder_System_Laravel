'use strict';
app.controller('adminController', function ($rootScope, $scope, $state, Data, $stateParams, $timeout) {
    $scope.registration = {};
    $scope.errorMsg = '';
  
    $scope.sessiontimeout = function () {
        $scope.logout("logout");
        //alert("Session expired. Redirected to login");
        window.location.reload();
        return false;
    }

    $scope.checkUsername = function (usernameData) {
        Data.post('checkUsername', {
            username: usernameData.mobile,
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.successMsg = response.message;
            }
        });
    }
    $scope.getEmployeeData = function () {
        $scope.extNumber = [];
        Data.get('getEmployeeData').then(function (response) {
            $scope.ct_employee = response.records;
        });
    }

    $scope.orderByField = function (keyname) {
        $scope.sortKey = keyname;
        $scope.reverseSort = !$scope.reverseSort;
    }
    $scope.resetErrorMsg = function () {
        $scope.errorMsg = '';
    }
    $scope.login = function (loginData) {
        $scope.errorMsg = '';
        Data.post('authenticate', {
            username: loginData.mobile, password: loginData.password,
        }).then(function (response) {
            if (response.success) {
                $scope.showloader1();
                //$state.reload();
                $rootScope.authenticated = true;
                $rootScope.id = response.loggedInUserId;
                $rootScope.loginFullName = response.fullname;
                $rootScope.profileImage = response.profileImage;
                $scope.errlMsg = false;               
                $state.go('dashboard');
                window.location.reload(true);
                $scope.hideloader1();
                return false;

            } else {
                //alert($scope.errorMsg);

                $scope.errlMsg = true;
                $scope.errorMsg = response.message;
            }
        });
    };

    $scope.logout = function (logoutData) {
        $scope.showloader1();
        Data.post('logout', {
            data: logoutData
        }).then(function (response) {
            if (response.success) {
                $rootScope.authenticated = false;
                $rootScope.currentPath = "/login";
                $state.reload();
                $state.go('login');
                window.location.reload();
                $scope.hideloader1();
                return false;
            } else {
                $scope.errorMsg = response.message;
            }
        });
    }
    $scope.signUp = function (registerationData) {
        Data.post('saveRegister', {
            data: registerationData
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $state.go('login');
                $state.reload();
            }
        });
    };
    $scope.sendResetLink = function (sendEmailData) {
        Data.post('password/email', {
            data: sendEmailData
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.successMsg = response.message;
            }
        });
    }
    $scope.resetPassword = function (resetData) {
        Data.post('password/reset', {
            data: resetData
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $state.go('dashboard');
            }
        });
    }

    $rootScope.alert = function (type, msg) {
        $rootScope.message = [];
        $rootScope.message.push(msg);
        $rootScope.alerts = {
            class: type,
            messages: $rootScope.message
        }
    }

$rootScope.forgotP = false;
    $scope.getpassword = function (username) {
        $rootScope.forgotP = true;
        Data.post('getforgotpassword', {
            username: username
        }).then(function (response) {
            if (response.success) {
                $scope.collapsed = false;
                $scope.showmsg = true;
                $scope.changedPassword = response.message;
                $timeout(function () {
                    $scope.showmsg = false;
                }, 10000);


            } else {
                $scope.changedPassword = response.message;
                $scope.next1 = true;
                $scope.showmsg = true;
                $timeout(function () {
                    $scope.showmsg = false;
                }, 3000);
                $scope.next2 = false;
            }

        });
    }
}
);

app.controller('amenitiesCtrl', function ($scope, Data) {
    $scope.amenitiesList = [];
    Data.get('getAmenitiesList').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.amenitiesList = response.records;
        }
    });
});
app.controller('salesEnqCategoryCtrl', function ($scope, Data) {
    Data.get('getSalesEnqCategory').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.salesEnqCategoryList = response.records;
        }
    });
    $scope.getSubCategory = function (categoryId) {
        Data.post('getSalesEnqSubCategory', {categoryId: categoryId}).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.salesEnqSubCategoryList = response.records;
                $("#sales_subcategory_id").val("");
            }
        });
    }
    $scope.getFilterSubCategory = function (categoryId) {
        var data = categoryId.split("_");
        categoryId = data[0];
        Data.post('getSalesEnqSubCategory', {categoryId: categoryId}).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.salesEnqSubCategoryList = response.records;
            }
        });
    }
});

app.controller('salesEnqStatusCtrl', function ($scope, Data) {
    Data.get('getSalesEnqStatus').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.salesEnqStatusList = response.records;
        }
    });
    $scope.getSubStatus = function (statusId) {
        Data.post('getSalesEnqSubStatus', {statusId: statusId}).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.salesEnqSubStatusList = response.records;
                $scope.divEmail = false;
                $scope.divSms = false;
                $scope.divText = true;
            }
        });
    }
    $scope.getFilterSubStatus = function (statusId) {
        var data = statusId.split("_");
        statusId = data[0];
        Data.post('getSalesEnqSubStatus', {statusId: statusId}).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.salesEnqSubStatusList = response.records;
            }
        });
    }

});


app.controller('salesLostReasonCtrl', function ($scope, Data) {
    $scope.salessublostreasons = [];
    Data.get('getSalesLostReason').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.saleslostreasons = response.records;
        }
    });

    $scope.getlostsubreason = function (lostReasonId) {
        var data = lostReasonId.split("_");
        lostReasonId = data[0];
        Data.post('getSalesLostSubReason', {
            data: {lostReasonId: lostReasonId},
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.salessublostreasons = response.records;
                console.log($scope.salessublostreasons);
            }
        });
    }
});


app.controller('employeesWiseTeamCtrl', function ($scope, Data, $timeout) {
    $scope.employeesData = [];
    Data.post('getTeamEmployees', {
        data: {empId: ''},
    }).then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
            $scope.employeesData = response.records;
        } else {
            $timeout(function () {
                console.log($("input[name=customer_number]"));

                $scope.employeesData = response.records;
            }, 1000);

        }
    });
});
app.controller('projectCtrl', function ($scope, Data) {
    Data.get('getProjects').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.projectList = response.records;
        }
    });
});
app.controller('companyCtrl', function ($scope, Data) {
    Data.get('getCompany').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.firmPartnerList = response.records;
        }
    });
});
app.controller('stationaryCtrl', function ($scope, Data) {
    Data.get('getStationary').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.stationaryList = response.records;
        }
    });
});
app.controller('titleCtrl', function ($scope, Data) {
    Data.get('getTitle').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.titles = response.records;
        }
    });
});
app.controller('genderCtrl', function ($scope, Data) {
    Data.get('getGender').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.genders = response.records;
        }
    });
});
app.controller('bloodGroupCtrl', function ($scope, Data) {
    Data.get('getBloodGroup').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.bloodGroups = response.records;
        }
    });
});
app.controller('professionCtrl', function ($scope, Data) {
    Data.get('getProfessionList').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.professions = response.records;
        }
    });
});
app.controller('departmentCtrl', function ($scope, Data, $timeout) {
    $scope.departments = [];
    var empId = $("#empId").val();
    if (empId === "0" || empId === undefined) {

        Data.get('getDepartments').then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.departments = response.records;
            }
        });
    } else {
        $timeout(function () {
            Data.post('editDepartments', {data: empId}).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.departments = response.records;
                }
            });
        }, 3000);
    }
});
app.controller('designationCtrl', function ($scope, Data) {
    Data.get('getDesignations').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.designationList = response.records;
        }
    });
});
app.controller('educationListCtrl', function ($scope, Data) {
    Data.get('getEducationList').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.educationList = response.records;
        }
    });
});
app.controller('blockTypeCtrl', function ($scope, Data) {
    $scope.blockTypeList = [];
    $scope.subBlockList = [];
    $scope.getBlockTypes = function (projectId) {
//        projectId = $scope.enquiryData.project_id.split('_')[0];
        projectId = $("#project_id").val().split('_')[0];
        Data.post('getBlockTypes', {projectId: projectId}).then(function (response) {
                if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.blockTypeList = response.records;
            }
        });
    }
    $scope.checkBlockLength = function (blockId) {
        var blockTypeId = [];
        var projectId = $("#project_id").val().split('_')[0];
        angular.forEach(blockId, function (value, key) {
            blockTypeId.push(value.id);
        });
        var myJsonString = JSON.stringify(blockTypeId);
        if (blockId.length === 0) {
            $scope.emptyBlockId = true;
            $scope.applyClassBlock = 'ng-active';
            $scope.subBlockList = [];
        } else {
            $scope.emptyBlockId = false;
            $scope.applyClassBlock = 'ng-inactive';
            Data.post('getSubBlocks/', {
                data: {myJsonString, projectId: projectId}
            }).then(function (response) {
                if (!response.success) {
                    $scope.errorMsg = response.message;
                } else {
                    $scope.subBlockList = response.records;
                }
            });
        }
    };
});

app.controller('enquirySourceCtrl', function ($scope, Data) {
    $scope.$on("myEvent", function (event, args) {
        $scope.onEnquirySourceChange(args.source_id);
    });
    Data.get('getEnquirySource').then(function (response) {
        $scope.sourceList = '';
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.sourceList = response.records;
        }
    });
    $scope.onEnquirySourceChange = function (sourceId) {

        Data.post('getEnquirySubSource', {
            data: {sourceId: sourceId}}).then(function (response) {
            $scope.subSourceList = '';
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.subSourceList = response.records;
            }
        });
    };
    $scope.onEnquiryFilterSourceChange = function (sourceId) {
        var data = sourceId.split("_");
        sourceId = data[0];
        Data.post('getEnquirySubSource', {
            data: {sourceId: sourceId}}).then(function (response) {
            $scope.subSourceList = '';
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.subSourceList = response.records;
            }
        });
    };
});
app.controller('channelCtrl', function ($scope, Data) {
    Data.get('getChannelList').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.channelList = response.records;
        }
    });
});

app.controller('paymentModeCtrl', function ($scope, Data) {
    Data.get('getpaymentModeList').then(function (response) {
        $scope.paymentModeList = [];
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.paymentModeList = response.records;
        }
    });
});

app.controller('projectBlocksCtrl', function ($scope, Data) {
    Data.get('getProjects').then(function (response) {
        $scope.paymentModeList = [];
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.paymentModeList = response.records;
        }
    });
    $scope.getWings = function (projectId) {
        Data.post('getProjectWings', {
            projectId: projectId
        }).then(function (response) {
            if (!response.status) {
                $scope.errorMsg = response.message;
            } else {
                $scope.wingList = response.result;
            }
        });
    }
    $scope.getBlocks = function (projectId) {
        Data.post('getBlocks', {
            projectId: projectId
        }).then(function (response) {
            $scope.blockList = [];
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.blockList = response.records;
            }
        });
    }
    $scope.getSubBlocks = function (projectId, blockId) {

        Data.post('getSubBlocksList', {
            data: {projectId: projectId, blockId: blockId}
        }).then(function (response) {
            $scope.subBlockList = [];
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.subBlockList = response.records;
            }
        });
    }
});


/****************************UMA************************************/
app.controller('webPageListCtrl', function ($scope, Data) {
    Data.get('getWebPageList').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.listPages = response.records;
        }
    });
});
app.controller('verticalCtrl', function ($scope, Data) {
    Data.get('getVerticals').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.verticals = response.records;
        }
    });
});
app.controller('salesemployeesCtrl', function ($scope, Data) {
    $scope.salesemployeeList = [];
    Data.post('getsalesEmployees').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {

            $scope.salesemployeeList = response.records;
        }
    });
});
/****************************UMA************************************/
/****************************MANDAR*********************************/
app.controller('employeesCtrl', function ($scope, Data) {
    $scope.employeeList = [];
    Data.get('getEmployeesDetails').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.employeeList = response.records;
        }
    });
});
app.controller('clientCtrl', function ($scope, Data) {
    Data.get('getClient').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.clients = response.records;
        }
    });
});
app.controller('vehiclebrandCtrl', function ($scope, Data) {
    Data.get('getVehiclebrands').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.vehiclebrands = response.records;
        }
    });
});
//app.controller('vehiclemodelCtrl', function ($scope, Data) {
//    Data.get('getVehiclemodels').then(function (response) {
//        if (!response.success) {
//            $scope.errorMsg = response.message;
//        } else {
//            $scope.vehiclemodels = response.records;
//        }
//    });
//});

app.controller('blockStageCtrl', function ($scope, Data) {
    Data.get('manageBlockStages').then(function (response) {
        $scope.blockStages = response.records;
    });
});


app.controller('teamLeadCtrl', function ($scope, Data) {
    Data.get('getTeamLead/' + $("#empId").val()).then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.teamLeads = response.records;
        }
    });
});

app.controller('salesSourceCtrl', function ($scope, Data) {
    Data.get('getSalesSource').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.salessources = response.records;
        }
    });


    $scope.onsalesSoucesChange = function () {
        Data.post('getEnquirySubSource', {
            data: {sourceId: $("#source_id").val()}}).then(function (response) {
            $scope.subSourceList = '';
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.subSourceList = response.records;
            }
        });
    };

});

app.controller('getEmployeeCtrl', function ($scope, Data, $timeout) {
    $scope.employees1 = [];
    $scope.memployees = [];
    var ct_id = $("#id").val();
    var flag = 0;
    $timeout(function () {
        Data.post('virtualnumber/editEmp', {ct_id: ct_id}).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.employees1 = response.employees;
                $scope.memployees = response.memployees;
            }
        });
    }, 1000);

});
/****************************MANDAR*********************************/
app.controller('ccpresalesStatusCtrl', function ($scope, Data) {
    Data.get('getccPreSalesStatus').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.ccpresalesstatus = response.records;
        }
    });
    
    $scope.onccpreSalesStatusChange = function (id) {
        
        
        $scope.ccpresalessubStatusList = [];
        if(id == undefined)
        {    
            id=0;
        }
        Data.post('getccpresalesSubtatus', {
            data: {statusId: id},
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.ccpresalessubStatusList = response.records;
            }
        });
    };
}); 


app.controller('salesStatusCtrl', function ($scope, Data) {
    Data.get('getSalesStatus').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.salesstatus = response.records;
        }
    });
}); 

app.controller('ccpresalesCategoryCtrl', function ($scope, Data) {
    Data.get('getccPreSalesCategory').then(function (response) {
        if (!response.success) {
            $scope.errorMsg = response.message;
        } else {
            $scope.ccpresalescategory = response.records;
        }
    });
    
    $scope.onccpresalesCategoryChange = function (id) {
        $scope.ccpresalesSubCategoriesList = [];
        if(id == undefined)
        {    
            id=0;
        }
        Data.post('getccPreSalesSubCategory', {
            data: {statusId: id},
        }).then(function (response) {
            if (!response.success) {
                $scope.errorMsg = response.message;
            } else {
                $scope.ccpresalesSubCategoriesList = response.records;
            }
        });
    };
});

app.filter('split', function () {
    return function (input, splitChar, splitIndex) {
        console.log(input);
        // do some bounds checking here to ensure it has that index
        return input.split(splitChar)[splitIndex];
    }
});
app.filter('underscoreless', function () {
    return function (input) {
        return input.replace(/_/g, ' ');
    };
});
app.filter('capitalize', function () {
    return function (input) {
        return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});
app.filter('htmlToPlaintext', function ()
{
    return function (text)
    {
        var temp = text ? String(text).replace(/<[^>]+>/gm, '') : '';
        temp = temp ? String(temp).replace(/  /g, '&nbsp; ') : '';
        return  temp;
    };
});

