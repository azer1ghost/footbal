<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Champions League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <section x-data="FootballData" x-init="getTeams()">
        <div class="container my-5">
            <div class="row">
                <div class="col-12 col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Teams</th>
                                <th>Points</th>
                                <th>Played</th>
                                <th>Won</th>
                                <th>Drawn</th>
                                <th>Lost</th>
                                <th title="Golas For">GF</th>
                                <th title="Goals Against">GA</th>
                                <th title="Goals Difference">GD</th>
                            </tr>
                        </thead>
                        <tbody>
{{--                        TODO faiz hesabati--}}
                            <template x-for="(team, index) in teams" :key="index">
                                <tr>
                                    <th x-text="team.name"></th>
                                    <td x-text="team.points"></td>
                                    <td x-text="team.played"></td>
                                    <td x-text="team.won"></td>
                                    <td x-text="team.drawn"></td>
                                    <td x-text="team.lost"></td>
                                    <td x-text="team.gf"></td>
                                    <td x-text="team.ga"></td>
                                    <td x-text="team.gd"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-sm btn-outline-success" @click="playWeek()">Play All</button>
                        <button class="btn btn-sm btn-outline-primary" @click="nextWeek()">Next Week</button>
                    </div>
                </div>
                <div class="col-12 col-md-5 offset-1" x-init="getWeek()">
                    <h4 x-text="'Week ' + week"></h4>
                    <template x-for="game in games">
                        <ul class="list-group list-group-horizontal col">
                            <li class="list-group-item" x-text="game.teams[0].name"></li>
                            <li class="list-group-item" x-text="game.teams[0].data.goals"></li>
                            <li class="list-group-item" x-text="game.teams[1].data.goals"></li>
                            <li class="list-group-item" x-text="game.teams[1].name"></li>
                        </ul>
                    </template>
                </div>
            </div>
        </div>
    </section>
    <script src="{{mix('js/app.js')}}"></script>
</body>
</html>
