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

	// (
	// 	[term_id] => 212
	// 	[name] => Онлайн школы
	// 	[slug] => onlajn-shkoly
	// 	[term_group] => 0
	// 	[term_taxonomy_id] => 212
	// 	[taxonomy] => job_listing_category
	// 	[description] => 
	// 	[parent] => 390
	// 	[count] => 8
	// 	[filter] => raw
	// 	[term_type] => 0
	// 	[term_font_icon] => 0
	// )

	public function ktn_admin_metabox_job_listing() {
		add_meta_box( 'ktn_courses', 'Принадлежность к онлайн-школе', function($post) {
			$relatedItems = get_posts( array(
				'post_type' => 'job_listing',
				'tax_query' => array(
					array(
						'taxonomy' => 'job_listing_category',
						// 'field'    => 'slug',
						'terms'    => 212
					)
				)
			));
			// echo "<pre>";
			// 	print_r($relatedItems);
			// echo "</pre>";
			if( $relatedItems ){
				// чтобы портянка пряталась под скролл...
				echo '
				<div style="max-height:200px; overflow-y:auto;">
					<ul>
				';
		
				foreach( $relatedItems as $item ){
					echo '
					<li><label>
						<input type="radio" name="post_parent" value="'. $item->ID .'" '. checked($item->ID, $post->post_parent, 0) .'> '. esc_html($item->post_title) .'
					</label></li>
					';
				}
		
				echo '
					</ul>
				</div>';
			}
			else
				echo 'Пусто...';
		}, 'courses', 'side', 'low'  );
	}

	public function ktn_admin_acf_init() {
		add_filter( "acf/prepare_field/name=date_and_time_start_coruse", function($field) {

			$value = $field['value'];
			if($value) {

				
			}else {
				// echo "Поле НЕ заполненно";
			}

			return $field;
		});

		add_filter( "acf/prepare_field/name=ktn_field_modification", function($field) {
			// Поле которое нужно будет модифицировать для подгрузки связанных 
			// c категориями характеристик.
			return $field;
		});

		// add_filter("acf/fields/taxonomy/result", function( $title, $term, $field, $post_id ) {
		// 	echo "<pre>";
		// 		print($field);
		// 	echo "</pre>";
		// });


	}

	public function test() {
		$currentScreen = get_current_screen();
		// $fields = get_fields("category_426");

		if($currentScreen->id === 'edit-courses_category') {
			// the_field( 'tax_extend_selections');
			// $tax = get_taxonomies([
			// 	'name' => 'courses_category'
			// ]);
			// echo "<pre>";
			// 	print_r($tax );
			// echo "</pre>";
		}
	}

	// Модификация страницы создания таксаномии
	// public function ktn_add_tax_fields() {
	// 	// [name] => courses_category
	// 	// // $fields = get_fields("category_426");
	// 	// Взять все поля которые есть у Категории курсов
	// 	$relatedItems = get_fields('category_426');

	// 	// echo "<pre>";
	// 	// 	print_r($relatedItems);
	// 	// echo "</pre>";
	// 	// 	echo 
	// 	// 	"<div class='related-attrs' style='margin: 10px 0;'>
	// 	// 		<h3>Унаследованные от категории характеристики:</h3>
	// 	// 	<div>
	// 	// 		<label style='display: inline-block;' for='scales'>Scales: </label>
	// 	// 		<input type='checkbox' id='scales' name='scales'>
	// 	// 	</div>
	// 	//   </div>";
	// }
// Модификация страницы редактирования таксаномии
	// public function ktn_edit_tax_fields($term) {
	// 	// echo "<pre>";
	// 	// 	echo "EDIT!!";
	// 	// 	print_r($term);
	// 	// echo "</pre>";
	// }

	// public function ktn_edited_tax_fields($term_id, $tt_id) {
	// 	// after edited
	// }

	// public function ktn_save_tax_fields ($term_id, $tt_id) {
	// 	// after saved
	// }



	public function ktn_admin_add_acf_field_group() {
		if( function_exists('acf_add_local_field_group') ):
			// Доп поля для сущности "Курс"
			acf_add_local_field_group(array(
				'key' => 'group_5e4f5e6ab8497',
				'title' => 'Дополнительные поля',
				'fields' => array(
					array(
						'key' => 'field_5e4f5e78ffe28',
						'label' => 'Артикул',
						'name' => 'course_sku',
						'type' => 'text',
						'instructions' => 'Уникальный артикул курса',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5e4f5ecaffe29',
						'label' => 'Ценовой вариант курса',
						'name' => 'paid_or_free',
						'type' => 'select',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'payd' => 'Платный',
							'free' => 'Бесплатный',
						),
						'default_value' => array(
							0 => 'payd',
						),
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'return_format' => 'array',
						'ajax' => 0,
						'placeholder' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'courses',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'acf_after_title',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));

			// Характеристики для сущности "Курс"
			acf_add_local_field_group(array(
				'key' => 'group_5e4d0534d0de1',
				'title' => 'Характеристики для курсов',
				'fields' => array(
					array(
						'key' => 'field_5e4d46c06f11e',
						'label' => 'Дата и время начало курса (не обязательна к заполнению)',
						'name' => 'date_and_time_start_coruse_group',
						'type' => 'group',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'layout' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_5e4d46e46f11f',
								'label' => 'Дата и время',
								'name' => 'date_and_time_start_coruse',
								'type' => 'date_time_picker',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'display_format' => 'd/m/Y g:i',
								'return_format' => 'd/m/Y g:i',
								'first_day' => 1,
							),
							array(
								'key' => 'field_5e4d47ee13b96',
								'label' => 'Что делать когда дата неактивна',
								'name' => 'what_doing_if_data_not_active',
								'type' => 'group',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'layout' => 'block',
								'sub_fields' => array(
									array(
										'key' => 'field_5e4d482413b97',
										'label' => 'Выберите вариант (Обязательное поле. По умолчанию "Деактивировать")',
										'name' => 'what_doing_if_data_not_active_variation',
										'type' => 'radio',
										'instructions' => '',
										'required' => 1,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'choices' => array(
											'diactivate' => 'Деактивировать',
											'nothing' => 'Ничего',
											'move_date' => 'Перенести дату начала (при выборе откроется новое поле даты)',
										),
										'allow_null' => 0,
										'other_choice' => 0,
										'default_value' => 'diactivate',
										'layout' => 'vertical',
										'return_format' => 'value',
										'save_other_choice' => 0,
									),
									array(
										'key' => 'field_5e4d4cd93f832',
										'label' => 'На какую дату и время перенести?',
										'name' => 'what_move_time',
										'type' => 'date_time_picker',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => array(
											array(
												array(
													'field' => 'field_5e4d482413b97',
													'operator' => '==',
													'value' => 'move_date',
												),
											),
										),
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'display_format' => 'd/m/Y g:i',
										'return_format' => 'd/m/Y g:i',
										'first_day' => 1,
									),
								),
							),
						),
					),
					array(
						'key' => 'field_5e4d0e85cb8b7',
						'label' => 'Возможность указывать дополнительные характеристики',
						'name' => 'extends_characteristic',
						'type' => 'group',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'layout' => 'block',
						'sub_fields' => array(
							array(
								'key' => 'field_5e4d12b5af527',
								'label' => 'Строковый тип',
								'name' => 'strings_type',
								'type' => 'repeater',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'collapsed' => '',
								'min' => 0,
								'max' => 0,
								'layout' => 'block',
								'button_label' => '',
								'sub_fields' => array(
									array(
										'key' => 'field_5e4d130faf528',
										'label' => 'Название характеристики',
										'name' => 'name_strings_type_characteristic',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									),
									array(
										'key' => 'field_5e4d163d96fea',
										'label' => 'Значение характеристики',
										'name' => 'value_strings_type_characteristic',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									),
								),
							),
							array(
								'key' => 'field_5e4d134eaf529',
								'label' => 'Числовой тип',
								'name' => 'numbers_type',
								'type' => 'repeater',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'collapsed' => '',
								'min' => 0,
								'max' => 0,
								'layout' => 'block',
								'button_label' => '',
								'sub_fields' => array(
									array(
										'key' => 'field_5e4d1381af52a',
										'label' => 'Название характеристики',
										'name' => 'name_numbers_type_characteristic',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									),
									array(
										'key' => 'field_5e4d15f296fe9',
										'label' => 'Значение характеристики',
										'name' => 'value_numbers_type_characteristic',
										'type' => 'number',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'min' => '',
										'max' => '',
										'step' => '',
									),
								),
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'courses',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => 'Характеристики для курсов',
			));

			// Доп характеристики для категорий и выборок
			acf_add_local_field_group(array(
				'key' => 'group_5e4e20281ee76',
				'title' => 'Доп характеристики для "категорий" и "выборок"',
				'fields' => array(
					array(
						'key' => 'field_5e4e31c4fa614',
						'label' => 'Дополнительные характеристики',
						'name' => 'tax_extend_selections',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'table',
						'button_label' => 'Добавить характеристику',
						'sub_fields' => array(
							array(
								'key' => 'field_5e4e3336b94af',
								'label' => 'Название характеристики',
								'name' => 'tax_extend_selections_child_name',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'field_5e4e33e2d3367',
								'label' => 'Значение характеристики(строка/число)',
								'name' => 'tax_extend_selections_child_value',
								'type' => 'text',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'taxonomy',
							'operator' => '==',
							'value' => 'courses_category',
						),
					),
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'courses_selection',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));

			endif;
	}

	public function ktn_admin_courses_type() {
		$type = 'courses';

		register_post_type($type, array(
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
			'menu_icon'           => 'dashicons-admin-post', 
			//'capability_type'   => 'post',
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'        => true,
			// 'supports' => get_all_post_type_supports('courses'),
			'supports'            => array( 'title', 'editor', 'custom-fields', 'comments' ), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			//'taxonomies'          => ['courses_category', 'courses_selection'], // , 'job_listing_category'
			'has_archive'         => true,
			'rewrite'             => true,
			'query_var'           => true,
		) );

		register_taxonomy( 'courses_category', [ $type ], [ 
			'label'                 => '', // определяется параметром $labels->name
			'labels'                => [
				'name'              => 'Категории курсов',
				'singular_name'     => 'courses_category',
				'parent_item' => 'Родительская категория',
			],
			'description'           => 'Категории связанные с курсом', // описание таксономии
			'public'                => true,
			'show_in_nav_menus'     => true, // равен аргументу public
			'show_ui'               => true, // равен аргументу public
			'hierarchical'          => true,
	
			'rewrite'               => true,
			//'query_var'             => $taxonomy, // название параметра запроса
			'capabilities'          => array('manage_terms', 'edit_terms', 'delete_terms', 'assign_terms'),
			'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
			'show_admin_column'     => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
			'show_in_rest'          => true, // добавить в REST API
		] );

		register_post_type('courses_selection', array(
			'label'  => null,
			'labels' => array(
				'name'               => 'Выборки курсов', // основное название для типа записи
				'singular_name'      => 'courses_selection', // название для одной записи этого типа
				'add_new'            => 'Добавить выборку', // для добавления новой записи
				'add_new_item'       => 'Добавление выборки курса', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактирование выборки', // для редактирования типа записи
				'new_item'           => 'Новое ____', // текст новой записи
				'view_item'          => 'Смотреть ____', // для просмотра записи этого типа.
				'search_items'       => 'Искать выборку', // для поиска по этим типам записи
				'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => 'Родитительский раздел', // для родителей (у древовидных типов)
				// 'menu_name'          => '____', // название меню
			),
			'description'         => '',
			'public'              => true,
			// 'publicly_queryable'  => null, // зависит от public
			// 'exclude_from_search' => null, // зависит от public
			'show_ui'             => true, // зависит от public
			//'show_in_nav_menus'   => null, // зависит от public
			'show_in_menu'        => 'edit.php?post_type=courses', // показывать ли в меню адмнки
			// 'show_in_admin_bar'   => null, // зависит от show_in_menu
			'show_in_rest'        => true, // добавить в REST API. C WP 4.7
			'rest_base'           => 'courses_selection', // $post_type. C WP 4.7
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-admin-post', 
			//'capability_type'   => 'post',
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'        => true,
			// 'supports' => get_all_post_type_supports('courses'),
			'supports'            => array( 'title', 'editor', 'custom-fields', 'comments' ), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			//'taxonomies'          => ['courses_category'], // 'courses_selection', 'job_listing_category'
			'has_archive'         => true,
			'rewrite'             => true,
			'query_var'           => true,
		) );

		// register_taxonomy( 'courses_selection', [ $type ], [ 
		// 	'label'                 => '', // определяется параметром $labels->name
		// 	'labels'                => [
		// 		'name'              => 'Выборки курсов',
		// 		'singular_name'     => 'courses_selection',
		// 		'parent_item' => 'Родительская категория',
		// 	],
		// 	'description'           => 'Категории связанные с курсом', // описание таксономии
		// 	'public'                => true,
		// 	'show_in_nav_menus'     => true, // равен аргументу public
		// 	'show_ui'               => true, // равен аргументу public
		// 	'hierarchical'          => true,
	
		// 	'rewrite'               => true,
		// 	//'query_var'             => $taxonomy, // название параметра запроса
		// 	'capabilities'          => array('manage_terms', 'edit_terms', 'delete_terms', 'assign_terms'),
		// 	'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
		// 	'show_admin_column'     => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
		// 	'show_in_rest'          => true, // добавить в REST API
		// ] );

	}

}
