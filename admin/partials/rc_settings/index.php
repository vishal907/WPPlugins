<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.7/popper.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
    $(document).ready(function() {
 
        $('input[name=date]').datetimepicker({
            format: 'YYYY-MM-DD',
           
        });

        
        $('input.search_rc_code_event').on('click', function(e) {
            e.preventDefault();
            var rc_title = $('input[name=rc_title]').val();

            $.post(
                ajaxurl,
                {
                    "action": "search_rc_code_event",
                    "rc_title": rc_title,
                }
            )
                .done(function(data) {
                    var obj = jQuery.parseJSON( data.success);
                    jQuery('#formContainer').css('display','block');
                    jQuery('#expire_date').val(obj.expire_date);
                    jQuery('.mytitle').html(rc_title);
                    if(obj.email_noti == 'off'){
                        $('#email_noti option:eq(1)').prop('selected', true);
                    }else{
                        $('#email_noti option:eq(0)').prop('selected', true);
                    }

                    if(obj.rc_status == 'no'){
                        $('#rc_status option:eq(1)').prop('selected', true);
                    }else{
                        $('#rc_status option:eq(0)').prop('selected', true);
                    }
                    jQuery('#crr_order_id').val(obj.order_id);
               
                $('#rc_title').attr("disabled", true) 


                })
                .fail(function(data) {
                    $('p#event_disabled_message').slideUp();
                    var response = data.responseText;
                    response = $.parseJSON(response);
                    if(response) {
                        display_message(response.error, true, 'event_disabled_message');
                    } else {
                        display_message('Unexpected error occurred.', true, 'event_disabled_message');
                    }
                });
        });


         $('input.update_changes').on('click', function(e) {
            e.preventDefault();
            var expire_date = jQuery('#expire_date').val();
            var email_noti = jQuery('#email_noti').val();
            var rc_status = jQuery('#rc_status').val();
            var crr_order_id = jQuery('#crr_order_id').val();
           
            $.post(
                ajaxurl,
                {
                    "action": "change_rc_redeemed_status",
                    "id": crr_order_id,
                    "status": rc_status,
                    "email_noti": email_noti,
                    "expire_date": expire_date,
                }
            )
                .done(function (data) {
                    alert(data.success);
                     setTimeout(function() {
                        location.reload();
                    }, 500);
                })
                .fail(function (data) {
                    var response = data.responseText;
                    response = $.parseJSON(response);
                    if (response) {
                        alert(response.error);
                    } else {
                        alert('Unexpected error occurred.');
                    }
                });
           
        });

       

        function display_message(message, is_error, id_name) {
            if(is_error) {
                $('p#'+id_name)
                    .find('small')
                    .html('<i class="fa fa-exclamation-triangle"></i> ' + message)
                    .removeClass('text-success')
                    .addClass('text-danger');
                $('p#'+id_name).slideToggle();
            } else {
                $('p#'+id_name)
                    .find('small')
                    .html('<i class="fa fa-check"></i> ' + message)
                    .removeClass('text-danger')
                    .addClass('text-success');
                $('p#'+id_name).slideToggle();
            }
        }
    });
</script>
<style>
    div#wpcontent {
        background-color: #F1F1F1;
    }
    select#email_noti, select#rc_status {
        max-width: 100%;
    }
    .card-body h6 {
        font-style: italic;
        padding-bottom: 10px;
    }
    i.mytitle {
    color: #4caf50;
    font-weight: normal;
    border-style: dotted;
    padding: 6px;
}
</style>

<div class="wrap" style="background-color: #F1F1F1;">
    <h2><i class="dashicons dashicons-calendar-alt"></i> RC-Settings</h2>
    <div class="container">
        <div class="row">
             <div class="col-md-6">
                <div class="card" style="min-width: 100%;">
                    <div class="card-body">
                        <form action="#">
                             <p id="event_disabled_message" style="display: none;"><small></small></p>
                            <div class="row mb-1">

                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm" id="rc_title" name="rc_title" placeholder="(ie: RXDRFEFGDD)" required></div>
                               
                                <div class="col-md-4">
                                 
                            <input type="submit" value="Search" class="btn btn-primary btn-sm btn-block search_rc_code_event">
                                </div>
                            </div>
                            
                           
                        </form>
                    </div>
                </div>
            </div>
           
        </div>
    
        
    </div>

    <div class="container" style="display: none;" id="formContainer">
        
         <div class="row">
            <div class="col-md-6">
                 <div class="card" style="min-width: 100%;">
                    <div class="card-body">
                        <h6>Settings for RC code <i class="mytitle"></i></h6>
                        <form action="#" >
                             <p id="event_disabled_message1" style="display: none;"><small></small></p>
                            <div class="row">


                               
                            
                                <div class="col-md-12">
                                    <label>Expiry Date  </label>
                                    <input type="text" class="form-control form-control-sm " id="expire_date" name="date" placeholder="Select a date" value="" required=""><BR>
                                    <label>Email Notification   </label>
                                    <select name="email_noti" id="email_noti" class="form-control form-control-sm">
                                        <option value="on">On</option>
                                        <option value="off">Off</option>
                                    </select>
                                    <BR>
                                    <label>RC Status</label>
                                    <select name="change_rc_status" id="rc_status" class="form-control form-control-sm">
                                        <option value="yes">Redeemed</option>
                                        <option value="no">Not Redeemed</option>
                                    </select>
                                      <BR>
                                </div>

                                <input type="hidden" name="crr_order_id" id="crr_order_id" value="">
                                <input type="submit" value="Update Changes" class="btn btn-primary btn-sm btn-block update_changes">
                            </div>
                            
                           
                        </form>
                    </div>
                </div>



             
            </div>
            
        </div>

    </div>
</div>