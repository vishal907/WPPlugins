<?php


class Iof_Utilities_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

    /**
     * The array of meta boxes registered with WordPress.
     * @since    1.0.0
     * @access   protected
     * @var array $meta_boxes   All custom meta boxes used by the plugin.
     */
	protected $meta_boxes;

    /**
     * The array of short_codes registered with WordPress.
     *
     * @since    1.1.0
     * @access   protected
     * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
     */
    protected $short_codes;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();
		$this->meta_boxes = array();
        $this->short_codes = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

    /**
     * Add a new meta box to the collection.
     *
     * @since    1.0.0
     * @param string    $id
     * @param object    $component
     * @param string    $callback
     * @param string    $screen
     * @param string    $context
     * @param string    $priority
     * @param string    $title
     */
	public function add_meta_box($id, $component, $callback, $screen, $context, $priority, $title) {
        $tmp = array(
            'id' => $id,
            'title' => $title,
            'callback' => array( $component, $callback),
            'screen' => $screen,
            'context' => $context,
            'priority' => $priority
        );

        $this->meta_boxes[] = $tmp;
    }

    /**
     * Add a new shortcode to the collection to be registered with WordPress.
     *
     * @since    1.1.0
     * @param    string               $name             The name of the WordPress shortcode that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the shortcode is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     */
    public function add_shortcode($name, $component, $callback) {
        $this->short_codes[] = array(
            'name' => $name,
            'component' => $component,
            'callback' => $callback
        );
    }

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	public function add_all_meta_boxes() {
        foreach ($this->meta_boxes as $hook) {
            add_meta_box($hook['id'], $hook['title'], $hook['callback'], $hook['screen'], $hook['context'], $hook['priority'], null);
            //remove_meta_box( $hook['id'], $hook['screen'], $hook['context'] );
        }
    }

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

        foreach ($this->short_codes as $short_code) {
            add_shortcode($short_code['name'], array($short_code['component'], $short_code['callback']));
        }

		add_action('add_meta_boxes', array($this, 'add_all_meta_boxes'), 30);

	}

}
