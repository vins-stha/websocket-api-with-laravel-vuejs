<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    //
    public  $user = array();
    public $gamePlayed = array();

    public function index()
    {
        return view('index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function login (Request $request)
    {
        $this->user['gameCount']  = 0;
        $this->user['tied']  = 0;
        $this->user['win']  = 0;
        $this->user['lost']  = 0;

        $this->user['rock']  = 0;
        $this->user['paper']  = 0;
        $this->user['scissors']  = 0;

        $this->user['name'] = $request->get('fullname') == null ? 'Sampo Jokinen': $request->get('fullname');

        $this->user = $this->getStats($this->user);

        return view('stats')->with(['user'=> $this->user, 'games'=>$this->gamePlayed]);
    }

    public function getStats($user)
    {
        $apiResponse = json_decode(file_get_contents("https://bad-api-assignment.reaktor.com/rps/history"));

        $this->user['gamesPlayed'] = array();
        $this->gamePlayed['with'] = '';
        $this->gamePlayed['against'] = '';
        $this->gamePlayed['for'] = '';
        $this->gamePlayed['gameId'] = '';

        $match = false;

        foreach ($apiResponse->data as $key => $value)
        {
            if (strcmp($value->playerA->name, $user['name']) == 0 || strcmp($value->playerB->name, $user['name']) == 0) {
                $gamePlayed['gameId'] = $value->gameId;

                $match = true;

                $this->user['gameCount'] += 1;

                if (strcmp($value->playerA->name, $user['name']) == 0)
                {
                    $playedA = $value->playerA->played;
                    $playedB = $value->playerB->played;

                    $this->gamePlayed['with'] = $value->playerB->name;

                    $this->gamePlayed['against'] = $playedB;
                    $this->gamePlayed['for'] = $playedA;

                    $this->user = $this->getWinnerAndUpdateUser($playedA, $playedB, $this->user);

                }
                else if (strcmp($value->playerB->name, $user['name']) == 0)
                {
                    $playedB = $value->playerA->played;
                    $playedA = $value->playerB->played;

                    $this->gamePlayed['with'] = $value->playerA->name;

                    $this->gamePlayed['for'] = $playedB;

                    $this->gamePlayed['against'] = $playedA;

                    $this->user = $this->getWinnerAndUpdateUser($playedB, $playedA, $this->user);
                }

                $match == true ? array_push($this->user['gamesPlayed'], $this->gamePlayed): null;
            }
        }
        return $this->user;
    }

    public function getWinnerAndUpdateUser($playedA, $playedB, $user )
    {
        if (strcmp($playedA, $playedB) == 0) {
            $user['tied'] += 1;
            $result = "Tie";
        }
        $win = false;
        if ($playedA == "ROCK") {

            $user['rock']++;

            if ($playedB == "PAPER") {
                $user['lost']++;
                $result = "Lost";
            } else if ($playedB == "SCISSORS") {
                $user['win']++;
                $win = true;
                $result = "Win";
            }

        } elseif ($playedA == "PAPER") {
            if ($playedB == "ROCK") {
                $user['win']++;
                $win = true; $result = "Win";
            } else if ($playedB == "SCISSORS") {
                $user['lost']++;
                $result = "Lost";
            }
            $user['paper']++;
        } elseif ($playedA == "SCISSORS") {
            if ($playedB == "PAPER") {
                $user['win']++;
                $result = "Win";

            } else if ($playedB == "ROCK") {
                $user['lost']++;
                $result = "Lost";
                $win = false;
            }
            $user['scissors']++;
        }

        $this->gamePlayed['result'] = $result;
        return $user;
    }
}
