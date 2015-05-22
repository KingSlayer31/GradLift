	<?php foreach( $ultimatemember->shortcodes->loop as $comment ) { ?>
<li id="comment-<?php echo $comment->comment_ID; ?>" class="um-itemn comment">
			<div class="um-item-link"><i class="um-icon-chatboxes"></i><a href="<?php echo get_comment_link( $comment->comment_ID ); ?>"><?php echo get_comment_excerpt( $comment->comment_ID ); ?></a></div>
			<div class="um-item-meta">
				<span><?php printf(__('From %1$s','ultimatemember'), $comment->comment_author ); ?></span>
			</div>
		</li>
		
	<?php } ?>
	
	<?php if ( isset($ultimatemember->shortcodes->modified_args) && count($ultimatemember->shortcodes->loop) >= 10 ) { ?>
	
		<div class="um-load-items">
			<a href="#" class="um-ajax-paginate um-button" data-hook="um_load_comments" data-args="<?php echo $ultimatemember->shortcodes->modified_args; ?>"><?php _e('load more comments','ultimatemember'); ?></a>
		</div>
		
	<?php } ?>
