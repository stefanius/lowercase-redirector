<?php

namespace Stefanius\LowerCaseRedirectorBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RedirectController
{
    /**
     * Redirect to a new lowercased url.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function lowerCaseAction(Request $request)
    {
        return new RedirectResponse(strtolower($request->getUri()), 301);
    }
}
