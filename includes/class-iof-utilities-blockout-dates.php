<?php


class Iof_Utilities_Blockout_Dates {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */

    public static $default_blocked_events = array(
        array(
            'title' => 'Christmas Day',
            'date' => '25-12',
            'type' => 'all'
        ),
        array(
            'title' => 'New Year Day',
            'date' => '01-01',
            'type' => 'all'
        ),
        array(
            'title' => 'Thanksgiving Day',
            'date' => '23-11',
            'type' => 'all'
        ),
        array(
            'title' => 'Labor Day',
            'date' => '04-09',
            'type' => 'all'
        ),
        array(
            'title' => 'Independence Day',
            'date' => '04-07',
            'type' => 'all'
        ),
        array(
            'title' => 'Independence Day Observed',
            'date' => '05-07',
            'type' => 'all'
        ),
        array(
            'title' => 'Memorial Day',
            'date' => '30-05',
            'type' => 'all'
        ),
        array(
            'title' => 'New Year Day Observed',
            'date' => '02-01',
            'type' => 'outsourced'
        ),
        array(
            'title' => 'Memorial Day Observed',
            'date' => '30-05',
            'type' => 'outsourced'
        ),
        array(
            'title' => 'Independence Day Observed',
            'date' => '06-07',
            'type' => 'outsourced'
        ),
        array(
            'title' => 'Labor Day Observed',
            'date' => '05-09',
            'type' => 'outsourced'
        ),
        array(
            'title' => 'Thanksgiving Day Observed',
            'date' => '24-11',
            'type' => 'outsourced'
        ),
        array(
            'title' => 'Christmas Day Observed',
            'date' => '26-12',
            'type' => 'outsourced'
        )
    );
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function add_block_out_menu() {
        add_menu_page('Block Out Dates', 'Block Out Dates', 'read', 'block-out-dates', array($this, 'display_block_out_dates'), 'dashicons-calendar-alt', 7);
    }

    public function display_block_out_dates() {
        $blocked_dates = self::get_all_blocked_dates();
        $blocked_events = self::get_all_blocked_events();
        $cut_off_times = self::get_all_cut_off_times();
        $week_days_disabled = self::get_week_days_disabled();
        
        usort($blocked_dates, function($a, $b) {
            $date_a = $a->date;
            $date_b = $b->date;
            return strtotime($date_a) - strtotime($date_b);
        });

        usort($blocked_events, function($a, $b) {
            $date_a = $a->date.'-'.date('Y');
            $date_b = $b->date.'-'.date('Y');
            return strtotime($date_a) - strtotime($date_b);
        });
        ob_start();
        include __DIR__ . '/../admin/partials/block_out_dates/index.php';
        $result = ob_get_clean();
        echo $result;
    }

    public function add_specific_date() {
        if(isset($_POST['date']) && isset($_POST['type'])) {
            $date = sanitize_text_field($_POST['date']);
            $type = sanitize_text_field($_POST['type']);
            if(!empty($date) && !empty($type)) {
                if($blocked_days = get_option('iof_block_out_days', false)) {
                    $blocked_days = json_decode($blocked_days);
                    $blocked_days[] = array('date'=>$date, 'type' => $type);
                } else {
                    $blocked_days = array(array('date'=>$date, 'type' => $type));
                }
                update_option('iof_block_out_days', json_encode($blocked_days));
                return wp_send_json(array('success' => 'Date added successfully!'), 200);
            }
        }
        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }

    public function add_specific_event() {
        if(isset($_POST['event_name']) && isset($_POST['event_date']) && isset($_POST['event_type'])) {
            $event_name = $_POST['event_name'];
            $event_date = $_POST['event_date'];
            $event_type = $_POST['event_type'];
            if(!empty($event_name) && !empty($event_date) && !empty($event_type)) {
                if($blocked_events = get_option('iof_block_out_events', false)) {
                    $blocked_events = json_decode($blocked_events);
                    $blocked_events[] = array('title'=>$event_name, 'date' => $event_date, 'type'=>$event_type);
                } else {
                    $blocked_events = array(array('title'=>$event_name, 'date' => $event_date, 'type'=>$event_type));
                }
                update_option('iof_block_out_events', json_encode($blocked_events));
                return wp_send_json(array('success' => 'Event added successfully!'), 200);
            }
        }
        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }

    public function save_next_day_cut_off() {
        if(isset($_POST['courier_cut_off']) && isset($_POST['outsourced_cut_off'])) {
            $courier_cut_off = $_POST['courier_cut_off'];
            $outsourced_cut_off = $_POST['outsourced_cut_off'];
            if(!empty($courier_cut_off) && !empty($outsourced_cut_off)) {
                $cut_off = array('courier_cut_off'=>$courier_cut_off, 'outsourced_cut_off'=>$outsourced_cut_off);
                update_option('iof_cut_off_times', json_encode($cut_off));
                return wp_send_json(array('success' => 'All cut-off times stored!'), 200);
            }
        }
        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }

    public function save_week_days_disabled() {
        if(isset($_POST['courier_week_days']) || isset($_POST['outsourced_week_days'])) {
            $courier_week_days = isset($_POST['courier_week_days']) ? $_POST['courier_week_days'] : array();
            $outsourced_week_days = isset($_POST['outsourced_week_days']) ? $_POST['outsourced_week_days'] : array();
            $week_days_disabled = array(
                'courier' => $courier_week_days,
                'outsourced' => $outsourced_week_days
            );

            update_option('iof_week_days_disabled', json_encode($week_days_disabled));
            return wp_send_json(array('success' => 'Week Days stored successfully!'), 200);
        }
        return wp_send_json(array('error' => 'Bad Request Format!'), 422);
    }

    public function remove_date_from_disabled() {
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
            if(is_numeric($id)) {
                $disabled_dates = self::get_all_blocked_dates();
                $index = $id - 1;
                if( isset($disabled_dates[$index]) ) {
                    unset($disabled_dates[$index]);
                    $disabled_dates = array_values($disabled_dates);
                    update_option('iof_block_out_days', json_encode($disabled_dates));
                    return wp_send_json(array('success' => 'Date removed from list!'), 200);
                }
            }
        }
        return wp_send_json(array('error' => 'Something went wrong!'), 422);
    }

    public function remove_event_from_disabled() {
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
            if(is_numeric($id)) {
                $disabled_events = self::get_all_blocked_events();
                $index = $id - 1;
                if( isset($disabled_events[$index]) ) {
                    unset($disabled_events[$index]);
                    $disabled_events = array_values($disabled_events);
                    update_option('iof_block_out_events', json_encode($disabled_events));
                    return wp_send_json(array('success' => 'Event removed from list!'), 200);
                }
            }
        }
        return wp_send_json(array('error' => 'Something went wrong!'), 422);
    }

    public static function get_week_days_disabled() {
        $result = array();
        if($week_days_disabled = get_option('iof_week_days_disabled', false)) {
            $result = json_decode($week_days_disabled, true);
        }

        return $result;
    }

    public static function get_days_disabled($method = 'courier') {
        $result = array();
        if($week_days_disabled = get_option('iof_week_days_disabled', false)) {
            $tmp = json_decode($week_days_disabled, true);
            $result = isset($tmp[$method]) ? $tmp[$method] : array();
        }

        return $result;
    }

    public static function get_all_cut_off_times() {
        $result = array();
        if($cut_off_times = get_option('iof_cut_off_times', false)) {
            $tmp = json_decode($cut_off_times);
            $courier = $tmp->courier_cut_off;
            $outsourced = $tmp->outsourced_cut_off;
            $result['courier'] = self::get_time($courier);
            $result['outsourced'] = self::get_time($outsourced);
        }
        return $result;
    }

    private static function get_time($time_string) {
        $time_part = explode(' ',$time_string);
        $hour = 0;
        $minute = 0;
        if(count($time_part) == 2) {
            $section = $time_part[1];
            $time = $time_part[0];
            $hour_part = explode(':', $time);
            if(count($hour_part) == 2) {
                $hour = (int) $hour_part[0];
                $minute = (int) $hour_part[1];
            }
            if($section == 'PM') {
                $hour += 12;
            }
        }

        return array(
            'hour' => $hour,
            'minute' => $minute
        );
    }

    public static function get_all_blocked_dates() {
        $result = array();
        if($blocked_days = get_option('iof_block_out_days', false)) {
            $result = json_decode($blocked_days);
        }
        return $result;
    }

    public static function get_all_blocked_events() {
        $result = array();
        if($blocked_events = get_option('iof_block_out_events', false)) {
            $result = json_decode($blocked_events);
        }
        return $result;
    }

    public static function get_blocked_dates($method = 'courier') {
        $dates = array();
        if($blocked_days = get_option('iof_block_out_days', false)) {
            $blocked_days = json_decode($blocked_days);
            foreach ($blocked_days as $day) {
                if($day->type == $method || $day->type == 'all') {
                    $tmp = $day->date;
                    $tmp = date('Y-m-d', strtotime($tmp));
                    $dates[] = $tmp;
                }
            }
        }

        $cut_off_arr = self::get_all_cut_off_times();
        $zone_cut_off = $cut_off_arr[$method];
        date_default_timezone_set('America/New_York');
        $current_time = date('H:i');
        $cut_off_time = $zone_cut_off['hour'].':'.$zone_cut_off['minute'];
        if(strtotime($current_time) >= strtotime($cut_off_time)) {
            $dates[] = date("Y-m-d", strtotime('tomorrow'));
        }

        if($blocked_events = get_option('iof_block_out_events', false)) {
            $blocked_events = json_decode($blocked_events);
            foreach($blocked_events as $event) {
                if($event->type == $method || $event->type == 'all') {
                    $next_year = date('Y', strtotime('+1 year'));
                    $current_year = date('Y');
                    $tmp_current = $event->date . '-' . $current_year;
                    $tmp_next = $event->date . '-' . $next_year;
                    $tmp_current = date('Y-m-d', strtotime($tmp_current));
                    $tmp_next = date('Y-m-d', strtotime($tmp_next));
                    $dates[] = $tmp_current;
                    $dates[] = $tmp_next;
                }
            }
        }

        return $dates;
    }

	/**
	 * Gets the block out dates (and pre-selected dates) for a 4 week time span per item on cart page.
	 *
	 * @param array $selected_dates     The dates selected on the cart page.
	 * @param array $blocked_holidays   The block-out holidays, as dates.
	 * @param array $blocked_weekends   The block-out weekend dates, as integers.
	 * @param bool $include_selected    Whether to include the dates already selected as block-out dates.
	 *
	 * @return array                    Block out dates, one array per cart item.
	 */
    public static function get_four_weeks_block_out_dates( $selected_dates, $blocked_holidays, $blocked_weekends, $include_selected = true ) {
	    date_default_timezone_set( 'America/New_York' );
	    $all_blocked_dates = array();
	    $max_date          = date( 'Y-m-d', strtotime( '+4 week' ) );
	    $min_date          = date( 'Y-m-d' );

	    foreach ( $selected_dates as $key => $_selected_dates ) {

		    foreach ( $_selected_dates as $index => $selected_date ) {
		    	$_selected_dates[ $index ] = date( 'Y-m-d', strtotime( $selected_date ) );
		    }

			if ( $include_selected ) {
				$all_blocked_dates[ $key ] = $_selected_dates;
			}

		    foreach ( $blocked_weekends as $date_int ) {

			    for ( $i = 0; $i <= 4; $i ++ ) {
				    $date_int     = ( $i == 0 ) ? $date_int : $date_int + 7;
				    $blocked_date = date( 'Y-m-d', strtotime( "last Sunday +{$date_int} days" ) );

				    if ( strtotime( $blocked_date ) >= strtotime( $min_date ) && strtotime( $blocked_date ) <= strtotime( $max_date ) ) {
					    $all_blocked_dates[ $key ][] = $blocked_date;
				    }
			    }
		    }

		    foreach ( $blocked_holidays as $blocked_date ) {

			    if ( strtotime( $blocked_date ) >= strtotime( $min_date ) && strtotime( $blocked_date ) <= strtotime( $max_date ) ) {
				    $all_blocked_dates[ $key ][] = $blocked_date;
			    }
		    }

		    $all_blocked_dates[ $key ] = array_unique( $all_blocked_dates[ $key ] );
		    sort( $all_blocked_dates[ $key ] );
	    }

	    return $all_blocked_dates;
    }
}
