<?php 
/*
* Multiple card reading
*/
get_header();
?>
<?php 
	//get all post id

	if(isset($_GET['ppf'])){
		$ppf = str_replace("\'", "", $_GET['ppf']);
		//$p_id_array = explode(',', $ppf);
		$p_id_array = array_map('intval', explode(',', $ppf));
		/*echo '<pre>';
		var_dump($p_id_array);
		echo '</pre>';*/

		//echo 'Count: ' . count($p_id_array);
		$args = array(
		'post_type' => array('card'),
		'post__in' => $p_id_array
		);
		$card_posts = new WP_Query($args);
		$headArray = array('past', 'present', 'future');
	}

	if($card_posts->have_posts()):
		$get_of_backend_data = explode(',', get_option('of_card_backend'));
		$loop = 1; ?>

			  <section id="a-main">
          		<div class="a-page oracle-card-result page-oracle">
          			<div id="block-system-main" class="block block-system no-title" >  
					  <div class="row header-oracle">
					  <div class="column">
					    <h5 class="header-title-oracle">
					    <?php if(count($p_id_array) <= 3): ?>
					    	Past, present, future
						<?php else: ?>
							Situation or concern
						<?php endif; ?>
					    </h5>
					  </div>
					  <div class="column">
					    <ul class="inline-list list-func-reading">
					      <li class="func-new-reading"><a href="<?= get_home_url() . '/' . $exploadArray['of-afterLogin']; ?>">Start New Reading</a></li>
					      <li><a href="http://www.angeltherapy.com/oracle-cards"><img src="<?= plugins_url('of_card/of_card_front/images/icon_star_new_reading.png'); ?>" /></a></li>
					      <li><a href="#"><img src="<?= plugins_url('of_card/of_card_front/images/icon_audio.png'); ?>" /></a></li>
					    </ul>
					    <span style="display:none;" class="element-invisible"><div id="card_sound">Sound</div></span>
					<script>
					  (function ($){
					    $(document).ready(function (){
					      jwplayer("card_sound").setup({
					        file: "<?= plugins_url('of_card/of_card_front/images/card_sound.mp3'); ?>",
					        height: 1,
					        width: 1,
					        repeat : false,
					        mute:false,
					        autostart:true,
					        flashplayer: false,
					        html5player: "<?= plugins_url('of_card/of_card_front/jwplayer.html5.js'); ?>"
					      });
					    });
					  })(jQuery);
					</script>  </div>
					</div>
					<div class="row section-card-result">
						<ul class="card-result-pagi">
						 <?php for($i=1; $i <= count($p_id_array); $i+=1 ){ ?>
					      	 <?php if($i == 1){ ?>
					      	<li id="pagi-card-<?= $i; ?>" class="pagi-active"><a href="#card-<?= $i; ?>">&nbsp;</a></li>
					      	<?php }else{ ?>
					      	<li id="pagi-card-<?= $i; ?>"><a href="#card-<?= $i; ?>">&nbsp;</a></li>
					      	<?php } ?>

					     <?php } ?>
					    </ul>
					  <div class="column list-card-result">
					  <!-- Start While  -->
				<?php
					while($card_posts->have_posts()): 
						$card_posts->the_post(); 
						$thumb = wp_get_attachment_url(get_post_thumbnail_id());
				 	?>
					    <div class="card-result-item">
					    		<a href="#" id="card-<?= $loop; ?>"></a>
					    		<?php if(count($p_id_array) <= 3):  ?>
					            	<h5 class="card-result-title"><?= $headArray[$loop-1]; ?></h5>	
					        	<?php endif; ?>
					              <div class="flipper card-result-img">
							        <div class="front">
							        	<img class="image-style-card-detail" src="<?= get_home_url() . $get_of_backend_data[$_GET["b_id"]]; ?>" width="350" height="500" alt="" />
							        </div>
					        <div class="back">
					        	<img class="image-style-card-detail" src="<?= $thumb; ?>" width="350" height="500" alt="" />
					        </div>
					      </div>
					      <p class="card-result-name"><?php the_title(); ?></p>
					      <div class="card-result-content">
					        	<?php the_content(); ?>
						   </div>
						   <?php if(count($p_id_array) != $loop ){ ?>
						   <a href="#" class="card-result-readmore">&nbsp;</a>
						   <?php } ?>
					    </div>
					    <?php $loop +=1; endwhile; ?> 
					  </div>
					</div>
					  </div>
					  </div>
		</section>
				
		<?php endif; ?>
<?php 
get_footer();
?>
