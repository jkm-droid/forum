@component('mail::message')
    Hello {{ ucfirst($details['topic_author']) }},

{{--    @component('mail::subcopy')--}}
        You have a new notification. <strong>{{ ucfirst($details['message_author']) }}</strong> reacted to your post <strong>{{ $details['post_title'] }}</strong>.<br>

        Please do not reply to this message. You must visit the forum to reply.<br>

        Kindest regards,<br>
        The Forum
{{--    @endcomponent--}}
@endcomponent
