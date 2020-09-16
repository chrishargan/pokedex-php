# PHP Pokédex

## Practical Information

* Repository: `pokedex`
* Deadline: 2 days
* Delivery: Github page (published)
* Team: groups of 2

<img src="pokedex.png">

## Exercise

Making a [Pokédex](https://www.google.com/search?q=pokedex&source=lnms&tbm=isch&sa=X&ved=0ahUKEwiRtNT3-vDfAhWDy6QKHd1cBD4Q_AUIDigB&biw=1300&bih=968#imgrc=_) using [this API](https://pokeapi.co/).

Basic functionality that is expected (read: core features):
* You can search a pokémon by name and by ID
* Of said pokémon you need to show:
    * The ID-number
    * An image (sprite)
    * _At least_ 4 "moves"
    * The previous evolution, _only if it exists_, along with their name and image. Be carefull, you cannot just do ID-1 to get the previous form, for example look into "magmar" - "magmortar". You have to use a seperate api call for this!

There are a couple of pokemon that don't play with the normal rules, add code so their cases are also handled elegantly.

- Ditto only has 1 move.
- Eevee has 6 evolutions.
