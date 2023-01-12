@extends('vendor.installer.layouts.master')

@section('template_title')
	{{ trans('installer_messages.final.templateTitle') }}
@endsection

@section('title')
	<i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
	{{ trans('installer_messages.final.title') }}
@endsection

@section('container')

	@if(session('message')['dbOutputLog'])
		<div class="console-card">
			<div class="console-tools">
				<div class="console-circle">
					<span class="console-red console-box"></span>
				</div>
				<div class="console-circle">
					<span class="console-yellow console-box"></span>
				</div>
				<div class="console-circle">
					<span class="console-green console-box"></span>
				</div>
				<div class="console-header"><strong>{{ trans('installer_messages.final.migration') }}</strong></div>
			</div>
			<div class="card__content">
				<pre><code>{{ session('message')['dbOutputLog'] }}</code></pre>
			</div>
		</div>
	@endif

	<div class="console-card">
		<div class="console-tools">
			<div class="console-circle">
				<span class="console-red console-box"></span>
			</div>
			<div class="console-circle">
				<span class="console-yellow console-box"></span>
			</div>
			<div class="console-circle">
				<span class="console-green console-box"></span>
			</div>
			<div class="console-header"><strong>{{ trans('installer_messages.final.console') }}</strong></div>
		</div>
		<div class="card__content">
			<pre><code>{{ $finalMessages }}</code></pre>
		</div>
	</div>

	<div class="console-card">
		<div class="console-tools">
			<div class="console-circle">
				<span class="console-red console-box"></span>
			</div>
			<div class="console-circle">
				<span class="console-yellow console-box"></span>
			</div>
			<div class="console-circle">
				<span class="console-green console-box"></span>
			</div>
			<div class="console-header"><strong>{{ trans('installer_messages.final.log') }}</strong></div>
		</div>
		<div class="card__content">
			<pre><code>{{ $finalStatusMessage }}</code></pre>
		</div>
	</div>

	<div class="console-card">
		<div class="console-tools">
			<div class="console-circle">
				<span class="console-red console-box"></span>
			</div>
			<div class="console-circle">
				<span class="console-yellow console-box"></span>
			</div>
			<div class="console-circle">
				<span class="console-green console-box"></span>
			</div>
			<div class="console-header"><strong>{{ trans('installer_messages.final.env') }}</strong></div>
		</div>
		<div class="card__content">
			<pre><code>{{ $finalEnvFile }}</code></pre>
		</div>
	</div>

	<div class="button-group">
		<div class="gradient-btn-bg"></div>
		<a href="{{ url('/') }}" class="gradient-btn" role="button">
			{{ trans('installer_messages.final.exit') }}
		</a>
	</div>

@endsection
