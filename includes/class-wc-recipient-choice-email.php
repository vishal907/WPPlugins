<?php


class WC_Recipient_Choice_Email extends WC_Email {

    protected $iof_rc_details = array();

    public function __construct() {
        // set ID, this simply needs to be a unique name
        $this->id = 'wc_recipient_choice';

        // this is the title in WooCommerce Email settings
        $this->title = 'Recipient Choice';

        // this is the description in WooCommerce email settings
        $this->description = 'Recipient Choice Notification emails are sent when a customer places an order with a recipient choice';

        // these are the default heading and subject lines that can be overridden using the settings
        $this->heading = 'Recipient Choice';
        $this->subject = "Instead of Flowers: You've Received a Recipient Choice from {order_first_name} {order_last_name}!";

        // these define the locations of the templates that this email should use, we'll just use the new order template since this email is similar
        $this->template_html  = 'emails/customer-recipient-choice.php';
        $this->template_plain = 'emails/plain/customer-recipient-choice.php';


       // Trigger on new paid orders
        add_action( 'woocommerce_order_status_pending_to_processing_notification', array( $this, 'trigger' ), 10, 2 );
        add_action( 'woocommerce_order_status_failed_to_processing_notification', array( $this, 'trigger' ), 10, 2 );

        // Call parent constructor to load any other defaults not explicity defined here
        parent::__construct();

        // if none was entered, just use the WP admin email as a fallback
        $this->recipient = get_option( 'admin_email' );
    }

    /**
     * Determine if the email should actually be sent and setup email merge variables
     *
     * @since 0.1
     * @param int $order_id
     */
    public function trigger( $order_id, $order = false ) {

        // bail if no order ID is present
        if ( ! $order_id )
            return;

        // setup order object
        $this->object = wc_get_order( $order_id );

        // bail if order does not contain recipient choice.
        if ( ! $this->has_recipient_choice($order_id) ) {
            return;
        }

        // replace variables in the subject/headings
        $this->placeholders['{order_first_name}'] = $this->object->get_billing_first_name();

        $this->placeholders['{order_last_name}'] = $this->object->get_billing_last_name();

        $this->recipient = $this->object->shipping_email;

        $this->iof_rc_details = $this->get_order_details($order_id);

        if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
            return;
        }

		
        // woohoo, send the email!
        $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
    }

    /**
     * Check if order is a recipient choice.
     *
     * @param $order_id
     *
     * @return bool
     */
    private function has_recipient_choice($order_id) {
        $order = wc_get_order( $order_id );
        $items = $order->get_items();
        foreach($items as $item) {
            $product_id = $item['product_id'];
            if(has_term('recipients-choice', 'product_cat', $product_id)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get recipient choices details for email.
     *
     * @param $order_id
     *
     * @return array
     */
    private function get_order_details($order_id) {
        $order = wc_get_order( $order_id );
        $items = $order->get_items();

        $count = 0;
        $coupon = get_post_meta( $order_id,'_iof_recipient_choice',true ); 
        $note = $order->get_customer_note();
        $note_card_message = get_post_meta( $order_id,'_shipping_note_card_message',true );
        $iof_rc_expire = get_post_meta( $order_id,'_iof_rc_expire',true );
        $recipient_choices = array();

        foreach($items as $item) {
            $product_id = $item['product_id'];
            if(has_term('recipients-choice', 'product_cat', $product_id)) {
                $count++;
                $product_id = ( isset($item['variation_id']) && !empty($item['variation_id']) ) ? $item['variation_id'] : $item['product_id'];
                $product = wc_get_product($product_id);
                $recipient_choices[] = $product->get_name();
            }
        }

        return array(
            'total' => $count,
            'coupon' => $coupon,
            'note' => $note,
            'note_card_message' => $note_card_message,
             'recipient_choices' => $recipient_choices,
            'iof_rc_expire' => date('F j, Y', strtotime($iof_rc_expire))
        );
    }

    /**
     * get_content_html function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_html() {
        ob_start();
        wc_get_template( $this->template_html, array(
            'order'         => $this->object,
            'email_heading' => $this->get_heading(),
            'rc_details' => $this->iof_rc_details
        ) );
        return ob_get_clean();
    }


    /**
     * get_content_plain function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_plain() {
        ob_start();
        wc_get_template( $this->template_plain, array(
            'order'         => $this->object,
            'email_heading' => $this->get_heading(),
            'rc_details' => $this->iof_rc_details
        ) );
        return ob_get_clean();
    }

    /**
     * Initialize Settings Form Fields
     *
     * @since 0.1
     */
    public function init_form_fields() {

        $this->form_fields = array(
            'enabled'    => array(
                'title'   => 'Enable/Disable',
                'type'    => 'checkbox',
                'label'   => 'Enable this email notification',
                'default' => 'yes'
            ),
            'subject'    => array(
                'title'       => 'Subject',
                'type'        => 'text',
                'description' => sprintf( 'This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', $this->subject ),
                'placeholder' => '',
                'default'     => ''
            ),
            'heading'    => array(
                'title'       => 'Email Heading',
                'type'        => 'text',
                'description' => sprintf( __( 'This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.' ), $this->heading ),
                'placeholder' => '',
                'default'     => ''
            ),
            'email_type' => array(
                'title'       => 'Email type',
                'type'        => 'select',
                'description' => 'Choose which format of email to send.',
                'default'     => 'html',
                'class'       => 'email_type',
                'options'     => array(
                    'html'      => 'HTML',
                )
            )
        );
    }
}