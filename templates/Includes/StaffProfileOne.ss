<li class="$FirstLast $EvenOdd StaffProfileOne ">
	<% if ProfilePicture %><div class="StaffProfilePicture">$ProfilePicture.SetWidth(250)</div><% end_if %>
	<div class="StaffProfileText">
		<h2 class="StaffProfileName">$Name</h2>
		<p class="StaffProfileDescription">$Description</p>
		<% if EncodedEmailLink %><p class="StaffProfileEmail">Email: <a href="$EncodedEmailLink">$EncodedEmailText</a></p><% end_if %>
	</div>
</li>
