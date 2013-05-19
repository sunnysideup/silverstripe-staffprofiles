<% if ProfilePicture %><div class="StaffProfilePicture">$ProfilePicture.SetWidth(250)</div><% end_if %>
<h1>$Title - $Position</h1>
$Content
<% if EncodedEmailLink %><p class="StaffProfileEmail">Email: <a href="$EncodedEmailLink">$EncodedEmailText</a></p><% end_if %>
<p class="backToMainPage"><a href="$Parent.Link">back to $Parent.Title</a>
