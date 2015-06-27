<?php 
    global $ultimatemember;
    $user_stuff = $ultimatemember->user->usermeta;
    
    $complete_profile = $user_stuff['first_name'][0];
    $loan_statements = $user_stuff['are_loans_submitted'][0];
    $student_account_summary = $user_stuff['is_summary_submitted'][0];    
    $transcripts =  $user_stuff['are_transcripts_submitted'][0];
    $agreed_terms = $user_stuff['agreed_terms'][0];
    $paid_application = $user_stuff['paid_app_fee'][0];
    $highschool= $user_stuff['are_529forms_submitted'][0];
    
    echo '<div class="">';
    echo '<h4>Complete your Gradline</h4>';
    if ($complete_profile){
        echo '<p class="um-faicon-check-square-o completed">Profile is complete!</p>';
    } else {
        echo '<p class="um-faicon-square-o">Complete your Profile</p>';    
    }
	/*
    if ($transcripts == 'true'){
        echo '<p class="um-faicon-check-square-o completed">Transcripts were submitted!</p>';
    } else {
        echo '<p class="um-faicon-square-o">Submit your Transcripts</p>';    
    }
	*/
	/*
    if ($student_account_summary == 'true'){
        echo '<p class="um-faicon-check-square-o completed">Student Account Summary was submitted!</p>';
    } else {
        echo '<p class="um-faicon-square-o">Submit your Student Account Summary</p>';    
    }
	*/
    if ($loan_statements == 'true'){
        echo '<p class="um-faicon-check-square-o completed">Loan Statements were submitted!</p>';
    } else {
        echo '<p class="um-faicon-square-o">Submit your Loan Statements</p>';    
    }
    if ($agreed_terms == 'true'){
        echo '<p class="um-faicon-check-square-o completed">You agreed to the Terms!</p>';
    } else {
        echo '<p class="um-faicon-square-o">Agree to Terms and Conditions</p>';    
    }
	/*
    if ($paid_application == 'true'){
        echo '<p class="um-faicon-check-square-o completed">Application Fee is paid!</p>';
    } else {
        echo '<p class="um-faicon-square-o">Pay Application Fee</p>';    
    }
	*/
    if ($highschool == 'true'){
        echo '<p class="um-faicon-check-square-o completed">You submitted your 529 forms!</p>';
    } else {
        echo '<p class="um-faicon-square-o">Please submit 529 forms if in high school</p>';    
    }
    echo '</div>';

	
    include '_widget.php';
    echo '</div>';

?>
