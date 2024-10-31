<?php 
// Of Cards Admin Functionality 
// Admin Script
function of_card_admin_script() {
		wp_enqueue_script( 'admin_of_script',  plugin_dir_url( __FILE__ ) . '/of_card_admin.js');
		//wp_localize_script( 'ajax_of_slider', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );	
        wp_register_style( 'of_wp_admin_css', plugin_dir_url(__FILE__) . '/of_card_admin.css', false, '1.0.0' );
        wp_enqueue_style( 'of_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'of_card_admin_script' );

// Admin Action Manu  
add_action( 'admin_menu', 'of_card_admin' );
function of_card_admin() {
	//add_menu_page('Of Card', 'OF CARDS', 'administrator', __FILE__, 'of_card_admin_settings_page' , plugins_url('/of-card-menu-icon.png', __FILE__) );
	add_submenu_page(
    'edit.php?post_type=card',
    'Card Settings', /*page title*/
    'Settings', /*menu title*/
    'manage_options', /*roles and capabiliyt needed*/
    'of_card_setting',
    'of_card_admin_settings_page' /*replace with your own function*/
);
}


function of_card_uploader_enqueue() {
    wp_enqueue_media();
    wp_register_script( 'media-lib-uploader-js', plugins_url( 'media-lib-uploader.js' , __FILE__ ), array('jquery') );
    wp_enqueue_script( 'media-lib-uploader-js' );
  }
  add_action('admin_enqueue_scripts', 'of_card_uploader_enqueue');

function of_card_admin_settings_page(){
    /**************************************************************
                F O R M  P R O C E S S 
    ***************************************************************/
    if(isset($_POST['get-reading'])):
    	if(!empty($_POST['admin-img'])):
        	$_POST['admin-img'] = str_replace(get_home_url(), '', $_POST['admin-img']);
    	endif;
    	if(!empty($_POST['single-img'])):
        	$_POST['single-img'] = str_replace(get_home_url(), '', $_POST['single-img']);
    	endif;
    	if(!empty($_POST['three-img'])):
        	$_POST['three-img'] = str_replace(get_home_url(), '', $_POST['three-img']);
    	endif;
    	if(!empty($_POST['multi-img'])):
        	$_POST['multi-img'] = str_replace(get_home_url(), '', $_POST['multi-img']);
    	endif;

        unset($_POST['get-reading']);
        //$get_reading = '';

       /* foreach($_POST as $key => $value):
            $get_reading .= $key . ':' . $value . ',';
        endforeach;*/
        
        $get_reading = urldecode(http_build_query($_POST, '', ';'));
        $get_reading_data = get_option('card_get_read'); // data quary from database
        if(empty($get_reading)):
        	add_option('card_get_read', $get_reading, '', 'yes');	
    	else: 
    		update_option('card_get_read', $get_reading);
    	endif;

    elseif(isset($_POST['of-backend-submit'])):
        $back_card_array = array();
        foreach($_POST['card-backend'] as $backCard):
            $back_card_array[] = str_replace(get_home_url(), '', $backCard);
        endforeach;
        $get_reading_ad = implode(',', $back_card_array);
        $get_back_ed_data = get_option('of_card_backend'); // data quary from database
        if(empty($get_back_ed_data)):
            add_option('of_card_backend', $get_reading_ad, '', 'yes');
        else:
            update_option('of_card_backend', $get_reading_ad);
        endif;
    elseif(isset($_POST['of_page_title_submit'])):
        $data_pageTitle = $_POST['of_page_title'];
        $of_page_title_back = get_option('ofpagetitle'); // data quary from database
        if(empty($of_page_title_back)):
            add_option('ofpagetitle', $data_pageTitle, '', 'yes');
        else:
            update_option('ofpagetitle', $data_pageTitle);
        endif;
    endif;

 ?>
	<div class="wrap">
		
		<h2 class="cardSettingsTitle">Card Settings</h2>
		<?php
		$tabs = array( 'get-reading' => 'Get Reading', 'card-backend' => 'Card Backend', 'title' => 'Title' );
    	echo '<div id="icon-themes" class="icon"><span class="dashicons dashicons-admin-generic"></span><br></div>';
    	echo '<h2 class="nav-tab-wrapper">';
    	
    	foreach( $tabs as $tab => $name ){
    		$class = '';
    		if(isset($_GET['tab'])):
        		$class .= ( $tab == $_GET['tab'] ) ? ' nav-tab-active' : '';
        	endif;
        	echo "<a class='nav-tab $class' href='?post_type=card&page=of_card_setting&tab=$tab'>$name</a>";
    	}
    	echo '</h2>';


    	// Settings page body 
    	if(isset($_GET['tab'])):
    		switch($_GET['tab']):
    			case 'get-reading':

    			$get_reading_data = get_option('card_get_read'); // get data from database 
    			$get_data_explode = explode(';', $get_reading_data);
    			$exploadArray = array();
    			foreach($get_data_explode as $single_ex):
    				$seconExpload = explode('=', $single_ex);
    				$exploadArray[$seconExpload[0]] = 	$seconExpload[1];
    			endforeach;
    				_e('<h2>Get Reading Page Content: </h2>');
    				?>
    					<form id="get-reading" method="POST">
    					<div class="half-div">
    						<label for="admin-massage">Admin Massage: </label>
    						<textarea name="admin-massage" id="admin-massage"><?= $exploadArray['admin-massage']; ?></textarea>
    						<br/>
    						<label for="admin-img">Image: </label>
    						<input style="display:none;" type="text" value="<?= $exploadArray['admin-img']; ?>" name="admin-img" id="admin-img"/>
                            <span class="upload-img admin-img">
                            	<?php 
                            	if(!empty($exploadArray['admin-img'])):
                            		echo '<img src="'.$exploadArray['admin-img'].'" />';
                            	else:
                            	?>
                            	<div alt="f132" class="dashicons dashicons-plus"></div>
                            	<?php endif; ?>
                            </span>
    						<div class="img-prev">
    						</div>
    					</div>
    					<div class="half-div">
    						<div class="single-card">
    							<div class="left">
    								<input type="text" style="display:none;" value="<?= $exploadArray['single-img']; ?>" name="single-img" id="single-img" />	
    								<span class="upload-img">
		    							<?php 
		                            	if(!empty($exploadArray['single-img'])):
		                            		echo '<img src="'.$exploadArray['single-img'].'" />';
		                            	else:
		                            	?>
		                            	<div alt="f132" class="dashicons dashicons-plus"></div>
		                            	<?php endif; ?>
		    						</span>
    							</div>
    							<div class="right">
    								<label for="single-reading">Simple Reading Single</label>
    								<input type="text" placeholder="Simple Reading Single" name="single-reading" id="single-reading" value="<?php if(array_key_exists('single-reading', $exploadArray)) { echo $exploadArray['single-reading']; } ?>" />
    							</div>
    						</div>
    						<div class="single-card">
    							<div class="left">
    								<input type="text" style="display:none;" value="<?= $exploadArray['three-img']; ?>" name="three-img" id="three-img" />	
                                    <span class="upload-img">
                                    	<?php 
		                            	if(!empty($exploadArray['three-img'])):
		                            		echo '<img src="'.$exploadArray['three-img'].'" />';
		                            	else:
		                            	?>
		                            	<div alt="f132" class="dashicons dashicons-plus"></div>
		                            	<?php endif; ?>
                                    </span>
    							</div>
    							<div class="right">
    								<label for="three-reading">Past, Present & Future</label>
    								<input type="text" placeholder="Past, Present & Future" name="three-reading" id="three-reading" value="<?= $exploadArray['three-reading']; ?>" />
    							</div>
    						</div>
    						<div class="single-card">
    							<div class="left">
    								<input type="text" style="display:none;" value="<?= $exploadArray['multi-img']; ?>" name="multi-img" id="multi-img" />	
                                    <span class="upload-img">
                                    	<?php 
		                            	if(!empty($exploadArray['multi-img'])):
		                            		echo '<img src="'.$exploadArray['multi-img'].'" />';
		                            	else:
		                            	?>
		                            	<div alt="f132" class="dashicons dashicons-plus"></div>
		                            	<?php endif; ?>
                                    </span>
    							</div>
    							<div class="right">
    								<label for="multi-reading">Situation or Concern</label>
    								<input type="text" name="multi-reading" placeholder="Situation or Concern" id="multi-reading" value="<?= $exploadArray['multi-reading']; ?>" />
    							</div>
    						</div>
                            <br/>
                            <div class="login-redirection">

                            	<h3>Login Page & Redirect after Login: </h3>
                            	<?php 
                                if(!empty($exploadArray['of-login'])):
                            	   $page_login = get_posts( array( 'name' => $exploadArray['of-login'], 'post_type' => 'page' ) );
                                endif;
                                if(!empty($exploadArray['of-afterLogin'])):
                            	   $page_redirect = get_posts( array( 'name' => $exploadArray['of-afterLogin'], 'post_type' => 'page' ) );
                                endif;
                                if(!empty( $exploadArray['of-signup'])):
                                    $page_signup = get_posts( array( 'name' => $exploadArray['of-signup'], 'post_type' => 'page' ) );
                                endif;

                            	?>
                            	<label for="of-login">Login Page: </label>
                            	<select name="of-login" id="of-login">
                            		<?php if(!empty($exploadArray['of-login'])): ?>
                            			<option value="<?= $exploadArray['of-login']; ?>"><?= $page_login[0]->post_title; ?></option>
                            		<?php else: ?>
                            		<option value="">Select Login Page</option>
                            		<?php
                            		endif;
                            			$pages = get_pages(); 
                            			foreach($pages as $page):
                            				echo '<option value="'.$page->post_name.'">'.$page->post_title.'</option>';
                            			endforeach;	
                            		?>
                            	</select><br/>
                            	<label for="of-afterLogin">Redirect After Login: </label>
                            	<select name="of-afterLogin" id="of-afterLogin">
                            		<?php if(!empty($exploadArray['of-afterLogin'])): ?>
                            		<option value="<?= $exploadArray['of-afterLogin']; ?>"><?= $page_redirect[0]->post_title; ?></option>
                            		<?php else: ?>
                            		<option value="">Select Redirect Page</option>
                            		<?php
                            		endif;
                            			$pages = get_pages(); 
                            			foreach($pages as $page):
                            				echo '<option value="'.$page->post_name.'">'.$page->post_title.'</option>';
                            			endforeach;	
                            		?>
                            	</select><br/>
                                <!-- Sign up page -->
                                <label for="of-signup">Sign Up Page: </label>
                                <select name="of-signup" id="of-signup">
                                    <?php if(!empty($exploadArray['of-signup'])): ?>
                                    <option value="<?= $exploadArray['of-signup']; ?>"><?= $page_signup[0]->post_title; ?></option>
                                    <?php else: ?>
                                    <option value="">Select Sign Up Page</option>
                                    <?php
                                    endif;
                                        $pages = get_pages(); 
                                        foreach($pages as $page):
                                            echo '<option value="'.$page->post_name.'">'.$page->post_title.'</option>';
                                        endforeach; 
                                    ?>
                                </select>

                            </div>
                            <br/>
                            <input type="submit" name="get-reading" class="button button-primary" value="Save" />
    					</div>
    					</div>
                        </form>
    				<?php
    			break;
                case 'card-backend': ?>
                    <form method="POST">
                        <h3 class="back-img">Card Back Image's</h3>
                        <div class="img-div-wrap">

                            <input type="text" style="display:none;" value="" name="multi-img" class="multi-img" />  
                            <?php 
                            $get_of_backend_data = explode(',', get_option('of_card_backend')); // data quary from database
                            ?>
                            <?php foreach($get_of_backend_data as $single_back): ?>
                            <input style='display:none;' type='checkbox' checked name='card-backend[]' value='<?= get_home_url() . $single_back; ?>'/><span class='upload-img-backend-card'><img src='<?= get_home_url() . $single_back; ?>'/><span class="delete-back-img"><div alt="f182" class="dashicons dashicons-trash"></div></span></span>
                            <?php endforeach; ?>
                            <span id="img-uploade-id" class="img-uploade-btn"><div alt="f132" class="dashicons dashicons-plus"></div></span>
                        </div><br/><br/>
                        <div class="submit-btn">
                            <input type="submit" value="Submit" name="of-backend-submit" class="button button-primary" />
                        </div>
                    </form>
                <?php break;
                case 'title': ?>
                    <h2>Front Page Title: </h2>
                    <?php 
                     $of_page_title = get_option('ofpagetitle'); // data quary from database
                    ?>
                    <form method="POST">
                        <input type="text" style="width: 50%; height: 50px;font-size: 20px;" name="of_page_title" id="of_page_title" value="<?= $of_page_title; ?>" /><br/>
                        <input style="margin-top: 20px; padding: 0px 10px;" type="submit" value="Submit" class="button button-primary" name="of_page_title_submit" />
                    </form>
                <?php break;
    		endswitch;
    	else:  ?>
    	<h2>Wellcome to OF Cards Settings Page</h2>
    	<p>
    		Set your all settings from here. 
    		<br/>
    		Developer:  <a href="http://www.aboutdhaka.com">About Dhaka (Omar Faruque)</a>
            <br/><br/>
            <strong>All Shortcodes: </strong>
            <ul>
                <li>Cards landing page : <b>[of-card-get-reading]</b></li>
                <li>Signup pages: <b>[of-card-signup]</b></li>
                <li>Login pages: <b>[of-card-login]</b></li>
            </ul>

    	</p>

		<?php
    	endif;


?>
	</div>


<?php }


add_action( 'init', 'of_card' );
/**
 * Register post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function of_card() {
	$labels = array(
		'name'               => _x( 'Cards', 'post type general name', 'Greendotbd' ),
		'singular_name'      => _x( 'Card', 'post type singular name', 'Greendotbd' ),
		'menu_name'          => _x( 'Cards', 'admin menu', 'Greendotbd' ),
		'name_admin_bar'     => _x( 'Card', 'add new on admin bar', 'Greendotbd' ),
		'add_new'            => _x( 'Add New', 'Card', 'Greendotbd' ),
		'add_new_item'       => __( 'Add New Card', 'Greendotbd' ),
		'new_item'           => __( 'New Card', 'Greendotbd' ),
		'edit_item'          => __( 'Edit Card', 'Greendotbd' ),
		'view_item'          => __( 'View Card', 'Greendotbd' ),
		'all_items'          => __( 'All Cards', 'Greendotbd' ),
		'search_items'       => __( 'Search Cards', 'Greendotbd' ),
		'parent_item_colon'  => __( 'Parent Cards:', 'Greendotbd' ),
		'not_found'          => __( 'No Cards found.', 'Greendotbd' ),
		'not_found_in_trash' => __( 'No Cards found in Trash.', 'Greendotbd' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'menu_icon'			 => plugins_url('/of-card-menu-icon.png', __FILE__),
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'card' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
	);

	register_post_type( 'card', $args );
}



