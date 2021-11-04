<p align="center">
    <img width="150" height="150" alt="Termwind logo" src="/art/logo.png"/>
</p>

<h1 align="center" style="border:none !important">
    <code>Termwind</code>
    <br>
    <br>
</h1>

<p align="center">
    <img src="https://raw.githubusercontent.com/nunomaduro/tailcli/master/art/example.png" alt="TailCli example" height="300">
    <p align="center">
        <a href="https://github.com/nunomaduro/termwind/actions"><img alt="GitHub Workflow Status (master)" src="https://img.shields.io/github/workflow/status/nunomaduro/termwind/Tests/master"></a>
        <a href="https://packagist.org/packages/nunomaduro/termwind"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/nunomaduro/termwind"></a>
        <a href="https://packagist.org/packages/nunomaduro/termwind"><img alt="Latest Version" src="https://img.shields.io/packagist/v/nunomaduro/termwind"></a>
        <a href="https://packagist.org/packages/nunomaduro/termwind"><img alt="License" src="https://img.shields.io/packagist/l/nunomaduro/termwind"></a>
    </p>
</p>

------
**Termwind** allows you to build unique and beautiful PHP command-line applications, using the **[Tailwind CSS](https://tailwindcss.com/)** API. In short, it's like Tailwind CSS, but for the PHP command-line applications.

## Installation

> **Requires [PHP 8.0+](https://php.net/releases/)**

Require Termwind using [Composer](https://getcomposer.org):

```bash
composer require nunomaduro/termwind
```

## Usage

```php
use function Termwind\{render};

// single line html...
render('<div class="p-1 bg-green-300">Termwind</div>');

// multi-line html...
render(<<<'HTML'
    <div>
        <div class="p-1 bg-green-300">Termwind</div>
        <em class="ml-1">
          Give your CLI apps a unique look
        </em>
    </div>
HTML);

// Laravel or Symfony console commands...
class UsersCommand extends Command
{
    public function handle()
    {
        render(
            view('users.index', [
                'users' => User::all()
            ])
        );
    }
}
```

### `style()`

The `style()` function may be used to add own custom syles.

```php
use function Termwind\{style};

style('btn')->apply('p-4 bg-blue text-white');

render('<div class="btn">Click me</div>');
```

## HTML Elements Supported

All the elements have the capability to use the `class` attribute.

### `<div>`

The `<div>` element can be used as a block type element.

**Default Styles**: `block`

```php
render(<<<'HTML'
    <div>This is a div element.</div>
HTML);
```

### `<p>`

The `<p>` element can be used as a paragraph.

**Default Styles**: `block`

```php
render(<<<'HTML'
    <p>This is a paragraph.</p>
HTML);
```

### `<span>`

The `<span>` element can be used as a inline text container.

```php
render(<<<'HTML'
    <p>
        This is a CLI app built with <span class="text-green-300">Termwind</span>.
    </p>
HTML);
```

### `<a>`

The `<a>` element can be used as an hyperlink. Tt allows to use the `href` attribute to open the link when clicked.

```php
render(<<<'HTML'
    <p>
        This is a CLI app built with Termwind. <a href="/">Click here to open</a>
    </p>
HTML);
```

### `<b>` and `<strong>`

The `<b>`and `<strong>` elements can be used to mark the text as **bold**.

**Default Styles**: `font-bold`

```php
render(<<<'HTML'
    <p>
        This is a CLI app built with <b>Termwind</b>.
    </p>
HTML);
```

### `<i>` and `<em>`

The `<i>`and `<em>` elements can be used to mark the text as *italic*.

**Default Styles**: `italic`

```php
render(<<<'HTML'
    <p>
        This is a CLI app built with <i>Termwind</i>.
    </p>
HTML);
```

### `<br>`

The `<br>` element can be used to do a line break.

```php
render(<<<'HTML'
    <p>
        This is a CLI <br>
        app built with Termwind.
    </p>
HTML);
```

### `<ul>`

The `<ul>` element can be used for an unordered list. It can only accept `<li>` elements as childs, if there is another element provided it will throw an `InvalidChild` exception. 

**Default Styles**: `block`, `list-disc`

```php
render(<<<'HTML'
    <ul>
        <li>Item 1</li>
        <li>Item 2</li>
    </ul>
HTML);
```

### `<ol>`

The `<ol>` element can be used for an ordered list. It can only accept `<li>` elements as childs, if there is another element provided it will throw an `InvalidChild` exception. 

**Default Styles**: `block`, `list-decimal`

```php
render(<<<'HTML'
    <ol>
        <li>Item 1</li>
        <li>Item 2</li>
    </ol>
HTML);
```

### `<li>`

The `<li>` element can be used as a list item. It should only be used as a child of `<ul>` and `<ol>` elements.

**Default Styles**: `block`, `list-decimal`

```php
render(<<<'HTML'
    <ul>
        <li>Item 1</li>
    </ul>
HTML);
```

### `<dl>`

The `<dl>` element can be used for an description list. It can only accept `<dt>` or `<dd>` elements as childs, if there is another element provided it will throw an `InvalidChild` exception. 

**Default Styles**: `block`

```php
render(<<<'HTML'
    <dl>
        <dt>🍃 Termwind</dt>
        <dd>Give your CLI apps a unique look</dd>
    </dl>
HTML);
```

### `<dt>`

The `<dt>` element can be used as a description title. It should only be used as a child of `<dl>` elements.

**Default Styles**: `block`, `font-bold`

```php
render(<<<'HTML'
    <dl>
        <dt>🍃 Termwind</dt>
    </dl>
HTML);
```

### `<dd>`

The `<dd>` element can be used as a description title. It should only be used as a child of `<dl>` elements.

**Default Styles**: `block`, `ml-4`

```php
render(<<<'HTML'
    <dl>
        <dd>Give your CLI apps a unique look</dd>
    </dl>
HTML);
```

### `<hr>`

The `<hr>` element can be used as an horizontal line.

```php
render(<<<'HTML'
    <div>
        <div>🍃 Termwind</div>
        <hr>
        <p>Give your CLI apps a unique look</p>
    </div>
HTML);
```

### `<table>`

The `<table>` element can have columns and rows.

```php
render(<<<'HTML'
    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Status</th>
            </tr>
        </thead>
        <tr>
            <th>Termwind</th>
            <td>✓ Done</td>
        </tr>
    </table>
HTML);
```

### `<pre>`

The `<pre>` element can be used as preformatted text.

```php
render(<<<'HTML'
    <pre>
        Text in a pre element
        it preserves
        both      spaces and
        line breaks
    </pre>
HTML);
```

### `<code>`

The `<code>` element can be used as code highligher. It accepts `line` and `start-line` attributes.

```php
render(<<<'HTML'
    <code line="22" start-line="20">
        try {
            throw new \Exception('Something went wrong');
        } catch (\Throwable $e) {
            report($e);
        }
    </code>
HTML);
```

## How To Contribute

Head over to [tailwindcss.com/docs](https://tailwindcss.com/docs), and choose a class that is not implemented in Termwind. As an example, let's assume you would like to add the `lowercase` Tailwind CSS class to Termwind:

1. Head over to [`src/Components/Element`](https://github.com/nunomaduro/termwind/blob/master/src/Components/Element.php#L275) and add a new method with the name `lowercase`:
```php
    /**
     * Makes the element's content lowercase.
     */
    final public function lowercase(): static
    {
        $content = $this->applyModifier(
            $this->content,
            fn ($text) => mb_strtolower($text, 'UTF-8')
        );

        return new static($this->output, $content, $this->properties, $this->styles);
    }
```

2. Next, add a new test in [`tests/classes.php`](https://github.com/nunomaduro/termwind/blob/master/tests/classes.php#L130) to see if the `lowercase` class works as expected:

```php
test('lowercase', function () {
    $html = parse('<div class="lowercase">tEXT</div>');

    expect($html)->toBe('text');
});
```

3. Pull request the code, and that's it.

Termwind is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
