<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'boardinghouse');

// Project repository
set('repository', 'git@gitlab.com:dkoehl/booking.git');
set('symfony_env', 'prod');
// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
set('shared_files', ['.env']);
set('shared_dirs', []);

// Writable dirs by web server 
set('allow_anonymous_stats', false);
set('branch', 'master');
set('default_stage', 'prod');

// Hosts

host('boardinghouse.westeurope.cloudapp.azure.com')
    ->stage('prod')
    ->user('dkoehl')
    ->identityFile('~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/booking');


task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:clear_paths',
    'composer install',
    'yarn install',
    'yarn encore',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);
task('composer install', 'composer install');
task('yarn install', '/usr/bin/yarn install');
task('yarn encore', '/usr/bin/yarn encore dev');
// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
