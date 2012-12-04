<h1>$Title</h1>
$Content
<% if StaffProfilesAll %>
<ul id="StaffProfiles">
	<% control StaffProfilesAll %>
		<% include StaffProfileOne %>
	<% end_control %>
</ul>
<% end_if %>
$Form