/**
 * Created by Cengkuru michael <Email: mcengkuru@newwavetech.co.ug> on 8/5/2015.
 */

$(document).ready(function(){



    // --------------------------------------------------------------------------------------------------------
    // declare commonly used variables
    // --------------------------------------------------------------------------------------------------------
    var loadingGif = '<img src="' + commonFunctions.baseUrl() + 'public/images/loading.gif" alt="Please wait ...">';

    // --------------------------------------------------------------------------------------------------------
    // add form token to every ajax request
    // --------------------------------------------------------------------------------------------------------

    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });


    // --------------------------------------------------------------------------------------------------------
    // reset all form fields
    // --------------------------------------------------------------------------------------------------------

    $(".reset").click(commonFunctions.resetForm());



    // --------------------------------------------------------------------------------------------------------
    // Handling normal post form
    // --------------------------------------------------------------------------------------------------------

    var normalForm = $("#normalForm");

    //if form is submitted
    normalForm.submit(function(){
        var form =$(this);

        var formData = normalForm.serialize();
        //get form Method
        var method = form.find('input[name="method"]').val()||'POST';

        //make ajax request
        $.ajax({
            url: form.prop('action'),
            type: method,
            data: formData,
            success: function (data){
                var successHtml='';
                if(data._success) {
                    successHtml += data._success;
                }

                if(data._message) {
                    console.log(data._message)
                    successHtml +='<div class="alert alert-info">'+data._message+'</div>';
                }

                if(data._fail) {
                    successHtml +='<div class="alert alert-danger">'+data._fail+'</div>';
                }

                if(data._success_redirect) {
                    window.location.href = data._success_redirect;
                }



                //empty all fields after adding values
                var submit_val=$('input[type="submit"]').val().toLowerCase();

                if(submit_val.substring(0,6)!='update'){
                    form.find('input[type="text"],input[type="password"],input[type="textarea"]').val("");
                }



                noty({
                    text: successHtml,
                    layout: 'top',
                    closeWith: ['click', 'hover'],
                    type: 'success'
                });

            },
            error: function(data){
                //if ajax request fails
                var errors =data.responseJSON;

                //create container for message
                var errorsHtml;

                errorsHtml = '<ul style="list-style: none;">';

                $.each(errors, function (key, value) {
                    errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                });
                errorsHtml += '</ul>';
                //appending to a <div class=".formAlerts"></div> inside form

                noty({
                    text: errorsHtml,
                    layout: 'top',
                    timeout     : 10000,
                    closeWith: ['click', 'hover'],
                    type: 'error'
                });


            }

        });

        //prevent default action of the form
        return false;

    });




});
