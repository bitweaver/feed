<form>
	<input type="text" name="feed_status"/>
	<input type="submit"/>
</form>

{foreach from=$statuses item='status'}
	<div style="margin-top:25px;clear:both;">
		{if $status.feed_icon_url}<img style="width:50px;height:50px;float:left;" src="{$status.feed_icon_url}" />{/if}
		<div style="width:250px;float:right;vertical-align:top;">
			{displayname hash=$status} {$status.data} <br/>
			<small>{$status.last_modified|date_format}</small>
			<div>
				{foreach from = $status.replies item='reply'}
					<div style="margin-top:10px;">
						{if $reply.feed_icon_url} <img style="width:25px;height:25px;float:left;" src="{$reply.feed_icon_url}"/> {/if}
						<div style="vertical-align:top;"> 
							{displayname hash=$reply} {$reply.data} <br/>
							<small>{$reply.last_modified|date_format}</small>
						</div>
					</div>
				{/foreach}
			</div>
			<form>
				<input type="text" name="comment_{$status.content_id}"/>
				<input style="width:25px;height:20px;" value="go" type="submit"/>
			</form>
		</div>
	</div>
{/foreach}
