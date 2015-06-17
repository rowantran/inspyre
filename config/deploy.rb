# config valid only for current version of Capistrano
lock '3.4.0'

set :application, "Inspyre"
set :repo_url, "git@github.com:bishopblade/inspyre.git"
set :branch, "staging"
set :deploy_to, "/var/www/inspyre"
