@extends("layout_public")
@section("content")

<div class="text-blob">

  @if ($_ENV['LEAGUE'] == 'belles')
    <div class="alert alert-info">Dear Belles, the text below was written with the San Francisco Pinball Department in mind. Some of it will be relevant for you, some will not. I hope it's self-evident which is which. —Andreas</div>
  @endif

  <h2>Overview</h2>
  <p>To help Per not having to spend all Wednesday night typing in scores from league nights we have a mobile app for entering scores and viewing results.</p>
  <p>The app is a mobile website that allows you to:</p>
  <ul>
    <li>Enter game scores</li>
    <li>View results from current and previous league nights</li>
    <li>View current standings in the league</li>
  </ul>
  <p>Making software is hard, so we will still be using paper scoresheets as well. They'll function as a paper trail in case Andreas messed up when writing the software. <b>If you have any questions find Andreas and ask him</b>. Don't go to Per with questions about the mobile app.</p>
  <p>The app is a mobile website. <b>No download is necessary ahead of time.</b> Just show up with your phone and you're all set.</p>

  <h3>Player check in &amp; drawing groups</h3>
  <p>Player check in is <b>unchanged</b>. Go to the counter. Find your name. Add it to the bag.</p>
  <p>Groups are drawn as <b>normal</b>. Eric will yell out your name as it's drawn. Your group will get a paper scoresheet as normal.</p>

  <h3>Designate a scorekeeper</h3>
  <p><b>Designate a single scorekeeper for your group</b>. Anyone can view results, but you can avoid trouble by assigning a single person to enter scores for all your games.</p>

  <h3>Find your group in the app</h3>
  <p>Your scoresheet will look a little different. At the top  you will see a 4 or 5 letter "secret" code. Go to <a href="{{url('/')}}">{{url('/')}}</a> and type in the "secret" code in the text box.</p>

  <h3>Add players</h3>
  <p>At first your group will look empty. It will just display a dropdown with all players. Use the dropdown to <b>add players in the same order as on your scoresheet</b>. Order matters as the first player selected will be picking the first game.</p>
  <p>If you make a mistake you can remove players until the first game has been picked.</p>
  <p>If you are in a three person group, pick only three players. Then choose your first game. Whoever has the worst score after 3 machines gets to pick the 4th machine.</p>
  <p>Whoever has the worst score after 4 machines gets to pick the 5th machine.</p>

  <h3>Choose a game</h3>
  <p>After you have selected all players in your group you can scroll down and pick the first game. There is a dropdown with all functional games as Free Gold Watch.</p>

  <p>The player whose turn it is picks a game. The scorekeeper uses the dropdown to find the game. This will take him or her to the results page.</p>

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
