<h1>$Title</h1>
$Content
<% if StaffProfilesAll.count %>
<ul id="StaffProfiles">
	<% loop StaffProfilesAll %>
		<% include StaffProfileOne %>
	<% end_loop %>
</ul>
<% end_if %>
$Form