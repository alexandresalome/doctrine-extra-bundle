# Contributors

## By order of appearance

* Alexandre Salomé
* Pascal Borreli
* Oskar Stark
* Robert (Jamie) Munro
* Théo FIDRY
* Grégoire Marchal


## Command used to generate:

```
git log --reverse --format="%aN" \
| sed "s/alexandresalome/Alexandre Salomé/g" \
| sed "s/gmarchal/Grégoire Marchal/g" \
| perl -ne 'if (!defined $x{$_}) { print $_; $x{$_} = 1; }'
```
