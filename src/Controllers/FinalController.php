<?php

namespace Smarteknoloji\SmartInstaller\Controllers;

use Illuminate\Routing\Controller;
use Smarteknoloji\SmartInstaller\Events\LaravelInstallerFinished;
use Smarteknoloji\SmartInstaller\Helpers\EnvironmentManager;
use Smarteknoloji\SmartInstaller\Helpers\FinalInstallManager;
use Smarteknoloji\SmartInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Smarteknoloji\SmartInstaller\Helpers\InstalledFileManager $fileManager
     * @param \Smarteknoloji\SmartInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \Smarteknoloji\SmartInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
