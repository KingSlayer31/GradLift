// (function($) {

    jQuery(document).ready(function($){

        $('#main-menu li.green').remove();

        jQuery(document).on('click', '.um-profile-save', function(e){
            e.preventDefault();
            e.stopImmediatePropagation()
            e.stopPropagation();
            jQuery(this).parents('form').submit();
            return false;
        });

        /* ------------------------------------------------------------------------------
        -------------- !! Ignition Deck Lightbox Stuff !! ----------------------
        ------------------------------------------------------------------------------ */
        // add price buttons to lightbox form
         var button_html = '<div class="btn-levels-container">';
         var prices = [25, 50, 75, 100, 250, 500, 999];
         $.each(prices, function(index, value){
            var html = '<div><button class="btn-levels" data-value="'+value+'">$'+value+'</button></div>';
            button_html += html;
         });
         button_html += '</div>';
         $('.idc_lightbox .form').prepend(button_html);
         
        $('.id-product-infobox .main-btn').on('click', function(){
            var $total_input = $('#total');
            var level_amount = $total_input.val();
            var $lightbox_container = $('.idc_lightbox').not('.mfp-hide');
            
            // if there are levels then change the layout
            if ( !level_amount ) {
                $('.idc_lightbox').addClass('alternative-lightbox');
            } 

            // when you click the buttons change the input value            
            $('.btn-levels').on('click', function(){
                $('.chosen-level-btn').removeClass('chosen-level-btn');
                $(this).addClass('chosen-level-btn');
                var amount = $(this).attr('data-value');
                $('#total').val(amount);
            });

            // when you change the input manually remove the button selections
            $('.total').on('keyup', function(){
                $('.chosen-level-btn').removeClass('chosen-level-btn');
            });

        });

        /* ------------------------------------------------------------------------------
        ---------------- !! ENABLE BOXIT STUFF !! ----------------------------
        ----------------------------------------------------------------------------- */
        $('#boxit-holder').hide();
        var user_meta;

        $('.boxit-container').click(function(){
            var $parent = $(this).parent();
            var parent_class = $parent.attr('class');

            if (parent_class === 'gradlift-transcripts') {
                $('#boxit-holder h5').html('Upload your Transcripts');
                $('#boxit-holder').show();
                user_meta = 'transcripts';
            }
            if (parent_class === 'gradlift-summary') {
                $('#boxit-holder h5').html('Upload your Summary');
                $('#boxit-holder').show();
                user_meta = 'summary';
            }
            if (parent_class === 'gradlift-loans') {
                $('#boxit-holder h5').html('Upload your Loans');
                $('#boxit-holder').show();
                user_meta = 'loans';
            }
        });

        $('.boxit-cancel-btn').click(function(){
            $('#boxit-holder').hide();
        })

        /* ------------------------------------------------------------------------------
        ---------- !! UPDATING PROFILE/BOXIT STUFF !! -----------------
        ----------------------------------------------------------------------------- */
        var upload_interval;

        function update_gradlift(user_data){
            // user_meta comes from boxit uploads
            // otherwise we just pass it through when directly calling this function
            if (user_meta) {
                user_data = user_meta;
            }
            // this post url variable is declared in the functions.php file
            $.post(gradlift_ajax.ajaxurl, {
                'action': 'update_gradlift',
                'user_data':  user_data
            }, function(response){
                    // alert('The server responded: ' + response);
            })
        };

        function check_upload(){
            var dropbox_status_attr = $('#boxit').attr('data-files');
            var dropbox_status;
            var number_of_files = 0;

            if (dropbox_status_attr) {
                var dropbox_status = JSON.parse(dropbox_status_attr);
                var number_of_files = dropbox_status.length;                
            } else {
                setTimeout(check_upload, 2000);
            }
            
            if (number_of_files > 0) {
                $.each(dropbox_status, function(index, value){
                    if (value.percent == 100) {
                        update_gradlift('transcripts');
                        return false;
                    }
                })
            }
        }

        $('#boxit_start_upload').click(function(){
            setTimeout(check_upload, 3000);
        });

        $('input[name="transcript-upload"]').change(function(){
            if( $(this).val() == 'true') {
                update_gradlift('transcripts');
            }
        });

        $('#terms-button').click(function(){
            update_gradlift('terms');
            $(this).fadeOut();
        });

    });
// });