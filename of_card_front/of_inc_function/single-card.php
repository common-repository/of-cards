<?php
get_header();
?>
<?php 
	if(have_posts()):
		$get_of_backend_data = explode(',', get_option('of_card_backend'));
	 	$get_reading_data = get_option('card_get_read');
	 	
	 	$get_data_explode = explode(';', $get_reading_data);
    		$exploadArray = array();
    		foreach($get_data_explode as $single_ex):
    			$seconExpload = explode('=', $single_ex);
    			$exploadArray[$seconExpload[0]] = 	$seconExpload[1];
    		endforeach;
		while(have_posts()):
				the_post(); 
				$thumb = wp_get_attachment_url(get_post_thumbnail_id());
				 ?>
			  <section id="a-main">
          		<div class="a-page oracle-card-result page-oracle">
          			<div id="block-system-main" class="block block-system no-title" >  
  
					  <div class="row header-oracle">
					  <div class="column">
					    <h5 class="header-title-oracle">Simple Reading</h5>
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
					  <div class="column list-card-result">
					    <div class="card-result-item">
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
					    </div>
					  </div>
					</div>
					  </div>
					  </div>
		</section>
				<?php 
		endwhile;
	endif;
?>

<?php 
get_footer();
?>
