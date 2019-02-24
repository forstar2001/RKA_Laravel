<nav class="custom-tab">
    <ul>
        <li class='{{ (isset($tab) && $tab=="AccountSettings")?"active":"" }}'><a href="{{url("/User/Settings")}}">Account settings</a></li>
        <li class='{{ (isset($tab) && $tab=="Notifications")?"active":"" }}'><a href="#">Notifications</a></li>
        <li class='{{ (isset($tab) && $tab=="HiddenMembers")?"active":"" }}'><a href="#">Hidden Members</a></li>
        <li class='{{ (isset($tab) && $tab=="BlockedMembers")?"active":"" }}'><a href="#">Blocked Members</a></li>
        <li class='{{ (isset($tab) && $tab=="PaymentSettings")?"active":"" }}'><a href="#">Payment Settings</a></li>
    </ul>
</nav>