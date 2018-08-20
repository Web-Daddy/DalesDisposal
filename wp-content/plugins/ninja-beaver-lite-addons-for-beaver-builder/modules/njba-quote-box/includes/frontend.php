
<div class="njba-quote-box-main  layout-<?php echo $settings->quotebox_layout; ?>">
  	<div class="njba-quote-box-inner">
  		 
		<?php
		$layout = $settings->quotebox_layout;
			switch ( $layout ) {
				case '1':
						echo '<div class="njba-quote-box">';
							echo '<div class="njba-quote-post">';
								 echo ' <div class="njba-quote-post-name">';
									 		$module->profile_name(); 
									 		$module->profile_designation();
								 echo '</div>';
							echo '</div>';
							echo '<div class="njba-quote-box-content">';
							 		$module->profile_content();
							echo '</div>';	
									$module->left_quotesign(); 
									$module->right_quotesign(); 
						echo '</div>';
				break;
				case '2':
						echo '<div class="njba-quote-box">';
							echo '<div class="njba-quote-box-content">';
							 		$module->profile_content();
							echo '</div>';	
							echo '<div class="njba-quote-post">';
								 echo ' <div class="njba-quote-post-name">';
									 		$module->profile_name(); 
									 		$module->profile_designation();
								 echo '</div>';
							echo '</div>';
									$module->left_quotesign(); 
									$module->right_quotesign(); 
						echo '</div>';
				break;
				case '3':
						echo '<div class="njba-quote-box">';
							$module->left_quotesign(); 
							echo '<div class="njba-quote-box-content">';
									echo ' <div class="njba-quote-post-name">';
									 		$module->profile_name(); 
									 		$module->profile_designation();
									 echo '</div>';
							 		$module->profile_content();
							echo '</div>';	
							$module->right_quotesign(); 
						echo '</div>';
				break;
				case '4':
						echo '<div class="njba-quote-box">';
							echo '<div class="njba-quote-post">';
									$module->profile_image();
								 echo ' <div class="njba-quote-post-name">';
									 $module->profile_name(); 
									 $module->profile_designation();
								 echo '</div>';
							echo '</div>';
									$module->right_quotesign(); 
							echo '<div class="njba-quote-box-content">';
							 		$module->profile_content();
							echo '</div>';
						echo '</div>';
				break;
				case '5':
						echo '<div class="njba-quote-box">';
							$module->right_quotesign(); 
							echo '<div class="njba-quote-post">';
									$module->profile_content();
									$module->profile_name(); 
									$module->profile_designation();
							echo '</div>';
							$module->profile_image();
						echo '</div>';
				break;
				case '6':
						 echo '<div class="njba-quote-box">';
							echo '<div class="njba-quote-post">';
									$module->profile_image();
									echo '<div class="njba-quote-post-name">';
			                                $module->profile_name(); 
											$module->profile_designation();
			                        echo '</div>';
							echo ' <div class="njba-separator-arrow"></div>';		
							echo '</div>';
							
							
							echo '<div class="njba-quote-box-content">';
									$module->profile_content();
							echo '</div>';
							$module->right_quotesign();
						echo '</div>';
				break;
				case '7':
						echo '<div class="njba-quote-post">';
								$module->profile_image();
								echo '<div class="njba-quote-post-name">';
		                                $module->profile_name(); 
										$module->profile_designation();
		                        echo '</div>';
								echo ' <div class="njba-separator-arrow"></div>';		
						echo '</div>';
						echo '<div class="njba-quote-box">'; 
							echo '<div class="njba-quote-box-content">';
									$module->profile_content();
							echo '</div>';
							$module->left_quotesign();
						echo '</div>';
				break;
				case '8':
						echo '<div class="njba-quote-box">'; 
							echo '<div class="njba-quote-post">';
								echo '<div class="njba-quote-post-image-box">';
											$module->left_quotesign();
											$module->profile_image();
								echo '</div>';
									echo '<div class="njba-quote-post-name">';
			                                	$module->profile_name(); 
												$module->profile_designation();
			                        echo '</div>';
									echo ' <div class="njba-separator-arrow"></div>';			
							echo '</div>';
							
							echo '<div class="njba-quote-box-content">';
										$module->profile_content();
							echo '</div>';
								
						echo '</div>';
				break;
				case '9':
						echo '<div class="njba-quote-box">';
							echo '<div class="njba-separator-arrow"></div>';
							$module->left_quotesign(); 
							echo '<div class="njba-quote-box-content">';
									$module->profile_content();
									echo ' <div class="njba-quote-post-name">';
									 		$module->profile_name(); 
									 		$module->profile_designation();
									echo '</div>';
							echo '</div>';
							
							$module->right_quotesign(); 
						echo '</div>';
				break;
				case '10':
						echo '<div class="njba-quote-box">';
							echo '<div class="njba-quote-box-shep-main"></div>';
							echo '<div class="njba-separator-arrow"></div>';
							$module->left_quotesign(); 
							echo '<div class="njba-quote-box-content">';
									$module->profile_content();
									echo ' <div class="njba-quote-post-name">';
									 		$module->profile_name(); 
									 		$module->profile_designation();
									echo '</div>';
							echo '</div>';
							
							$module->right_quotesign(); 
						echo '</div>';
				break;
				case '11':
						echo '<div class="njba-quote-box">';
							
							echo '<div class="njba-quote-box-content">';
									
									echo ' <div class="njba-quote-post-name">';
									 		$module->profile_name(); 
									 		$module->profile_designation();
									echo '</div>';
									echo '<div class="njba-quote-box-content-inner">';
										$module->left_quotesign(); 
										$module->profile_content();
										$module->right_quotesign(); 
									echo '</div>';
									
							echo '</div>';
							
							
						echo '</div>';
				break;
				
			}
		 ?>
	</div><!--njba-quote-box-inner-->	
</div><!--njba-quote-box-main-->
				 
                    
                       
