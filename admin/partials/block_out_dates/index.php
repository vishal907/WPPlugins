<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.7/popper.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
    $(document).ready(function() {
        $('input[name=courier_next_day]').datetimepicker({
            format: 'hh:mm A',
            defaultDate: moment().hours(<?= isset($cut_off_times['courier']['hour']) ? $cut_off_times['courier']['hour'] : 0 ?>)
                .minutes(<?= isset($cut_off_times['courier']['minute']) ? $cut_off_times['courier']['minute'] : 0 ?>)
        });

        $('input[name=outsourced_next_day]').datetimepicker({
            format: 'hh:mm A',
            defaultDate: moment().hours(<?= isset($cut_off_times['outsourced']['hour']) ? $cut_off_times['outsourced']['hour'] : 0 ?>)
                .minutes(<?= isset($cut_off_times['outsourced']['minute']) ? $cut_off_times['outsourced']['minute'] : 0 ?>)
        });

        $('input[name=date]').datetimepicker({
            format: 'DD-MM-YYYY',
            defaultDate: 'now',
            minDate: 'now'
        });

        $('input[name=event_date]').datetimepicker({
            format: 'DD-MM',
            defaultDate: 'now'
        });

        $('input.add_special_date').on('click', function(e) {
            e.preventDefault();
            var date = $('input[name=date]').val();
            var type = $('select[name=date_type]').val();
            $.post(
                ajaxurl,
                {
                    "action": "add_special_date_block_out",
                    "date": date,
                    "type": type
                }
            )
                .done(function(data) {
                    $('p#date_disabled_message').slideUp();
                    display_message(data.success, false, 'date_disabled_message');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                })
                .fail(function(data) {
                    $('p#date_disabled_message').slideUp();
                    var response = data.responseText;
                    response = $.parseJSON(response);
                    if(response) {
                        display_message(response.error, true, 'date_disabled_message');
                    } else {
                        display_message('Unexpected error occurred.', true, 'date_disabled_message');
                    }
                });
        });

        $('button.save_week_days_disabled').on('click', function(e) {
            e.preventDefault();
            var courier_week_disabled = [];
            var outsourced_week_disabled = [];
            $.each( $("input[name='courier_week_disabled[]']:checked"), function() {
                courier_week_disabled.push($(this).val());
            });
            $.each( $("input[name='outsourced_week_disabled[]']:checked"), function() {
                outsourced_week_disabled.push($(this).val());
            });

            $.post(
                ajaxurl,
                {
                    "action": "save_week_days_disabled",
                    "courier_week_days": courier_week_disabled,
                    "outsourced_week_days": outsourced_week_disabled
                }
            )
                .done(function(data) {
                    $('p#week_days_disabled_message').slideUp();
                    display_message(data.success, false, 'week_days_disabled_message');
                })
                .fail(function(data) {
                    $('p#week_days_disabled_message').slideUp();
                    var response = data.responseText;
                    response = $.parseJSON(response);
                    if(response) {
                        display_message(response.error, true, 'week_days_disabled_message');
                    } else {
                        display_message('Unexpected error occurred.', true, 'week_days_disabled_message');
                    }
                });
        });

        $('button.save_next_day_cut').on('click', function(e) {
            e.preventDefault();
            var courier_cut = $('input[name=courier_next_day]').val();
            var outsourced_cut = $('input[name=outsourced_next_day]').val();
            $.post(
                ajaxurl,
                {
                    "action": "save_next_day_cut_off",
                    "courier_cut_off": courier_cut,
                    "outsourced_cut_off": outsourced_cut
                }
            )
                .done(function(data) {
                    $('p#cut_off_message').slideUp();
                    display_message(data.success, false, 'cut_off_message');
                })
                .fail(function(data) {
                    $('p#cut_off_message').slideUp();
                    var response = data.responseText;
                    response = $.parseJSON(response);
                    if(response) {
                        display_message(response.error, true, 'cut_off_message');
                    } else {
                        display_message('Unexpected error occurred.', true, 'cut_off_message');
                    }
                });
        });

        $('input.add_special_event').on('click', function(e) {
            e.preventDefault();
            var event_name = $('input[name=event_title]').val();
            var event_date = $('input[name=event_date]').val();
            var type = $('select[name=event_type]').val();
            $.post(
                ajaxurl,
                {
                    "action": "add_special_event_block_out",
                    "event_name": event_name,
                    "event_date": event_date,
                    "event_type": type
                }
            )
                .done(function(data) {
                    $('p#event_disabled_message').slideUp();
                    display_message(data.success, false, 'event_disabled_message');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
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

        $('span.remove_date_disabled').on('click', function() {
            var el = $(this);
            var id = el.data('id');
            if(confirm('Do you want to remove this date?')) {
                $.post(
                    ajaxurl,
                    {
                        "action": "remove_date_from_disabled",
                        "id": id
                    }
                )
                    .done(function (data) {
                        el.parent().parent().remove();
                        alert(data.success);
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
            }
        });

        $('span.remove_event_disabled').on('click', function() {
            var el = $(this);
            var id = el.data('id');
            if(confirm('Do you want to remove this event?')) {
                $.post(
                    ajaxurl,
                    {
                        "action": "remove_event_from_disabled",
                        "id": id
                    }
                )
                    .done(function (data) {
                        el.parent().parent().remove();
                        alert(data.success);
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
            }
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
</style>

<div class="wrap" style="background-color: #F1F1F1;">
    <h2><i class="dashicons dashicons-calendar-alt"></i> Block-Out Dates</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>
                                    <small><span class="dashicons dashicons-clock"></span> <strong>Courier</strong> Next Day Cut-off Time</small>
                                </label>
                                <input type="text" name="courier_next_day" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label>
                                    <small><span class="dashicons dashicons-clock"></span> <strong>FedEx</strong> Next Day Cut-off Time</small>
                                </label>
                                <input type="text" name="outsourced_next_day" class="form-control form-control-sm">
                            </div>
                            <p id="cut_off_message" style="display: none;"><small></small></p>
                            <button type="submit" class="btn btn-primary btn-sm save_next_day_cut">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card" style="min-width: 100%;">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class=""><small><span class="dashicons dashicons-calendar-alt"></span><strong>Courier</strong> Disabled Week Days :</small></label>
                                <form class="form-inline">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="courier_week_disabled[]" type="checkbox" value="0"
                                                    <?php if(isset($week_days_disabled['courier']) && in_array(0, $week_days_disabled['courier'])) { echo 'checked'; } ?> > Sun
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="courier_week_disabled[]" type="checkbox" value="1"
                                                    <?php if(isset($week_days_disabled['courier']) && in_array(1, $week_days_disabled['courier'])) { echo 'checked'; } ?>> Mon
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="courier_week_disabled[]" type="checkbox" value="2"
                                                    <?php if(isset($week_days_disabled['courier']) && in_array(2, $week_days_disabled['courier'])) { echo 'checked'; }
                                                    ?>> Tue
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="courier_week_disabled[]" type="checkbox" value="3"
                                                    <?php if(isset($week_days_disabled['courier']) && in_array(3, $week_days_disabled['courier'])) { echo 'checked'; }
                                                    ?>> Wed
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="courier_week_disabled[]" type="checkbox" value="4"
                                                    <?php if(isset($week_days_disabled['courier']) && in_array(4, $week_days_disabled['courier'])) { echo 'checked'; }
                                                    ?>> Thu
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="courier_week_disabled[]" type="checkbox" value="5"
                                                    <?php if(isset($week_days_disabled['courier']) && in_array(5, $week_days_disabled['courier'])) { echo 'checked'; }
                                                    ?>> Fri
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="courier_week_disabled[]" type="checkbox" value="6"
                                                    <?php if(isset($week_days_disabled['courier']) && in_array(6, $week_days_disabled['courier'])) { echo 'checked'; }
                                                    ?>> Sat
                                            </small>
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class=""><small><span class="dashicons dashicons-calendar-alt"></span> <strong>FedEx</strong> Disabled Week Days :</small></label>
                                <form class="form-inline">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="outsourced_week_disabled[]" type="checkbox" value="0"
                                                    <?php if(isset($week_days_disabled['outsourced']) && in_array(0, $week_days_disabled['outsourced'])) { echo 'checked'; }
                                                    ?>> Sun
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="outsourced_week_disabled[]" type="checkbox" value="1"
                                                    <?php if(isset($week_days_disabled['outsourced']) && in_array(1, $week_days_disabled['outsourced'])) { echo 'checked'; }
                                                    ?>> Mon
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="outsourced_week_disabled[]" type="checkbox" value="2"
                                                    <?php if(isset($week_days_disabled['outsourced']) && in_array(2, $week_days_disabled['outsourced'])) { echo 'checked'; }
                                                    ?>> Tue
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="outsourced_week_disabled[]" type="checkbox" value="3"
                                                    <?php if(isset($week_days_disabled['outsourced']) && in_array(3, $week_days_disabled['outsourced'])) { echo 'checked'; }
                                                    ?>> Wed
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="outsourced_week_disabled[]" type="checkbox" value="4"
                                                    <?php if(isset($week_days_disabled['outsourced']) && in_array(4, $week_days_disabled['outsourced'])) { echo 'checked'; }
                                                    ?>> Thu
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="outsourced_week_disabled[]" type="checkbox" value="5"
                                                    <?php if(isset($week_days_disabled['outsourced']) && in_array(5, $week_days_disabled['outsourced'])) { echo 'checked'; }
                                                    ?>> Fri
                                            </small>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <small>
                                                <input class="form-check-input" name="outsourced_week_disabled[]" type="checkbox" value="6"
                                                    <?php if(isset($week_days_disabled['outsourced']) && in_array(6, $week_days_disabled['outsourced'])) { echo 'checked'; }
                                                    ?>> Sat
                                            </small>
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p id="week_days_disabled_message" style="display: none;"><small></small></p>
                                <button type="submit" class="btn btn-primary btn-sm save_week_days_disabled">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card" style="min-width: 100%;">
                    <div class="card-body">
                        <label>Add One-Time Block:</label>
                        <form action="#">
                            <div class="row mb-1">
                                <div class="col-md-8"><input type="text" class="form-control form-control-sm " name="date" placeholder="Select a date" required></div>
                                <div class="col-md-4">
                                    <select name="date_type" class="form-control form-control-sm">
                                        <option value="all">All</option>
                                        <option value="courier">Courier</option>
                                        <option value="outsourced">FedEx</option>
                                    </select>
                                </div>
                            </div>
                            <p id="date_disabled_message" style="display: none;"><small></small></p>
                            <input type="submit" value="Block Delivery." class="btn btn-primary btn-sm btn-block add_special_date">
                            <p><i class="fa fa-info-circle"></i> This date will not be repeated and will be blocked for delivery once.</p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="min-width: 100%;">
                    <div class="card-body">
                        <label>Add Yearly Event:</label>
                        <form action="#">
                            <div class="row mb-1">
                                <div class="col-md-5"><input type="text" class="form-control form-control-sm" name="event_title" placeholder="Name (ie: Christmas)"
                                                             required></div>
                                <div class="col-md-3"><input type="text" class="form-control form-control-sm" name="event_date" placeholder="Select month and day"
                                                             required></div>
                                <div class="col-md-4">
                                    <select name="event_type" class="form-control form-control-sm">
                                        <option value="all">All</option>
                                        <option value="courier">Courier</option>
                                        <option value="outsourced">FedEx</option>
                                    </select>
                                </div>
                            </div>
                            <p id="event_disabled_message" style="display: none;"><small></small></p>
                            <input type="submit" value="Block Delivery" class="btn btn-primary btn-sm btn-block add_special_event">
                            <p><i class="fa fa-info-circle"></i> This day and month combination will be blocked for delivery every year.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h5>List of One-Time Blocks:</h5>
                <ul class="list-group disabled_dates_list">
                    <?php $i = 0; foreach($blocked_dates as $date) { $i++; ?>
                        <li class="list-group-item">
                            <small>
                                <?= $date->date ?>
                                <?php if($date->type != 'all') { ?>
                                    <span class="badge badge-warning"><?= $date->type ?></span>
                                <?php } ?>
                                <span class="pull-right text-danger remove_date_disabled" style="cursor: pointer;" data-id="<?= $i ?>"><i class="fa fa-trash"></i></span>
                            </small>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h5>List of Yearly Events:</h5>
                <ul class="list-group">
                    <?php $j = 0; foreach($blocked_events as $event) { $j++; ?>
                        <li class="list-group-item">
                            <small>
                                <?= $event->title ?> <span class="text-muted"><em>( <?= date('M d', strtotime($event->date.'-'.date('Y'))) ?> )</em></span>
                                <?php if($event->type != 'all') { ?>
                                    <span class="badge badge-warning"><?= $event->type ?></span>
                                <?php } ?>
                                <span class="pull-right text-danger remove_event_disabled" style="cursor: pointer;" data-id="<?= $j ?>"><i class="fa fa-trash"></i></span>
                            </small>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>