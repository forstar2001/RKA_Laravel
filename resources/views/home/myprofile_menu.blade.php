<nav class="custom-tab">
    <ul>
        <li class='{{ (isset($tab) && $tab=="BasicProfile")?"active":"" }}'><a href="{{url("/User/BasicProfile")}}">Basic Info</a></li>
        <li class='{{ (isset($tab) && $tab=="FitnessInfo")?"active":"" }}'><a href="{{url("/User/FitnessInfo")}}">Fitness Info</a></li>
        <li class='{{ (isset($tab) && $tab=="PersonalInfo")?"active":"" }}'><a href="{{url("/User/PersonalInfo")}}">Personal Info</a></li>
        <li class='{{ (isset($tab) && $tab=="Photos")?"active":"" }}'><a href="{{url("/User/Photos")}}">Photos</a></li>
        <li class='{{ (isset($tab) && $tab=="LocationInfo")?"active":"" }}'><a href="{{url("/User/LocationInfo")}}">Location Info</a></li>
        <li class='{{ (isset($tab) && $tab=="Description")?"active":"" }}'><a href="{{url("/User/Description")}}">Your Description</a></li>
    </ul>
</nav>