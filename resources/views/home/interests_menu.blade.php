<nav class="custom-tab">
    <ul>
        <li class='{{ (isset($tab) && $tab=="Favorites")?"active":"" }}'><a href="{{url("/User/Favorites")}}">My favorites</a></li>
        <li class='{{ (isset($tab) && $tab=="ViewedMe")?"active":"" }}'><a href="{{url("/User/ViewedMe")}}">Viewed me</a></li>
        <li class='{{ (isset($tab) && $tab=="FavoritedMe")?"active":"" }}'><a href="{{url("/User/FavoritedMe")}}">Favorited me</a></li>
    </ul>
</nav>