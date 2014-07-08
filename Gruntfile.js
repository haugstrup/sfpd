module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
        report: 'min',
        mangle: false
      },
      build: {
        files: {
          'public/js/scripts.min.js' : [
            'public/js/vendor/angular-resource.js',
            'public/js/vendor/angular-sanitize.js',
            'public/js/vendor/angular-route.js',
            'public/js/app.js',
            'public/js/services/game.js',
            'public/js/services/group.js',
            'public/js/controllers/game.js',
            'public/js/controllers/group.js',
            'public/js/controllers/heats_list.js',
            'public/js/controllers/main.js',
            'public/js/controllers/standings.js'
          ]
        }
      }
    },
    sass: {
      build: {
        options: {
          style: 'compressed'
        },
        files: {
          'public/css/main.css': 'app/assets/sass/main.scss',
          'public/css/admin.css': 'app/assets/sass/admin.scss',
          'public/css/admin_print.css': 'app/assets/sass/admin_print.scss'
        }
      }
    },
    watch: {
      sass: {
        files: 'app/assets/sass/**/*.scss',
        tasks: ['sass']
      },
      js: {
        files: ['public/js/**/*.js'],
        tasks: ['uglify']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['uglify', 'sass', 'watch']);

};
