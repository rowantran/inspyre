role :app, %w{deploy@192.168.1.10}

set :ssh_options, {
  auth_methods: %w(password),
  password: "Mw88itbg"
}
