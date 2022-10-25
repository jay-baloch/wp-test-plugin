<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wordpress.com/
 * @since      1.0.0
 *
 * @package    JZ
 * @subpackage JZ/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    JZ
 * @subpackage JZ/public
 * @author     Jahanzaib <jahanzaibbaloch14@gmail.com>
 */
class JZ_Public {

	/**
	 * [$scripts_data load the scripts]
	 * @var array
	 */
	private $scripts_data = array();
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array($this,'enqueue_scripts') );

		// Register Ajax post call 
		add_action('wp_ajax_jz_ajax_post_call', array($this, 'ajax_post_call'));	
		add_action('wp_ajax_nopriv_jz_ajax_post_call', array($this, 'ajax_post_call'));

	}


	/**
	 *[ajax_post_call] descriptions
	 *show 3 old post on Page
	 *@return [type] $response [description]
	 */
	public function ajax_post_call(){
		global $wpdb;

		$response 	= new \stdClass;

		$response->success 	= false;

		$html = '';

	  		$args = array(
		    	'post_type' => 'post',
		    	'posts_per_page' => 3, 
		    	'order' => 'ASC', 
		   	);
			$query = new WP_Query($args);
			if ($query->have_posts() ){
				    $html .= '<div class="container">';   
					    $html .= '<div class="jz_post_section">';   
						while ( $query->have_posts() ) : 
							$query->the_post(); 
						        $html .=  '<div class="item">';
								  $html .= '<div class="thumbnail">';

									  	if ( has_post_thumbnail() ) {
						    				$html .=  get_the_post_thumbnail( get_the_ID());
										}
										else {
										    $html .=  '<img src="' . JZ_URL_PATH. 'public/images/defaultthumbnail.png" />';
										}

								  $html .= '</div>';
								  $html .= '<div class="content">';
									$html .= '<h2 class="title">'. get_the_title() .'</h2>';
									$html .= '<div class="entry-date">'. get_the_date().'</div>';
									$html .= '<div class="desc">'.get_the_content().'</div>';

								  $html .= '</div>'; 
						  		$html .= '</div>';

						endwhile; 
						$html .= '</div>';
					$html .= '</div>';
			}else{
				$html .= '<div class="container">';  
					$html .= '<h4>No Post Available</h4>'; 
				$html .= '</div>';

			}

			$response->success 	= true;
			$response->html 	= $html;

		echo json_encode($response);die;
	}

	/**
	 * Enqueue the Store Locator Scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($type = '', $atts = array()) {

		$media = 'all'; //screen, all

		// enqueue public Script
		wp_enqueue_script( 'plugin_public_script', JZ_URL_PATH . 'public/js/public_script.js', array('jquery'), 1.0, true );

		// Add Bootstrap CDN 
		wp_enqueue_style( 'jz_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css', array(), 5.2, $media );


		//	config array
		$configs = array('URL' 	=> admin_url('admin-ajax.php'),'type' => get_post_type(get_the_ID()));

		// Inject All Configs
		$this->localize_scripts( 'plugin_public_script', 'JZ_CONFIG', $configs);

		//	Inject script with inline_script
		wp_add_inline_script( 'plugin_public_script', $this->get_local_script_data(), 'before');
	}
		
	/**
	 * [localize_scripts description]
	 * @param  [type] $script_name [description]
	 * @param  [type] $variable    [description]
	 * @param  [type] $data        [description]
	 * @return [type]              [description]
	 */
	private function localize_scripts($script_name, $variable, $data) {

		$this->scripts_data[] = [$variable, $data]; 
	}



	/**
	 * [get_local_script_data Render the scripts data]
	 * @return [type] [description]
	 */
	private function get_local_script_data($with_tags = false) {

		$scripts = '';

		foreach ($this->scripts_data as $script_data) {
				
			$scripts .= 'var '.$script_data[0].' = '.(($script_data[1] && !empty($script_data[1]))?json_encode($script_data[1]): "''").';';
		}
		//	With script tags
		if($with_tags) {

			$scripts = "<script type='text/javascript' id='jz-script-js'>".$scripts."</script>";
		}

		//	Clear it
		$this->scripts_data = [];

		return $scripts;
	}


}
