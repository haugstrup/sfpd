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
          'public/tmp/uglified.js' : [
            'public/js/vendor/angular-resource.js',
            'public/js/vendor/angular-sanitize.js',
            'public/js/vendor/angular-route.js',
            'public/js/app.js',
            'public/js/services/game.js',
            'public/js/services/group.js',
            'public/js/controllers/player.js',
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
        files: ['public/js/**/*.js', 'public/views/**.html', '!public/js/scripts.min.js'],
        tasks: ['uglify', 'ngtemplates', 'concat']
      }
    },
    ngtemplates:  {
      options: {
        htmlmin: {
          collapseBooleanAttributes:      true,
          collapseWhitespace:             true,
          removeAttributeQuotes:          true,
          removeComments:                 true, // Only if you don't use comment directives!
          removeEmptyAttributes:          true,
          removeRedundantAttributes:      true,
          removeScriptTypeAttributes:     true,
          removeStyleLinkTypeAttributes:  true
        }
      },
      sfpdApp: {
        src: 'public/views/**.html',
        dest: 'public/tmp/templates.js'
      }
    },
    concat: {
      build: {
        src: [ 'public/tmp/uglified.js', '<%= ngtemplates.sfpdApp.dest %>' ],
        dest: 'public/js/scripts.min.js'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-angular-templates');

  // Default task(s).
  grunt.registerTask('default', ['sass', 'uglify', 'ngtemplates', 'concat', 'watch']);

};
