<h5>Username: {{ $user->username }}</h5>
<h6>Email: {{ $user->email }}</h6>
<h6>Status: {{ $user->level }}</h6>
<h6>Joined: {{ $user->created_at }}</h6>
<table class="table table-responsive profile-section">
    <thead>
    <tr>
        <th>Messages</th>
        <th>Likes</th>
        <th>Rating</th>
        <th>Score</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            {{ $user->messages->count() }}
        </td>
        <td>25</td>
        <td>{{ $user->rating }}%</td>
        <td>
            {{ $user->score }}
        </td>
    </tr>
    </tbody>
</table>
