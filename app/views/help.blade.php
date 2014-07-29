@extends("layout")
@section("title")
  SFPD Help
@stop
@section("content")

@if (!Auth::check())
<div class="navbar navbar-default">
  <div class="navbar-inner">
    <a class="navbar-brand" href="{{ url('/') }}"><img src="/img/logo64.png" alt="SFPD" width="32" height="32"></a>
    <ul class="nav navbar-nav">

      <li class="{{ substr(Request::path(), 6, 8) == 'players' ? 'active' : '' }}">
        <a href="{{ url('/') }}">Go Back</a>
      </li>

    </ul>
  </div>
</div>
@endif

<div class="text-blob">
  <h2>Overview</h2>
  <p>To help Per not having to spend all Wednesday night typing in scores from league nights we're introducing a mobile app this season for entering scores and viewing results.</p>
  <p>The app is a mobile website that allows you to:</p>
  <ul>
    <li>Enter game scores</li>
    <li>View results from the current and previous league nights</li>
    <li>View the current standings in the league</li>
  </ul>
  <p>Making software is hard, so we will still be using paper scoresheets as well. They'll function as a paper trail in case Andreas messed up when writing the software. <b>If you have any questions find Andreas and ask him</b>. Don't go to Per with questions about the mobile app.</p>
  <p>The app is a mobile website. <b>No download is necessary ahead of time.</b> Just show up with your phone and you're all set.</p>

  <h3>Player checkin &amp; drawing groups</h3>
  <p>Player checkin is <b>unchanged</b>. Go to the counter. Find your name. Add it to the bag.</p>
  <p>Groups are drawn as <b>normal</b>. Eric will yell out your name as it's drawn. Your group will get a paper scoresheet as normal.</p>

  <h3>Designate a scorekeeper</h3>
  <p><b>Designate a single scorekeeper for your group</b>. Anyone can view results, but you can avoid trouble be assigning a single person to enter scores for all your games.</p>

  <h3>Find your group in the app</h3>
  <p>Your scoresheet will look a little different. On the right hand side you will find a QR-code (one of those square barcode things) and below it a 4 or 5 letter "secret" code.</p>
  <p>You can use either to find your group in the app. If you have a QR Reader app simply scan the QR code and the app will open and display your group.</p>
  <p>If you don't have a QR Reader app on your phone go to <a href="{{url('/')}}">{{url('/')}}</a> and type in the "secret" code in the text box.</p>

  <h3>Add players</h3>
  <p>At first your group will look empty. It will just display a dropdown with all players. Use the dropdown to <b>add players in the same order as on your scoresheet</b>. Order matters as the first player selected will be picking the first game.</p>
  <p>If you make a mistake you can remove players until the first game has been picked.</p>
  <p>If you are in a three person group only pick three players. Then choose your first game.</p>

  <h3>Choose a game</h3>
  <p>After you have selected all players in your group you can scroll down and pick the first game. There is a dropdown with all functional games as Free Gold Watch. Beware that you may not be eligible to pick all of these games. <b>Only pick games in your assigned section!</b></p>

  <p>The play who's turn it is picks a game. The scorekeeper uses the dropdown to find the game and clicks the "Pick game" button. This will take him or her to the results page.</p>

  <h3>Enter results</h3>
  <p>After the game has ended use the dropdowns to select the finishing <b>position</b> for each player. Click the save button when you're done.</p>
  <p>If you had fat fingers and picked the wrong game use the "Remove game" button to remove the game and pick a new one.</p>
  <p>After you save the results you are taken back to the previous page. Now you can view the results of the games finished so far and pick the next game.</p>

  <h3>Fixing mistakes</h3>
  <p>If you mistakenly enter the wrong results you can use the "edit" link to go back and change the results on a specific game.</p>

  <h3>Viewing overall results and standings</h3>
  <p>You can use the "Results" and "Standings" links in the menu to view individual results and overall standings respetively.</p>

  <h3>Add the app to your home screen</h3>
  <p>For easy access you can add the SFPD app to your home screen. You'll get to display the awesome SFPD logo to all your friends.</p>
</div>
@stop
