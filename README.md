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

## Usage

Let's start with an example: You have an ecommerce store, and you want to track a sale with a third party script.
The script you need to inject on the success page looks like this:

```javascript
easyTrack({
    event: 'sale',
    value: <the order value>
});
```

You have a controller that handles the order when it is completed and redirects to the sucess page:

```php
<?php
use Setono\TagBag\Tag\ScriptTag;
use Setono\TagBag\TagBagInterface;

final class OrderCompletedController
{
    /** @var TagBagInterface */
    private $tagBag;

    public function __construct(TagBagInterface $tagBag) {
        $this->tagBag = $tagBag;
    }

    public function __invoke($order)
    {
        $tag = new ScriptTag(
            sprintf("easyTrack({event: 'sale', value: %s});", $order->getTotalAsFloat())
        );
        $this->tagBag->addTag($tag);

        // redirect to the success page
    }
}
```

On your success page you would then output this tag and other tags using `$tagBag->renderAll()`.

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
