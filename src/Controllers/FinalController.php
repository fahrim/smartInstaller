<?php

namespace Smarteknoloji\SmartlInstaller\Controllers;

use Illuminate\Routing\Controller;
use Smarteknoloji\SmartlInstaller\Events\LaravelInstallerFinished;
use Smarteknoloji\SmartlInstaller\Helpers\EnvironmentManager;
use Smarteknoloji\SmartlInstaller\Helpers\FinalInstallManager;
use Smarteknoloji\SmartlInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Smarteknoloji\SmartlInstaller\Helpers\InstalledFileManager $fileManager
     * @param \Smarteknoloji\SmartlInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \Smarteknoloji\SmartlInstaller\Helpers\EnvironmentManager $environment
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
