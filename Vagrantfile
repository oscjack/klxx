require 'yaml'

VAGRANTFILE_API_VERSION ||= "2"

vmFold = "./vagrant";
configPath = vmFold + "/config.yaml"

require File.expand_path(vmFold + '/Bootstrap.rb')

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    config.vm.box_check_update = false

    Bootstrap.configure(config, YAML::load(File.read(configPath)))

    ENV['LC_ALL']="en_US.UTF-8"
end
