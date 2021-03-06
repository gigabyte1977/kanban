<?php



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



// Kanban_Status_Change::init();



class Kanban_Status_Change extends Kanban_Db
{
	// the instance of this object
	private static $instance;

	// the common name for this class
	static $slug = 'status_change';

	// the table name of this class
	protected static $table_name = 'log_status_changes';

	// define db table columns and their validation type
	protected static $table_columns = array(
		'task_id' => 'int',
		'created_dt_gmt' => 'datetime',
		'status_id_old' => 'int',
		'status_id_new' => 'int',
		'user_id_author' => 'int',
	);



	// static function init()
	// {
	// 	add_action( sprintf('wp_ajax_add_%s', self::$slug), array(__CLASS__, 'ajax_save') );
	// }



	// static function ajax_save ()
	// {
	// 	if (  !isset( $_POST[Kanban_Utils::get_nonce()] ) || ! wp_verify_nonce( $_POST[Kanban_Utils::get_nonce()], 'kanban-save') || !is_user_logged_in() ) wp_send_json_error();



	// 	do_action( sprintf('%s_before_%s_ajax_save', Kanban::get_instance()->settings->basename, self::$slug) );



	// 	$status_id_old = Kanban_Utils::format_key (self::$slug, 'status_id_old');
	// 	$status_id_new = Kanban_Utils::format_key (self::$slug, 'status_id_new');

	// 	// build post data
	// 	$post_data = array(
	// 		'post_type' => Kanban_Post_Types::format_post_type (self::$slug),
	// 		'post_title' => sprintf('changed task ID %s from %s to %s', $_POST['task_id'], $_POST['status_id_old'], $_POST['status_id_new']),
	// 		'post_parent' => $_POST['task_id'],
	// 		'postmeta' => array(
	// 			$status_id_old => $_POST['status_id_old'],
	// 			$status_id_new => $_POST['status_id_new']
	// 		),
	// 		'terms' => array()
	// 	);



	// 	// save our work_hour
	// 	$post_data = Kanban_Post::save($post_data);



	// 	if ( !$post_data ) wp_send_json_error();



	// 	do_action( sprintf('%s_after_%s_ajax_save', Kanban::get_instance()->settings->basename, self::$slug) );



	// 	wp_send_json_success(array(
	// 		'message' => sprintf('%s saved', self::$slug),
	// 		self::$slug => $post_data
	// 	));
	// }



	static function add ($task_id, $status_id_new, $status_id_old = 0, $user_id_author = NULL)
	{
		if ( !$user_id_author )
		{
			$user_id_author = get_current_user_id();
		}



		$data = array(
			'task_id' => $task_id,
			'created_dt_gmt' => Kanban_Utils::mysql_now_gmt(),
			'status_id_old' => $status_id_old,
			'status_id_new' => $status_id_new,
			'user_id_author' => $user_id_author
		);

		$id = self::_insert($data);
	}



	// define the db schema
	static function db_table ()
	{
		return "CREATE TABLE " . self::table_name() . " (
					id bigint(20) NOT NULL AUTO_INCREMENT,
					task_id bigint(20) NOT NULL,
					created_dt_gmt datetime NOT NULL,
					status_id_old bigint(20) NOT NULL,
					status_id_new bigint(20) NOT NULL,
					user_id_author bigint(20) NOT NULL,
					UNIQUE KEY  (id)
				)";
	} // db_table



	/**
	 * get the instance of this class
	 * @return	object	the instance
	 */
	public static function get_instance()
	{
		if ( ! self::$instance )
		{
			self::$instance = new self();
		}
		return self::$instance;
	}



	/**
	 * construct that can't be overwritten
	 */
	private function __construct() { }

}


