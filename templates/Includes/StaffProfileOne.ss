<li class="$FirstLast <% if Odd %>oddPos<% else %>evenPos<% end_if %> StaffProfileOne ">
    <% if ProfilePicture %><div class="StaffProfilePicture">$ProfilePicture.SetWidth(250)</div><% end_if %>
    <div class="StaffProfileText">
        <h4 class="StaffProfileName">$Name</h4>
        <p class="StaffProfileDescription">$Description</p>
        <% if EncodedEmailLink %><p class="StaffProfileEmail">Email: <a href="$EncodedEmailLink">$EncodedEmailText</a></p><% end_if %>
    </div>
</li>
