@php
$config = [
    'appName' => config('app.name'),
    'appVersion' => config('app.version'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales')
];

$polyfills = [
    'Promise',
    'Object.assign',
    'Object.values',
    'Array.prototype.find',
    'Array.prototype.findIndex',
    'Array.prototype.includes',
    'String.prototype.includes',
    'String.prototype.startsWith',
    'String.prototype.endsWith',
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<meta name="theme-color" content="#3f435f">

  <title>{{ config('app.name') }}</title>

  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div id="app"></div>

  {{-- Global configuration object --}}
  <script>window.config = @php echo json_encode($config); @endphp</script>

  {{-- Polyfill JS features via polyfill.io --}}
  <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ implode(',', $polyfills) }}"></script>

  {{-- Load the application scripts --}}
  @if (app()->isLocal())
    <script src="{{ mix('js/app.js') }}"></script>
  @else
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
  @endif
</body>
</html>
