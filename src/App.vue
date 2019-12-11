<template>
  <div id="app">
    <table border="1">
      <thead>
      <th></th>
      <th v-for="winner in winners">{{ winner.name }}</th>
      </thead>
      <tbody>
      <tr v-for="runnerUp in runnersUp">
        <td>{{ runnerUp.name }}</td>
        <td v-for="winner in winners">{{ getPercentage(winner, runnerUp) }}</td>
      </tr>
      </tbody>
    </table>
    <button @click="draw">Run</button>
  </div>
</template>

<script>
import Team from './classes/Team';

export default {
  name: 'app',
  data() {
    return {
      nbDraws: 100000,
      winners: [
        new Team('PSG', 'France', 'A'),
        new Team('Bayern', 'Allemagne', 'B'),
        new Team('MCity', 'Angleterre', 'C'),
        new Team('Juve', 'Italie', 'D'),
        new Team('Liverpool', 'Angleterre', 'E'),
        new Team('Barca', 'Espagne', 'F'),
        new Team('Leipzig', 'Allemagne', 'G'),
        new Team('Valence', 'Espagne', 'H'),
      ],
      runnersUp: [
        new Team('Real', 'Espagne', 'A'),
        new Team('Tottenham', 'Angleterre', 'B'),
        new Team('Shatktar', 'Ukraine', 'C'),
        new Team('Atlético', 'Espagne', 'D'),
        new Team('Naples', 'Italie', 'E'),
        new Team('Dortmund', 'Allemagne', 'F'),
        new Team('Lyon', 'France', 'G'),
        new Team('Chelsea', 'Angleterre', 'H'),
      ],
    };
  },
  computed: {},
  methods: {
    draw() {
      this.resetPicks();

      let cpt = 0;
      let test = 0;

      draw: while (cpt < this.nbDraws) {
        // copying the groups
        const localWinners = this.winners.slice(0);
        const localRunnersUp = this.runnersUp.slice(0);
        const localDraw = [];

        for (let i = 0; i < localWinners.length; i++) {
          const pickedIndex = Math.floor(Math.random() * localRunnersUp.length);
          const runnerUp = localRunnersUp[pickedIndex];
          const winner = localWinners[i];

          if (runnerUp.country === winner.country || runnerUp.pool === winner.pool) {
            test++;
            continue draw;
          }

          localDraw[i] = runnerUp.name;
          localRunnersUp.splice(pickedIndex, 1);
        }

        for (let j = 0; j < localWinners.length; j++) {
          localWinners[j].allowedPicks.filter(pick => pick.name === localDraw[j])[0].timesPicked++;
        }

        cpt++;
      }
    },
    allowedPicks(team) {
      return this.runnersUp
        .filter(teamToFilter => teamToFilter.country !== team.country && teamToFilter.pool !== team.pool)
        .map(teamToMap => ({
          name: teamToMap.name,
          timesPicked: 0,
        }));
    },
    getPercentage(winner, runnerUp) {
      const picks = winner.allowedPicks.filter(pick => pick.name === runnerUp.name);
      if (picks.length) {
        return (picks[0].timesPicked / this.nbDraws * 100).toFixed(2);
      }
      return '';
    },
    resetPicks() {
      for (let i = 0; i < this.winners.length; i++) {
        this.winners[i].allowedPicks = this.allowedPicks(this.winners[i]);
      }
    },
  },
  created() {
    this.resetPicks();
  },
};
</script>

<style>
</style>
