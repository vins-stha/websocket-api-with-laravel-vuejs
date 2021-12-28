@extends('layouts.app')
@section('content')
    <section class="navbar">
        <div class="nav-logo">
            RkPprCZor
        </div>
        <div class="menu">
            <h6 class="sm">Hello, {{$user['name']}}</h6>
            <h6><a class="sm" href="/">Change user</a></h6>
        </div>
    </section>
<div id="app">

   <div>
        <section class="statsContainer" id="app">
            <div class="mainStat">
                <!----------Present status of the user------------>
                <div class="newGame">
                    <h4>Game status for {{$user['name']}}</h4>
                    <table class="table table-striped table-dark">
                        <thead>
                        <tr>
                            <th scope="col">Rock</th>
                            <th scope="col">Paper</th>
                            <th scope="col">Scissors</th>
                            <th scope="col">Wins</th>
                            <th scope="col">Lost</th>
                            <th scope="col">Ties</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @if(is_array($user))
                                <td> {{$user['rock']}}</td>
                                <td>{{$user['paper']}}</td>
                                <td>{{$user['scissors']}} </td>
                                <td>{{$user['win']}}</td>
                                <td>{{$user['lost']}} </td>
                                <td>{{$user['tied']}} </td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>{{$user['gameCount']}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>W:L</td>
                            <td>{{$user['win']}}:{{$user['lost']}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Win %</td>
                            @php
                            $win = $user['win'];
                            $total = $user['gameCount'];
                            $winpc = $total >0 ? round(($win / $total *100), PHP_ROUND_HALF_UP) : 0;
                            @endphp
                            <td><?= $winpc ?>%</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        @endif
                        </tbody>
                    </table>
                </div>

                <!--------Game history------------>
                <div class="newGame">
                    <h4> Your game history</h4>
                    <div class="games" style="font-size: 10px">
                        <table class="table table-dark table-striped">
                            <thead>
                            <th scope="col">Game id:</th>
                            <th scope="col">Player A</th>
                            <th scope="col">Player B</th>
                            <th scope="col">Against</th>
                            <th scope="col">For</th>
                            <th scope="col">Results</th>
                            </thead>
                            <tbody>
                            @if($user['gameCount'] > 0)
                                @foreach($user['gamesPlayed'] as $game)

                                    <tr>
                                        <td>{{$game['gameId']}}</td>
                                        <td>{{$user['name']}}</td>
                                        <td>{{$game['with']}}</td>
                                        <td>{{$game['against']}}</td>
                                        <td>{{$game['for']}}</td>
                                        <td>{{$game['result']}}</td>

                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
        <rps></rps>
    </div>

</div>
@endsection

<script>
  var username = "{{$user['name']}}"
</script>
