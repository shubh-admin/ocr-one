<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://shubhcomputing.com
 * @since      1.0.2
 *
 * @package    Ocr_One
 * @subpackage Ocr_One/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.2
 * @package    Ocr_One
 * @subpackage Ocr_One/includes
 * @author     shubhcomputing <support@shubhcomputing.com>
 */
class Ocr_One {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.2
	 * @access   protected
	 * @var      Ocr_One_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.2
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.2
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.2
	 */
	public function __construct() {

		$this->plugin_name = 'ocr-one';
		$this->version = '1.0.2';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ocr_One_Loader. Orchestrates the hooks of the plugin.
	 * - Ocr_One_i18n. Defines internationalization functionality.
	 * - Ocr_One_Admin. Defines all hooks for the admin area.
	 * - Ocr_One_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.2
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ocr-one-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ocr-one-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ocr-one-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ocr-one-public.php';

		$this->loader = new Ocr_One_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ocr_One_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.2
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ocr_One_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.2
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ocr_One_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.2
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ocr_One_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.2
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.2
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.2
	 * @return    Ocr_One_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.2
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


	/**
		 * menu_page function
		 * generate the options page in the wordpress admin
		 * @access public
		 * @return void
		 */
	function create_menu()
		{
			add_menu_page('OCR ONE', 'OCR ONE', 'administrator', __FILE__, array($this,'options_page') );
		}

		/**
		 * options_page function
		 * generate the options page in the wordpress admin
		 * @access public
		 * @return void
		 */

		function options_page()
		{
			// API Form
			/*echo "<h1>Api Key</h1>"*/;
			echo "<fieldset class='admin_main_fieldset'><legend>Configure OCR-One</legend>";
			echo "<form method='post'>";
			echo "API Key: <input type='text' class='api_extend' name='incuro_subscription_key' value='".get_option('incuro_subscription_key')."'>";
			echo "<input type='submit' value='Update' name='isk_submit'>";
			echo "</form>";
			$url = "http://ics01.cloudapp.net:9003/GetOCRLanguageCodeList";
		 	$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$headers = (object)array('Ocp-Apim-Subscription-Key:'.get_option('incuro_subscription_key'));			
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$server_output = curl_exec ($ch);			
			$v = json_decode($server_output); 
			/*echo "<h1> OCR ONE </h1>";	*/
			echo "<div class='ocr_one_wrapper'>";
			/*echo "<form method='post' action='' enctype='multipart/form-data'>";
			
			echo "<input type='file' name='ocr_file'>";
			echo "<select name='ocr-lang'>";
			for ($i=0; $i < count($v); $i++) { 
				echo "<option value='".$v[$i]->Code."'>".$v[$i]->Description."</option>";
			}
			echo "</select>";
			echo "Persist <input type='checkbox' value='persist' name='persist'>";
			echo "<input type='submit' name='ocr_submit'>";
			
			echo "</form>";*/
			echo "</div>";

			// Display table for files
			$parray = array('post_type'=>'ocr_files');
			 $get_posts = new WP_Query;
			 $d = $get_posts->query($parray);
			echo "<fieldset class='admin_sub_fieldset'><legend>Saved OCR Operation</legend>";
			?>
			<table border="3" class="ocr-table">
				<tr>
					<th>Date</th>
					<th>File</th>
					<th>User</th>
					<th>Operation</th>
				</tr>
				<?php

					for ($i=0; $i < count($d) ; $i++) { 
						$e =  get_post_meta($d[$i]->ID,'file_url');
						$f = get_userdata( $d[$i]->post_author);;
					
						echo "<tr>";
						echo "<td>";
						echo get_the_date(get_option('date_format'),$d[$i]->ID);
						//echo $d[$i]->post_date;
						echo "</td>";

						echo "<td>";
						echo "<a href='".$e[0]."'>";
						echo $d[$i]->post_title;
						echo "</a>";
						echo "</td>";
						echo "<td>";
						echo "<a href='".get_edit_user_link($d[$i]->post_author)."'>";
						echo $f->user_login;
						echo "</a>";
						echo "</td>";

						echo "<td class='actions_is'>";
						echo "<div style='float:left'>";
						echo "<form method='post' action''>";
						
						echo "<input type='hidden' value='".$e[0]."' name='file_url'>";
						echo "<input type='hidden' name='delete_id' value='".$d[$i]->ID."'>";
						echo "<input type='submit'   name='apc_delete_file' value='Delete'>";
						
						echo "</form>";
						echo "</div>";
						echo "<div style='float:right'>";
						echo "<form method='post' action''>";
						echo "<input type='hidden' name='show_id' value='".$d[$i]->ID."'>";
						echo "<input type='submit' name='apc_show_admin_file' value='Show'>";
						echo "</form>";
						echo "</div>";
						echo "</td>";

						echo "</tr>";
					}
				?>
			</table>
		</fieldset>
			<?php
			echo "</fieldset>";
			echo "<fieldset class='admin_help_fieldset'><legend>Help</legend>";
			echo "<fieldset class='admin_help_inner_fieldset'>";
			echo "How to Get API? </br> Go to <a href='http://ics01.cloudapp.net:9003/' target='_blank'>Docunate</a>, 
			Register there and</br> Get  API Key";

			echo "</fieldset>";
			echo "</fieldset>";


		}

		/*
		 * save_ocr_files function
		 * save the ocr_files from the options page to the database
		 * @access public
		 * @param mixed $data
		 * @return void
		 */
		function save_ocr_files($data) {
			
							$errors=array();
						    $allowed_ext= array('jpg','jpeg','png','gif',pdf);
						    $file_or_name =$_FILES['ocr_file']['name'];
						    $file_name =$_FILES['ocr_file']['tmp_name'];
						    $file_ext = strtolower( end(explode('.',$file_or_name)));
			
							//echo $file_ext;
						    $file_size=$_FILES['ocr_file']['size'];
						    $file_tmp= $_FILES['ocr_file']['tmp_name'];
						    //echo $file_tmp;echo "<br>";
			
						    $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
						    $data = file_get_contents($file_tmp);
						    $base64 = base64_encode($data);
						   
						    //echo "Base64 is ".$base64;
						    $url = "http://ics01.cloudapp.net:9003/GetOCRData";
						    $pfields =array('Name'=>$file_or_name,
						    	'FileType'=>'application/'.$file_ext,
						    	'FileName'=>$file_or_name,
						    	'FileContent'=>$base64,
						    	'LanCode'=> $_POST['ocr-lang']
			
						    	);
						    
						 	$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL,$url);
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($pfields));  //Post Fields
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								
							// $headers = array();
							// (object)$headers['Ocp-Apim-Subscription-Key'] = 'edb86e8b2d064b0ba612872231e8abcd';
							// (object)$headers['Content-Type'] = 'application/json';

							$headers = (object)array('Ocp-Apim-Subscription-Key:'.get_option('incuro_subscription_key'),'Content-Type:application/json');
							
			
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
							$server_output = curl_exec ($ch);
							
							$v = json_decode($server_output); 
							
							
							if(isset($_POST['persist']) && $_POST['persist']!="")
							{

							     if ( ! function_exists( 'wp_handle_upload' ) ) {
								    require_once( ABSPATH . 'wp-admin/includes/file.php' );
								}

								$uploadedfile = $_FILES['ocr_file'];

								$upload_overrides = array( 'test_form' => false );

								$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

								if ( $movefile && !isset( $movefile['error'] ) ) {
									
								    $data1  = array(
								    	'post_title' => $_FILES['ocr_file']['name'],
								    	'post_type' => 'ocr_files',
								    	 'post_content' => $v->Text,
								    	'post_status' => 'publish'
								     );
								    $post_id = wp_insert_post($data1,true);
								   
								    	add_post_meta($post_id,'file_url',$movefile['url']);
								    
								} else {
								    /**
								     * Error generated by _wp_handle_upload()
								     * @see _wp_handle_upload() in wp-admin/includes/file.php
								     */
								    echo $movefile['error'];
								}
							}
							else
							{
								echo "<div class='popup-div'>";
								?>
									<div><span class='cross_button'><button onclick="close_div('popup-div')">x</button></span></div>
									<?php
									echo $v->Text;
								echo "</div>";
							}
							curl_close ($ch);
				    
		}

		function save_subscription_key()
		{
			update_option('incuro_subscription_key', $_POST['incuro_subscription_key']);
		}

		function delete_ocr_data()
		{
			wp_delete_post( $_POST['delete_id'],true);
			unlink($_POST['file_url']);
		}

		function show_ocr_admin_data()
		{
			$r = get_post($_POST['show_id']);
			echo "<div class='popup-div'>";
								?>
									<div>
									<span class='cross_button'><button onclick="close_div('popup-div')">x</button></span></div>
										<div id="ocr_content_div">
									<?php
									echo $r->post_content;
									?>
									</div>
									<?php
								echo "</div>";

		}

		function show_ocr_data()
		{
			$r = get_post($_POST['show_id']);
			echo "<div class='popup-div'>";
								?>
									<div>
									<span class='cross_button'><button onclick="close_div('popup-div')">x</button></span></div>
										<div id="ocr_content_div">
									<?php
									echo $r->post_content;
									?>
									</div>
									<form method="post" onsubmit="putvaluesofdivinform()">
										<input type="hidden" name="pid" value="<?php echo $_POST['show_id'] ?>">
										<input type="hidden" id="frontend_editing_content">
										<input type="button" style=" position:fixed; top:402px; right:527px;" value="Edit" onclick="add_attr(this)" id="ocr_data_edit">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
										<input type="submit" style=" position:fixed; top:402px; right:446px;" value="Save" name="edit_ocr_submit">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
										<input type="button" style=" position:fixed; top:402px; right:603px;" value="Cancel" onclick="close_div('popup-div')">
									</form> 
								
									<?php
								echo "</div>";

		}

		// Add Shortcode
		function ocrone_shortcode() {
			if(is_user_logged_in())
			{
			$url = "http://ics01.cloudapp.net:9003/GetOCRLanguageCodeList";
		 	$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$headers = (object)array('Ocp-Apim-Subscription-Key:'.get_option('incuro_subscription_key'));			
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$server_output = curl_exec ($ch);			
			$v = json_decode($server_output); 
			
			/*echo "<h1> OCR ONE </h1>";*/
			echo "<fieldset class='public_main_fieldset'><legend> OCR Operation</legend>";	
			echo "<div class='ocr_one_wrapper'>";
			echo "<form method='post' action='' enctype='multipart/form-data'>";
			echo "<input type='file' name='ocr_file'>";
			echo "<br>";
			echo "<br>";
			echo "<select name='ocr-lang'>";
			echo "<option>Select Languange</option>";
			for ($i=0; $i < count($v); $i++) { 
				echo "<option value='".$v[$i]->Code."'>".$v[$i]->Description."</option>";
			}
			echo "</select> ";
			
			echo "  Persist <input type='checkbox' value='persist' name='persist'>";
			echo "<br>";
			echo "<br>";
			echo "<input type='submit' name='ocr_submit_frontend'>";
			echo "<br>"; echo "<br>";
			echo "</form>";
			echo "</div>";
			echo "</fieldset>";

			// Display table for files
			$parray = array('post_type'=>'ocr_files','author'=>get_current_user_id());

			 $get_posts = new WP_Query;
			 $d = $get_posts->query($parray);
			echo "<fieldset class='public_main_fieldset'><legend> Saved OCR Operations</legend>";	
			?>

			<table border="3" class="ocr-table">
				<tr>
					<th>Date</th>
					<th>File</th>
					<!-- <th>User</th> -->
					<th>Operation</th>
				</tr>
				<?php

					for ($i=0; $i < count($d) ; $i++) { 
						$e =  get_post_meta($d[$i]->ID,'file_url');
						$f = get_userdata( $d[$i]->post_author);;
					
						echo "<tr>";
						echo "<td>";
						echo get_the_date(get_option('date_format'),$d[$i]->ID);
						echo "</td>";

						echo "<td>";
						echo "<a href='".$e[0]."'>";
						echo $d[$i]->post_title;
						echo "</a>";
						echo "</td>";
						/*echo "<td>";
						echo "<a href='".get_edit_user_link($d[$i]->post_author)."'>";
						echo $f->user_login;
						echo "</a>";
						echo "</td>";
*/
						echo "<td class='actions_is'>";
						echo "<div style='float:right; '>";
						echo "<form method='post' action''>";
						echo "<input type='hidden' value='".$e[0]."' name='file_url'>";
						echo "<input type='hidden' name='delete_id' value='".$d[$i]->ID."'>";
						echo "<input type='submit'   name='apc_delete_file_frontend' value='Delete'>";
						echo "</form>";
						echo "</div>";
						echo "<div style='float:right;margin-right:5px'>";
						echo "<form method='post' action''>";
						echo "<input type='hidden' name='show_id' value='".$d[$i]->ID."'>";
						echo "<input type='submit' name='apc_show_file_frontend' value='Show'>";
						echo "</form>";
						echo "</div>";
						echo "</td>";

						echo "</tr>";
					}
				?>
			</table>

			<?php
			echo "</fieldset>";
			}
		}

		function save_ocr_frontend()
		{
			$post_author = get_current_user_id();

			$c = rtrim(ltrim($_POST['editedcontent']));
			$id = $_POST['pid'];
			$post_array = [
				'ID'           => $id,
		      'post_content' => $c,
		      'post_author'=>$post_author
			];
			wp_update_post( $post_array );
		}
		
		/**
		 * Register a ocr_files post type.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		function codex_ocrone_init() {
			

			 $args = array(
		      'public' => true,
		      'label'  => 'Ocr Files'
		    );
			register_post_type( 'ocr_files', $args );
		}


}
