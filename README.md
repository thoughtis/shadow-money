# Affiliated Links for WordPress

A WordPress plugin to find links for affiliate partners in post content and add their tracking tags. The plugin also provides filters to use on other fields or content types.

## Supported Affiliate Programs

- [Amazon.com Affiliate Program](https://affiliate-program.amazon.com/)

## Filters

### `affiliated_content_locations`

Locations to search for links. Should be (mostly) valid HTML.

**Default:**

```php
$locations = array(
	'the_content',
	'the_content_feed',
	'comment_text',
	'comment_text_rss',
);
```

---------------------------------------

### `affiliated_link_locations`

Locations to replace links. Good for adding affiliate links to custom post meta that are known to be links.

**Default:**

```php
$locations = array();
```

---------------------------------------

### `affiliated_link_filters`

Filters to run links through to add affiliate codes. Used internally to add new affiliate programs.

**Default:** None.

---------------------------------------

### `affiliated_amazon_affiliate_tags`

List of Amazon affiliate tags per country.

**Default:**

```php
$tags = array(
	'at' => '',
	'ca' => '',
	'de' => '',
	'es' => '',
	'fr' => '',
	'it' => '',
	'jp' => '',
	'uk' => '',
	'us' => '',
);
```

**Example:**

```php
add_filter( 'affiliated_amazon_affiliate_tags', function( $tags ) {

	$tags['us'] = 'xxxxxxxxxx-20';

	return $tags;

} );
```