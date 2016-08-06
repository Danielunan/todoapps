var commonFunctions = {

    baseUrl: function getBaseURL(){
        var pageURL=document.location.href;
        var urlArray=pageURL.split("/");
        var BaseURL=urlArray[0]+"//"+urlArray[2]+"/";

        if(urlArray[2]=='localhost') BaseURL=BaseURL+'todoApp/';

        return BaseURL;
    },
    resetForm: function resetForm () {
        $(this).closest('form').find("input[type=text], textarea").val("");
    }
}




