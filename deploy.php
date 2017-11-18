<?php

namespace Deployer;

require 'vendor/deployer/deployer/recipe/common.php';

set('repository', 'git@github.com:perfumerlabs/start.git');
set('git_cache', true);
set('shared_dirs', ['tmp/logs']);
set('writable_dirs', ['tmp/cache', 'tmp/twig']);
set('writable_mode', 'chmod');
set('keep_releases', 3);
set('ssh_multiplexing', false);

host('node')
    ->hostname('45.32.157.162')
    ->user('perfumer')
    ->roles('node')
    ->port(22)
    ->set('branch', 'master')
    ->set('keep_releases', 3)
    ->set('deploy_path', '/home/perfumer/projects/start');

// Composer
desc('Installing Composer dependencies');
task('deploy:vendors', function () {
    run('cd {{release_path}} && php composer.phar install --prefer-dist --no-dev');
});

// Migrations
desc('Migrating database');
task('deploy:migrate', function() {
    run('cd {{release_path}} && php cli/prod framework propel/migrate');
});

desc('Deploy project');
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:migrate',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

after('deploy:failed', 'deploy:unlock');
