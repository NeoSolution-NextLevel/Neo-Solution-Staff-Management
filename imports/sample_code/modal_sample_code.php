<div class="modal fade w3-white w3-opacity w3-right" data-backdrop="static" data-keyboard="false" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content w3-theme-l4">

            <div class="modal-body" id="myModalbody">


            </div>

        </div>
    </div>
</div>





<!------------------------->
<div class="row">
    <div class="col-lg-12">
        <div class="w3-panel w3-red" id="error_msg_body" style="display: none;">
            <h3>Error Message!</h3>
            <p id="error_msg">Green often indicates something successful or positive.</p>
        </div>
    </div>
</div>
<!------------------------->

<div class="row">
    <div class="col-lg-12 w3-margin-top w3-margin-bottom">
        <div class="container-fluid">
            <?php $get_image_form_id_setup = "st_body_02_02_E_06_form_id" ?>
            <!---------------------------------------------------------------------------------------------------->
            <div class="row" id="<?php echo $get_image_form_id_setup ?>_image_not_found_body">
                <div class="col-lg-12">
                    <div class="container-fluid w3-padding-16 w3-theme-l2" >
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="w3-display-container w3-animate-zoom">
                                    <img src="<?php echo $pth; ?>imports/img/EMPTY_IMAGE.png" style="width: 100%;height: 400px" class="w3-image w3-animate-zoom" id="<?php echo $get_image_form_id_setup ?>_image_not_found">
                                    <div class="w3-display-middle w3-xlarge w3-header w3-strong w3-center w3-text-white w3-animate-zoom" style="width: 100%;">
                                        Deposit Slip Image Not Found
                                    </div>
                                    <div class="w3-display-bottomleft">
                                        <img src="<?php echo $company_obj->get_compnay_logo_url(); ?>" style="width: 50px;" class="w3-animate-zoom w3-margin" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-8 w3-center">                                    
                                <button type="button" class="w3-button w3-padding-16 w3-theme-dark w3-round w3-margin-top w3-margin-bottom w3-block w3-strong w3-animate-zoom" id="<?php echo $get_image_form_id_setup ?>_uploadTrigger">
                                    Upload Deposit Slip 
                                </button>
                            </div>
                            <div class="col-lg-4">
                                <script  type="text/javascript">
                                    function <?php echo $get_image_form_id_setup ?>_mobile_scan_image() {
                                        document.getElementById("image_uploder_myModal_scan_image").value = "1";
                                        document.getElementById("image_uploder_myModal_pic_image").value = "0";
                                        document.getElementById("image_uploder_myModal_normal_image_uploader").value = "1";
                                        mobile_scan_image();

                                    }

                                </script>
                                <button type="button" class="w3-button w3-padding-16 w3-theme-dark w3-round w3-margin-top w3-margin-bottom w3-block w3-strong w3-animate-zoom w3-block" onclick="<?php echo $get_image_form_id_setup ?>_mobile_scan_image()">
                                    Scan
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#<?php echo $get_image_form_id_setup ?>_uploadTrigger').click(function () {
                        image_uploader_form_id = "st_body_02_02_E_06_form_id";
                        document.getElementById("image_uploder_image_TYPE").value = "DEPOSIT_SLIP_IMAGE";
                        document.getElementById("image_uploder_MULTI").value = "1";// 1 is only one 0 is mutiple 
                        document.getElementById("<?php echo $get_image_form_id_setup ?>_error_msg_body").style.display = "none";
                        $('#image_uploder_image').click();
                    });
                });
            </script>
            <!--------------------------------------------------------------------------------------------------------->
            <div class="row" id="<?php echo $get_image_form_id_setup ?>_body" style="display: none;">
                <div class="col-lg-12">
                    <div class="container-fluid w3-padding-16 w3-theme-l2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="w3-display-container w3-animate-zoom">
                                    <img src="<?php echo $pth; ?>imports/img/EMPTY_IMAGE.png" style="width: 100%;height: 400px;" class="w3-image w3-animate-zoom" id="<?php echo $get_image_form_id_setup ?>_IMG">
                                    <div class="w3-display-bottomleft">
                                        <img src="<?php echo $company_obj->get_compnay_logo_url(); ?>" style="width: 50px;" class="w3-animate-zoom w3-margin w3-animate-zoom" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="<?php echo $get_image_form_id_setup ?>_del_btn">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <button type="button" class="w3-button w3-padding-16 w3-round w3-margin-top w3-margin-bottom w3-block w3-strong w3-animate-zoom w3-red" onclick="image_uploder_update_del_request_form()">
                                    Remove Image
                                </button>
                            </div>     
                            <div class="col-lg-3"></div>
                        </div>
                        <div class="row" id="<?php echo $get_image_form_id_setup ?>_del_request_body" style="display: none;">
                            <div class="col-lg-12">
                                <div class="container-fluid w3-margin-top">
                                    <div class="row">
                                        <div class="col-lg-12 w3-strong w3-large">
                                            Do you want to change this image?
                                        </div>
                                    </div>
                                    <div class="row w3-margin-top">
                                        <!--<div class="col-lg-1"></div>-->
                                        <div class="col-lg-7">
                                            <button type="button" class="w3-button w3-red w3-padding-16 w3-block w3-round w3-strong" onclick="image_uploder_remveo_image()">Change Image </button>
                                        </div>
                                        <div class="col-lg-5">
                                            <button type="button" class="w3-button w3-theme-dark w3-padding-16 w3-block w3-round w3-strong" onclick="image_uploder_show_image()">Cancel</button>
                                        </div>
                                        <!--<div class="col-lg-1"></div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!--------------------------------------------------------------------------------------------------------->

        </div>
    </div>
</div>