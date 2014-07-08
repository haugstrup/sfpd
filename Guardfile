guard :concat, :type => "css", :files => %w[admin admin_print bootstrap/bootstrap bootstrap main navbar], :input_dir => "public/css", :output => "public/css/styles.min"

guard :concat, :type => "js", :files => %w[app controllers/game controllers/group controllers/heats_list controllers/main controllers/standings services/game services/group vendor/angular-resource vendor/angular-route vendor/angular-sanitize vendor/angular vendor/jquery], :input_dir => "public/js", :output => "public/js/scripts.min"

# Refresh the browser on save
guard 'livereload' do
  watch(%r{.+(?<!\.min)\.(css|html|js|blade\.php)$})
end

module ::Guard
  class Refresher < Guard
    def run_all
      # refresh
    end

    def run_on_additions(paths)
      refresh
    end

    def run_on_removals(paths)
      refresh
    end

    def refresh
      `php artisan guard:refresh`
    end
  end
end

require 'cssmin'
require 'jsmin'

guard :refresher do
  watch(%r[public/js/.+])
  watch(%r[public/css/.+])
  watch(%r{app/config/packages/way/guard-laravel/guard.php}) do |m|
    `php artisan guard:refresh`
  end
  watch('public/css/styles.min.css') do |m|
    css = File.read(m[0])
    File.open(m[0], 'w') { |file| file.write(CSSMin.minify(css)) }
  end
  watch('public/js/scripts.min.js') do |m|
    js = File.read(m[0])
    File.open(m[0], 'w') { |file| file.write(JSMin.minify(js)) }
  end
end

guard :sass, :input => 'app/assets/sass', :output => 'public/css'
