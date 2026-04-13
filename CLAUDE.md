# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

`setono/tag-bag` is a PHP library for programmatically injecting dynamic HTML/JavaScript tags into web pages. Tags are organized by page section (head, body_begin, body_end, or custom), rendered with priority ordering, and deduplicated via fingerprinting.

## Commands

```bash
composer phpunit              # Run all tests
vendor/bin/phpunit tests/TagBagTest.php                    # Run a single test file
vendor/bin/phpunit --filter testAddTag tests/TagBagTest.php # Run a single test method
composer analyse              # Static analysis (Psalm, level 1)
composer check-style          # Coding standards check (ECS with Sylius standard)
composer fix-style            # Auto-fix coding standards
vendor/bin/rector process --dry-run  # Rector dry run
vendor/bin/infection           # Mutation testing
```

## Architecture

The library has four core subsystems coordinated by `TagBag`:

- **Tags** (`Tag/`): Immutable value objects using `with*` clone methods. All implement `TagInterface` which defines section, priority, uniqueness, and fingerprint. The abstract `Tag` base class provides defaults. Concrete types: `ContentTag`, `InlineScriptTag`, `ScriptTag`, `StyleTag`, `LinkTag`, `ElementTag`, `TemplateTag`, and consentable variants.
- **Renderers** (`Renderer/`): Convert tags to HTML strings. Each renderer declares which tag types it `supports()`. `CompositeRenderer` chains multiple renderers. Shared attribute rendering is in `AttributesAwareRendererTrait`.
- **Serializers** (`Serializer/`): Persist/restore tags across requests. `JsonSerializer` is the primary implementation. `CompositeSerializer` tries each serializer in order.
- **Storage** (`Storage/`): Abstraction for where serialized tags are kept. `InMemoryStorage` is provided; real implementations (e.g., session-based) live in consumer packages.

**Tag lifecycle**: `TagBag::add()` dispatches a `PreTagAddedEvent` (PSR-14), renders the tag via the renderer chain, generates a fingerprint for deduplication, stores a `RenderedTag`, then dispatches `TagAddedEvent`. Tags are consumed (removed) on `renderAll()` or `renderSection()`.

**Deduplication**: When a tag with the same fingerprint already exists, unique/non-unique flags and priority determine whether the new tag replaces, coexists with, or is discarded relative to the existing one.

## Conventions

- PHP 8.1+ with `declare(strict_types=1)` in every file
- PSR-4 autoloading under `Setono\TagBag\` namespace
- Psalm level 1 (strictest) — all code must pass without errors
- Coding standard: Sylius Labs (`vendor/sylius-labs/coding-standard/ecs.php`)
- Tests mirror the `src/` directory structure under `tests/`
- Traits are used for cross-cutting concerns (`AttributesAwareTrait`, `ContentAwareTrait`)
