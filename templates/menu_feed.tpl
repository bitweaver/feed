{strip}
<ul>
	{if $gBitUser->hasPermission( 'p_feed_master' )}
		<li><a class="item" href="{$smarty.const.FEED_PKG_URL}index.php">{booticon iname="icon-comment" iexplain="`$smarty.const.FEED_PKG_NAME` Activity" ilocation=menu}{tr}Recent Activity{/tr}</a></li>
	{/if}
</ul>
{/strip}
