# Affiliated Links for WordPress

Plugin to add affiliate codes to links in post and page content. Provides filters to use on other content types.

## Supported Affiliate Programs

- [Amazon.com Affiliate Program](https://affiliate-program.amazon.com/)

## Filters

### `affiliated_content_locations`

Locations to search for links. Should be mostly valid HTML.

#### Default Value

```php
$locations = array(
	'the_content',
	'the_content_feed',
	'comment_text',
	'comment_text_rss',
);
```

### `affiliated_link_locations`

Locations to replace links. Good for adding affiliate links to custom post meta that are known to be links.

#### Default Value

```php
$locations = array();
```

### `affiliated_link_filters`

Filters to run links through to add affiliate codes. Used internally to add new affiliate programs.

#### Default Value

None.

### `affiliated_amazon_affiliate_tags`

List of Amazon affiliate tags per country.

#### Default Value

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

#### Example Usage

```php
add_filter( 'affiliated_amazon_affiliate_tags', function( $tags ) {

	$tags['us'] = 'xxxxxxxxxx-20';

	return $tags;

} );
```