<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<% if $Thumbnail %>
				$Thumbnail.SetWidth(200)
			<% end_if %>
			<span class="position">$Position</span>
			<span class="phone">$Phone</span>
			<% if $EmailLink %>
			<a href="$EmailLink" class="contact" rel="nofollow">Contact</a>
			<% end_if %>
			$Content
		</div>
	</article>
	$Form
	$PageComments
</div>