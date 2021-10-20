<?php

use Termwind\HtmlRenderer;
use function Termwind\{render};

it('can render complext html', function () {
    $html = parse(<<<'HTML'
<div class="bg-white">
    <a class="ml-2">link text</a>
    <a class="ml-2" href="link">link text</a>
</div>
HTML);

    expect($html)->toBe('<bg=white>  link text  <href=link>link text</></>');
});

it('can render strings', function () {
    $html = parse('text');

    expect($html)->toBe('text');
});

it('can render to custom output', function () {
    $html = render(<<<'HTML'
        <div class="bg-white">
            <a class="ml-2">link text</a>
            <a class="ml-2" href="link">link text</a>
        </div>
    HTML);

    expect($this->output->fetch())->toBe("  link text  link text\n");
});

it('can render table to a string', function () {
    $html = (new HtmlRenderer())->parse(<<<HTML
<table style="box-double">
    <thead title="Books" class="bg-red text-color-white px-10">
        <tr>
            <th align="right">ISBN</th>
            <th>Title</th>
            <th>Author</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th align="right">99921-58-10-7</th>
            <td>Divine Comedy</td>
            <td align="right">Dante Alighieri</td>
        </tr>
        <tr border="1">
            <th class="bg-blue text-color-red" align="right">9971-5-0210-0</th>
            <td>A Tale of Two Cities</td>
            <td align="right">Charles Dickens</td>
        </tr>
        <tr>
            <th align="right">960-425-059-0</th>
            <td>The Lord of the Rings</td>
            <td align="right">J. R. R. Tolkien</td>
        </tr>
        <tr>
            <th align="right">80-902734-1-6</th>
            <td>And Then There Were None</td>
            <td rowspan="2" align="right">Dante Alighieri\nspans multiple rows</td>
        </tr>
        <tr>
            <th align="right">978-052156781</th>
            <td>De Monarchia</td>
        </tr>
    </tbody>
    <tfoot title="Page 1/2" class="mx-5 bg-blue">
        <tr>
            <th colspan="3">This value spans 3 columns.</th>
        </tr>
    </tfoot>
</table>
HTML);

    expect($html->toString())->toBe(<<<'OUT'
╔═══════════════╤══[37;41m           Books           [39;49m═══════════════════╗
║[39;49m          [1mISBN[0m [39;49m│[39;49m [1mTitle[0m                    [39;49m│[39;49m [1mAuthor[0m              [39;49m║
╠═══════════════╪══════════════════════════╪═════════════════════╣
║[39;49m [1m99921-58-10-7[0m [39;49m│[39;49m Divine Comedy            [39;49m│[39;49m     Dante Alighieri [39;49m║
║[31;44m [1m9971-5-0210-0[0m [39;49m│[39;49m A Tale of Two Cities     [39;49m│[39;49m     Charles Dickens [39;49m║
╟───────────────┼──────────────────────────┼─────────────────────╢
║[39;49m [1m960-425-059-0[0m [39;49m│[39;49m The Lord of the Rings    [39;49m│[39;49m    J. R. R. Tolkien [39;49m║
[39;49m║[39;49m[39;49m [1m80-902734-1-6[0m [39;49m[39;49m│[39;49m[39;49m And Then There Were None [39;49m[39;49m│[39;49m[39;49m     Dante Alighieri [39;49m[39;49m║[39;49m
║[39;49m [1m978-052156781[0m [39;49m│[39;49m De Monarchia             [39;49m│[39;49m spans multiple rows [39;49m║
╟───────────────┼──────────────────────────┼─────────────────────╢
║[39;49m [1mThis value spans 3 columns.[0m                                    [39;49m║
╚═══════════════╧══════     [44m Page 1/2 [49m     ╧═════════════════════╝

OUT
);
});

it('renders element inside another one', function () {
    $html = parse('<div>Hello <strong>world</strong></div>');

    expect($html)->toBe("Hello \e[1mworld\e[0m");
});

it('renders element inside another one with extra spaces and line breaks', function () {
    $html = parse(<<<'HTML'
        <div class="bg-red">
            Hello
            <strong>world</strong>
        </div>
    HTML);

    expect($html)->toBe("<bg=red>Hello \e[1mworld\e[0m</>");
});
