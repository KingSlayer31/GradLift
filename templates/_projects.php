<?php 
    global $ultimatemember;
    $user_stuff = $ultimatemember->user->usermeta;

    // $complete_profile = $user_stuff['are_transcripts_submitted'][0];

    $loan_statements = $user_stuff['are_loans_submitted'][0];
    $loan_message = $user_stuff['loan_message'][0];

    $student_account_summary = $user_stuff['is_summary_submitted'][0];
    $account_summary_message = $user_stuff['summary_message'][0];
    
    $transcripts =  $user_stuff['are_transcripts_submitted'][0];
    $transcripts_message =  $user_stuff['transcripts_message'][0];
    
    $agreed_terms = $user_stuff['agreed_terms'][0];
    $paid_application = $user_stuff['paid_app_fee'][0];
    
	$transcript_text = '<p>Official Transcripts must be sent to GradLift for any schooling/tuition that you are looking to fund here. Transcript fees are separate from GradLift. Transcripts can be requested directly from your academic institution and must be sent to this mailing address:</p>
	
		<p>GradLift, Inc.<br>
		Ph 818-268-4244<br>
		Attn: Validation Dept<br>
		PO BOX 6920<br>
		Woodland Hills, CA 91365</p>
		
		<p>GRADLIFT WILL GIVE YOU $5 TOWARDS YOUR SCHOLARSHIP ONCE YOUR PROFILE IS VALIDATED!</p>';

    
    // $to_update['are_transcripts_submitted'] = 'false';
    // $ultimatemember->user->update_profile( $to_update );

    echo '<div class="gradline-container macho">';
        echo '<div class="gradline-main">';
            echo '<h4>Your GradLine</h4>';
            // you can only have one boxit instance per page
            echo '<div id="boxit-holder"><section>';
                echo '<header>';
                    echo '<h5 class="boxit-header"></h5>';
                    echo '<span class="um-faicon-times-circle boxit-cancel-btn"></span>';
                echo '</header>';
                echo do_shortcode('[boxit]');
            echo '</section></div>';

/*
            echo '<div class="gradlift-transcripts">';
                echo '<h5>Transcripts</h5>';
                if ($transcripts_message){
                    echo '<p class="message"><span class="um-faicon-exclamation-circle">' . $transcripts_message . '</span></p>';
                } else {
                    if ($transcripts) {
                        echo '<p class="message">We are reviewing your transcripts and will contact you if we need further documentation.</p>';
                    }                    
                }
                echo $transcript_text;
                echo '<div class="transcript-radio-holder">';
                    echo '<header>Did you request your transcripts already?</header>';
                    echo '<label>';
                        echo '<span>No</span>';
                        echo '<input type="radio" value="false" name="transcript-upload">';
                    echo '</label>';
                
                    echo '<label>';
                        echo '<span>Yes</span>';
                        if ($transcripts) {
                            echo '<input type="radio" value="true" name="transcript-upload" checked="checked">';
                        } else {
                            echo '<input type="radio" value="true" name="transcript-upload">';
                        }
                    echo '</label>';
                echo '</div>';
                //echo '<div class="boxit-container">';
                //echo '<div class="boxit-button">Click here to upload Loans</div>';
                //echo '</div>';
            echo '</div>';
            
*/
            
			/*
            echo '<div class="gradlift-summary">';
                echo '<h5>Student Account Summary</h5>';
                if ($account_summary_message){
                    echo '<p class="message"><span class="um-faicon-exclamation-circle">' . $account_summary_message . '</span></p>';
                } else {
                    if ($student_account_summary) {
                        echo '<p class="message">We are reviewing your Account Summary and will contact you if we need further documentation.</p>';
                    }                    
                }
                echo '<p>Depending on your school you can usually retrieve your student account summary through your student website. If you are having trouble finding it, you can call your schools student help line for help.</p>';
                echo '<div class="boxit-container">';
                echo '<div class="boxit-button">Click here to upload Summary</div>';
                echo '</div>';
            echo '</div>';
			*/
            
            
            echo '<div class="gradlift-loans">';
                echo '<h5>Student Loan Documents</h5>';
                if ($loan_message){
                    echo '<p class="message"><span class="um-faicon-exclamation-circle">' . $loan_message . '</span></p>';
                } else {
                    if ($loan_statements) {
                        echo '<p class="message">We are reviewing your Loan Documents and will contact you if we need further documentation.</p>';
                    }                    
                }
                echo '<p>Upload your current student loan statements here. Numerous files are ok if you have multiple loans.</p>';
                echo '<div class="boxit-container">';
                echo '<div class="boxit-button">Click here to upload Loans</div>';
                echo '</div>';
            echo '</div>';
            echo '<div class="gradlift-terms">';
                echo '<h5>Accept the Terms and Conditions</h5>';
                if($agreed_terms == "true") {
                    echo '<p>You have already accepted our <a href="' . get_site_url() . '/terms-of-service/" target="_blank">Terms and Conditions</a>.</p>';
                } else {
                    echo '<p>You know we have to mention all the legal stuff. Click the link below to accept the terms.</p>';
					echo '<div class="alt-profilebutton-container">';
                    echo '<a class="boxit-button" href="' . get_site_url() . '/terms-of-service/" target="_blank">Agree to Terms and Conditions</a>';
					echo '</div>';
                    
                }
            echo '</div>';
			/*
            echo '<div class="gradlift-fee">';
                echo '<h5>Pay $25 Application Fee</h5>';                
                if($paid_application == "true") {
                    echo '<p>Your application fee has been paid already!</p>';
                } else {
                    echo '<p>Before your campaign goes live we charge a $25 application fee. You can pay securely with Stripe.</p>';
                    include '_stripe.php';
                }
            echo '</div>';
			*/

        echo '</div>';

        echo '<div class="gradline-sidebar">';
            include '_projects_sidebar.php';
        echo '</div>';

    echo '</div>';

echo '<br style="clear:both">';

?>