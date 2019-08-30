export default class Team {
  constructor(name, country, pool, pos) {
    this.name = name
    this.pos = pos
    this.country = country
    this.pool = pool
    this.allowedPicks = []
  }
}
