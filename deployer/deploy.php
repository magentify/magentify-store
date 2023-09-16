<?php

namespace Deployer;

require 'recipe/symfony.php';

// Configurations
set('shared_files', ['.env.local', 'public/.htaccess', 'public/robots.txt', 'public/sitemap.xml']);
set('shared_dirs', ['public/.well-known', 'var/data', 'var/log']);

desc('Upload the artifact to the production server');
task('deploy:upload', function () {
    upload(__DIR__ . '/build.zip', '{{release_path}}');
    run('cd {{release_path}} && unzip -qn build.zip && rm build.zip');
});

desc('Clear cache');
task('deploy:cache:clear', function () {
    run('{{bin/php}} {{release_path}}/bin/console cache:clear --no-interaction');
});

desc('Deploys project');
task('deploy', [
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:shared',
    'deploy:upload',
    'deploy:cache:clear',
    'deploy:publish',
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
