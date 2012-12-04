<li class="$FirstLast $EvenOdd StaffProfileOne ">
	<% if ProfilePicture %><div class="StaffProfilePicture">$ProfilePicture.SetWidth(250)</div><% end_if %>
	<div class="StaffProfileText">
		<h2 class="StaffProfileName">$Name</h2>
		<p class="StaffProfileDescription">$Description</p>
		<% if EmailObfuscator %><p class="StaffProfileEmail">Email: $EmailObfuscator</p><% end_if %>
	</div>
</li>