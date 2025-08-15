# Fields Handler

Simple, typed PHP form-fields handler.

## Installation

```bash
composer require markingman/fields
```

## Quick start

Define a fields class where **each public `AbstractFieldElement` type property is a field element**:

```php
use MarkIngman\Fields\{Fields, FieldTextElement, FieldBoolElement};

class CustomFields extends Fields {
	public function __construct(
		public FieldTextElement $name = new FieldTextElement(label: 'Name'),
		public FieldBoolElement $subscribe = new FieldBoolElement(label: 'Subscribe?', option: 'yes')
	) {}
}
```

Ergonomic, typed access: `$fields->name->value`.  
You can still iterate fields: `foreach ($fields as $field) { … }`.

## Meld (set incoming values)

```php
$fields->meld_values($_POST, $_FILES);
```

- Signature: `meld_values(array ...$sources)`.
- **First-match wins per field** (by the *source order* you pass in).
- **Key resolution per source**: looks for the **property name** (e.g. `name`), then the optional alias `$field->name` (e.g. `'n'`). The first key found across all sources is used; later sources are ignored for that field.
- Each meld **resets the field to its default** before applying the new value.

What meld accepts (approximate validity):

- `FieldTextElement` — trims; ignores strings over `max_len`.
- `FieldEmailElement` — trims & lowercases; ignores over `max_len`.
- `FieldDateElement` — accepts only `YYYY-MM-DD`.
- `FieldSelectElement` — accepts only keys present in `options`.
- `FieldSelectMultipleElement` — accepts only option keys; de-dupes.
- `FieldArrayElement` — trims strings within `min_len…max_len`, up to `max_count`.
- `FieldBoolElement` — accepts only `option` or `option_empty`; `checked()` helper.
- `FieldFileElement` — expects an array like `$_FILES['file']` and copies known keys.

Introspection helpers:

```php
$fields->get_last_meld_key($fields->name); // which key matched: 'name' or alias
$fields->get_property_name($fields->name); // 'name'
```

## Validate

```php
if (!$fields->validate()) {
    $invalid = $fields->get_invalids(); // e.g. ['name', ...]
}
```

Validation is strict (email format, real dates, select membership, file size/MIME, etc).  
**Note:** a value can be *persisted but invalid* until you handle the errors (e.g. “abc” kept in a phone field).

## Read values

```php
$values = $fields->get_values();           // all values
$values = $fields->get_values(['secret']); // exclude some fields
```

Use these **after** successful validation when saving to storage.

## Field types (built-ins)

- `FieldTextElement` — `min_len`, `max_len`
- `FieldEmailElement` — lowercase + email validation
- `FieldDateElement` — `YYYY-MM-DD`
- `FieldBoolElement` — two explicit options (`option`, `option_empty`), `checked()`
- `FieldSelectElement` — single value from `options`
- `FieldSelectMultipleElement` — multiple values from `options`
- `FieldArrayElement` — list of strings with length/count limits
- `FieldFileElement` — uploaded file with size/MIME checks (`size_max`, `mime_type`, `suffix`)

## Aliases

Give an input alias via the constructor `name`:

```php
new FieldTextElement(name: 'n') // accepts POST/FILES key 'n' as an alias
```

Property names remain canonical; aliases only affect meld lookup.

## Entities (example)

See `tests/fixtures/TestEntityFields.php`:

- `get_entity()` to build an entity from field values.
- `meld_entity($entity)` to prefill fields for editing.

## Utilities

```php
$fields->reset_values();          // back to defaults
$fields->update_default_values(); // set current values as new defaults
$fields->is_valid();              // after validate()
```

## License

MIT

