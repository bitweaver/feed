<div class="span-8" style="margin-top:10px;">
	{foreach from=$actions item='action'}
		<div>
			{*{$action.icon}*} {$action.real_log} on {$action.last_modified|date_format}
		</div>
	{/foreach}
</div>
