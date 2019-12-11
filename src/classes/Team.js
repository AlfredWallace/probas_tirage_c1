export default class Team {
  constructor(name, country, pool) {
    this.name = name;
    this.country = country;
    this.pool = pool;
    this.allowedPicks = [];
  }
}
