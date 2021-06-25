@component('mail::message')
<center><img src="{{Storage::disk('uploads')->url($mailData['setting']->headerImage)}}" style="max-width: 200px; margin-bottom: 2rem;"></center>

<center style="font-size: 2rem; font-weight:bold; margin-bottom: 1.5rem;">{{$mailData['menuitem']->title}}({{$mailData['menuitem']->quantity}} {{$mailData['menuitem']->unit}})</center>

<img src="{{Storage::disk('uploads')->url($mailData['menuitemimage']->filename)}}" alt="{{$mailData['menuitem']->title}}" style="max-width: 100%;">

@component('mail::button', ['url' => $mailData['url'], 'color' => 'green'])
    Take a look at the Item.
@endcomponent
@endcomponent
