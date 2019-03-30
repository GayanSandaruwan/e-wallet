
@component('mail::message')


    @component('mail::button', ['url'=>$url])
        View Goals
        @endcomponent

    some of your goals can be achieved

    @foreach($goals as $goal)
            {{$goal}}
        @endforeach
    Thanks,

        {{ config('app.name') }}
    @endcomponent
