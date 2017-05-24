<% if $StaffProfilesAll %>
<ul id="StaffProfiles">
    <% loop $StaffProfilesAll %>
        <% include StaffProfileOne %>
    <% end_loop %>
</ul>
<% end_if %>
