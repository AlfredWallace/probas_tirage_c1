<template>
  <div id="app">
    <ul>
      <li v-for="team in allowedPicks(this.teams.filter(teamToFilter => teamToFilter.name === 'Chelsea')[0])" :key="team.name">
        {{ team.name }}
      </li>
    </ul>
  </div>
</template>

<script>
import Team from './classes/Team'

export default {
  name: 'app',
  data() {
    return {
      teams: [
        new Team('ManU', 'Angleterre', 'A', 'winner', 3),
        new Team('PSG', 'France', 'B', 'winner', 1),
        new Team('Roma', 'Italie', 'C', 'winner', 6),
        new Team('Barca', 'Espagne', 'D', 'winner', 0),
        new Team('Liverpool', 'Angleterre', 'E', 'winner', 5),
        new Team('ManCity', 'Angleterre', 'F', 'winner', 2),
        new Team('Besiktas', 'Turquie', 'G', 'winner', 7),
        new Team('Tottenham', 'Angleterre', 'H', 'winner', 4),
        new Team('Bâle', 'Suisse', 'A', 'runner-up', 7),
        new Team('Bayern', 'Allemagne', 'B', 'runner-up', 1),
        new Team('Chelsea', 'Angleterre', 'C', 'runner-up', 4),
        new Team('Juve', 'Italie', 'D', 'runner-up', 2),
        new Team('Séville', 'Espagne', 'E', 'runner-up', 3),
        new Team('Chakhtar', 'Ukraine', 'F', 'runner-up', 6),
        new Team('Porto', 'Portugal', 'G', 'runner-up', 5),
        new Team('Real', 'Espagne', 'H', 'runner-up', 0),
      ]
    }
  },
  computed: {
    winners() {
      return this.teams.filter(team => team.group === 'winner')
    },
    runnersUp() {
      return this.teams.filter(team => team.group === 'runner-up')
    },
  },
  methods: {
    draw() {
      // copying the groups
      const winners = this.winners().slice(0)
      const runnersUp = this.runnersUp().slice(0)

    },
    allowedPicks(team) {
      return this.teams.filter(teamToPick => teamToPick.group !== team.group && teamToPick.country !== team.country && teamToPick.pool !== team.pool)
    }
  }
}
</script>

<style>
</style>
