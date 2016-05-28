# ReactPHP example for CakeFest 2016 #

## Install ##

* Clone this repository into your apps `plugins` directory: `git clone git@github.com:WyriHaximus/cakephp-reactphp-cakefest2016.git CakephpReactphpCakefest2016`
* Load it in `app/bootstrap.php`:

```php
Plugin::load('WyriHaximus/CakeFest2016', [
    'bootstrap' => true,
    'path' => 'plugins/CakephpReactphpCakefest2016/',
]);
```

## Usage ###

* Start the shell `./bin/cake WyriHaximus/CakeFest2016.server start`
* Open [`http://localhost:1337/index.html`](http://localhost:1337/index.html) in your browser

## License ##

Copyright 2016 [Cees-Jan Kiewiet](http://wyrihaximus.net/)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
