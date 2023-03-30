jQuery(document).ready(function($) {

    const captcha =new Captcha($('#canvas'),{
      width: 200,
      height: 60,
        length: 4,
        autoRefresh:false

    });

    $("#CaptchaUser").val(captcha.getCode());

    $('#canvas').on('click',function() {
        $("#CaptchaUser").val(captcha.getCode());
    });

    $('#refreshCapta').on('click',function() {
        captcha.refresh();
        $("#CaptchaUser").val(captcha.getCode());
    });




    $('form.ajax').on('submit',function(e) {

        // alert("sadas");
        


            e.preventDefault();
            //alert(cpm_object.ajax_url);

            const ans = captcha.valid($('input[name="code"]').val());
        
            // console.log(ans);

            var form = $('#query-form').serialize();



            var formData = new FormData;
            formData.append('action','submit_query');
            formData.append('submit_query',form);


            $.ajax({
               url: cpm_object.ajax_url,
               type:'post',
               processData:false,
               contentType:false,
               data:formData,
                success: function(response){
                    console.log(response);
                   var result  = jQuery.parseJSON(response);
                    console.log(result);
                    $("#CaptchaUser").val(captcha.getCode());
                    
                    if(result.code == 404){
                        let errorhtml = ''; 
                        if(result.validation_msg.length > 0){
                            for (let index = 0; index < result.validation_msg.length; index++) {
                                errorhtml += `<li>${result.validation_msg[index]}</li>`;
                                 
                             }
                        }

                        $(".display-error").html(`<ul>${errorhtml}</ul>`);
                        $(".display-error").css("display","block");
                    }
                    if(result.code == 200){
                        let successhtml = ''; 

                        $("#msg").html(`<div class="success-message">${result.msg}</div>`);
                        captcha.refresh();
                        $("#CaptchaUser").val(captcha.getCode());
                        $(".display-error").html(` `);
                        $(".display-error").css("display","none");
                        $('form.ajax')[0].reset();
                        
                    }
                    
                    
                }, 
                error: function(data){
                  $(".error_msg").css("display","block"); 
                }
            });
           
        
    })

});

