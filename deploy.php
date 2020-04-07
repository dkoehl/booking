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
set('keep_releases', '3');
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
    'setPerms',
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
    'clear cache',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'setPerms',
    'success'
]);
task('composer install', 'composer install');
task('yarn install', '/usr/bin/yarn install');
task('yarn encore', '/usr/bin/yarn encore dev');
task('clear cache', 'php bin/console cache:clear');
task('setPerms', 'chmod -R 0777 /var/www/booking/current/');
// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
