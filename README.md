# Fields Handler

Simple PHP form fields handler

## Installation

To use, require in `composer.json`, e.g.:

```
composer require markingman/fields
```

## Usage

Create custom fields classes with fields as public `AbstractFieldElement` class properties.

Typically fields are defined as shorthand in the constructor, for example:

```
class CustomFields extends Fields {
	public function __construct(
		public FieldTextElement $field1 = new FieldTextElement(),
		public FieldBoolElement $field2 = new FieldBoolElement(),
	) {}
}
```

Use `Fields::meld_values()` to get values, for example: `$fields->meld_values($_POST)`.

Use `Fields::validate()` to set and validate values.

Use `Fields::get_values()` to return values.

Note the `tests/fixtures/EntityFields.php` example for working with entity objects.


