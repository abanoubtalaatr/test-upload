module.exports = {
    apps: [
      {
        name: 'SooogAdmin',
        exec_mode: 'cluster',
        instances: 1, // Or a number of instances
        script: './node_modules/nuxt/bin/nuxt.js',
        args: 'start',
        watch: true,
        env: {
            HOST: "0.0.0.0",
            PORT: 3056,
            NODE_ENV: "production"
        }
      }
    ]
  }
