/**
 *
 */
define(
    [
        'jquery',
        "jquery/ui",
    ],
    function ($) {
        'use strict';
//        console.log("Loaded : Ordercomment js");


         $(document).on('click', '.order-comment-btn', function (e) {

            e.preventDefault();

            var flag = true;

            if (document.getElementById("order_comments_required")) {
               var order_comments_required = document.getElementById("order_comments_required").value;
            }

            if (order_for_required = document.getElementById("order_for_required")) {
               var order_for_required = $("#order_for_required").val();
            }

            if (order_comments_required == "") {
                document.getElementById('order_comments_required_error').innerHTML = 'This is a required field.';
                var flag = false;
            }

            if (order_for_required == "") {
                document.getElementById('order_for_required_error').innerHTML = 'This is a required field.';
                var flag = false;
            }

            if (flag == false) {
                return false;
            } else {
                var form = $('#co-shipping-form');
                var formData = new FormData(form[0]);
                /*data: $('#co-shipping-form').serialize(),*/
                 $.ajax({
                        showLoader: true,
                        url: window.checkoutConfig.ordercommentbaseurl,
                        data: formData,
                        type: "POST",
                        datatype: "json",
                        cache:false,
                        contentType: false,
                        processData: false
                    }).done(function (data) {
                        console.log(data);
                        if(data.success == 'true'){

                            if(data.fileuploadstauts == 1 && data.filename != "") {
                                $('.block-order-comments .block-order-for .block-content .file-uploded').remove();
                                $('#order_for').val('');

                                $('.block-order-comments .block-order-for .block-content').append('<div class="file-uploded"><span class="file-upload-status" data-bind="text: getfileuploadvalue()">'+ data.filename +'</span><a href="javascript:;" class="order-file-removelink remove-file-icon"> Remove</a></div>');
                            }



                            if(data.ordercommentstatus == 1 && data.comment != "") {
                                $('.block-order-comment .block-content .block-title').remove();
                                $('#submitfordelete').remove();
                                $('.block-order-comment .block-content').append('<p class="block-title">'+ data.comment +'</p>');
                            }

                            if(data.ordercommentstatus == 1 && data.comment){
                                $('.block-order-comment .block-content').append('<a href="javascript:;" id="submitfordelete" class="order-comment-removelink remove-comment-icon"> Remove Comment</a>');
                            }
                            $("#order_comments").val('');
                            $(".block-title").show();
                            $(".order-comment-removelink").show();
                        }else{
                            $(".block-title").hide();
                            $(".order-comment-removelink").hide();
                        }
                        validatefrom();

                    });
                return false;
                /*return true;*/
            }


       });
        $(document).on('click', '.order-file-removelink', function (event) {
            event.preventDefault();
            $.ajax({
                showLoader: true,
                url: window.checkoutConfig.orderfiledelete,
                data: "",
                type: "POST",
                datatype: "json"
            }).done(function (data) {
                if(data.success == 'true'){
                    validatefrom();
                    $('.block-order-comments .block-order-for .block-content .file-uploded').remove();
                    $('.order-file-removelink').remove();
                }
            });
        });

        $(document).on('click', '#submitfordelete', function (event) {
                event.preventDefault();
                $.ajax({
                    showLoader: true,
                    url: window.checkoutConfig.ordercommentdelete,
                    data: "",
                    type: "POST",
                    datatype: "json"
                }).done(function (data) {
                    if(data.success == 'true'){
                        $('#order_for').val('');
                        validatefrom();
                        $('.block-order-comment .block-content .block-title').html('');
                        $('.block-order-comment .block-content #submitfordelete').html('');
                    }
                });
            });


        function validatefrom() {
            if($('#order_for').length >0 && $('#order_comments').length >0 ){
                // console.log('asdh');
                if($('#order_for').val() == "" && $.trim($('#order_comments').val()) == ""){
                    $('#order-commentbtn').prop('disabled', true);
                }
                else{
                    $('#order-commentbtn').removeAttr('disabled');
                }
            }else{
                if($('#order_for').length >0){
                    if($('#order_for').val() == ""){
                        $('#order-commentbtn').prop('disabled', true);
                    }
                    else{
                        $('#order-commentbtn').removeAttr('disabled');
                    }
                }
                if($('#order_comments').length >0){
                    if($.trim($('#order_comments').val()) == "") {
                        $('#order-commentbtn').prop('disabled', true);
                    }
                    else{
                        $('#order-commentbtn').removeAttr('disabled');
                    }
                }
            }
        }
        validatefrom();
        $(document).on('input', '#order_comments', function (event) {
            validatefrom();
        });
        $(document).on('change', '#order_for', function (event) {
            validatefrom();
        });


    }
)
