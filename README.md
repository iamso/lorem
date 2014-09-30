Lorem
=====

Simple PHP lorem ipsum and nonsense generator.

Usage Example
-------------

Generate 10 html paragraphs of lorem ipsum text with 20-30 words:

```bash
curl http://domain.tld/lorem/p-10/30-40
```

Options
-------

Options are passed in the following order:

```bash
curl http://domain.tld/<type>/<format>/<words>
```

### Type

- lorem
- nonsense


### Format

- plain
- p
- ul
- ol
- h1
- h2
- h3
- h4
- h5
- h6

Add a hyphen followed by a number to specify the number of paragraphs or list items. When generating h1-h6 the number will be ignored.

### Words

Single number (i.e. 10) for a fixed number of words or a range (i.e. 10-20) for random number from that range.

License
-------

Copyright (c) 2014, Steve Ottoz

Permission to use, copy, modify, and/or distribute this software for any purpose with or without fee is hereby granted, provided that the above copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.