# Tag Bag - Inject dynamic tags programmatically

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Coverage Status][ico-code-coverage]][link-code-coverage]
[![Quality Score][ico-code-quality]][link-code-quality]

Inject all kinds of tags onto your web pages with this library. Tags in this context could be a `<script>` tag, a `<style>`,
or anything else that goes onto a web page.

This is especially useful when you want to render tags with dynamic content.

## Installation

```bash
$ composer require setono/tag-bag
```

## Basic usage

```php
<?php
use Setono\TagBag\Tag\ScriptTag;
use Setono\TagBag\TagBagInterface;

/** @var TagBagInterface $tagBag */

// in a controller or service
$tagBag->addTag(new ScriptTag('trackSomething();'));

// in your template
$tagBag->renderAll();
```

The above call to `TagBagInterface::renderAll()` would output the following:

```html
<script>trackSomething();</script>
```

Here we introduced two important concepts of the tag bag: The [tags](#tags) and the [rendering of the tags](#renderers).

Tags are PHP classes implementing the `TagInterface` and they are designed to make it easier for you to output content
on your pages. The ones included are pretty basic, and you may find that you'd want to use some of the other more
advanced tags that you can read about in the [tags](#tags) section below.

## Tags
Included are three tags. If you need another tag, just implement the `TagInterface` and you're ready to go.

**Content tag**

```php
<?php
use Setono\TagBag\Tag\ContentTag;

$tag = new ContentTag('<div class="class-name">tag</div>');
```

**Script tag**

```php
<?php
use Setono\TagBag\Tag\ScriptTag;

$tag = new ScriptTag('alert("Hey!")');
```

A `ScriptTag` is wrapped in `<script>` tags by the `ScriptRenderer`.

**Style tag**

```php
<?php
use Setono\TagBag\Tag\StyleTag;

$tag = new StyleTag('body { background-color: red; }');
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
