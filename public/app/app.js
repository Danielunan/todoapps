var app = angular.module('app', ['ui.router', 'ng-bootstrap-datepicker'])
    .config(function($stateProvider,$urlMatcherFactoryProvider,$urlRouterProvider) {

        //case insensitive urls
        $urlMatcherFactoryProvider.caseInsensitive(true);

        //configure default route
        $urlRouterProvider.otherwise('/')


        $stateProvider

            //dashboard
            .state('home', {
                url: '/',
                templateUrl: 'app/templates/home/index.html',
                controller:'mainController',
                controllerAs:'mainCtrl',
                data:{
                    pageTitle:'home'
                },

                resolve:{
                    myTasks:function($http){
                        return $http
                            .get('api/tasks/all')
                            .then
                            (
                                //result
                                function (response) {
                                    return response.data;
                                }
                            )
                    }
                }

            })

            //tasks
            .state('tasks', {
                url: '/tasks',
                templateUrl: 'app/templates/tasks/index.html',
                controller:'tasksController',
                controllerAs:'tasksCtrl',
                data:{
                    pageTitle:'tasks',
                    updateView:false
                }

            })
            // new tasks
            .state('newTask', {
                url: '/new',
                templateUrl: 'app/templates/tasks/new.html',
                controller:'tasksController',
                controllerAs:'tasksCtrl',
                data:{
                    pageTitle:'New task',
                    updateView:false

                },
                resolve:{
                    Task:function($http,$stateParams){

                    }
                },


            })
            //update task
            .state('taskEdit',
                {
                    url: '/task/:id/edit',
                    templateUrl: 'app/templates/tasks/update.html',
                    controller:'tasksController',
                    controllerAs:'tasksCtrl',
                    data:{
                        pageTitle:'Update task',
                        updateView:true
                    },
                    resolve:{
                        Task:function($http,$stateParams){

                            return $http({
                                url:'task/'+$stateParams.id+'/edit',
                                method:'get'
                            })
                                .then
                                (
                                    //result
                                    function(response){
                                        return response.data;
                                    }
                                )
                        }
                    }
                }
            )

            //search for task
            .state('taskSearch',
                {
                    url: '/tasksSearch/:title',
                    templateUrl: 'app/templates/tasks/search.html',
                    controller:'taskSearchController',
                    data:{
                        pageTitle:'Search For task'
                    },
                    resolve:{
                        Tasks:function($http,$stateParams){
                            return $http({
                                url: 'api/tasks/search/'+$stateParams.title,
                                method: 'get'
                            })
                                .then
                                (
                                    //result
                                    function (response) {
                                        console.log(response.data)
                                        return response.data;
                                    }
                                )
                        }
                    }
                }
            )

            //tasklists
            .state('tasklists', {
                url: '/tasklists',
                templateUrl: 'app/templates/tasklists/index.html',
                controller:'tasklistsController',
                controllerAs:'tasklistsCtrl',
                data:{
                    pageTitle:'tasklists'
                }

            })

    })

    //*************SERVICES***********************8888
    .service('tasksService',['$http','$log','$state',function($http,$log,$state){

        //get all tasks
        this.getAllTasks = function(){
            $http
                .get('api/tasks/all')
                .then
                (
                    //result
                    function (response) {
                        $log.info(response)
                        return response.data;


                    },
                    //if there is an error
                    function (reason) {
                        $log.info(reason)
                        return reason.data;

                    }
                )
        }

        // add task
        this.addTask = function () {

            this.task.duedate = $("#datetimepicker").val();


            //when updating
            if (this.updateView) {
                //when updating new task
                $http
                    .put('task/' + $stateParams.id, {
                        title: $scope.task.title,
                        duedate: !$scope.parent.checkOut ? new Date() : $scope.parent.checkOut,
                        tasklist_id: !$scope.task.tasklist_id ? '1' : $scope.task.tasklist_id,
                        status: !$scope.task.status ? 'ACTIVE' : $scope.task.status
                    })
                    .then(
                        function (response) {
                            $scope.success = response.data;
                            $log.info(response)

                        }, function (reason) {
                            $scope.error = reason.data;

                            $log.info(reason)
                        })


            } else {
                //when adding a new task
                $http
                    .post('task', {
                        title: $scope.tasks.title,
                        duedate: !$scope.parent.checkOut ? new Date() : $scope.parent.checkOut,
                        tasklist_id: !$scope.tasks.tasklist_id ? '1' : $scope.tasks.tasklist_id,
                        status: !$scope.tasks.status ? 'ACTIVE' : $scope.tasks.status
                    })
                    .then(
                        function (response) {
                            $scope.success = response.data;
                            $scope.tasks = [];
                            $scope.parent =
                            {
                                checkOut: ''
                            };
                            $scope.tasks.tasklist_id = 0;
                            $scope.tasks.status = '';


                            $log.info(response)

                        }, function (reason) {
                            $scope.error = reason.data;

                            $log.info(reason)
                        })

            }


        }

        // reload the route
        this.reloadData = function () {
            $state.reload();
        }

        //search for tasks
        this.searchTask = function () {

            //if there is a search param
            if (this.searchTaskInput) {

                $location.url('/tasksSearch/' + this.searchTaskInput)
            } else {
                $location.url('/tasksSearch/')
            }

            if(this.searchTaskInput){
                $http({
                    url: 'api/tasks/search/'+this.searchTaskInput,
                    method: 'get'
                })
                    .then
                    (
                        //result
                        function (response) {
                            this.searchResults = response.data;

                            $log.info(response)

                        },
                        //if there is an error
                        function (reason) {
                            this.error = reason.data;
                            $log.info(reason)
                        }
                    )

            }else {
                //grab tasks
                $http
                    .get('api/tasks/all')
                    .then
                    (
                        //result
                        function (response) {
                            this.searchResults = response.data;
                            $log.info(response)

                        },
                        //if there is an error
                        function (reason) {
                            this.error = reason.data;
                            $log.info(reason)
                        }
                    )


            }
        }






    }])

    //tasklist service
    .service('tasklistsService',['$http','$log','$state',function($http,$log){

        //get all tasks
        this.getAllTasklists = function(){
            $http
                .get('api/tasklists/all')
                .then
                (
                    //result
                    function(response){

                        return response.data;


                    }
                )
        }
    }])


    // main controller
    .controller("mainController", ['$scope','myTasks','$state','tasksService','tasklistsService','$http','$location', function($scope,myTasks,$state,tasksService,tasklistsService,$http,$location) {
        $scope.pageTitle=$state.current.data.pageTitle;

        // date picker defaults
        $scope.datepickerOptions = {
            format: 'yyyy-mm-dd',
            language: 'fr',
            startDate: "2012-10-01",
            endDate: "2012-10-31",
            autoclose: true,
            weekStart: 0
        }

        $scope.parent =
        {
            checkOut: ''
        };

        //by default update view is false
        $scope.updateView = false;

        $scope.tasks = myTasks;

        // reload the route
        $scope.reloadData = function () {
            tasksService.reloadData()
        }

        // array to hold deleted items
        $scope.deletedTasks = [];

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


        //search for tasks
        $scope.searchTask = function () {

                //if there is a search param
            $state.go('taskSearch',{title:$scope.searchTaskInput?$scope.searchTaskInput:'all'})

            }





    }])
    // tasks controller
    .controller("tasksController", ['$scope','Task','$state','tasksService','$stateParams','$http', function($scope,Task,$state,tasksService,$stateParams,$http) {
        $scope.pageTitle=$state.current.data.pageTitle;
        $scope.updateView=$state.current.data.updateView;

        console.log($scope.updateView)


        //get all task lists
        $http
            .get('api/tasklists/all')
            .then
            (
                //result
                function(response){
                    $scope.tasklists = response.data;
                }
            )

        $scope.parent =
        {
            checkOut:''
        };
        if($stateParams.id){
            $scope.updateView = true;
        }



        //get task by id
        if($scope.updateView==true){
            $scope.task = Task;
            $scope.pageTitle='Update '+$scope.task.title

            $scope.parent.checkOut=$scope.task.duedate;

        }

        $scope.addTask = function(){

            $scope.task.duedate = $("#datetimepicker").val();


            //when updating
            if($scope.updateView==true){
                //when updating new task
                $http
                    .put('task/'+$stateParams.id,{
                        title:$scope.task.title,
                        duedate:!$scope.parent.checkOut?new Date():$scope.parent.checkOut,
                        tasklist_id: !$scope.task.tasklist_id?'1':$scope.task.tasklist_id,
                        status:!$scope.task.status?'ACTIVE':$scope.task.status
                    })
                    .then(
                        function(response){
                            $scope.success=response.data;

                        },function(reason){
                            $scope.error=reason.data;
                        })
            }else {
                //when adding a new task
                $http
                    .post('task',{
                        title:$scope.task.title,
                        duedate:!$scope.parent.checkOut?new Date():$scope.parent.checkOut,
                        tasklist_id: !$scope.task.tasklist_id?'1':$scope.task.tasklist_id,
                        status:!$scope.task.status?'ACTIVE':$scope.task.status
                    })
                    .then(
                        function(response){
                            $scope.success=response.data;
                            $scope.task=[];
                            $scope.parent =
                            {
                                checkOut:''
                            };
                            $scope.task.tasklist_id=0;
                            $scope.task.status='';

                        },function(reason){
                            $scope.error=reason.data;
                        })

            }




        }




    }])
    // tasks controller
    .controller("taskSearchController", ['$scope','Tasks','$state', function($scope,Tasks,$state) {
        $scope.pageTitle=$state.current.data.pageTitle;
        $scope.tasks= Tasks;
    }])




