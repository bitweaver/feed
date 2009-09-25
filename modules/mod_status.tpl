{literal}
<script type="text/javascript">

function showHideReplies( contentId , total , feedback ){

var hidden = document.getElementById('hidden_'+contentId);

if( hidden.style.display == 'none' ){
	hidden.style.display = 'block';
	feedback.innerHTML = 'Hide '+ total + ' replies';
}else{
	hidden.style.display = 'none';
	feedback.innerHTML = 'Show '+ total + ' replies';
}

}

</script>

{/literal}


{if $gBitUser->mUserId == $statuses.0.user_id}
	<form>
		<input type="text" name="feed_status"/>
		<input type="submit"/>
	</form>
{/if}

{foreach from=$statuses item='status'}
	<div style="margin-top:25px;clear:both;">
		{if $status.feed_icon_url}<img style="width:50px;height:50px;float:left;" src="{$status.feed_icon_url}" />{/if}
		<div style="width:250px;float:right;vertical-align:top;">
			{displayname hash=$status} {$status.data} <br/>
			<small>{$status.last_modified|date_format}</small>
			<div>
				{if !empty($status.replies_excess) }
				{* loop through all but the ones we want to be actually visible and place them in a collapsed div*}
				<div id="hidden_{$status.content_id}" style="display:none;">
				{foreach from = $status.replies_excess item='reply'}
					<div style="margin-top:10px;background-color:#eee;">
						{if $reply.feed_icon_url} <img style="width:25px;height:25px;float:left;" src="{$reply.feed_icon_url}"/> {/if}
						<div style="vertical-align:top;"> 
							{displayname hash=$reply} {$reply.data} <br/>
							<small>{$reply.last_modified|date_format}</small>
						</div>
					</div>
				{/foreach}
				</div>
				<a onclick="showHideReplies( {$status.content_id}, {$status.replies_excess|@count}, this );">Show {$status.replies_excess|@count} replies</a>
				{/if}
				{foreach from = $status.replies item='reply'}
					<div style="margin-top:10px;background-color:#eee;">
						{if $reply.feed_icon_url} <img style="width:25px;height:25px;float:left;" src="{$reply.feed_icon_url}"/> {/if}
						<div style="vertical-align:top;"> 
							{displayname hash=$reply} {$reply.data} <br/>
							<small>{$reply.last_modified|date_format}</small>
						</div>
					</div>
				{/foreach}
			</div>
			<form>
				<input type="text" value="write something..." onclick="this.value='';" name="comment_{$status.content_id}"/>
				<input style="width:25px;height:20px;" value="go" type="submit"/>
			</form>
		</div>
	</div>
{/foreach}
