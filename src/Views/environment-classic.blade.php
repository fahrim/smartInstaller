@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.classic.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-code fa-fw" aria-hidden="true"></i> {{ trans('installer_messages.environment.classic.title') }}
@endsection

@section('container')

    <form method="post" action="{{ route('LaravelInstaller::environmentSaveClassic') }}">
        @csrf
        <textarea class="textarea" name="envConfig" aria-label="env">{{ $envConfig }}</textarea>

        <div class="buttons-container flex-end">
            <div class="button-group">
                <div class="gradient-btn-bg save"></div>
                <button class="gradient-btn" type="submit">
                    <i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i>
                    {!! trans('installer_messages.environment.classic.save') !!}
                </button>
            </div>
        </div>
    </form>

    @if( ! isset($environment['errors']))
        <div class="buttons-container">

            <div class="button-group">
                <div class="gradient-btn-bg"></div>
                <a href="{{ route('LaravelInstaller::environmentWizard') }}" class="gradient-btn" role="button">
                    <i class="fa fa-sliders fa-fw" aria-hidden="true"></i>
                    {!! trans('installer_messages.environment.classic.back') !!}
                </a>
            </div>

            <div class="button-group">
                <div class="gradient-btn-bg install"></div>
                <a href="{{ route('LaravelInstaller::database') }}" class="gradient-btn" role="button">
                    <i class="fa fa-check fa-fw" aria-hidden="true"></i>
                    {!! trans('installer_messages.environment.classic.install') !!}
                    <i class="fa fa-angle-double-right fa-fw" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    @endif

@endsection