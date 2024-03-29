# Tag Bag - Inject dynamic tags programmatically

[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Mutation testing][ico-infection]][link-infection]

Tag bag is an object oriented and very extendable way of adding content/tags to your pages.

A very common use case for the tag bag is tracking events on your pages. 

## Installation

```bash
composer require setono/tag-bag
```

## Basic usage

```php
<?php
declare(strict_types=1);

use Setono\TagBag\Renderer\ElementRenderer;
use Setono\TagBag\Tag\InlineScriptTag;
use Setono\TagBag\TagBag;

$tagBag = new TagBag(new ElementRenderer());

// in a controller or service
$tagBag->add(InlineScriptTag::create('trackSomething();'));

// in your template
$tagBag->renderAll();
```

The above call to `TagBagInterface::renderAll()` would output the following:

```html
<script>trackSomething();</script>
```

Here we introduced two important concepts of the tag bag: The [tags](#tags) and the [rendering of the tags](#renderers).

Tags are PHP classes implementing the `TagInterface` and they are designed to make it easier for you to output content
on your pages. The ones included are pretty basic, and you may find that you'd want to use some other more
advanced tags that you can read about in the [tags](#tags) section below.

## Tags
The base library includes the following tags:

### Content tag

```php
<?php
use Setono\TagBag\Tag\ContentTag;

$tag = ContentTag::create('<div class="class-name">tag</div>');
```

Renders as:

```html
<div class="class-name">tag</div>
```

### Element tag

```php
<?php
use Setono\TagBag\Tag\ElementTag;

$tag = ElementTag::createWithContent('div', 'content');
```

Renders as:

```html
<div>content</div>
```

### Inline script tag

```php
<?php
use Setono\TagBag\Tag\InlineScriptTag;

$tag = InlineScriptTag::create('alert("Hey!");');
```

Renders as:

```html
<script>
alert("Hey!");
</script>
```

You can also add attributes to the inline script tag:

```php
<?php
use Setono\TagBag\Tag\InlineScriptTag;

$tag = InlineScriptTag::create('{"@context": "https://schema.org/"}')->withType('application/ld+json');
```

The above renders as:
```html
<script type="application/ld+json">
{"@context": "https://schema.org/"}
</script>
```

### Link tag

```php
<?php
use Setono\TagBag\Tag\LinkTag;

$tag = LinkTag::create('stylesheet', 'https://example.com/style.css');
```

Renders as:

```html
<link rel="stylesheet" href="https://example.com/style.css">
```

### Style tag

```php
<?php
use Setono\TagBag\Tag\StyleTag;

$tag = StyleTag::create('body { background-color: red; }');
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
use Setono\TagBag\Tag\InlineScriptTag;
use Setono\TagBag\TagBagInterface;

/** @var TagBagInterface $tagBag */

// in a controller or service
$tagBag->add(new InlineScriptTag('trackSomething();'));

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
[ico-code-coverage]: https://codecov.io/gh/Setono/tag-bag/branch/2.x/graph/badge.svg
[ico-infection]: https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FSetono%2Ftag-bag%2F2.x

[link-packagist]: https://packagist.org/packages/setono/tag-bag
[link-github-actions]: https://github.com/Setono/tag-bag/actions
[link-code-coverage]: https://codecov.io/gh/Setono/tag-bag
[link-infection]: https://dashboard.stryker-mutator.io/reports/github.com/Setono/tag-bag/2.x
