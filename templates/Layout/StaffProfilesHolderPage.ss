<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
	</article>xxxxx $CurrentCategoryID
	<% if $Categories %>
	<nav class="categories">
		<ul>
			<li><a href="{$Top.Link()}" <% if $CurrentCategoryID == 0 %>class="selected"<% end_if %> title="View all categories">All</a></li>
			<% loop $Categories %>
			<li><a href="{$Top.Link(category)}/{$URLSegment}" <% if $ID == $Top.CurrentCategoryID %>class="selected"<% end_if %> title="View {$Title.XML} category">$Title</a></li>
			<% end_loop %>
		</ul>
	</nav>
	<% end_if %>
	<% if $StaffProfiles %>
	<section class="listing">
		<% loop $StaffProfiles %>
		<article class="summary">
			<h3>$Title</h3>
			<% if $Thumbnail %>
				<a href="$Link" title="$Title.XML">$Thumbnail.SetWidth(200)</a>
			<% end_if %>
			<p>$Content.FirstParagraph() <a href="$Link" title="$Title.XML"><% _t('StaffProfilesHolderPage_ss.VIEW','View') %></a></p>
		</article>
		<% end_loop %>
	</section>
	<% end_if %>
	$Form
	$PageComments
</div>