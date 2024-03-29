@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.requirements.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-list-ul fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.requirements.title') }}
@endsection

@section('container')

    <ul class="list">
        <li class="list__item list__title {{ $dbSupportInfo['supported'] ? 'success' : 'error' }}">
            <strong>DB</strong>

            <strong>
                <small>
                    (version {{ $dbSupportInfo['minimum'] }} required)
                </small>
            </strong>
            <span class="float-right">
            <strong>{{ $dbSupportInfo['current'] }}</strong>
            <i class="fa fa-fw fa-{{ $dbSupportInfo['supported'] ? 'check-circle-o' : 'exclamation-circle' }} row-icon" aria-hidden="true"></i>
        </span>
        </li>
        <li class="list__item {{ $dbSupportInfo['supported'] ? 'success' : 'error' }}">
            Version {{ $dbSupportInfo['minimum'] }} required
            <i class="fa fa-fw fa-{{ $dbSupportInfo['supported'] ? 'check-circle-o' : 'exclamation-circle' }} row-icon" aria-hidden="true"></i>
        </li>
    </ul>

    @foreach($requirements['requirements'] as $type => $requirement)
        <ul class="list">
            <li class="list__item list__title {{ $phpSupportInfo['supported'] ? 'success' : 'error' }}">
                <strong>{{ ucfirst($type) }}</strong>
                @if($type == 'php')
                    <strong>
                        <small>
                            (version {{ $phpSupportInfo['minimum'] }} required)
                        </small>
                    </strong>
                    <span class="float-right">
                        <strong>
                            {{ $phpSupportInfo['current'] }}
                        </strong>
                        <i class="fa fa-fw fa-{{ $phpSupportInfo['supported'] ? 'check-circle-o' : 'exclamation-circle' }} row-icon" aria-hidden="true"></i>
                    </span>
                @endif
            </li>
            @foreach($requirements['requirements'][$type] as $extention => $enabled)
                <li class="list__item {{ $enabled ? 'success' : 'error' }}">
                    {{ $extention }}
                    <i class="fa fa-fw fa-{{ $enabled ? 'check-circle-o' : 'exclamation-circle' }} row-icon" aria-hidden="true"></i>
                </li>
            @endforeach
        </ul>
    @endforeach

    @if ( ! isset($requirements['errors']) && $phpSupportInfo['supported'] && $dbSupportInfo['supported'])
        @if(isset($requirements['warnings']))
            <div class="alert alert-warning" id="error_alert">
                <button type="button" class="close" id="close_alert" data-dismiss="alert" aria-hidden="true">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="alert-icon">
                    <i class="fa fa-exclamation" aria-hidden="true"></i>
                    <strong>{{ trans('installer_messages.requirements.warning') }}</strong>
                </div>
                <span class="alert-text">{{ trans('installer_messages.requirements.warningNotExistPhpFunction') }}</span>
            </div>
        @endif
        <div class="button-group">
            <div @class(['gradient-btn-bg', 'warning'=> isset($requirements['warnings'])])></div>
            <a href="{{ route('LaravelInstaller::permissions') }}" class="gradient-btn" role="button">
                {{ trans('installer_messages.requirements.next') }}
                <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
            </a>
        </div>
    @endif

@endsection
