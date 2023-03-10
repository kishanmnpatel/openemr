<?php

/**
 * portal/verify_session.php
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Cassian LUP <cassi.lup@gmail.com>
 * @author    Kevin Yeh <kevin.y@integralemr.com>
 * @author    Jerry Padgett <sjpadgett@gmail.com>
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2011 Cassian LUP <cassi.lup@gmail.com>
 * @copyright Copyright (c) 2013 Kevin Yeh <kevin.y@integralemr.com>
 * @copyright Copyright (c) 2016-2017 Jerry Padgett <sjpadgett@gmail.com>
 * @copyright Copyright (c) 2019 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

// All of the common intialization steps for the get_* patient portal functions are now in this single include.



//continue session
// Will start the (patient) portal OpenEMR session/cookie.
require_once(__DIR__ . "/../src/Common/Session/SessionUtil.php");
OpenEMR\Common\Session\SessionUtil::portalSessionStart();

//landing page definition -- where to go if something goes wrong
// if this script is included somewhere else we want to support them changing up the landingpage url such as adding
// parameters, or even setting what the landing page should be for the portal verify session.
if (!isset($landingpage)) {
    $landingpage = "index.php?site=" . urlencode($_SESSION['site_id'] ?? null);
}
//

// kick out if patient not authenticated
if (isset($_SESSION['pid']) && isset($_SESSION['patient_portal_onsite_two'])) {
    $pid = $_SESSION['pid'];
} else {
    OpenEMR\Common\Session\SessionUtil::portalSessionCookieDestroy();
    header('Location: ' . $landingpage . '&w');
    exit;
}

//

$ignoreAuth_onsite_portal = true; // ignore the standard authentication for a regular OpenEMR user
require_once(dirname(__file__) . './../interface/globals.php');
