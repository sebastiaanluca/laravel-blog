const gulp = require('gulp')
const dotenv = require('dotenv')
const path = require('path')
const del = require('del')
const spawn = require('./spawn')
const runSequence = require('run-sequence')
const browserSync = require('browser-sync').create()

// Load environment variables
dotenv.load({path: path.resolve(process.cwd(), '.env')})

/* Tasks */

gulp.task('default', callback => {
    runSequence('clean', 'webpack', callback)
})

gulp.task('production', callback => {
    process.env.APP_ENV = 'production'
    
    runSequence('clean', 'webpack', callback)
})

gulp.task('hot', callback => {
    runSequence('clean', 'webpack', 'webpack-dev-server', callback)
})

gulp.task('serve', callback => {
    runSequence('clean', 'webpack', 'browsersync', 'webpack-watch', callback)
})

/* Individual tasks */

gulp.task('clean', function () {
    let directories = ['public/vendor/blog']
    
    if (process.env.APP_ENV === 'production') {
        directories = ['resources/assets/dist']
    }
    
    return del(directories)
})

gulp.task('webpack', callback => {
    spawn('node_modules/.bin/webpack', [], callback)
})

gulp.task('webpack-dev-server', callback => {
    spawn('node_modules/.bin/webpack-dev-server', ['--inline', '--watch', '--hot'], callback)
})

gulp.task('webpack-watch', callback => {
    spawn('node_modules/.bin/webpack', ['-w'], callback)
})

gulp.task('browsersync', callback => {
    // Serve files from the root of this project
    browserSync.init({
        // Create a server to serve static files
        // https://www.browsersync.io/docs/options/#option-server
        proxy: process.env.SERVE_PROXY_TARGET,
        port: process.env.SERVE_PORT || 8080,
    
        https: true,
        // Prevent BrowserSync from automatically opening a browser window to the page
        open: false,
    })
    
    // Watch compiled file and template changes and do a full refresh
    gulp.watch('./public/**/*').on('change', browserSync.reload)
    gulp.watch('./resources/views/**/*').on('change', browserSync.reload)
    
    callback()
})