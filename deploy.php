<?php

namespace Deployer;

import(__DIR__ . '/deployer/host.yml');
import(__DIR__ . '/deployer/deploy.php');

set('default_timeout', 1200);
