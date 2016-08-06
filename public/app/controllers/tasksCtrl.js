app.controller('tasksCtrl',function($scope,$http,$interval,$log,$routeParams,$route){

    $scope.datepickerOptions = {
        format: 'yyyy-mm-dd',
        language: 'fr',
        startDate: "2012-10-01",
        endDate: "2012-10-31",
        autoclose: true,
        weekStart: 0
    }

    //page information
    var pageInfo=
    {
        pageTitle:'All tasks'
    };

    // array to hold deleted items
    $scope.deletedTasks=[];

    $scope.pageInfo=pageInfo;
    $scope.parent =
    {
        checkOut:''
    };

    //by default update view is false
    $scope.updateView = false;
    if($routeParams.id){
        $scope.updateView = true;
    }






    $scope.addTask = function(){

        $scope.task.duedate = $("#datetimepicker").val();


        //when updating
        if($scope.updateView){
            //when updating new task
            $http
                .put('task/'+$routeParams.id,{
                    title:$scope.task.title,
                    duedate:!$scope.parent.checkOut?new Date():$scope.parent.checkOut,
                    tasklist_id: !$scope.task.tasklist_id?'1':$scope.task.tasklist_id,
                    status:!$scope.task.status?'ACTIVE':$scope.task.status
                })
                .then(
                    function(response){
                        $scope.success=response.data;
                        $log.info(response)

                    },function(reason){
                        $scope.error=reason.data;

                        $log.info(reason)
                    })











        }else {
            //when adding a new task
            $http
                .post('task',{
                    title:$scope.tasks.title,
                    duedate:!$scope.parent.checkOut?new Date():$scope.parent.checkOut,
                    tasklist_id: !$scope.tasks.tasklist_id?'1':$scope.tasks.tasklist_id,
                    status:!$scope.tasks.status?'ACTIVE':$scope.tasks.status
                })
                .then(
                    function(response){
                        $scope.success=response.data;
                        $scope.tasks=[];
                        $scope.parent =
                        {
                            checkOut:''
                        };
                        $scope.tasks.tasklist_id=0;
                        $scope.tasks.status='';


                        $log.info(response)

                    },function(reason){
                        $scope.error=reason.data;

                        $log.info(reason)
                    })

        }




    }

    $scope.deleteTask = function(task){
        var index = $scope.tasks.indexOf(task);


        $http({
            url:'task/'+task.id,
            method:'delete'
        })
            .then
            (
                //result
                function(response){

                    $log.info(response)

                },
                //if there is an error
                function(reason){
                    $scope.error=reason.data;
                    $log.info(reason)
                }
            )

        //clear task from view
        $scope.tasks.splice(index, 1);

    }


    //grab all tasklists
    $http
        .get('api/tasklists/all')
        .then
        (
            //result
            function(response){
                $scope.tasklists = response.data;
                $log.info(response)

            },
            //if there is an error
            function(reason){
                $scope.error=reason.data;
                $log.info(reason)
            }
        )

    // when on tasks index page
    if(!$scope.updateView){
        //grab tasks
        $http
            .get('api/tasks/all')
            .then
            (
                //result
                function(response){
                    $scope.tasks = response.data;
                    $log.info(response)

                },
                //if there is an error
                function(reason){
                    $scope.error=reason.data;
                    $log.info(reason)
                }
            )



    }

    //get task by id
    if($scope.updateView){

        $http({
            url:'task/'+$routeParams.id+'/edit',
            method:'get'
        })
            .then
            (
                //result
                function(response){
                    $scope.task = response.data;
                    $scope.parent.checkOut=$scope.task.duedate;
                    $log.info(response)

                },
                //if there is an error
                function(reason){
                    $scope.error=reason.data;
                    $log.info(reason)
                }
            )
    }

    // reload the route
    $scope.reloadData = function(){
        $route.reload();
    }






})