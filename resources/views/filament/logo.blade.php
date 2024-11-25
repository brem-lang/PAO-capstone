@guest
    <img id="logo-img" src="{{ asset('/images/logo.png') }}" alt="logo"
        style="height: 70px;position:relative;margin-top: -20px;">

    <span style="font-weight:bold;font-size:14px;margin-left:5px;margin-top:5px">Public Attorney's Office</span>
@endguest
@auth
    <img id="logo-img" src="{{ asset('/images/logo.png') }}" alt="logo"
        style="height: 50px;position:relative;margin-top: -13px;">

    <span style="margin-left:5px;font-weight:bold;font-size:13px;margin-top:3px">Public Attorney's Office</span>
@endauth
