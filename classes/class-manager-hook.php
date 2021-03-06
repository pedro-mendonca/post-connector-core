<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class SP_Manager_Hook {

	private $hook_dir;
	private static $hooks;

	public function __construct( $hook_dir  ) {
		$this->hook_dir = $hook_dir;
	}

	/**
	 * Load and set hooks
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public function load_hooks() {

		foreach ( new DirectoryIterator( $this->hook_dir ) as $file ) {
			$file_name = $file->getFileName();

			if ( ! $file->isDir() && ( strpos( $file->getFileName(), '.' ) !== 0 ) ) {

				$class = SP_Class_Manager::format_class_name( $file->getFileName() );
				if ( 'SP_Hook' != $class ) {
					self::$hooks[$class] = new $class;
				}

			}

		}

	}

	/**
	 * Return instance of created hook
	 *
	 * @param $class_name
	 *
	 * @return SP_Hook
	 */
	public static function get_hook_object( $class_name ) {
		if ( isset( self::$hooks[$class_name] ) ) {
			return self::$hooks[$class_name];
		}
		return null;
	}

}