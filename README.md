# Tag Bag - Inject dynamic tags programmatically

[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Coverage Status][ico-code-coverage]][link-code-coverage]

Tag bag is an object oriented and very extendable way of adding content/tags to your pages.

A very common use case for the tag bag is tracking events on your pages. 

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
The base library has three tags and on top of that you can use other tags by installing small sub packages of the tag bag.

### Content tag

```php
<?php
use Setono\TagBag\Tag\ContentTag;

$tag = new ContentTag('<div class="class-name">tag</div>');
```

Renders as:

```html
<div class="class-name">tag</div>
```

### Script tag

```php
<?php
use Setono\TagBag\Tag\ScriptTag;

$tag = new ScriptTag('alert("Hey!");');
```

Renders as:

```html
<script type="application/ld+json">
alert("Hey!");
</script>
```

The script tag also has an optional property named `type`:

```php
<?php
use Setono\TagBag\Tag\ScriptTag;

$tag = new ScriptTag('{"@context": "https://schema.org/"}');
$tag->setType('application/ld+json');
```

The above renders as:
```html
<script type="application/ld+json">
{"@context": "https://schema.org/"}
</script>
```

### Style tag

```php
<?php
use Setono\TagBag\Tag\StyleTag;

$tag = new StyleTag('body { background-color: red; }');
```

Renders as:

```html
<style>
body { background-color: red; }
</style>
```

### Twig tag

Render using twig templates. See installation instructions and usage [here](https://github.com/Setono/tag-bag-twig).

### PHP templates tag

Render using [PHP templates](https://github.com/Setono/php-templates). See installation instructions and usage [here](https://github.com/Setono/tag-bag-php-templates).

### Gtag tag

If you're using Google's services, some of them allow you to track events using the [gtag](https://developers.google.com/gtagjs).

To make it easier to create these tags, you can use the [gtag extension for the tag bag](https://github.com/Setono/tag-bag-gtag).

## Renderers
The base library contains three renderers that corresponds to the base tags.
A renderer implements the `RendererInterface`.

Just as with the tags there are also renderers in the sub packages.

**Content renderer**

The `ContentRenderer` renders the content you've input in the tag.

**Script renderer**

The `ScriptRenderer` wraps the content in a `<script>` tag.

**Style renderer**

The `StyleRenderer` wraps the content in a `<style>` tag.

## Storage

The intended use of the tag bag is to save the tag bag upon end of request and restore it upon starting the request life cycle.
The `TagBagInterface` has `store` and `restore` methods for these events respectively.

```php
<?php
use Setono\TagBag\Tag\ScriptTag;
use Setono\TagBag\TagBagInterface;

/** @var TagBagInterface $tagBag */

// in a controller or service
$tagBag->addTag(new ScriptTag('trackSomething();'));

// this stores the contents of the tag bag
$tagBag->store();

// this restores the contents of the tag bag
$tagBag->restore();
```

## Framework integration

- Symfony: [TagBagBundle](https://github.com/Setono/TagBagBundle)

[ico-version]: https://poser.pugx.org/setono/tag-bag/v/stable
[ico-license]: https://poser.pugx.org/setono/tag-bag/license
[ico-github-actions]: https://github.com/Setono/tag-bag/workflows/build/badge.svg
[ico-code-coverage]: https://img.shields.io/scrutinizer/coverage/g/Setono/tag-bag.svg

[link-packagist]: https://packagist.org/packages/setono/tag-bag
[link-github-actions]: https://github.com/Setono/tag-bag/actions
[link-code-coverage]: https://scrutinizer-ci.com/g/Setono/tag-bag/code-structure
