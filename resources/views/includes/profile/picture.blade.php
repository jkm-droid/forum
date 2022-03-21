<a href="{{ route('profile.show.edit', $user->user_id) }}" class="put-black" data-bs-toggle="tooltip"
   data-bs-placement="top" title="click to change avatar">
    <img class="img-fluid profile-image-mobile" src="/profile_pictures/{{ $user->profile_url }}" alt="">
</a>
<span class="disappear-item">
    @include('includes.forum_list')
</span>
