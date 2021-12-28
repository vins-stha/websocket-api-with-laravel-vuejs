<template>
    <div>

        <section class="section-heading">
            <h3 class="head">View more fresh stats below...</h3>
            <div class="actions">
                <button class="btn btn-danger small"
                        :disabled="stopDisabled"
                        v-on:click="close_connection">Stop
                </button>
                <button class="btn btn-primary small"
                        v-on:click="connectWs()"
                        :disabled="connectDisabled"
                >Connect
                </button>
            </div>
        </section>
        <div class="secondary">
            <div class="newGame">
                <h4> Games...just started</h4>

                <table class="table table-dark table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Player A</th>
                        <th scope="col">Player B</th>
                        <th scope="col">Id</th>
                    </tr>
                    </thead>

                    <tbody v-for="game in new_games" :key="game.gameId">
                    <tr>
                        <td>{{game.playerA.name}}</td>
                        <td>{{game.playerB.name}}</td>
                        <td class="gameId">{{game.gameId}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="newGame">
                <h4> Games...just Ended !!</h4>
                 <table class="table table-dark table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Player A</th>
                        <th scope="col">Player A-played</th>
                        <th scope="col">Player B</th>
                        <th scope="col">Player B-played</th>
                        <th scope="col">Winner</th>
                    </tr>
                    </thead>

                    <tbody v-for="game in just_completed_games" :key="game.gameId">
                    <tr>
                        <td>{{game.playerA.name}}</td>
                        <td>{{game.playerA.played}}</td>
                        <td>{{game.playerB.name}}</td>
                        <td>{{game.playerB.played}}</td>
                        <td>{{game.winner}}</td>

                    </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>


</template>

<script>
  export default {
    data() {
      return {
        username: username,
        new_games: [],
        just_completed_games: [],
        games_stats: [],
        games_history: [],
        connection: null,
        open: false,
        stopDisabled: true,
        connectDisabled: false,
      }
    },
    created() {
    },
    methods: {

      // connect and fetch data for live games
      async connectWs() {
        try {

          this.connection = new WebSocket("wss://bad-api-assignment.reaktor.com/rps/live");

          this.connection.onopen = function (event) {
            console.log('successfully connected')
          };

          this.connection.onmessage = (event) => {
            let newGame
            try {

              newGame = JSON.parse(event.data);

              newGame = newGame.constructor === "text".constructor ? JSON.parse(newGame) : newGame;

              newGame.type === "GAME_RESULT" ? this.just_completed_games.push(newGame) : this.new_games.push(newGame)
              if (newGame.type === "GAME_RESULT") {
                newGame.winner = this.get_winner(newGame)
              }

              this.open = true
              this.stopDisabled = false
              this.connectDisabled = true
            } catch (e) {
              console.log('error=', e)

            }
            return this.new_games
          }
        } catch (error) {
          console.log(error);
        }

      },

      // close connection on user demand
      close_connection() {

        if (this.connection.readyState === 1 || this.connection.readyState !== 3) {

          try {
            this.connection.close(1000);
            console.log('successfully closed')

          } catch (e) {
            console.log('could not stop ', e)
          }
        }
        ;
        this.connectDisabled = false
        this.stopDisabled = true
      },

      // determine winner for the game just finished
      get_winner(game) {

        let winner
        let playerA = game.playerA.name
        let A = game.playerA.played

        let playerB = game.playerB.name
        let B = game.playerB.played

        if (A === B)
          return "TIED"
        if (A === "ROCK") {
          winner = B === "PAPER" ? playerB : playerA
        } else if (A === "PAPER") {
          winner = B === "SCISSORS" ? playerB : playerA
        } else if (A === "SCISSORS") {
          winner = B === "PAPER" ? playerA : playerB
        }
        return winner
      }
      /*
        getData()
        {
          axios.post('/rps/getData', this.username)
              .then((res) => {
                console.log(this.username)
                this.games_history = res.data.games_history;
                this.games_stats = res.data.user_game_stats;
              })
              .catch((e) => {
                console.log('error', e.message)
              })
        }
        */
      /*    get_updated_stats() {
        axios.post('/rps/update', this.username)
            .then((res) => {
              console.log(' for updates result = ', res)
            })
            .catch(e => {
              console, log('error=>', e.response)
            })
      },
     */
    }
  }
</script>

