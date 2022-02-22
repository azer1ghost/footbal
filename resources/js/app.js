require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

queueMicrotask(() => {
    Alpine.start()
});

window.FootballData = FootballData()

function FootballData() {
    return {
        teams: [],
        games: [],
        week: 1,
        getTeams() {
            axios.get('teams')
                .then((response) => {
                    this.teams = response.data.sort((a, b) => b.P - a.P || b.GD - a.GD);
                })
        },
        getWeek(){
            axios.get( 'week/' + this.week )
                .then((response) => {
                    this.games = response.data.games;
                })
        },
        playWeek(){
            axios.post('week/' + this.week)
                .then(() => {
                    this.getTeams()
                    this.getWeek()
                })
        },
        nextWeek(){
            this.week++
            this.getWeek()
        },
    }
}
