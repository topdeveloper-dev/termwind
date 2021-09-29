<?php

declare(strict_types=1);

namespace NunoMaduro\TailCli\Components;

use NunoMaduro\TailCli\Exceptions\StyleNotFound;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 *
 * @template TValue
 */
abstract class Element
{
    /**
     * Creates an element instance.
     *
     * @param  TValue  $value
     * @param  array<string, string|int>  $options
     */
    final protected function __construct(
        protected OutputInterface $output,
        protected mixed $value,
        protected array $options = [
            'bg' => 'default',
        ])
    {
        // ..
    }

    /**
     * Creates an element instance with the given style.
     *
     * @param  TValue  $value
     */
    final public static function fromStyles(OutputInterface $output, $value, string $styles): static
    {
        $element = new static($output, $value);

        foreach (explode(' ', $styles) as $style) {
            $method = str_replace('-', ' ', $style);
            $method = ucwords($method);
            $method = str_replace(' ', '', $method);

            if ($style === '') {
                continue;
            }

            if (! method_exists($element, $method)) {
                StyleNotFound::style($style);
            }

            $element->$method();
        }

        return $element;
    }

    /**
     * Adds a background color to the element.
     */
    final public function bg(string $color): static
    {
        return $this->with(['bg' => $color]);
    }

    /**
     * Adds 2 margin left to the element.
     */
    final public function ml2(): static
    {
        return $this->ml(2);
    }

    /**
     * Adds 1 margin left to the element.
     */
    final public function ml1(): static
    {
        return $this->ml(1);
    }

    /**
     * Adds the given margin left to the element.
     */
    final public function ml(int $margin): static
    {
        return $this->with(['ml' => $margin]);
    }

    /**
     * Adds 2 margin right to the element.
     */
    final public function mr2(): static
    {
        return $this->mr(2);
    }

    /**
     * Adds 1 margin right to the element.
     */
    final public function mr1(): static
    {
        return $this->mr(1);
    }

    /**
     * Adds the given margin right to the element.
     */
    final public function mr(int $margin): static
    {
        return $this->with(['mr' => $margin]);
    }

    /**
     * Adds 2 padding left to the element.
     */
    final public function pl2(): static
    {
        return $this->pl(2);
    }

    /**
     * Adds 1 padding left to the element.
     */
    final public function pl1(): static
    {
        return $this->pl(1);
    }

    /**
     * Adds the given padding left to the element.
     */
    final public function pl(int $padding): static
    {
        $value = sprintf('%s%s', str_repeat(' ', $padding), $this->value);

        return new static($this->output, $value, $this->options);
    }

    /**
     * Adds 2 padding right to the element.
     */
    final public function pr2(): static
    {
        return $this->pr(2);
    }

    /**
     * Adds 1 padding right to the element.
     */
    final public function pr1(): static
    {
        return $this->pr(1);
    }

    /**
     * Adds the given padding right to the element.
     */
    final public function pr(int $padding): static
    {
        $value = sprintf('%s%s', $this->value, str_repeat(' ', $padding));

        return new static($this->output, $value, $this->options);
    }

    /**
     * Adds a text color to the element.
     */
    final public function textColor(string $color): static
    {
        return $this->with(['fg' => $color]);
    }

    /**
     * Truncates the text of the element.
     */
    final public function truncate(int $limit, string $end = '...'): static
    {
        $limit -= mb_strwidth($end, 'UTF-8');

        if (mb_strwidth($this->value, 'UTF-8') <= $limit) {
            return new static($this->output, $this->value, $this->options);
        }

        $value = rtrim(mb_strimwidth($this->value, 0, $limit, '', 'UTF-8')).$end;

        return new static($this->output, $value, $this->options);
    }

    /**
     * Forces the width of the element.
     */
    final public function width(int $value): static
    {
        $length = mb_strlen($this->value, 'UTF-8');

        if ($length <= $value) {
            $value = $this->value.str_repeat(' ', $value - $length);

            return new static($this->output, $value, $this->options);
        }

        $value = rtrim(mb_strimwidth($this->value, 0, $value, '', 'UTF-8'));

        return new static($this->output, $value, $this->options);
    }

    /**
     * Writes the string representation of the element on the output, and adds a new line.
     */
    final public function write(): void
    {
        $this->output->write($this->toString());
    }

    /**
     * Writes the string representation of the element on the output.
     */
    final public function writeln(): void
    {
        $this->output->writeln($this->toString());
    }

    /**
     * Get the string representation of the element.
     */
    final public function toString(): string
    {
        $style = [];

        foreach ($this->options as $option => $value) {
            if (in_array($option, ['fg', 'bg'], true)) {
                $style[] = "$option=$value";
            }
        }

        return sprintf(
            '%s<%s>%s</>%s',
            str_repeat(' ',  (int) ($this->options['ml'] ?? 0)),
            implode(';', $style),
            $this->value,
            str_repeat(' ', (int) ($this->options['mr'] ?? 0)),
        );
    }

    /**
     * Get the string representation of the element.
     */
    final public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Adds the given options to the element.
     *
     * @param  array<string, int|string>  $options
     */
    private function with(array $options): static
    {
        return new static(
            $this->output,
            $this->value,
            array_merge($this->options, $options)
        );
    }
}
