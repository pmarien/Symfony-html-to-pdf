# pmarien/html-to-pdf-bundle

Symfony integration for pmarien/html-to-pdf

1. Requirements
2. How to install?
3. How to configure?
4. How to use internal assets?
5. How to use?
    1. Controller (Inline PDF)
    1. Controller (Download PDF)
    1. Controller (Store PDF file)
    1. With Twig Templates
        1. Controller (Inline PDF)
        1. Controller (Download PDF)
        1. Controller (Store PDF file)

## Requirements

The bundle requires PHP in version 8.1 or higher and Symfony in version 5, 6 or 7.

The html-to-pdf-library requires implementations of `psr/http-message`, `psr/http-factory` and `psr/http-client`.

## How to install?

The bundle should be installed via composer: `pmarien/html-to-pdf`.

```shell
composer req pmarien/html-to-pdf
```

## How to configure?

If you want to configure the bundle you should add the file `config/packages/html_to_pdf.yaml`.

Without api key configuration the bundle will act as anonymous client, which leads to a limit of 3 generated PDF files
per day.

```yaml
html_to_pdf:
  apiKey: 'YOUR_API_KEY'
```

## How to use internal assets?

If you want to use assets in your pdf, they have to be public accessible via http for the pdf generator.
Sometimes you want to use the assets, but don't want to publish them.
For those cases, this bundle comes with an AssetAccessController, which requires a hash for file protection.

The routing have to be enabled via config (`config/routes/html_to_pdf.yaml`):

```yaml
HtmlToPdfBundle:
  resource: '@HtmlToPdfBundle/Resources/config/routes.xml'
```

Asset uris can be build manually (route name: `html_to_pdf_get_file`, required parameters: `filename` and `hash`) or via
twig filter:

```html
<img src="{{ '/assets/images/test.png'|pdfAsset }}" alt="Test">
```

If you build uris manually, the hash can be generated via `PMA\HtmlToPdfBundle\Asset\AssetAccessorInterface::getHash`
(available as symfony service).

## How to use?

If you want to generate pdf files directly from html, you should use `PMA\HtmlToPdfBundle\Bridge\FoundationBridge` as
generator. It's available as service in the service container and may be autowired by symfony's dependency injection.

### Controller (Inline PDF)

```php
public function showAction(\PMA\HtmlToPdfBundle\Bridge\FoundationBridge $generator):\Symfony\Component\HttpFoundation\Response{
   return $generator->inlineResponse(
        'test.pdf',
        '<html><body><p>This is a test!</p></body></html>'
    );
}
```

### Controller (Download PDF)

```php
public function downloadAction(\PMA\HtmlToPdfBundle\Bridge\FoundationBridge $generator):\Symfony\Component\HttpFoundation\Response{
   return $generator->attachmentResponse(
        'test.pdf',
        '<html><body><p>This is a test!</p></body></html>'
    );
}
```

### Service (Store PDF file)

```php
public function storeFile(\PMA\HtmlToPdfBundle\Bridge\FoundationBridge $generator):void {
    $generator->createFile(
        '/your/project/file-storage/test.pdf',
        '<html><body><p>This is a test!</p></body></html>'
    );
}
```

### Twig

If you want to generate pdf files from twig templates, you should use `PMA\HtmlToPdfBundle\Bridge\TwigBridge` as
generator. It's available as service in the service container and may be autowired by symfony's dependency injection.
It requires Twig to be installed in your project.

#### Controller (Inline PDF file)

```php
public function showAction(\PMA\HtmlToPdfBundle\Bridge\TwigBridge $generator):\Symfony\Component\HttpFoundation\Response{
   return $generator->inlineResponse(
        'test.pdf',
         'pdf-templates/test.pdf.twig',
        [
            'test'=>'Test'
        ]
    );
}
```

#### Controller (Download PDF file)

```php
public function downloadAction(\PMA\HtmlToPdfBundle\Bridge\TwigBridge $generator):\Symfony\Component\HttpFoundation\Response{
   return $generator->attachmentResponse(
        'test.pdf',
         'pdf-templates/test.pdf.twig',
        [
            'test'=>'Test'
        ]
    );
}
```

#### Service (Store PDF file)

```php
public function storeFile(\PMA\HtmlToPdfBundle\Bridge\TwigBridge $generator):void {
    $generator->createFile(
        '/your/project/file-storage/test.pdf',
        'pdf-templates/test.pdf.twig',
        [
            'test'=>'Test'
        ]
    );
}
```
