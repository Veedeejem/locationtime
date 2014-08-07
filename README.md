LOCATIONTIME
============

CraftCMS locationtime twig filter.
Uses google maps geocode to get latitude longitude and the geonames api to get timezone.


Version
-------
0.1

Usage
-----
```php
{{ entry.location | locationtime('H:i') }}
```

Params
------
- Format: Define the format of the outputted string. Default is H:i.

Note
----
For use in production please register and use your own (free) geonames account.


Todo
----
* Make settings page for geonames account