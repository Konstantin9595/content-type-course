<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://localhost
 * @since      1.0.0
 *
 * @package    Ktn_courses
 * @subpackage Ktn_courses/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ktn_courses
 * @subpackage Ktn_courses/admin
 * @author     Konstantin <konstantins9595@gmail.com>
 */
class Ktn_courses_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ktn_courses_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ktn_courses_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ktn_courses-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ktn_courses_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ktn_courses_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ktn_courses-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function admin_courses_type() {
		register_post_type('courses', array(
			'label'  => null,
			'labels' => array(
				'name'               => 'Курсы', // основное название для типа записи
				'singular_name'      => 'courses', // название для одной записи этого типа
				'add_new'            => 'Добавить курс', // для добавления новой записи
				'add_new_item'       => 'Добавление курса', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактирование курса', // для редактирования типа записи
				'new_item'           => 'Новое ____', // текст новой записи
				'view_item'          => 'Смотреть ____', // для просмотра записи этого типа.
				'search_items'       => 'Искать ____', // для поиска по этим типам записи
				'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				// 'menu_name'          => '____', // название меню
			),
			'description'         => '',
			'public'              => true,
			// 'publicly_queryable'  => null, // зависит от public
			// 'exclude_from_search' => null, // зависит от public
			'show_ui'             => true, // зависит от public
			// 'show_in_nav_menus'   => null, // зависит от public
			'show_in_menu'        => true, // показывать ли в меню адмнки
			// 'show_in_admin_bar'   => null, // зависит от show_in_menu
			'show_in_rest'        => true, // добавить в REST API. C WP 4.7
			'rest_base'           => 'courses', // $post_type. C WP 4.7
			'menu_position'       => 25,
			'menu_icon'           => null, 
			//'capability_type'   => 'post',
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'        => false,
			'supports'            => [ 'title', 'editor' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => ['courses_category', 'courses_selection', 'job_listing_category'],
			'has_archive'         => true,
			'rewrite'             => true,
			'query_var'           => true,
		) );
	}

}
