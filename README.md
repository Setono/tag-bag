# Tag Bag - Inject dynamic tags programmatically

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Coverage Status][ico-code-coverage]][link-code-coverage]
[![Quality Score][ico-code-quality]][link-code-quality]

## Installation

### Download
```bash
$ composer require setono/tag-bag
```

## Tags
Included are four tags. If you need another tag, just implement the `TagInterface` and you're ready to go.

**Base tag**

```php
<?php
use Setono\TagBag\Tag\Tag;

$tag = new Tag('key');
```

**Content tag**

```php
<?php
use Setono\TagBag\Tag\ContentTag;

$tag = new ContentTag('key', '<div class="class-name">tag</div>');
```

**Script tag**

```php
<?php
use Setono\TagBag\Tag\ScriptTag;

$tag = new ScriptTag('key', 'alert("Hey!")');
```

A `ScriptTag` is wrapped in `<script>` tags by the `ScriptRenderer`.

**Style tag**

```php
<?php
use Setono\TagBag\Tag\StyleTag;

$tag = new StyleTag('key', 'body { background-color: red; }');
```

A `StyleTag` is wrapped in `<style>` tags by the `StyleRenderer`.

## Renderers
The bundle contains four renderers that corresponds to the tags. A renderer implements the `RendererInterface` and is tagged with `setono_tag_bag.renderer`.

**Content renderer**

The `ContentRenderer` basically just renders the content you've input in the tag.

**Script renderer**

The `ScriptRenderer` wraps the content in a `<script>` tag.

**Style renderer**

The `StyleRenderer` wraps the content in a `<style>` tag.

[ico-version]: https://poser.pugx.org/setono/tag-bag/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/tag-bag/v/unstable
[ico-license]: https://poser.pugx.org/setono/tag-bag/license
[ico-github-actions]: https://github.com/Setono/tag-bag/workflows/build/badge.svg
[ico-code-coverage]: https://img.shields.io/scrutinizer/coverage/g/Setono/tag-bag.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/tag-bag.svg

[link-packagist]: https://packagist.org/packages/setono/tag-bag
[link-github-actions]: https://github.com/Setono/tag-bag/actions
[link-code-coverage]: https://scrutinizer-ci.com/g/Setono/tag-bag/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/tag-bag
