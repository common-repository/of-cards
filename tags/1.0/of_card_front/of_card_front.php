<?php // Front End Function 

	$get_reading_data = get_option('card_get_read'); // get data from database 
    $get_data_explode = explode(';', $get_reading_data);
    $exploadArray = array();
    if(!empty($get_data_explode)){
    foreach($get_data_explode as $single_ex):
    	$seconExpload = explode('=', $single_ex);
    	$exploadArray[$seconExpload[0]] = 	$seconExpload[1];
    endforeach;
	}

function of_card_front_scripts() {
    wp_enqueue_style( 'of-card-front-style', plugin_dir_url(__FILE__) . 'of_cad_style.css' );
    wp_enqueue_style( 'of-card-front_page-style', plugin_dir_url(__FILE__) . 'of_card_page_style.css' );
    wp_enqueue_script( 'of-card-jquery', plugin_dir_url(__FILE__) . 'jquery.min.js' );
    wp_enqueue_script('of-card-modernizer', plugin_dir_url(__FILE__). 'modernizr.custom.js');
    wp_enqueue_script( 'script-name', plugin_dir_url(__FILE__) . 'of_card_js.js');
    wp_enqueue_script( 'plugin', plugin_dir_url(__FILE__) . 'plugin.js');
    wp_enqueue_script('jsplayer', plugin_dir_url(__FILE__). 'jwplayer.js');
    wp_enqueue_script( 'angel-plugin', plugin_dir_url(__FILE__) . 'angel.js');
    wp_enqueue_script('jquery-nicescroll', plugin_dir_url(__FILE__) . 'jquery.nicescroll.min.js');
}
add_action( 'wp_enqueue_scripts', 'of_card_front_scripts' );


function of_card_get_reading(){
	global $exploadArray;
	if(!isset($_GET['cards'])):
?>
	<h2 class="get-reading-title" style="text-align:center;">Get Your Reading</h2>	
	<div class="get-reading">
		<div class="single-get-reading">
			<p>Current Deck</p>
			<p><?= $exploadArray['admin-massage']; ?></p>
			<p class="admin-img"><img src="<?= $exploadArray['admin-img']; ?>" alt="OF Card Admin Thumbnail" /></p>
		</div>
		<div class="single-get-reading">
			<p>Choose Your Spread:</p>
			<div class="reading-box">
				<a href="?cards=simple-reading">
				<div class="card-img"><img src="<?= $exploadArray['single-img']; ?>" alt="Single Reading" /></div>
				<div class="card-cotnent"><span><?= $exploadArray['single-reading']; ?></span></div>
				</a>
			</div>
			<div class="reading-box">
				<?php if(is_user_logged_in()): ?>
					<a href="?cards=past-present-future">
				<?php else: ?>
					<a href="<?= get_home_url() . '/' . $exploadArray['of-login']; ?>?destination=<?= $exploadArray['of-afterLogin']; ?>">
				<?php endif; ?>

				<div class="card-img"><img src="<?= $exploadArray['three-img']; ?>" alt="Three Reading" /></div>
				<div data-txt="Login to use" class="card-cotnent"><span><?= $exploadArray['three-reading']; ?></span></div>
				</a>
			</div>
			<div class="reading-box">
				<?php if(is_user_logged_in()): ?>
				<a href="?cards=situation-concern">
				<?php else: ?>
				<a href="<?= get_home_url() . '/' . $exploadArray['of-login']; ?>?destination=<?= $exploadArray['of-afterLogin']; ?>">	
				<?php endif; ?>
				<div class="card-img"><img src="<?= $exploadArray['multi-img']; ?>" alt="Multi Reading" /></div>
				<div data-txt="Login to use" class="card-cotnent"><span><?= $exploadArray['multi-reading']; ?></span></div>
				</a>
			</div>
			<a class="btn btn-shuffle" onClick="return false" href="#">Shuffle &amp; Get Reading</a>
		</div>
	</div>
<?php
	else:
		switch($_GET['cards']):
			case 'simple-reading': ?>
				<?php 
					$args = array(
						'post_type' => 'card'
						);
				$card = new WP_Query($args);
				if($card->have_posts()):
					$get_of_backend_data = explode(',', get_option('of_card_backend'));
					$of_backend = array_rand($get_of_backend_data, 1);

				?>

			  <section id="a-main">
			          <div class="a-page oracle-select-card page-oracle">
			          	<div id="block-system-main" class="block block-system no-title" >  
			  
			  
			  <div class="row header-oracle">
			    <div class="column">
			      <h5 class="header-title-oracle">Simple Reading</h5>
			    </div>
			    <div class="column">
			      <div class="list-link-app">
			        <a href="#" class="btn btn-shuffle">Shuffle Deck</a>
			        <div class="btn-audio-oracle"><a href="#"><img src="<?php  echo plugin_dir_url(__FILE__); ?>images/icon_audio.png" /></a></div>
			      </div>
			    </div>
			  </div>
			  <div class="row show-oracle-card">
			    <div class="column">
			      <ul class="inline-list list-card-select">
			        <li><a href="#"><img src="<?php  echo plugin_dir_url(__FILE__); ?>images/select_a_card.png" alt=""></a></li>
			      </ul>
			      <span class="txt-select-card">Select a card to get the answer to your question, or guidance about which healing steps to take to help you with the question you asked.</span>
			      <div class="list-oracle-card">
			        <a class="arrow-left" href="#"></a>
			        <a class="arrow-right" href="#"></a>
			        <div class="swiper-container">
			          <div class="swiper-wrapper">
			          	<?php while($card->have_posts()): $card->the_post();
			          		$slider_img = wp_get_attachment_url(get_post_thumbnail_id());
			          	?>
			                        <div class="swiper-slide"><a href="<?= get_permalink(); ?>?b_id=<?= $of_backend; ?>"><img class="image-style-card-thumb" src="<?= get_home_url() . $get_of_backend_data[$of_backend]; ?>" width="250" height="360" alt="" /></a></div>
			                    <?php endwhile; ?>
			                </div>
			        </div>
			        <div class="tip" style="padding-top: 10px;">Drag the cards or hover on the arrows to slide left or right</div>
			      </div>
			    </div>
			  </div>
			  </div></div>    
				</section>

			<?php endif; break;
			case 'past-present-future':
			case 'situation-concern':
						$args = array(
						'post_type' => 'card'
						);
				$card = new WP_Query($args);
				if($card->have_posts()):
					$get_of_backend_data = explode(',', get_option('of_card_backend'));
					$of_backend = array_rand($get_of_backend_data, 1);
				?>

			  <section id="a-main">
			          <div class="a-page oracle-select-card page-oracle">
			          	<div id="block-system-main" class="block block-system no-title" >  
			  
			  
			  <div class="row header-oracle">
			    <div class="column">

			      <h5 class="header-title-oracle">
			      	<?php if($_GET['cards'] == 'past-present-future'): ?>
			      		Past, Present Future
			      	<?php else: ?>
			      		Situation or concern
			      	<?php endif; ?>
			      	
			      </h5>
			    </div>
			    <div class="column">
			      <div class="list-link-app">
			        <a href="#" class="btn btn-shuffle">Shuffle Deck</a>
			        <div class="btn-audio-oracle"><a href="#"><img src="<?php  echo plugin_dir_url(__FILE__); ?>images/icon_audio.png" /></a></div>
			      </div>
			    </div>
			  </div>
			  <div class="row show-oracle-card">
			    <div class="column">
			      <ul class="inline-list list-card-select">
			      	<?php 
			      		if($_GET['cards']=='past-present-future'):
			      			$cardLoop = 3;
			      		else:
			      			$cardLoop = 5;
			      		endif;
			      	for($i = 1; $i <= $cardLoop; $i+=1){ ?>
			        <li><a id="card-selected-<?= $i; ?>" href="javascript:void(0)"><img src="<?php  echo plugin_dir_url(__FILE__); ?>images/select_a_card.png" alt=""></a></li>
			        <?php } ?>
			      </ul>
			      <span class="txt-select-card">Select a card to get the answer to your question, or guidance about which healing steps to take to help you with the question you asked.</span>
			      <div class="list-oracle-card">
			        <a class="arrow-left" href="#"></a>
			        <a class="arrow-right" href="#"></a>
			        <div class="swiper-container">
			          <div class="swiper-wrapper">
			          	<?php while($card->have_posts()): $card->the_post();
			          		global $post;
			          		
			          		$slider_img = wp_get_attachment_url(get_post_thumbnail_id());
			          	?>
			             <div class="swiper-slide three-slider"><a data="<?= $post->ID; ?>" href="javascript:void(0)"><img class="image-style-card-thumb" src="<?= get_home_url() . $get_of_backend_data[$of_backend]; ?>" width="250" height="360" alt="" /></a></div>
			                    <?php endwhile; ?>
			                </div>
			        </div>
			        <div class="tip" style="padding-top: 10px;">Drag the cards or hover on the arrows to slide left or right</div>
			      </div>
			    </div>
			  </div>
			  </div></div>

					  <script type="text/javascript">
					  	jQuery(document).ready(function($){
					  		var dataArray = []; 
					  		$('.swiper-slide.three-slider').click(function(){
					  			$(this).children('a').children('img').addClass('selectedImg');
					  			var data = $(this).children('a').attr('data');
					  			if($.inArray(data, dataArray) != -1){
					  				//alert('data Exist in array');
					  			}else{
					  				dataArray.push(data);	
					  				$('#card-selected-'+dataArray.length).children('img').attr('src', '<?= plugin_dir_url(__FILE__); ?>images/card_pagi_hover.png');
					  			}
					  			<?php if($_GET['cards'] == 'past-present-future'): ?>
					  			if(dataArray.length >= 3){
					  				location.replace("<?= get_home_url() ?>/tarot-past-present-future/?ppf='"+dataArray+"'&b_id=<?= $of_backend; ?>");
					  			}
					  			<?php else: ?>
					  			if(dataArray.length >= 5){
					  				location.replace("<?= get_home_url() ?>/tarot-past-present-future/?ppf='"+dataArray+"'&b_id=<?= $of_backend; ?>");
					  			}
					  			<?php endif; ?>
					  		});
					  	});
					  </script>
			</section>
				<?php

			endif;
			break;

		endswitch;
	endif;
}
add_shortcode('of-card-get-reading', 'of_card_get_reading');



// login page functin 
function of_card_login(){
global $exploadArray;
$args = array(
	'echo'           => true,
	'remember'       => true,
	'redirect'       => home_url(). '/' . $_GET['destination'],
	'form_id'        => 'loginform',
	'id_username'    => 'user_login',
	'id_password'    => 'user_pass',
	'id_remember'    => 'rememberme',
	'id_submit'      => 'wp-submit',
	'label_username' => __( 'Username' ),
	'label_password' => __( 'Password' ),
	'label_remember' => __( 'Remember Me' ),
	'label_log_in'   => __( 'Log In' ),
	'value_username' => '',
	'value_remember' => false
); ?>
<div class="of-login">
	<div class="col-half">
		<h3>New Customer</h3>	

		<a class="btn-signup" href="<?= get_home_url() . '/' . $exploadArray['of-signup']; ?>">Sign Up</a>
	</div>
	<div class="col-half">
		<h3>Login</h3>			
		<p class="already_have_account">Already have a account? Please log in below</p>		
		<?php wp_login_form( $args ); ?>
	</div>
</div>
<?php
}
add_shortcode('of-card-login', 'of_card_login');


// Registratin Function 
function of_card_signup(){
	global $exploadArray;
	if(isset($_POST['signup-submit'])):
	//Need registration.php for data validation
	//require_once( ABSPATH . WPINC . '/registration.php');
	$firstname = sanitize_text_field($_POST['firstname'] );
	$lastname = sanitize_text_field( $_POST['lastname'] );
	$username = sanitize_text_field( $_POST['username'] );
	$email = sanitize_text_field( $_POST['email'] );
	$user_pass = $_POST['user_pass']; //wp_generate_password();
	//Add usernames we don't want used
	$invalid_usernames = array( 'admin' );
	//Do username validation
	$error_massage = '';
	$username = sanitize_user( $username );
	if ( !validate_username( $username ) || in_array( $username, $invalid_usernames ) ) {
	    $error_massage.= '<li>Username is invalid.</li>';
	}
	if ( username_exists( $username ) ) {
	    $error_massage.= '<li>Username already exists.</li>';
	}
	//Do e-mail address validation
	if ( !is_email( $email ) ) {
	    $error_massage.= '<li>E-mail address is invalid.</li>';
	}
	if (email_exists($email)) {
	    $error_massage .='<li>E-mail address is already in use.</li>';
	}
	if($user_pass == ''){
		$error_massage .='<li>You have to set Password.</li>';
	}

	//Everything has been validated, proceed with creating the user
	//Create the user
	
	$user = array(
	    'user_login' => $username,
	    'user_pass' => $user_pass,
	    'first_name' => $firstname,
	    'last_name' => $lastname,
	    'user_email' => $email
	    );
	$user_id = wp_insert_user( $user );
	if($user_id && empty($error_massage)){
		echo '<script>window.location.replace("'.get_home_url().'/'.$exploadArray['of-login'].'?destination='.$exploadArray['of-afterLogin'].'")</script>';
	}
	endif;
	?>
	<?php if(!empty($error_massage)): ?>
	<ul class="of-error-msg">
		<?= $error_massage; ?>
	</ul>
	<?php endif; ?>
	<form method="POST" action="" id="of-signup-form">
		<div class="from-group">
			<label for="firstname">First Name: </label>
			<input type="text" required id="firstname" name="firstname" value="" />
		</div>
		<div class="form-group">
			<label for="lastname">Last Name: </label>
			<input type="text" id="lastname" name="lastname" value="" />
		</div>
		<div class="form-group">
			<label for="username">User Name:</label>
			<input type="text" id="usrname" required name="username" value="" />
		</div>	
		<div class="form-group">
			<label for="email">Email: </label>
			<input type="email" id="email" required name="email" value="" />
		</div>
		<div class="form-group">
			<label for="user_pass">User Password: </label>
			<input type="password" id="user_pass" name="user_pass" value=""  pattern=".{6,}"   required title="6 characters minimum" />
		</div><br/>
		<input type="submit" class="btn-submit" name="signup-submit" value="Sign Up" />

	</form>
<?php
}
add_shortcode('of-card-signup', 'of_card_signup');

require_once('of_inc_function/single_card_function.php');


// Change Title 
add_filter( 'wp_title', 'charts_title_so_15312385', 10, 2 );

function charts_title_so_15312385( $title, $post_id ) 
{ 
	$title = '';
	$of_page_title_back = get_option('ofpagetitle'); 
    // Ok, modify title
    if(isset($_GET['ppf'])){

    $title .= $of_page_title_back . ' | ';
	}
    return $title;
}




?>