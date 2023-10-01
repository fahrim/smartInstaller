<?php

namespace Smarteknoloji\SmartInstaller\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Smarteknoloji\SmartInstaller\Helpers\RequirementsChecker;

class RequirementsController extends Controller
{
    /**
     * @var RequirementsChecker
     */
    protected $requirements;

    /**
     * @param RequirementsChecker $checker
     */
    public function __construct(RequirementsChecker $checker)
    {
        $this->requirements = $checker;
    }

    /**
     * Display the requirements page.
     *
     * @return View
     */
    public function requirements(): View
    {
        $dbSupportInfo = $this->requirements->checkDbVersion(
            config('installer.core.minDbVersion')
        );

        $phpSupportInfo = $this->requirements->checkPhpVersion(
            config('installer.core.minPhpVersion')
        );

        $requirements = $this->requirements->check(
            config('installer.requirements')
        );

        return view('vendor.installer.requirements', compact('requirements', 'phpSupportInfo', 'dbSupportInfo'));
    }
}
